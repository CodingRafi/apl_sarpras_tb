<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user(){
        return $this->hasOne(User::class);
    }

    public function kelas(){
        return $this->hasMany(Kelas::class, 'sekolah_id');
    }

    public function kategori(){
        return $this->hasMany(Kategori::class, 'sekolah_id');
    }

    public function subcategories(){
        return $this->hasMany(Subcategory::class, 'sekolah_id');
    }

    public function produks(){
        return $this->hasMany(Produk::class, 'sekolah_id');
    }

    public function ruang(){
        return $this->hasMany(Ruang::class, 'sekolah_id');
    }
}