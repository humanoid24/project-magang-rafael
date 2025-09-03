<?php

namespace App\Http\Controllers;

use App\Models\ppic;
use Illuminate\Http\Request;

class AdminPPICController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $report = ppic::all();

        return view('adminppic.index', compact('report'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('adminppic.create');
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
            'pdoc_m' => 'required|string',
            'actual' => 'required|string',
        ]);

        // Simpan data ke database
        ppic::create($validatedData);

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
        $report = ppic::findOrFail($id);
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
            'pdoc_m' => 'required|string',
            'actual' => 'string',
        ]);

        // Ambil data berdasarkan id
        $report = ppic::findOrFail($id);

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
        $report = ppic::findOrFail($id);
        $report->delete();

        return redirect()->route('ppic.index')
            ->with('success', 'Laporan berhasil dihapus!');
    }
}
