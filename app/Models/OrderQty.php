<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderQty extends Model
{
    protected $table = 'order_qties';
    protected $fillable = [
        'id',
        'no_invoice',
        'model',
        'qty',
        'price',
    ];
}
