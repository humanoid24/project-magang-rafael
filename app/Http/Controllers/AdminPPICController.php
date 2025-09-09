<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\ppic;
use App\Models\ProductionReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPPICController extends Controller
{
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
        // Validasi sesuai form Perintah Pekerjaan
        $validatedData = $request->validate([
            'so_no' => 'required|string',
            'customer' => 'required|string',
            'pdo_crd' => 'required|string',
            'item_name' => 'required|string',
            'pdoc_n' => 'required|string',
            'item' => 'required|string',
            // 'pdoc_m' => 'required|string',
            'actual' => 'nullable|string',
            'divisi_id' => 'required|exists:divisis,id',
        ]);

        $validatedData['actual'] = $validatedData['actual'] ?? '-';
        $validatedData['user_id'] = Auth::id();

        // Simpan data ke database
        ProductionReport::create($validatedData);

        return redirect()->route('ppic.index')
            ->with('success', 'Perintah pekerjaan berhasil disimpan!');
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
            'so_no' => 'required|string',
            'customer' => 'required|string',
            'pdo_crd' => 'required|string',
            'item_name' => 'required|string',
            'pdoc_n' => 'required|string',
            'item' => 'required|string',
            // 'pdoc_m' => 'required|string',
            'actual' => 'string',
        ]);

        // Ambil data berdasarkan id
        $report = ProductionReport::findOrFail($id);

        // Update dengan data valid
        $report->update($validatedData);

        return redirect()->route('ppic.index')
            ->with('success', 'Perintah pekerjaan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $report = ProductionReport::findOrFail($id);
        $report->delete();

        return redirect()->route('ppic.index')
            ->with('success', 'Laporan berhasil dihapus!');
    }


    public function janfar()
    {
    // cari divisi_id JANFAR
    $divisi = Divisi::where('divisi', 'JANFAR')->first();

    // ambil report sesuai divisi
    $report = ProductionReport::where('divisi_id', $divisi->id)->get();

    return view('adminppic.divisi.janfar', compact('report'));
    }


    public function lihatsemuadatajanfar(Request $request)
    {
        // Ambil tanggal dari request
        $tanggal_report = Carbon::parse($request->tanggal_report)->toDateString();

        // Cari ID divisi JANFAR
        $divisi = Divisi::where('divisi', 'JANFAR')->first();

        // Query filter berdasarkan tanggal + divisi
        $report = ProductionReport::where('divisi_id', $divisi->id)
                    ->whereDate('created_at', $tanggal_report)
                    ->get();

        return view('adminppic.divisi.janfar', compact('report', 'tanggal_report'));
    }

    public function exportJanfar(Request $request)
    {
        $title = "Laporan Produksi Divisi Janfar";

        $divisi = Divisi::where('divisi', 'JANFAR')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('created_at', [
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



    public function sawing()
        {
            // cari divisi_id JANFAR
            $divisi = Divisi::where('divisi', 'SAWING')->first();

            // ambil report sesuai divisi
            $report = ProductionReport::where('divisi_id', $divisi->id)->get();

            return view('adminppic.divisi.sawing', compact('report'));
        }

        public function lihatsemuadatasawing(Request $request)
    {
        // Ambil tanggal dari request
        $tanggal_report = Carbon::parse($request->tanggal_report)->toDateString();

        // Cari ID divisi JANFAR
        $divisi = Divisi::where('divisi', 'SAWING')->first();

        // Query filter berdasarkan tanggal + divisi
        $report = ProductionReport::where('divisi_id', $divisi->id)
                    ->whereDate('created_at', $tanggal_report)
                    ->get();

        return view('adminppic.divisi.sawing', compact('report', 'tanggal_report'));
    }

    public function exportSawing(Request $request)
    {
        $title = "Laporan Produksi Divisi Sawing";

        $divisi = Divisi::where('divisi', 'SAWING')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('created_at', [
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



    public function cutting()
    {
        // cari divisi_id JANFAR
        $divisi = Divisi::where('divisi', 'CUTTING')->first();

        // ambil report sesuai divisi
        $report = ProductionReport::where('divisi_id', $divisi->id)->get();

        return view('adminppic.divisi.cutting', compact('report'));
    }

    public function lihatsemuadatacutting(Request $request)
    {
        // Ambil tanggal dari request
        $tanggal_report = Carbon::parse($request->tanggal_report)->toDateString();

        // Cari ID divisi JANFAR
        $divisi = Divisi::where('divisi', 'CUTTING')->first();

        // Query filter berdasarkan tanggal + divisi
        $report = ProductionReport::where('divisi_id', $divisi->id)
                    ->whereDate('created_at', $tanggal_report)
                    ->get();

        return view('adminppic.divisi.cutting', compact('report', 'tanggal_report'));
    }

    public function exportCutting(Request $request)
    {
        $title = "Laporan Produksi Divisi Cutting";

        $divisi = Divisi::where('divisi', 'CUTTING')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('created_at', [
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

    public function bending()
    {
        // cari divisi_id JANFAR
        $divisi = Divisi::where('divisi', 'BENDING')->first();

        // ambil report sesuai divisi
        $report = ProductionReport::where('divisi_id', $divisi->id)->get();

        return view('adminppic.divisi.bending', compact('report'));
    }

    public function lihatsemuadatabending(Request $request)
    {
        // Ambil tanggal dari request
        $tanggal_report = Carbon::parse($request->tanggal_report)->toDateString();

        // Cari ID divisi JANFAR
        $divisi = Divisi::where('divisi', 'BENDING')->first();

        // Query filter berdasarkan tanggal + divisi
        $report = ProductionReport::where('divisi_id', $divisi->id)
                    ->whereDate('created_at', $tanggal_report)
                    ->get();

        return view('adminppic.divisi.bending', compact('report', 'tanggal_report'));
    }


    public function exportBending(Request $request)
    {
        $title = "Laporan Produksi Divisi Bending";

        $divisi = Divisi::where('divisi', 'BENDING')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('created_at', [
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


    public function press()
    {
        // cari divisi_id JANFAR
        $divisi = Divisi::where('divisi', 'PRESS')->first();

        // ambil report sesuai divisi
        $report = ProductionReport::where('divisi_id', $divisi->id)->get();

        return view('adminppic.divisi.press', compact('report'));
    }

    public function lihatsemuadatapress(Request $request)
    {
        // Ambil tanggal dari request
        $tanggal_report = Carbon::parse($request->tanggal_report)->toDateString();

        // Cari ID divisi JANFAR
        $divisi = Divisi::where('divisi', 'PRESS')->first();

        // Query filter berdasarkan tanggal + divisi
        $report = ProductionReport::where('divisi_id', $divisi->id)
                    ->whereDate('created_at', $tanggal_report)
                    ->get();

        return view('adminppic.divisi.press', compact('report', 'tanggal_report'));
    }

    public function exportPress(Request $request)
    {
        $title = "Laporan Produksi Divisi Press";

        $divisi = Divisi::where('divisi', 'PRESS')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('created_at', [
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


    public function racking()
    {
        // cari divisi_id JANFAR
        $divisi = Divisi::where('divisi', 'RACKING')->first();

        // ambil report sesuai divisi
        $report = ProductionReport::where('divisi_id', $divisi->id)->get();

        return view('adminppic.divisi.racking', compact('report'));
    }

    public function lihatsemuadataracking(Request $request)
    {
        // Ambil tanggal dari request
        $tanggal_report = Carbon::parse($request->tanggal_report)->toDateString();

        // Cari ID divisi JANFAR
        $divisi = Divisi::where('divisi', 'RACKING')->first();

        // Query filter berdasarkan tanggal + divisi
        $report = ProductionReport::where('divisi_id', $divisi->id)
                    ->whereDate('created_at', $tanggal_report)
                    ->get();

        return view('adminppic.divisi.racking', compact('report', 'tanggal_report'));
    }


    public function exportRacking(Request $request)
    {
        $title = "Laporan Produksi Divisi Racking";

        $divisi = Divisi::where('divisi', 'RACKING')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('created_at', [
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


    public function rollforming()
    {
        // cari divisi_id JANFAR
        $divisi = Divisi::where('divisi', 'ROLL FORMING')->first();

        // ambil report sesuai divisi
        $report = ProductionReport::where('divisi_id', $divisi->id)->get();

        return view('adminppic.divisi.rollforming', compact('report'));
    }

    public function lihatsemuadatarollforming(Request $request)
    {
        // Ambil tanggal dari request
        $tanggal_report = Carbon::parse($request->tanggal_report)->toDateString();

        // Cari ID divisi JANFAR
        $divisi = Divisi::where('divisi', 'ROLL FORMING')->first();

        // Query filter berdasarkan tanggal + divisi
        $report = ProductionReport::where('divisi_id', $divisi->id)
                    ->whereDate('created_at', $tanggal_report)
                    ->get();

        return view('adminppic.divisi.rollforming', compact('report', 'tanggal_report'));
    }


    public function exportrollForming(Request $request)
    {
        $title = "Laporan Produksi Divisi Roll Forming";

        $divisi = Divisi::where('divisi', 'ROLL FORMING')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('created_at', [
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


    public function spotwelding()
    {
        // cari divisi_id JANFAR
        $divisi = Divisi::where('divisi', 'SPOT WELDING')->first();

        // ambil report sesuai divisi
        $report = ProductionReport::where('divisi_id', $divisi->id)->get();

        return view('adminppic.divisi.spotwelding', compact('report'));
    }

    public function lihatsemuadataspotwelding(Request $request)
    {
        // Ambil tanggal dari request
        $tanggal_report = Carbon::parse($request->tanggal_report)->toDateString();

        // Cari ID divisi JANFAR
        $divisi = Divisi::where('divisi', 'SPOT WELDING')->first();

        // Query filter berdasarkan tanggal + divisi
        $report = ProductionReport::where('divisi_id', $divisi->id)
                    ->whereDate('created_at', $tanggal_report)
                    ->get();

        return view('adminppic.divisi.spotwelding', compact('report', 'tanggal_report'));
    }


    public function exportSpotWelding(Request $request)
    {
        $title = "Laporan Produksi Divisi Spot Welding";

        $divisi = Divisi::where('divisi', 'SPOT WELDING')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('created_at', [
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


    public function weldingaccesoris()
    {
        // cari divisi_id JANFAR
        $divisi = Divisi::where('divisi', 'WELDING ACCESORIS')->first();

        // ambil report sesuai divisi
        $report = ProductionReport::where('divisi_id', $divisi->id)->get();

        return view('adminppic.divisi.weldingaccesoris', compact('report'));
    }

    public function lihatsemuadataweldingaccesoris(Request $request)
    {
        // Ambil tanggal dari request
        $tanggal_report = Carbon::parse($request->tanggal_report)->toDateString();

        // Cari ID divisi JANFAR
        $divisi = Divisi::where('divisi', 'WELDING ACCESORIS')->first();

        // Query filter berdasarkan tanggal + divisi
        $report = ProductionReport::where('divisi_id', $divisi->id)
                    ->whereDate('created_at', $tanggal_report)
                    ->get();

        return view('adminppic.divisi.weldingaccesoris', compact('report', 'tanggal_report'));
    }

    public function exportWeldingAccesoris(Request $request)
    {
        $title = "Laporan Produksi Divisi Welding Accesoris";

        $divisi = Divisi::where('divisi', 'WELDING ACCESORIS')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('created_at', [
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



    public function weldingshofiting1()
    {
        // cari divisi_id JANFAR
        $divisi = Divisi::where('divisi', 'WELDING SHOFITING 1')->first();

        // ambil report sesuai divisi
        $report = ProductionReport::where('divisi_id', $divisi->id)->get();

        return view('adminppic.divisi.weldingshofting1', compact('report'));
    }

    public function lihatsemuadataweldingshofiting1(Request $request)
    {
        // Ambil tanggal dari request
        $tanggal_report = Carbon::parse($request->tanggal_report)->toDateString();

        // Cari ID divisi JANFAR
        $divisi = Divisi::where('divisi', 'WELDING SHOFITING 1')->first();

        // Query filter berdasarkan tanggal + divisi
        $report = ProductionReport::where('divisi_id', $divisi->id)
                    ->whereDate('created_at', $tanggal_report)
                    ->get();

        return view('adminppic.divisi.weldingshofting1', compact('report', 'tanggal_report'));
    }


    public function exportWeldingShofiting1(Request $request)
    {
        $title = "Laporan Produksi Divisi Welding Shofiting 1";

        $divisi = Divisi::where('divisi', 'WELDING SHOFITING 1')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('created_at', [
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


    public function weldingshofiting2()
    {
        // cari divisi_id JANFAR
        $divisi = Divisi::where('divisi', 'WELDING SHOFITING 2')->first();

        // ambil report sesuai divisi
        $report = ProductionReport::where('divisi_id', $divisi->id)->get();

        return view('adminppic.divisi.weldingshofting2', compact('report'));
    }

    public function lihatsemuadataweldingshofiting2(Request $request)
    {
        // Ambil tanggal dari request
        $tanggal_report = Carbon::parse($request->tanggal_report)->toDateString();

        // Cari ID divisi JANFAR
        $divisi = Divisi::where('divisi', 'WELDING SHOFITING 2')->first();

        // Query filter berdasarkan tanggal + divisi
        $report = ProductionReport::where('divisi_id', $divisi->id)
                    ->whereDate('created_at', $tanggal_report)
                    ->get();

        return view('adminppic.divisi.weldingshofting2', compact('report', 'tanggal_report'));
    }

    public function exportWeldingShofiting2(Request $request)
    {
        $title = "Laporan Produksi Divisi Welding Shofiting 2";

        $divisi = Divisi::where('divisi', 'WELDING SHOFITING 2')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('created_at', [
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


    public function weldingdoor()
    {
        // cari divisi_id JANFAR
        $divisi = Divisi::where('divisi', 'WELDING DOOR')->first();

        // ambil report sesuai divisi
        $report = ProductionReport::where('divisi_id', $divisi->id)->get();

        return view('adminppic.divisi.weldingdoor', compact('report'));
    }

    public function lihatsemuadataweldingdoor(Request $request)
    {
        // Ambil tanggal dari request
        $tanggal_report = Carbon::parse($request->tanggal_report)->toDateString();

        // Cari ID divisi JANFAR
        $divisi = Divisi::where('divisi', 'WELDING DOOR')->first();

        // Query filter berdasarkan tanggal + divisi
        $report = ProductionReport::where('divisi_id', $divisi->id)
                    ->whereDate('created_at', $tanggal_report)
                    ->get();

        return view('adminppic.divisi.weldingdoor', compact('report', 'tanggal_report'));
    }

    public function exportWeldingDoor(Request $request)
    {
        $title = "Laporan Produksi Divisi Welding Door";

        $divisi = Divisi::where('divisi', 'WELDING DOOR')->first();
        $query = ProductionReport::where('divisi_id', $divisi->id);

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('created_at', [
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
