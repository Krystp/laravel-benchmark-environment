<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostgresOrder extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';

    protected $table = 'orders';

    protected $fillable = [
        'analiza_id',
        'product',
        'amount'
    ];

    public $timestamps = false;

    public function analiza()
    {
        return $this->belongsTo(Postgres::class, 'analiza_id');
    }
}
