<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWargaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warga', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('no_kk', 20); 
            $table->string('name');
            $table->string('nik', 20);
            $table->enum('gender', ['laki-laki', 'perempuan']);
            $table->date('birth_date');
            $table->enum('golongan_darah', ['A', 'B', 'AB', 'O']);
            $table->enum('religion', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']);
            $table->string('pendidikan'); 
            $table->string('pekerjaan');
            $table->string('alamat');
            $table->enum('status_perkawinan', ['Belum Menikah','Menikah']);
            $table->string('tempat_dikeluarkan');
            $table->date('tanggal_dikeluarkan');
            $table->string('status_keluarga');
            $table->string('kewarganegaraan');
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->date('tanggal_mulai');
            $table->string('keterangan');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warga');
    }
}


