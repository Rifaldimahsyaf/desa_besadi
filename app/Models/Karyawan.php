<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use Illuminate\Database\Eloquent\SoftDeletes;


class Karyawan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'id',
        'nip',
        'nama_lengkap',
        'email',
        'alamat',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'karyawan';
    public $timestamps = true;
    public $incrementing = false;

    public function format() : array{

        return [
            'id' => $this->id,
            'nip' => $this->nip,
            'nama_lengkap' => $this->nama_lengkap,
            'email' => $this->email,
            'alamat' => $this->alamat,
        ];
    }
}
