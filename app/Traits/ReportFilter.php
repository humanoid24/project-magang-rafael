<?php

namespace App\Traits;

use Carbon\Carbon;

trait ReportFilter
{
    public function filterByDate($query, $tanggal_awal, $tanggal_akhir)
    {
        return $query->when($tanggal_awal && $tanggal_akhir, function ($q) use ($tanggal_awal, $tanggal_akhir) {
            $q->whereBetween('created_at', [
                Carbon::parse($tanggal_awal)->startOfDay(),
                Carbon::parse($tanggal_akhir)->endOfDay()
            ]);
        });
    }

    public function filterBySearch($query, $search, $columns)
    {
        return $query->when($search, function ($q) use ($search, $columns) {
            $q->where(function ($sub) use ($columns, $search) {
                foreach ($columns as $col) {
                    $sub->orWhere($col, 'like', "%{$search}%");
                }
            });
        });
    }
}
