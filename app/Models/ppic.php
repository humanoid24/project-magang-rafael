<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ppic extends Model
{
    protected $table = 'ppics';
    protected $fillable = [
        'so_no',
        'customer',
        'pdo_crd',
        'item_name',
        'pdoc_n',
        'item',
        'pdoc_m',
        'actual',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
