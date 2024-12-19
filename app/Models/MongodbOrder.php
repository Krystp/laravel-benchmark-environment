<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class MongodbOrder extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';

    protected $collection = 'orders';

    protected $fillable = [
        'analiza_id',
        'product',
        'amount',
    ];

    public function analiza()
    {
        return $this->belongsTo(Mongodb::class, 'analiza_id', '_id');
    }
}
