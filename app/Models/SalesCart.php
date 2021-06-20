<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesCart extends Model
{
    use HasFactory;
    protected $fillable = ['product_price','price_total'];
}
