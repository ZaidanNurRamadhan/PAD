<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $table = 'stok';
    protected $fillable = ['jumlah', 'tanggalDistribusi', 'batasKritis'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'product_id');
    }
}