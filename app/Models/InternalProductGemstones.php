<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalProductGemstones extends Model
{
    use HasFactory;
    protected $table = 'product_gemstone_details';
	protected $guarded = [];
}
