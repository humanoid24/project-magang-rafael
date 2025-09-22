<?php

namespace App\Http\Controllers;

use App\Imports\ProductionReportImport;
use App\Models\Divisi;
use App\Models\ppic;
use App\Models\ProductionReport;
use App\Traits\ReportFilter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

class AdminPPICController extends Controller
{
    use ReportFilter;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $report = ProductionReport::all();

        return view('adminppic.dashboard', compact('report'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $divisis = Divisi::all();
        return view('adminppic.create', compact('divisis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'so_no'       => 'required|string',
            'customer'    => 'required|string',
            'pdo_crd'     => 'required|string',
            'item_name'   => 'required|string',
            'qty'         => 'required|string',
            'weight_pcs'  => 'required|string',
            'actual'      => 'nullable|string',
            'divisi_id'   => 'required|exists:divisis,id',
        ]);

        $validatedData['actual'] = $validatedData['actual'] ?? '-';
        ProductionReport::create($validatedData);

        // Ambil nama divisi
        $divisi = Divisi::findOrFail($validatedData['divisi_id']);
        $divisiName = strtolower($divisi->divisi);

        // Mapping divisi → route
        $divisiRoutes = [
            'janfar'           => 'ppic.janfar',
            'sawing'           => 'ppic.sawing',
            'cutting'          => 'ppic.cutting',
            'bending'          => 'ppic.bending',
            'press'            => 'ppic.press',
            'racking'          => 'ppic.racking',
            'rollforming'      => 'ppic.rollforming',
            'spotwelding'      => 'ppic.spotwelding',
            'weldingaccesoris' => 'ppic.weldingaccesoris',
            'weldingshofiting1' => 'ppic.weldingshofiting1',
            'weldingshofiting2' => 'ppic.weldingshofiting2',
            'weldingdoor'      => 'ppic.weldingdoor',
        ];

        // Ambil route sesuai divisi, fallback ke janfar kalau tidak ditemukan
        $route = $divisiRoutes[$divisiName] ?? 'ppic.janfar';

        return redirect()->route($route)
            ->with('success', 'Perintah pekerjaan berhasil disimpan!');
    }


    public function importCreate()
    {
        $divisis = Divisi::all();
        return view('adminppic.createexcel', compact('divisis')); 
    }

    public function import(Request $request)
    {
        // Simpan hasil validasi ke variabel
        $validatedData = $request->validate([
            'divisi_id' => 'required|exists:divisis,id',
            'file'      => 'required|mimes:xlsx,csv'
        ]);

        try {
            // Import file sesuai divisi
            Excel::import(new ProductionReportImport($validatedData['divisi_id']), $request->file('file'));

            // Ambil nama divisi
            $divisi = Divisi::findOrFail($validatedData['divisi_id']);
            $divisiName = strtolower(str_replace(' ', '', $divisi->divisi));

            // Mapping divisi → route
            $divisiRoutes = [
                'janfar'            => 'ppic.janfar',
                'sawing'            => 'ppic.sawing',
                'cutting'           => 'ppic.cutting',
                'bending'           => 'ppic.bending',
                'press'             => 'ppic.press',
                'racking'           => 'ppic.racking',
                'rollforming'       => 'ppic.rollforming',
                'spotwelding'       => 'ppic.spotwelding',
                'weldingaccesoris'  => 'ppic.weldingaccesoris',
                'weldingshofiting1' => 'ppic.weldingshofiting1',
                'weldingshofiting2' => 'ppic.weldingshofiting2',
                'weldingdoor'       => 'ppic.weldingdoor',
            ];

            // Ambil route sesuai divisi, fallback ke janfar kalau tidak ditemukan
            $route = $divisiRoutes[$divisiName] ?? 'ppic.index';

            return redirect()->route($route)
                ->with('success', 'Data Production Report berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }





    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $report = ProductionReport::findOrFail($id);
        return view('adminppic.edit', compact('report'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi sesuai form Perintah Pekerjaan
        $validatedData = $request->validate([
            'so_no'       => 'required|string',
            'customer'    => 'required|string',
            'pdo_crd'     => 'required|string',
            'item_name'   => 'required|string',
            'qty'         => 'required',
            'weight_pcs'  => 'required',
            // 'actual'      => 'nullable|string',
        ]);

        // Ambil data berdasarkan id
        $report = ProductionReport::findOrFail($id);

        // Update data
        $report->update($validatedData);

        // Ambil divisi dari data yang diupdate
        $divisiName = strtolower(str_replace(' ', '', $report->divisi->divisi));

        // Mapping divisi → route
        $divisiRoutes = [
            'janfar'           => 'ppic.janfar',
            'sawing'           => 'ppic.sawing',
            'cutting'          => 'ppic.cutting',
            'bending'          => 'ppic.bending',
            'press'            => 'ppic.press',
            'racking'          => 'ppic.racking',
            'rollforming'      => 'ppic.rollforming',
            'spotwelding'      => 'ppic.spotwelding',
            'weldingaccesoris' => 'ppic.weldingaccesoris',
            'weldingshofiting1' => 'ppic.weldingshofiting1',
            'weldingshofiting2' => 'ppic.weldingshofiting2',
            'weldingdoor'      => 'ppic.weldingdoor',
        ];

        // Ambil route sesuai divisi, fallback ke janfar
        $route = $divisiRoutes[$divisiName] ?? 'ppic.janfar';

        return redirect()->route($route)
            ->with('success', 'Perintah pekerjaan berhasil diperbarui!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $report = ProductionReport::findOrFail($id);
        $report->delete();

        return redirect()->back()
            ->with('success', 'Laporan berhasil dihapus!');
    }



    public function janfar(Request $request)
    {
        $divisi = Divisi::where('divisi', 'JANFAR')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        // search filter
        $columns = Schema::getColumnListing('production_reports');
        $this->filterBySearch($query, $request->search, $columns);

        // ambil data dengan pagination
        $report = $query->paginate(10)->appends($request->all());

        return view('adminppic.divisi.janfar', compact('report'));
    }



    public function lihatsemuadatajanfar(Request $request)
    {
        $tanggal_awal = $request->input('tanggal_report');
        $tanggal_akhir = $request->input('tanggal_report_akhir');

        $divisi = Divisi::where('divisi', 'JANFAR')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        // filter tanggal
        $this->filterByDate($query, $tanggal_awal, $tanggal_akhir);

        // search filter
        $columns = Schema::getColumnListing('production_reports');
        $this->filterBySearch($query, $request->search, $columns);

        $report = $query->paginate(10)->appends($request->all());

        return view('adminppic.divisi.janfar', compact('report', 'tanggal_awal', 'tanggal_akhir'));
    }


    public function exportJanfar(Request $request)
    {
        $title = "Laporan Produksi Workcenter Janfar";

        $divisi = Divisi::where('divisi', 'JANFAR')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('mulai_kerja', [
                $request->tanggal_awal . " 00:00:00",
                $request->tanggal_akhir . " 23:59:59"
            ]);
        }

        $report = $query->get(); // ambil data di akhir

        return response()->view('adminppic.divisi.export.export_divisi', compact('report', 'title'))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', "attachment; filename=laporan_janfar.xls")
            ->header('Cache-Control', 'no-cache, must-revalidate')
            ->header('Pragma', 'no-cache');
    }



    public function sawing(Request $request)
    {
        $divisi = Divisi::where('divisi', 'SAWING')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        // search filter
        $columns = Schema::getColumnListing('production_reports');
        $this->filterBySearch($query, $request->search, $columns);

        // ambil data dengan pagination
        $report = $query->paginate(10)->appends($request->all());

        return view('adminppic.divisi.sawing', compact('report'));
    }


    public function lihatsemuadatasawing(Request $request)
    {
        $tanggal_awal = $request->input('tanggal_report');
        $tanggal_akhir = $request->input('tanggal_report_akhir');

        $divisi = Divisi::where('divisi', 'SAWING')->first();

        // query awal
        $query = ProductionReport::where('divisi_id', $divisi->id);

        // filter tanggal
        $this->filterByDate($query, $tanggal_awal, $tanggal_akhir);

        // search filter
        $columns = Schema::getColumnListing('production_reports');
        $this->filterBySearch($query, $request->search, $columns);


        // ambil data dengan pagination
        $report = $query->paginate(10)->appends($request->all());

        return view('adminppic.divisi.sawing', compact('report', 'tanggal_awal', 'tanggal_akhir'));
    }


    public function exportSawing(Request $request)
    {
        $title = "Laporan Produksi Workcenter Sawing";

        $divisi = Divisi::where('divisi', 'SAWING')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('mulai_kerja', [
                $request->tanggal_awal . " 00:00:00",
                $request->tanggal_akhir . " 23:59:59"
            ]);
        }

        $report = $query->get(); // ambil data di akhir

        return response()->view('adminppic.divisi.export.export_divisi', compact('report', 'title'))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', "attachment; filename=laporan_sawing.xls")
            ->header('Cache-Control', 'no-cache, must-revalidate')
            ->header('Pragma', 'no-cache');
    }



    public function cutting(Request $request)
    {
        // cari divisi_id CUTTING
        $divisi = Divisi::where('divisi', 'CUTTING')->first();

        // query awal
        $query = ProductionReport::where('divisi_id', $divisi->id);

        // search filter
        $columns = Schema::getColumnListing('production_reports');
        $this->filterBySearch($query, $request->search, $columns);

        // ambil data dengan pagination
        $report = $query->paginate(10)->appends($request->all());

        return view('adminppic.divisi.cutting', compact('report'));
    }


    public function lihatsemuadatacutting(Request $request)
    {
        $tanggal_awal = $request->input('tanggal_report');
        $tanggal_akhir = $request->input('tanggal_report_akhir');

        $divisi = Divisi::where('divisi', 'CUTTING')->first();

        // query awal
        $query = ProductionReport::where('divisi_id', $divisi->id);

        // filter tanggal
        $this->filterByDate($query, $tanggal_awal, $tanggal_akhir);

        // search filter
        $columns = Schema::getColumnListing('production_reports');
        $this->filterBySearch($query, $request->search, $columns);


        // ambil data dengan pagination
        $report = $query->paginate(10)->appends($request->all());

        return view('adminppic.divisi.cutting', compact('report', 'tanggal_awal', 'tanggal_akhir'));
    }


    public function exportCutting(Request $request)
    {
        $title = "Laporan Produksi Workcenter Cutting";

        $divisi = Divisi::where('divisi', 'CUTTING')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('mulai_kerja', [
                $request->tanggal_awal . " 00:00:00",
                $request->tanggal_akhir . " 23:59:59"
            ]);
        }

        $report = $query->get(); // ambil data di akhir

        return response()->view('adminppic.divisi.export.export_divisi', compact('report', 'title'))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', "attachment; filename=laporan_cutting.xls")
            ->header('Cache-Control', 'no-cache, must-revalidate')
            ->header('Pragma', 'no-cache');
    }

    public function bending(Request $request)
    {
        // cari divisi_id BENDING
        $divisi = Divisi::where('divisi', 'BENDING')->first();

        // query awal
        $query = ProductionReport::where('divisi_id', $divisi->id);

        // search filter
        $columns = Schema::getColumnListing('production_reports');
        $this->filterBySearch($query, $request->search, $columns);

        // ambil data dengan pagination
        $report = $query->paginate(10)->appends($request->all());

        return view('adminppic.divisi.bending', compact('report'));
    }


    public function lihatsemuadatabending(Request $request)
    {
        $tanggal_awal = $request->input('tanggal_report');
        $tanggal_akhir = $request->input('tanggal_report_akhir');

        $divisi = Divisi::where('divisi', 'BENDING')->first();

        // query awal
        $query = ProductionReport::where('divisi_id', $divisi->id);

        // filter tanggal
        $this->filterByDate($query, $tanggal_awal, $tanggal_akhir);

        // search filter
        $columns = Schema::getColumnListing('production_reports');
        $this->filterBySearch($query, $request->search, $columns);

        // ambil data dengan pagination
        $report = $query->paginate(10)->appends($request->all());

        return view('adminppic.divisi.bending', compact('report', 'tanggal_awal', 'tanggal_akhir'));
    }



    public function exportBending(Request $request)
    {
        $title = "Laporan Produksi Workcenter Bending";

        $divisi = Divisi::where('divisi', 'BENDING')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('mulai_kerja', [
                $request->tanggal_awal . " 00:00:00",
                $request->tanggal_akhir . " 23:59:59"
            ]);
        }

        $report = $query->get(); // ambil data di akhir

        return response()->view('adminppic.divisi.export.export_divisi', compact('report', 'title'))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', "attachment; filename=laporan_bending.xls")
            ->header('Cache-Control', 'no-cache, must-revalidate')
            ->header('Pragma', 'no-cache');
    }


    public function press(Request $request)
    {
        // cari divisi_id PRESS
        $divisi = Divisi::where('divisi', 'PRESS')->first();

        // query awal
        $query = ProductionReport::where('divisi_id', $divisi->id);

        // search filter
        $columns = Schema::getColumnListing('production_reports');
        $this->filterBySearch($query, $request->search, $columns);

        // ambil data dengan pagination
        $report = $query->paginate(10)->appends($request->all());

        return view('adminppic.divisi.press', compact('report'));
    }


    public function lihatsemuadatapress(Request $request)
    {
        $tanggal_awal = $request->input('tanggal_report');
        $tanggal_akhir = $request->input('tanggal_report_akhir');

        $divisi = Divisi::where('divisi', 'PRESS')->first();

        // query awal
        $query = ProductionReport::where('divisi_id', $divisi->id);

        // filter tanggal
        $this->filterByDate($query, $tanggal_awal, $tanggal_akhir);

        // search filter
        $columns = Schema::getColumnListing('production_reports');
        $this->filterBySearch($query, $request->search, $columns);


        // ambil data dengan pagination
        $report = $query->paginate(10)->appends($request->all());

        return view('adminppic.divisi.press', compact('report', 'tanggal_awal', 'tanggal_akhir'));
    }


    public function exportPress(Request $request)
    {
        $title = "Laporan Produksi Workcenter Press";

        $divisi = Divisi::where('divisi', 'PRESS')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('mulai_kerja', [
                $request->tanggal_awal . " 00:00:00",
                $request->tanggal_akhir . " 23:59:59"
            ]);
        }

        $report = $query->get(); // ambil data di akhir

        return response()->view('adminppic.divisi.export.export_divisi', compact('report', 'title'))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', "attachment; filename=laporan_press.xls")
            ->header('Cache-Control', 'no-cache, must-revalidate')
            ->header('Pragma', 'no-cache');
    }


    public function racking(Request $request)
    {
        // cari divisi_id RACKING
        $divisi = Divisi::where('divisi', 'RACKING')->first();

        // query awal
        $query = ProductionReport::where('divisi_id', $divisi->id);

        // search filter
        $columns = Schema::getColumnListing('production_reports');
        $this->filterBySearch($query, $request->search, $columns);


        // ambil data dengan pagination
        $report = $query->paginate(10)->appends($request->all());

        return view('adminppic.divisi.racking', compact('report'));
    }


    public function lihatsemuadataracking(Request $request)
    {
        $tanggal_awal = $request->input('tanggal_report');
        $tanggal_akhir = $request->input('tanggal_report_akhir');

        $divisi = Divisi::where('divisi', 'RACKING')->first();

        // query awal
        $query = ProductionReport::where('divisi_id', $divisi->id);

        // filter tanggal
        $this->filterByDate($query, $tanggal_awal, $tanggal_akhir);

        // search filter
        $columns = Schema::getColumnListing('production_reports');
        $this->filterBySearch($query, $request->search, $columns);

        // ambil data dengan pagination
        $report = $query->paginate(10)->appends($request->all());

        return view('adminppic.divisi.racking', compact('report', 'tanggal_awal', 'tanggal_akhir'));
    }



    public function exportRacking(Request $request)
    {
        $title = "Laporan Produksi Workcenter Racking";

        $divisi = Divisi::where('divisi', 'RACKING')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('mulai_kerja', [
                $request->tanggal_awal . " 00:00:00",
                $request->tanggal_akhir . " 23:59:59"
            ]);
        }

        $report = $query->get(); // ambil data di akhir

        return response()->view('adminppic.divisi.export.export_divisi', compact('report', 'title'))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', "attachment; filename=laporan_racking.xls")
            ->header('Cache-Control', 'no-cache, must-revalidate')
            ->header('Pragma', 'no-cache');
    }


    public function rollforming(Request $request)
    {
        // cari divisi_id ROLL FORMING
        $divisi = Divisi::where('divisi', 'ROLL FORMING')->first();

        $query = ProductionReport::where('divisi_id', $divisi->id);

        // search filter
        $columns = Schema::getColumnListing('production_reports');
        $this->filterBySearch($query, $request->search, $columns);

        // ambil data dengan pagination
        $report = $query->paginate(10)->appends($request->all());

        return view('adminppic.divisi.rollforming', compact('report'));
    }


    public function lihatsemuadatarollforming(Request $request)
    {
        $tanggal_awal = $request->input('tanggal_report');
        $tanggal_akhir = $request->input('tanggal_report_akhir');

        $divisi = Divisi::where('divisi', 'ROLL FORMING')->first();

        $query = ProductionReport::where('divisi_id', $divisi->id);

        // filter tanggal
        $this->filterByDate($query, $tanggal_awal, $tanggal_akhir);

        // search filter
        $columns = Schema::getColumnListing('production_reports');
        $this->filterBySearch($query, $request->search, $columns);


        // ambil data dengan pagination
        $report = $query->paginate(10)->appends($request->all());

        return view('adminppic.divisi.rollforming', compact('report', 'tanggal_awal', 'tanggal_akhir'));
    }



    public function exportrollForming(Request $request)
    {
        $title = "Laporan Produksi Workcenter Roll Forming";

        $divisi = Divisi::where('divisi', 'ROLL FORMING')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('mulai_kerja', [
                $request->tanggal_awal . " 00:00:00",
                $request->tanggal_akhir . " 23:59:59"
            ]);
        }

        $report = $query->get(); // ambil data di akhir

        return response()->view('adminppic.divisi.export.export_divisi', compact('report', 'title'))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', "attachment; filename=laporan_rollforming.xls")
            ->header('Cache-Control', 'no-cache, must-revalidate')
            ->header('Pragma', 'no-cache');
    }


    public function spotwelding(Request $request)
    {
        // cari divisi_id JANFAR
        $divisi = Divisi::where('divisi', 'SPOT WELDING')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        // search filter
        $columns = Schema::getColumnListing('production_reports');
        $this->filterBySearch($query, $request->search, $columns);

        // ambil data dengan pagination
        $report = $query->paginate(10)->appends($request->all());

        return view('adminppic.divisi.spotwelding', compact('report'));
    }

    public function lihatsemuadataspotwelding(Request $request)
    {
        // Ambil tanggal dari request
        $tanggal_awal = $request->input('tanggal_report');  // misal 2025-08-01
        $tanggal_akhir = $request->input('tanggal_report_akhir'); // misal 2025-09-10

        $divisi = Divisi::where('divisi', 'SPOT WELDING')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        // filter tanggal
        $this->filterByDate($query, $tanggal_awal, $tanggal_akhir);

        // search filter
        $columns = Schema::getColumnListing('production_reports');
        $this->filterBySearch($query, $request->search, $columns);

        $report = $query->paginate(10)->appends($request->all());

        return view('adminppic.divisi.spotwelding', compact('report', 'tanggal_awal', 'tanggal_akhir'));
    }


    public function exportSpotWelding(Request $request)
    {
        $title = "Laporan Produksi Workcenter Spot Welding";

        $divisi = Divisi::where('divisi', 'SPOT WELDING')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('mulai_kerja', [
                $request->tanggal_awal . " 00:00:00",
                $request->tanggal_akhir . " 23:59:59"
            ]);
        }

        $report = $query->get(); // ambil data di akhir

        return response()->view('adminppic.divisi.export.export_divisi', compact('report', 'title'))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', "attachment; filename=laporan_spotwelding.xls")
            ->header('Cache-Control', 'no-cache, must-revalidate')
            ->header('Pragma', 'no-cache');
    }


    public function weldingaccesoris(Request $request)
    {
        // cari divisi_id JANFAR
        $divisi = Divisi::where('divisi', 'WELDING ACCESORIS')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        // search filter
        $columns = Schema::getColumnListing('production_reports');
        $this->filterBySearch($query, $request->search, $columns);

        // ambil data dengan pagination
        $report = $query->paginate(10)->appends($request->all());
        return view('adminppic.divisi.weldingaccesoris', compact('report'));
    }

    public function lihatsemuadataweldingaccesoris(Request $request)
    {
        // Ambil tanggal dari request
        $tanggal_awal = $request->input('tanggal_report');  // misal 2025-08-01
        $tanggal_akhir = $request->input('tanggal_report_akhir'); // misal 2025-09-10

        $divisi = Divisi::where('divisi', 'WELDING ACCESORIS')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        // filter tanggal
        $this->filterByDate($query, $tanggal_awal, $tanggal_akhir);

        // search filter
        $columns = Schema::getColumnListing('production_reports');
        $this->filterBySearch($query, $request->search, $columns);

        $report = $query->paginate(10)->appends($request->all());
        return view('adminppic.divisi.weldingaccesoris', compact('report', 'tanggal_awal', 'tanggal_akhir'));
    }

    public function exportWeldingAccesoris(Request $request)
    {
        $title = "Laporan Produksi Workcenter Welding Accesoris";

        $divisi = Divisi::where('divisi', 'WELDING ACCESORIS')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('mulai_kerja', [
                $request->tanggal_awal . " 00:00:00",
                $request->tanggal_akhir . " 23:59:59"
            ]);
        }

        $report = $query->get(); // ambil data di akhir

        return response()->view('adminppic.divisi.export.export_divisi', compact('report', 'title'))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', "attachment; filename=laporan_weldingaccesoris.xls")
            ->header('Cache-Control', 'no-cache, must-revalidate')
            ->header('Pragma', 'no-cache');
    }



    public function weldingshofiting1(Request $request)
    {
        // cari divisi_id JANFAR
        $divisi = Divisi::where('divisi', 'WELDING SHOFITING 1')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        // search filter
        $columns = Schema::getColumnListing('production_reports');
        $this->filterBySearch($query, $request->search, $columns);

        // ambil data dengan pagination
        $report = $query->paginate(10)->appends($request->all());

        return view('adminppic.divisi.weldingshofting1', compact('report'));
    }

    public function lihatsemuadataweldingshofiting1(Request $request)
    {
        // Ambil tanggal dari request
        $tanggal_awal = $request->input('tanggal_report');  // misal 2025-08-01
        $tanggal_akhir = $request->input('tanggal_report_akhir'); // misal 2025-09-10

        $divisi = Divisi::where('divisi', 'JANFAR')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        // filter tanggal
        $this->filterByDate($query, $tanggal_awal, $tanggal_akhir);

        // search filter
        $columns = Schema::getColumnListing('production_reports');
        $this->filterBySearch($query, $request->search, $columns);

        $report = $query->paginate(10)->appends($request->all());

        return view('adminppic.divisi.weldingshofting1', compact('report', 'tanggal_awal', 'tanggal_akhir'));
    }


    public function exportWeldingShofiting1(Request $request)
    {
        $title = "Laporan Produksi Workcenter Welding Shofiting 1";

        $divisi = Divisi::where('divisi', 'WELDING SHOFITING 1')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('mulai_kerja', [
                $request->tanggal_awal . " 00:00:00",
                $request->tanggal_akhir . " 23:59:59"
            ]);
        }

        $report = $query->get(); // ambil data di akhir

        return response()->view('adminppic.divisi.export.export_divisi', compact('report', 'title'))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', "attachment; filename=laporan_weldingshofiting1.xls")
            ->header('Cache-Control', 'no-cache, must-revalidate')
            ->header('Pragma', 'no-cache');
    }


    public function weldingshofiting2(Request $request)
    {
        // cari divisi_id JANFAR
        $divisi = Divisi::where('divisi', 'WELDING SHOFITING 2')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        // search filter
        $columns = Schema::getColumnListing('production_reports');
        $this->filterBySearch($query, $request->search, $columns);

        // ambil data dengan pagination
        $report = $query->paginate(10)->appends($request->all());

        return view('adminppic.divisi.weldingshofting2', compact('report'));
    }

    public function lihatsemuadataweldingshofiting2(Request $request)
    {
        // Ambil tanggal dari request
        $tanggal_awal = $request->input('tanggal_report');  // misal 2025-08-01
        $tanggal_akhir = $request->input('tanggal_report_akhir'); // misal 2025-09-10

        $divisi = Divisi::where('divisi', 'WELDING SHOFITING 2')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        // filter tanggal
        $this->filterByDate($query, $tanggal_awal, $tanggal_akhir);

        // search filter
        $columns = Schema::getColumnListing('production_reports');
        $this->filterBySearch($query, $request->search, $columns);

        $report = $query->paginate(10)->appends($request->all());

        return view('adminppic.divisi.weldingshofting2', compact('report', 'tanggal_awal', 'tanggal_akhir'));
    }

    public function exportWeldingShofiting2(Request $request)
    {
        $title = "Laporan Produksi Workcenter Welding Shofiting 2";

        $divisi = Divisi::where('divisi', 'WELDING SHOFITING 2')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('mulai_kerja', [
                $request->tanggal_awal . " 00:00:00",
                $request->tanggal_akhir . " 23:59:59"
            ]);
        }

        $report = $query->get(); // ambil data di akhir

        return response()->view('adminppic.divisi.export.export_divisi', compact('report', 'title'))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', "attachment; filename=laporan_weldingshofiting2.xls")
            ->header('Cache-Control', 'no-cache, must-revalidate')
            ->header('Pragma', 'no-cache');
    }


    public function weldingdoor(Request $request)
    {
        // cari divisi_id JANFAR
        $divisi = Divisi::where('divisi', 'WELDING DOOR')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        // search filter
        $columns = Schema::getColumnListing('production_reports');
        $this->filterBySearch($query, $request->search, $columns);

        // ambil data dengan pagination
        $report = $query->paginate(10)->appends($request->all());

        return view('adminppic.divisi.weldingdoor', compact('report'));
    }

    public function lihatsemuadataweldingdoor(Request $request)
    {
        // Ambil tanggal dari request
        $tanggal_awal = $request->input('tanggal_report');  // misal 2025-08-01
        $tanggal_akhir = $request->input('tanggal_report_akhir'); // misal 2025-09-10

        $divisi = Divisi::where('divisi', 'WELDING DOOR')->first();

        $query = ProductionReport::where('divisi_id', $divisi->id);

        // filter tanggal
        $this->filterByDate($query, $tanggal_awal, $tanggal_akhir);

        // search filter
        $columns = Schema::getColumnListing('production_reports');
        $this->filterBySearch($query, $request->search, $columns);

        $report = $query->paginate(10)->appends($request->all());

        return view('adminppic.divisi.weldingdoor', compact('report', 'tanggal_awal', 'tanggal_akhir'));
    }

    public function exportWeldingDoor(Request $request)
    {
        $title = "Laporan Produksi Workcenter Welding Door";

        $divisi = Divisi::where('divisi', 'WELDING DOOR')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('mulai_kerja', [
                $request->tanggal_awal . " 00:00:00",
                $request->tanggal_akhir . " 23:59:59"
            ]);
        }

        $report = $query->get(); // ambil data di akhir

        return response()->view('adminppic.divisi.export.export_divisi', compact('report', 'title'))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', "attachment; filename=laporan_weldingdoor.xls")
            ->header('Cache-Control', 'no-cache, must-revalidate')
            ->header('Pragma', 'no-cache');
    }

}
