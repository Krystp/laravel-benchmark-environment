<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postgres extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';

    protected $table = 'analiza';

    protected $fillable = [
        'firstname',
        'lastname',
        'age',
        'phone'
    ];

    public $timestamps = false;

    public function orders()
    {
        return $this->hasMany(PostgresOrder::class, 'analiza_id');
    }
}
