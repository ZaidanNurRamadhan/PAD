<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $fillable = ['name', 'hargaBeli', 'hargaJual', 'batasKritis', 'jumlah'];


    public function stok()
    {
        return $this->hasOne(Stok::class, 'product_id');
    }
    public function pemasok()
{
    return $this->belongsTo(Pemasok::class, 'pemasok_id');
}

}
