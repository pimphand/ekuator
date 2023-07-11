<?php

namespace App\Models;

use App\Traits\HasUuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes, HasUuidTrait;

    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'product_id',
        'price',
        'quantity',
        'admin_fee',
        'tax',
        'total',
    ];

    function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'uuid');
    }

    function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'uuid');
    }
}
