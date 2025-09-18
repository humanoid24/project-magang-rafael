<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionReport extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','shift', 'mulai_kerja', 'selesai_kerja', 'bagian', 'sub_bagian', 'catatan',
        'so_no',
        'customer',
        'pdo_crd',
        'item_name',
        'qty',
        'weight_pcs',
        'weight_total',
        'actual',
        'divisi_id',];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }
}
