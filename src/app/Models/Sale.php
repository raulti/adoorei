<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['amount'];

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withTimestamps();
    }
}
