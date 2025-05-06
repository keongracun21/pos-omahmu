<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokMenu extends Model
{
    protected $table = 'stok_menu'; // <--- Ini penting

    protected $primaryKey = 'id_menu'; // sesuaikan jika bukan 'id'

    public $timestamps = false;

    protected $fillable = [
        'nama_menu',
        'harga',
        'kuantitas',
        'gambar_produk',
        'jenis_menu'
    ];
}
