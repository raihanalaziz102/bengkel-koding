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
        Schema::create('periksas', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->unsignedBigInteger('id_pasien');
            $table->unsignedBigInteger('id_dokter');

            // Data fields
            $table->dateTime('tgl_periksa');
            $table->longText('catatan')->nullable(); // lebih fleksibel kalau kosong
            $table->bigInteger('biaya_periksa')->default(0); // jaga-jaga default

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_pasien')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_dokter')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Disarankan drop foreign key secara eksplisit dulu (untuk versi MySQL lama)
        Schema::table('periksas', function (Blueprint $table) {
            $table->dropForeign(['id_pasien']);
            $table->dropForeign(['id_dokter']);
        });

        Schema::dropIfExists('periksas');
    }
};
