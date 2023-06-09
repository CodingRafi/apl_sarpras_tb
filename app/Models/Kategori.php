<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function sekolah(){
        return $this->belongsTo(Sekolah::class);
    }

    public function subcategory(){
        return $this->hasMany(Subcategory::class);
    }

    public function ruang(){
        return $this->hasMany(Ruang::class);
    }
}
