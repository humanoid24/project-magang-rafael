<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'divisi_id',
        'pdo_due_date',
        'so_no',
        'customer',
        'pdo_crd',
        'item_code',
        'item_name',
        'qty',
        'tebal',
        'panjang',
        'lebar',
        'item_weight',
        'jumlah_stroke',
        'actual_hasil',
        'weight_total',
        'mesin_on',
        'waktu_setting',
        'mulai_kerja',
        'selesai_kerja',
        'hasil_jam_kerja',
        'performa',
        'group',
        'shift',
        'bagian',
        'sub_bagian',
        'catatan',
 ];



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }
}
