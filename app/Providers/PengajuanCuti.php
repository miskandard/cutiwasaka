<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanCuti extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_cuti';

    protected $primaryKey = 'id_pengajuan';

    protected $fillable = [
        'id_user',
        'tanggal_pengajuan',
        'tanggal_mulai',
        'tanggal_selesai',
        'jumlah_hari',
        'alasan_pengajuan',
        'status_pengajuan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}