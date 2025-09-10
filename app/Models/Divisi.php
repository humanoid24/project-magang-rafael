<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    protected $table = 'divisis';



    public function ppics() {
        return $this->hasMany(Ppic::class);
    }

    public function users() {
        return $this->hasMany(User::class);
    }
    public function productionReports()
    {
        return $this->hasMany(ProductionReport::class);
    }
    
}
