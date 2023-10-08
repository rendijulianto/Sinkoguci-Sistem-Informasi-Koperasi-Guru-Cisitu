<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Petugas extends Authenticatable
{
    use HasFactory;

    protected $table = 'petugas';
    protected $primaryKey = 'id_petugas';

    protected $fillable = [
        'id_petugas',
        'nama',
        'email',
        'password',
        'level',
    ];


    public static function scopeFilter($query, $cari, $level)
    {
        if ($cari) {
            $query->where(function($q) use ($cari) {
                $q->where('nama', 'like', '%'.$cari.'%')
                ->orWhere('email', 'like', '%'.$cari.'%')
                ->orWhere('level', 'like', '%'.$cari.'%')
                ->orWhere('id_petugas', 'like', '%'.$cari.'%');
            });
        }
        if ($level) {
            $query->where('level', '=', $level);
        }
        return $query;
    }
}
