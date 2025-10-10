<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProductionReportMultiImport implements WithMultipleSheets
{
    protected $divisiId;
    protected $selectedSheet; // Tambah property untuk sheet yang dipilih

    public function __construct($divisiId)
    {
        $this->divisiId = $divisiId;
    }

    // Method untuk set sheet yang dipilih user
    public function setSheetTitle($sheet)
    {
        $this->selectedSheet = $sheet;
    }

    public function sheets(): array
    {
        // Hanya import sheet yang dipilih user
        return [
            $this->selectedSheet => new ProductionReportImport($this->divisiId)
        ];
    }
}
