<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi';
    protected $fillable = [
        'toko_id',
        'produk_id',
        'nama_produk',
        'transactionType',
        'transactionDate',
        'returDate',
        'amount',
        'terjual',
        'waktuEdar',
        'status',
    ];


    protected $casts = [
        'transactionDate' => 'date',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'toko_id');
    }
}
