<?php

namespace App\Imports;

use App\Models\ProductionReport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class ProductionReportImport implements ToCollection, WithCalculatedFormulas
{
    protected $divisiId;
    protected $sheetTitle;


    public function __construct($divisiId)
    {
        $this->divisiId = $divisiId;
    }

    public function setSheetTitle($title)
    {
        $this->sheetTitle = $title;
    }

    public function collection(Collection $rows)
    {
        $headers = [];
        $dataStart = false;

        // optional: bisa simpan sheet_title di DB
        $sheetDate = $this->sheetTitle;


        foreach ($rows as $index => $row) {
            $rowArray = $row->toArray();

            // cari header
            if (!$dataStart && $this->isHeaderRow($rowArray)) {
                $headers = array_map(function ($h) {
                    return $this->normalizeHeader($h);
                }, $rowArray);
                // Log::info('✅ Detected Headers (Row ' . ($index + 1) . '):', $headers);

                $dataStart = true;
                continue; // lewati baris header
            }

            if ($dataStart) {
                $finalHeaders = [];
                $seen = [];

                foreach ($headers as $h) {
                    if (!isset($seen[$h])) {
                        $seen[$h] = 1;
                        $finalHeaders[] = $h;
                    } else {
                        $seen[$h]++;
                        $finalHeaders[] = $h . '_' . $seen[$h]; // kasih suffix
                    }
                }

                $data = @array_combine($finalHeaders, $rowArray);

                Log::debug('📌 Headers final:', $finalHeaders);
                Log::debug('📌 Data row:', $data);

                if (!$data) continue;

                // Log::info('📌 Mapped Row (Row ' . ($index + 1) . '):', $data);

                // Skip baris invalid
                if (
                    empty($data['so_no']) ||
                    strtolower(trim($data['so_no'])) === 'so no' ||
                    strtolower(trim($data['customer'])) === 'customer'
                ) {
                    continue;
                }

                try {
                    $report = ProductionReport::create([
                        'divisi_id'     => $this->divisiId,
                        'pdo_due_date' => $this->getValue($data, ['pdo_due_date', 'pdo due date'])
                            ? $this->parseDate($this->getValue($data, ['pdo_due_date', 'pdo due date']))
                            : null,

                        'so_no'         => $this->getValue($data, ['so no', 'so_no']),
                        'customer'      => $this->getValue($data, ['customer']),
                        'pdo_crd'       => $this->getValue($data, ['pdo_crd', 'pdocrd']),
                        'item_code'     => $this->getValue($data, ['item_code']),
                        'item_name'     => $this->getValue($data, ['item name', 'item_name']),
                        'qty' => $this->getNumeric($data, ['pdocrd_qty']),
                        'tebal'         => $this->getNumeric($data, ['tebal']) ?? 0,
                        'panjang'       => $this->getNumeric($data, ['panjang']) ?? 0,
                        'lebar'         => $this->getNumeric($data, ['lebar']) ?? 0,
                        'item_weight'   => $this->getNumeric($data, ['item_weight', 'item weight', 'weight_per_pcs']),
                        'sheet_date'  => $this->sheetTitle, // nama sheet / tanggal
                    ]);
                    // Log::debug('📝 Data akan disimpan:', $report->toArray()); // ✅ pindahin ke sini
                    // ✅ Tambahin log kalau sukses masuk DB
                    // Log::info('✅ Data berhasil disimpan ke DB (ID: ' . $report->id . ')', $report->toArray());
                } catch (\Exception $e) {
                    Log::error('Import failed: ' . $e->getMessage(), $data ?? []);
                    throw $e; // biar error muncul di browser saat dev
                }
            }
        }
    }

    private function normalizeHeader($header)
    {
        $h = trim($header);
        $h = strtolower($h);
        $h = str_replace([' ', '-', '__'], '_', $h);
        $h = preg_replace('/_+/', '_', $h);

        $map = [
            'pdo due date' => 'pdo_due_date',
            'pdo_due_date' => 'pdo_due_date',
            'item code'    => 'item_code',
            'item_code'    => 'item_code',
            'item name'    => 'item name',
            'tebal'        => 'tebal',
            'panjang'      => 'panjang',
            'lebar'        => 'lebar',
            'item weight'  => 'item_weight',
            'item_weight'  => 'item_weight',
            'weight total' => 'pdocrd weight total',
            'pdo crd weight total' => 'pdocrd weight total',
            'pdo crd qty'    => 'pdocrd_qty',
            'pdocrd qty'     => 'pdocrd_qty',
            'pdo_crd_qty'    => 'pdocrd_qty',
            'pdo crd quantity' => 'pdocrd_qty',

        ];
        return $map[$h] ?? $h;
    }

    private function isHeaderRow($rowArray)
    {
        $rowLower = array_map(fn($v) => strtolower(trim($v)), $rowArray);
        return in_array('so no', $rowLower) || in_array('so_no', $rowLower);
    }

    private function getValue(array $data, array $keys, $default = null)
    {
        foreach ($keys as $key) {
            if (isset($data[$key]) && $data[$key] !== '') {
                $val = $data[$key];

                // Cek jika ini kemungkinan tanggal Excel
                if (is_numeric($val)) {
                    try {
                        // Excel serial → Carbon date
                        return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($val))->format('Y-m-d');
                    } catch (\Exception $e) {
                        return $val; // kalau gagal, tetap return
                    }
                }

                return $val;
            }
        }
        return $default;
    }


    private function getNumeric(array $data, array $keys, $default = 0)
    {
        foreach ($keys as $key) {
            if (isset($data[$key]) && $data[$key] !== '') {
                $val = str_replace(',', '.', $data[$key]); // ubah koma jadi titik
                if (is_numeric($val)) {
                    return $val + 0; // jadi float
                }
            }
        }
        return $default;
    }

    private function parseDate($value)
    {
        // Jika kosong, return null
        if (!$value) return null;

        // Jika angka (Excel serial)
        if (is_numeric($value)) {
            try {
                return \Carbon\Carbon::instance(
                    \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)
                )->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }

        // Jika string, coba parse
        try {
            // replace "-" dengan "/" biar lebih konsisten
            $value = str_replace('-', '/', $value);

            // buat Carbon object
            $date = \Carbon\Carbon::createFromFormat('d/m/Y', $value);

            return $date->format('Y-m-d');
        } catch (\Exception $e) {
            try {
                // fallback parse otomatis (Carbon bisa coba deteksi format lain)
                return \Carbon\Carbon::parse($value)->format('Y-m-d');
            } catch (\Exception $e) {
                return null; // kalau gagal, kasih null
            }
        }
    }
}
