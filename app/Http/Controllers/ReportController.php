<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\ProductionReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $user = Auth::user();

        if ($user->role === 1) {
            // Admin: semua report
            $report = ProductionReport::all();
            return view('report.index', compact('report'));
        }

        if ($user->role === 2) {
            $report = ProductionReport::where('divisi_id', $user->divisi_id)
                ->get();

            return view('report.index', ['report' => $report]);
        }
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Langkah 1: Validasi Input
        // Ini untuk memastikan data yang masuk sesuai format yang kita inginkan.
        $validatedData = $request->validate([
            'shift' => 'required|integer',
            'mulai_kerja' => 'required|date',
            'selesai_kerja' => 'required|date|after_or_equal:mulai_kerja',
            'bagian' => 'required',
            'sub_bagian' => 'required',
            'catatan' => 'nullable|string', // nullable artinya boleh kosong
        ]);

        // Langkah 2: Simpan Data ke Database
        // Kita tambahkan user_id dari user yang sedang login
        ProductionReport::create([
            'user_id' => Auth::id(), // Mengambil ID user yang login
            'shift' => $validatedData['shift'],
            'mulai_kerja' => $validatedData['mulai_kerja'],
            'selesai_kerja' => $validatedData['selesai_kerja'],
            'bagian' => $validatedData['bagian'],
            'sub_bagian' => $validatedData['sub_bagian'],
            'catatan' => $validatedData['catatan'],
        ]);

        return redirect()->route('dashboard.index')->with('success', 'Laporan berhasil disimpan!');
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
        $report = ProductionReport::with('divisi')->findOrFail($id);

        return view('report.edit', compact('report'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'shift' => 'required|integer',
            'mulai_kerja' => 'required|date',
            'selesai_kerja' => 'required|date|after_or_equal:mulai_kerja',
            'bagian' => 'required',
            'sub_bagian' => 'required',
            'catatan' => 'nullable|string',
        ]);

        $validatedData['user_id'] = Auth::id();

        $report = ProductionReport::findOrFail($id);
        $report->update($validatedData);

        return redirect()->route('dashboard.index')->with('success', 'Laporan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!isAdmin()) {
            abort(403, 'Unauthorized');
        }
        $report = ProductionReport::findOrFail($id);
        $report->delete();

        return redirect()->route('dashboard.index')
            ->with('success', 'Laporan berhasil dihapus!');
    }
}
