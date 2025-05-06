<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokMenu; // Pastikan sudah ada model StokMenu
use Illuminate\Support\Facades\Storage;

class StokMenuController extends Controller
{
    public function store(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'gambar_produk' => 'required|image|mimes:jpg,png|max:2048',
            'jenis_menu' => 'required|string',
            'nama_menu' => 'required|string|max:255',
            'kuantitas' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:1000',
        ]);

        // Menyimpan gambar ke storage
        if ($request->hasFile('gambar_produk')) {
            $imagePath = $request->file('gambar_produk')->store('images', 'public');
        }

        // Menyimpan data ke tabel stok_menu
        StokMenu::create([
            'nama_menu' => $request->input('nama_menu'),
            'harga' => $request->input('harga'),
            'kuantitas' => $request->input('kuantitas'),
            'gambar_produk' => $imagePath ?? null,  // Menyimpan path gambar
            'jenis_menu' => $request->input('jenis_menu'),
        ]);

        // Redirect atau response setelah berhasil menyimpan
        return redirect()->route('dashboard')->with('success', 'Menu berhasil ditambahkan!');
    }
}
