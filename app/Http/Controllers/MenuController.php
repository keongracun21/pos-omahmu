<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokMenu;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'kategori' => 'required|in:makanan,minuman,snack',
            'nama_menu' => 'required|string|max:100',
            'harga' => 'required|numeric|min:1000'
        ]);

        try {
            $imagePath = $request->file('gambar')->store('menu_images', 'public');

            StokMenu::create([
                'menu' => $validated['nama_menu'],
                'harga' => $validated['harga'],
                'jenis_menu' => $validated['kategori'],
                'gambar' => $imagePath,
                'kuantitas' => 0
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
    }
}
