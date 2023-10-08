<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $table = 'sekolah';
    protected $primaryKey = 'id_sekolah';

    protected $fillable = [
        'id_sekolah',
        'nama',
    ];

    public function anggota()
    {
        return $this->hasMany(Anggota::class, 'id_sekolah', 'id_sekolah');
    }


    public static function scopeFilter($query, $cari)
    {
        if ($cari) {
            $query->where(function($q) use ($cari) {
                $q->where('nama', 'like', '%'.$cari.'%')
                ->orWhere('id_sekolah', 'like', '%'.$cari.'%');
            });
        }
        return $query;
    }

}
