
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Perbaiki tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('id', 'id_user');
            $table->renameColumn('name', 'nama_lengkap');

            $table->string('username')->unique();
            $table->string('no_hp', 20);
        });

        // 2. Perbaiki tabel admins
        Schema::table('admins', function (Blueprint $table) {
            $table->renameColumn('id', 'id_admin');

            $table->string('username')->unique();
            $table->string('password');
            $table->string('nama_admin');
        });

        // 3. Perbaiki tabel kamars
        Schema::table('kamars', function (Blueprint $table) {
            $table->renameColumn('id', 'id_kamar');

            $table->string('no_kamar')->unique();
            $table->string('tipe_kamar');
            $table->decimal('harga_per_malam', 12, 2);
            $table->string('status_kamar')->default('tersedia');
        });

        // 4. Perbaiki tabel reservasis
        Schema::table('reservasis', function (Blueprint $table) {
            $table->renameColumn('id', 'id_reservasi');

            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_kamar');
            $table->unsignedBigInteger('id_admin')->nullable();

            $table->date('tgl_checkin');
            $table->date('tgl_checkout');
            $table->decimal('total_bayar', 12, 2);
            $table->text('fasilitas_tambahan')->nullable();
            $table->string('status_reservasi')->default('menunggu');
        });

        // 5. Perbaiki tabel pembayarans
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->renameColumn('id', 'id_pembayaran');

            $table->unsignedBigInteger('id_reservasi');
            $table->unsignedBigInteger('id_admin')->nullable();

            $table->date('tgl_bayar')->nullable();
            $table->decimal('jumlah_bayar', 12, 2);
            $table->string('bukti_transfer')->nullable();
            $table->string('status_pembayaran')->default('menunggu');
        });

        // 6. Buat foreign key setelah semua kolom tersedia
        Schema::table('reservasis', function (Blueprint $table) {
            $table->foreign('id_user')
                ->references('id_user')->on('users');

            $table->foreign('id_kamar')
                ->references('id_kamar')->on('kamars');

            $table->foreign('id_admin')
                ->references('id_admin')->on('admins')
                ->nullOnDelete();
        });

        Schema::table('pembayarans', function (Blueprint $table) {
            $table->foreign('id_reservasi')
                ->references('id_reservasi')->on('reservasis');

            $table->foreign('id_admin')
                ->references('id_admin')->on('admins')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropForeign(['id_reservasi']);
            $table->dropForeign(['id_admin']);
            $table->dropColumn([
                'id_reservasi',
                'id_admin',
                'tgl_bayar',
                'jumlah_bayar',
                'bukti_transfer',
                'status_pembayaran'
            ]);
            $table->renameColumn('id_pembayaran', 'id');
        });

        Schema::table('reservasis', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
            $table->dropForeign(['id_kamar']);
            $table->dropForeign(['id_admin']);
            $table->dropColumn([
                'id_user',
                'id_kamar',
                'id_admin',
                'tgl_checkin',
                'tgl_checkout',
                'total_bayar',
                'fasilitas_tambahan',
                'status_reservasi'
            ]);
            $table->renameColumn('id_reservasi', 'id');
        });

        Schema::table('kamars', function (Blueprint $table) {
            $table->dropUnique(['no_kamar']);
            $table->dropColumn([
                'no_kamar',
                'tipe_kamar',
                'harga_per_malam',
                'status_kamar'
            ]);
            $table->renameColumn('id_kamar', 'id');
        });

        Schema::table('admins', function (Blueprint $table) {
            $table->dropUnique(['username']);
            $table->dropColumn([
                'username',
                'password',
                'nama_admin'
            ]);
            $table->renameColumn('id_admin', 'id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['username']);
            $table->dropColumn(['username', 'no_hp']);
            $table->renameColumn('nama_lengkap', 'name');
            $table->renameColumn('id_user', 'id');
        });
    }
};
