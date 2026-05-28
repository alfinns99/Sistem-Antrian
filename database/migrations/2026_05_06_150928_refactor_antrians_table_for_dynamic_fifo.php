<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('antrians', function (Blueprint $table) {
            // Drop foreign key TERLEBIH DAHULU
            $table->dropForeign(['loket_id']);
            
            // Kemudian drop unique constraint
            $table->dropUnique(['loket_id', 'nomor_antrian', 'tanggal']);
            
            // Ubah loket_id menjadi nullable
            $table->unsignedBigInteger('loket_id')->nullable()->change();
            
            // Pasang kembali foreign key dengan onDelete set null
            $table->foreign('loket_id')->references('id')->on('lokets')->onDelete('set null');

            // Tambahkan kolom angka_antrian untuk mempermudah sorting angka murni
            $table->integer('angka_antrian')->after('nomor_antrian')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antrians', function (Blueprint $table) {
            $table->dropForeign(['loket_id']);
            $table->unsignedBigInteger('loket_id')->nullable(false)->change();
            $table->foreign('loket_id')->references('id')->on('lokets')->onDelete('cascade');
            $table->unique(['loket_id', 'nomor_antrian', 'tanggal']);
            $table->dropColumn('angka_antrian');
        });
    }
};
