<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ict_id',20)->nullable();
            $table->string('harta_id',20)->nullable();
            $table->string('butiran',100)->nullable();
            $table->integer('status')->nullable();
            $table->integer('kod_kategori')->nullable();
            $table->integer('kod_sub_kategori')->nullable();
            $table->date('tkh_beli')->nullable();
            $table->date('tkh_jaminan')->nullable();
            $table->string('no_siri',50)->nullable();
            $table->string('no_invoice',25)->nullable();
            $table->string('no_rujukan',25)->nullable();
            $table->integer('jenama')->nullable();
            $table->string('emp_id',10)->nullable();
            $table->string('kod_pembekal',10)->nullable();
            $table->integer('harga_beli')->nullable();
            $table->integer('lokasi_id')->nullable();
            $table->string('ipaddress',30)->nullable();
            $table->string('catatan',1000)->nullable();
            $table->integer('ict_no_master')->nullable();
            $table->integer('pembelian_id')->nullable();
            $table->string('kod_pinjam',10)->nullable();
            $table->string('pengguna_id',50)->nullable();
            $table->string('kod_lesen',10)->nullable();
            $table->integer('kod_auditict')->nullable();
            $table->date('tkh_disposed')->nullable();
            $table->integer('kod_alasan_disp')->nullable();
            $table->string('catat_disp',100)->nullable();
            $table->string('kod_tahaprisiko',1)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('assets');
    }
}
