<?php

namespace App\Imports;

use App\Models\ProductionReport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductionReportImport implements ToCollection
{
    protected $divisiId;

    public function __construct($divisiId)
    {
        $this->divisiId = $divisiId;
    }

    public function collection(Collection $rows)
    {
        $headers = [];
        $dataStart = false;

        foreach ($rows as $row) {
            $rowArray = $row->toArray();

            // Cari baris header
            if (!$dataStart && $this->isHeaderRow($rowArray)) {
                $headers = array_map(function ($h) {
                    return $this->normalizeHeader($h);
                }, $rowArray);

                $dataStart = true;
                continue; // lewati baris header
            }

            if ($dataStart) {
                $data = @array_combine($headers, $rowArray);
                if (!$data) continue;

                // Skip baris invalid
                if (
                    empty($data['so_no']) ||
                    strtolower(trim($data['so_no'])) === 'so no' ||
                    strtolower(trim($data['customer'])) === 'customer'
                ) {
                    continue;
                }

                ProductionReport::create([
                    'divisi_id'     => $this->divisiId,
                    'so_no'         => $this->getValue($data, ['so_no']),
                    'customer'      => $this->getValue($data, ['customer']),
                    'pdo_crd'       => $this->getValue($data, ['pdocrd', 'pdo_crd']),
                    'item_name'     => $this->getValue($data, ['item_name']),
                    'qty'           => $this->getNumeric($data, ['pdocrd_qty', 'pdo_qty', 'qty']),
                    'weight_pcs'    => $this->getNumeric($data, ['item_weight', 'weight_per_pcs']),
                    'weight_total'  => $this->getNumeric($data, ['pdocrd_weight_total', 'total_weight']),
                ]);
            }
        }
    }

    private function normalizeHeader($header)
    {
        $h = trim($header);
        $h = strtolower($h);
        $h = str_replace([' ', '-', '__'], '_', $h);
        $h = preg_replace('/_+/', '_', $h);

        // Mapping manual jika header Excel aneh
        $map = [
            'so no'                 => 'so_no',
            'sono'                  => 'so_no',
            'customer_name'         => 'customer',
            'cust'                  => 'customer',
            'pdocrd qty'            => 'pdocrd_qty',
            'pdo_crd qty'           => 'pdocrd_qty',
            'qty'                   => 'pdocrd_qty',
            'pdo crd qty'           => 'pdocrd_qty',
            'pdocrdqty'           => 'pdocrd_qty',
            'itemweight'            => 'item_weight',
            'item weight'           => 'item_weight',
            'item_weight'           => 'item_weight',
            'weight per pcs'        => 'item_weight',
            'total_weight'          => 'pdocrd_weight_total',
            'pdo_crd_weight_total'  => 'pdocrd_weight_total',
            'pdo crd weight total'  => 'pdocrd_weight_total',
            'pdocrd_weight_total'  => 'pdocrd_weight_total',

        ];

        return $map[$h] ?? $h;
    }

    private function isHeaderRow($rowArray)
    {
        $rowLower = array_map(fn($v) => strtolower(trim($v)), $rowArray);
        return in_array('so no', $rowLower) && in_array('customer', $rowLower);
    }

    /**
     * Ambil value dari beberapa kemungkinan key
     */
    private function getValue(array $data, array $keys, $default = null)
    {
        foreach ($keys as $key) {
            if (isset($data[$key]) && $data[$key] !== '') {
                return $data[$key];
            }
        }
        return $default;
    }

    /**
     * Ambil angka dari beberapa kemungkinan key, fallback 0
     */
    private function getNumeric(array $data, array $keys, $default = 0)
    {
        foreach ($keys as $key) {
            if (isset($data[$key]) && is_numeric($data[$key])) {
                return $data[$key];
            }
        }
        return $default;
    }
}
