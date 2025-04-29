<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    protected $primaryKey = 'user_id'; // Tambahkan ini
    public $incrementing = true; // Sesuaikan (true jika auto-increment)
    protected $keyType = 'int'; // Sesuaikan dengan tipe data user_id
    protected $fillable = ['name', 'email', 'phone', 'password'];
}
