<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\LaporanPenjualan;

class OrderController extends Controller
{
    public function submit(Request $request)
    {
        \App\Models\LaporanPenjualan::create([
            'id_transaksi' => $request->id_transaksi,
            'tanggal' => now(),
            'total' => $request->total, // pastikan ini dikirim dari frontend
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil dicatat!');
    }
}
