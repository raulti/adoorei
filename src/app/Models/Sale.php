<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class Sale extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;
    protected $fillable = ['amount'];

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withTimestamps();
    }

    public function setAmount(float $amount)
    {
        if ($amount == null) {
            throw new UnprocessableEntityHttpException('A venda precisa ter um valor maior ou igual a zero');
        }

        $this->attributes['amount'] = $amount;
    }
}
