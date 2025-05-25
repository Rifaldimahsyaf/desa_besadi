<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventaris', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('jenis_barang', ); 
            $table->enum('asal_barang', ['dibeli sendiri', 'bantuan pemerintah', 'bantuan provinsi', 'bantuan kabupaten', 'sumbangan']);
            $table->enum('keadaan_barang',['baik', 'rusak']);
            $table->enum('penghapusan_barang', ['dipakai','rusak', 'dijual','disumbangkan']);
            $table->string('keterangan');
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
        Schema::dropIfExists('inventaris');
    }
}
