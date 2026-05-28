<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Loket;
use Illuminate\Http\Request;
use App\Events\AntrianDipanggil;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AntrianController extends Controller
{
    /**
     * Menampilkan daftar antrian hari ini (Halaman Publik/Petugas).
     */
    public function index()
    {
        $today = Carbon::today()->toDateString();
        
        $antrians = Antrian::with('loket')
            ->where('tanggal', $today)
            ->orderBy('created_at', 'desc')
            ->get(); 
            
        $lokets = Loket::where('status', 'aktif')->get(); 
        
        $antrianSaatIni = Antrian::with('loket')
            ->where('status', 'dipanggil')
            ->where('tanggal', $today)
            ->first();
            
        return view('antrians.index', compact('antrians', 'lokets', 'antrianSaatIni'));
    }

    /**
     * Menyimpan antrian baru (Sistem Satu Pintu).
     */
    public function store(Request $request)
    {
        $today = Carbon::today()->toDateString();

        // Gunakan transaksi untuk memastikan pengambilan nomor urut aman
        $newAntrian = \Illuminate\Support\Facades\DB::transaction(function () use ($today) {
            $last_antrian = Antrian::where('tanggal', $today)
                ->lockForUpdate()
                ->orderBy('angka_antrian', 'desc')
                ->first();

            $nomor_urut = $last_antrian ? $last_antrian->angka_antrian + 1 : 1;
            $formatted_nomor = str_pad($nomor_urut, 3, '0', STR_PAD_LEFT);

            return Antrian::create([
                'nomor_antrian' => $formatted_nomor,
                'angka_antrian' => $nomor_urut,
                'status' => 'menunggu',
                'tanggal' => $today,
            ]);
        });

        $nomor_antrian_baru = $newAntrian->nomor_antrian;

        // Broadcast bahwa ada antrian baru agar angka "Menunggu" di Kiosk update
        $this->broadcastToSocket('antrian.baru', [
            'total_menunggu' => Antrian::where('status', 'menunggu')->where('tanggal', Carbon::today()->toDateString())->count()
        ]);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'antrian' => $newAntrian
            ]);
        }

        return redirect()->route('antrians.index')->with('success', "Nomor antrian Anda: **$nomor_antrian_baru**");
    }
    
    public function create() { /* not used */ }

    /**
     * Memanggil antrian berikutnya secara dinamis (FIFO).
     */
    public function callNext()
    {
        $user = Auth::user();
        if (!$user || ($user->role !== 'admin' && $user->role !== 'petugas')) {
             abort(403, 'Akses Ditolak.');
        }

        if (!$user->loket_id) {
            return redirect()->back()->with('error', 'Anda belum ditugaskan ke loket manapun.');
        }

        $today = Carbon::today()->toDateString();

        // VALIDASI: Cek apakah petugas masih memiliki antrian yang belum diselesaikan
        $exists = Antrian::where('loket_id', $user->loket_id)
            ->where('tanggal', $today)
            ->where('status', 'dipanggil')
            ->exists();
        
        if ($exists) {
            return redirect()->back()->with('error', 'Selesaikan antrian saat ini sebelum memanggil antrian berikutnya.');
        }

        // Proses transaksi pengambilan antrian tertua
        $antrian = \Illuminate\Support\Facades\DB::transaction(function () use ($today, $user) {
            $next = Antrian::where('status', 'menunggu')
                ->where('tanggal', $today)
                ->orderBy('angka_antrian', 'asc')
                ->lockForUpdate()
                ->first();

            if ($next) {
                $next->status = 'dipanggil';
                $next->loket_id = $user->loket_id;
                $next->save();
            }

            return $next;
        });

        if (!$antrian) {
            return redirect()->back()->with('error', 'Tidak ada antrian menunggu saat ini.');
        }
        
        $this->broadcastToSocket('antrian.dipanggil', ['antrian' => $antrian->load('loket')]);

        return redirect()->back()->with('success', "Memanggil nomor: $antrian->nomor_antrian");
    }

    /**
     * Memanggil ulang antrian yang sedang aktif di loket petugas.
     */
    public function recall(Antrian $antrian)
    {
        if ($antrian->status !== 'dipanggil') {
            return redirect()->back()->with('error', 'Hanya antrian berstatus dipanggil yang bisa dipanggil ulang.');
        }

        $this->broadcastToSocket('antrian.dipanggil', ['antrian' => $antrian->load('loket')]);
        return redirect()->back()->with('success', "Memanggil ulang nomor: $antrian->nomor_antrian");
    }

    /**
     * Helper untuk mengirim data ke Node.js Socket.io Bridge (No-Redis)
     */
    private function broadcastToSocket($event, $data)
    {
        try {
            \Illuminate\Support\Facades\Http::post('http://localhost:3000/broadcast', [
                'event' => $event,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Gagal broadcast ke Socket.io: " . $e->getMessage());
        }
    }

    /**
     * Mengupdate status antrian menjadi 'selesai'.
     */
    public function finish(Antrian $antrian)
    {
        if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::user()->role !== 'petugas')) {
             abort(403, 'Akses Ditolak.');
        }

        if ($antrian->status !== 'dipanggil') {
             return redirect()->back()->with('error', 'Antrian harus berstatus dipanggil sebelum diselesaikan.');
        }

        $antrian->status = 'selesai';
        $antrian->finished_at = now(); 
        $antrian->save();

        // Broadcast bahwa antrian selesai agar monitor update status loket jadi "MEJA SIAP"
        $this->broadcastToSocket('antrian.selesai', [
            'antrian_id' => $antrian->id,
            'loket_id' => $antrian->loket_id
        ]);

        return redirect()->back()->with('success', 'Antrian berhasil diselesaikan.');
    }

    /**
     * Mereset seluruh data antrian (Kembali ke nol).
     */
    public function reset()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Hanya Admin yang dapat mereset antrian.');
        }

        // Hapus seluruh data antrian
        Antrian::truncate();

        // Broadcast reset agar semua monitor/kiosk refresh
        $this->broadcastToSocket('antrian.reset', ['message' => 'Sistem antrian telah direset.']);

        return redirect()->back()->with('success', 'Seluruh data antrian telah berhasil direset.');
    }

    /**
     * Menghapus antrian.
     */
    public function destroy(Antrian $antrian)
    {
        if (!Auth::check() || (Auth::user()->role !== 'admin' && Auth::user()->role !== 'petugas')) {
             abort(403, 'Akses Ditolak.');
        }
        $antrian->delete();
        return redirect()->route('antrians.index')->with('success', 'Antrian berhasil dihapus.');
    }
    
    /**
     * Metode API untuk mendapatkan data monitor saat initial loading (menggantikan Long Polling).
     */
    public function getMonitorData()
    {
        $today = Carbon::today()->toDateString();
        
        // Data loket beserta antrian yang sedang dipanggil di sana
        $lokets = Loket::where('status', 'aktif')->get()->map(function($loket) use ($today) {
            $loket->antrian_sekarang = Antrian::where('loket_id', $loket->id)
                ->where('tanggal', $today)
                ->where('status', 'dipanggil')
                ->first();
            return $loket;
        });

        $antrianDipanggil = Antrian::with('loket')
            ->where('status', 'dipanggil')
            ->where('tanggal', $today)
            ->orderBy('updated_at', 'desc')
            ->first();
        
        $antriansMenunggu = Antrian::where('status', 'menunggu')
            ->where('tanggal', $today)
            ->orderBy('angka_antrian', 'asc')
            ->limit(10)
            ->get();

        return response()->json([
            'lokets' => $lokets,
            'antrian_dipanggil' => $antrianDipanggil, 
            'antrians_menunggu' => $antriansMenunggu,
            'total_hari_ini' => Antrian::where('tanggal', $today)->count()
        ]);
    }
    
    public function show(Antrian $antrian) { /* not used */ }
    public function edit(Antrian $antrian) { /* not used */ }
    public function update(Request $request, Antrian $antrian) { /* not used */ }
    /**
     * Tampilkan halaman cetak tiket antrian.
     */
    public function printTicket(Antrian $antrian)
    {
        $settings = \App\Models\Setting::all()->pluck('value', 'key');
        return view('antrians.print', compact('antrian', 'settings'));
    }
}