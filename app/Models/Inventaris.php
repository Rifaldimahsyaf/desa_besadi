<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;


class Inventaris extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'id',
        'jenis_barang',
        'asal_barang',
        'keadaan_barang',
        'penghapusan_barang',
        'keterangan',
        
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'inventaris';
    public $timestamps = true;
    public $incrementing = false;

   

    public function format() : array{

        return [
            'id' => $this->id,
            'jenis_barang' => $this->jenis_barang,
            'asal_barang' => $this->asal_barang,
            'keadaan_barang' => $this->keadaan_barang,
            'penghapusan_barang' => $this->penghapusan_barang,
            'keterangan' => $this->keterangan,
           
           
            
        ];
    }
}
