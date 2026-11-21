<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id('id_pembayaran');

            $table->foreignId('id_reservasi')
                ->constrained('reservasis', 'id_reservasi')
                ->restrictOnDelete();

            $table->foreignId('id_admin')
                ->nullable()
                ->constrained('admins', 'id_admin')
                ->nullOnDelete();

            $table->date('tgl_bayar')->nullable();

            $table->decimal('jumlah_bayar', 12, 2);

            $table->string('bukti_transfer')->nullable();

            $table->string('status_pembayaran');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};