<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisCuti extends Model
{
    use HasFactory;

    protected $table = 'jenis_cuti';

    protected $primaryKey = 'id_jenis_cuti';

    protected $fillable = [
        'nama_jenis_cuti',
        'maksimal_hari',
    ];
}