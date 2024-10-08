<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SamaProductsModel extends Model
{
    use HasFactory;
    protected $table = 'sama_products';
    protected $guarded = [];
}
