<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;


class Purchase extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'id',
        'supplier_id',
        'product_id',
        'unit',
        'price',
        'items',
        'status',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'purchase';
    public $timestamps = true;
    public $incrementing = false;

    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id')->withTrashed();
    }

    public function product()
    {
        return $this->hasOne(product::class, 'id', 'product_id');
    }

    public function format() : array{

        return [
            'id' => $this->id,
            'supplier_id' => $this->supplier_id,
            'product_name' => $this->product->name,
            'unit' => $this->unit,
            'price' => $this->price,
            'items' => $this->items,
            'supplier_name' => $this->supplier->name,
            'status' => $this->status,
        ];
    }
}
