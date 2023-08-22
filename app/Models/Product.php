<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;


class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'id',
        'name',
        'unit',
        'purchase_price',
        'selling_price',
        'items',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'product';
    public $timestamps = true;
    public $incrementing = false;

    public function format() : array{

        return [
            'id' => $this->id,
            'name' => $this->name,
            'unit' => $this->unit,
            'purchase_price' => $this->purchase_price,
            'selling_price' => $this->selling_price,
            'items' => $this->items,
           
        ];
    }
}
