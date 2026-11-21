<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservasis', function (Blueprint $table) {
            $table->id('id_reservasi');

            $table->foreignId('id_user')
                ->constrained('users', 'id_user')
                ->restrictOnDelete();

            $table->foreignId('id_kamar')
                ->constrained('kamars', 'id_kamar')
                ->restrictOnDelete();

            $table->foreignId('id_admin')
                ->nullable()
                ->constrained('admins', 'id_admin')
                ->nullOnDelete();

            $table->date('tgl_checkin');
            $table->date('tgl_checkout');

            $table->decimal('total_bayar', 12, 2);

            $table->text('fasilitas_tambahan')->nullable();

            $table->string('status_reservasi');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservasis');
    }
};