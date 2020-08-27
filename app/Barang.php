<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = "barang";

    protected $primaryKey = "id";
    
    protected $fillable = [
        'nama_barang',
        'gambar_barang',
        'stok_barang'
    ];
}
