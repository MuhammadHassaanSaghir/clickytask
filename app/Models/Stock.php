<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = [
        'variant',
        'stock',
    ];

    public static function getStock()
    {
        $records = DB::table('stocks')->select('variant', 'id')->get()->toArray();
        return $records;
    }
}
