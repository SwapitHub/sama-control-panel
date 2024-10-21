<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SamaPrices extends Model
{
    use HasFactory;
    protected $table = 'sama_product_price';
	protected $guarded = [];
}
