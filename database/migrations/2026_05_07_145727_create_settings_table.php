<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $row) {
            $row->id();
            $row->string('key')->unique();
            $row->text('value')->nullable();
            $row->timestamps();
        });

        // Seed data awal
        DB::table('settings')->insert([
            ['key' => 'ticket_header', 'value' => 'NAMA INSTANSI ANDA'],
            ['key' => 'ticket_footer', 'value' => 'Terima Kasih Atas Kunjungan Anda'],
            ['key' => 'ticket_note', 'value' => 'Simpan tiket ini dengan baik.'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
