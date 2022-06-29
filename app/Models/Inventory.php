<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventories';
    protected $fillable = [
        'id',
        'model',
        'category',
        'ordered_qty',
        'current_qty',
        'price',
    ];
}
