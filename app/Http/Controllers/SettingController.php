<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'ticket_header' => 'required|string|max:255',
            'ticket_header_2' => 'nullable|string|max:255',
            'ticket_footer' => 'required|string|max:255',
            'ticket_note' => 'nullable|string|max:500',
        ]);

        Setting::updateOrCreate(['key' => 'ticket_header'], ['value' => $request->ticket_header]);
        Setting::updateOrCreate(['key' => 'ticket_header_2'], ['value' => $request->ticket_header_2]);
        Setting::updateOrCreate(['key' => 'ticket_footer'], ['value' => $request->ticket_footer]);
        Setting::updateOrCreate(['key' => 'ticket_note'], ['value' => $request->ticket_note]);

        return redirect()->back()->with('success', 'Pengaturan tiket berhasil diperbarui!');
    }
}
