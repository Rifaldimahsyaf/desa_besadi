<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;


class Warga extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'id',
        'no_kk',
        'name',
        'nik',
        'gender',
        'birth_date',
        'golongan_darah',
        'religion',
        'pendidikan',
        'pekerjaan',
        'alamat',
        'status_perkawinan',
        'tempat_dikeluarkan',
        'tanggal_dikeluarkan',
        'status_keluarga',
        'kewarganegaraan',
        'nama_ayah',
        'nama_ibu',
        'tanggal_mulai',
        'keterangan',
        
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'warga';
    public $timestamps = true;
    public $incrementing = false;

   

    public function format() : array{

        return [
            'id' => $this->id,
            'no_kk' => $this->no_kk,
            'name' => $this->name,
            'nik' => $this->nik,
            'gender' => $this->gender,
            'birth_date' => $this->birth_date,
            'golongan_darah' => $this->golongan_darah,
            'religion' => $this->religion,
            'pendidikan' => $this->pendidikan,
            'pekerjaan' => $this->pekerjaan,
            'alamat' => $this->alamat,
            'status_perkawinan' => $this->status_perkawinan,
            'tempat_dikeluarkan' => $this->tempat_dikeluarkan,
            'tanggal_dikeluarkan' => $this->tanggal_dikeluarkan,
            'status_keluarga' => $this->status_keluarga,
            'kewarganegaraan' => $this->kewarganegaraan,
            'nama_ayah' => $this->nama_ayah,
            'nama_ibu' => $this->nama_ibu,
            'tanggal_mulai' => $this->tanggal_mulai,
            'keterangan' => $this->keterangan,
           
            
        ];
    }
}
