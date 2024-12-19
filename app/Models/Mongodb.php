<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Mongodb extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';

    protected $collection = 'analiza';

    protected $fillable = [
        'firstName',
        'lastName',
        'age',
        'phone',
    ];

    protected $appends = ['orders'];

    public function orders()
    {
        return $this->hasMany(MongodbOrder::class, 'analiza_id', '_id');
    }

    public function getOrdersAttribute()
    {
        return $this->orders()->get();
    }
}
