<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokMenu extends Model
{
    use HasFactory;

    protected $table = 'stok_menu';
    protected $primaryKey = 'id_menu';
    public $timestamps = false;

    protected $fillable = [
        'menu',
        'harga',
        'kuantitas',
        'gambar',
        'jenis_menu'
    ];
}
