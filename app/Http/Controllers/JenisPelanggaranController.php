<?php

namespace App\Http\Controllers;

use App\Models\JenisPelanggaran;
use Illuminate\Http\Request;

class JenisPelanggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenis_pelanggaran = JenisPelanggaran::paginate(5);
        return view('jenispelanggarans.index', compact('jenis_pelanggaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jenispelanggarans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_pelanggaran' => 'required',
        ]);

        $jenis_pelanggaran = new JenisPelanggaran();
        $jenis_pelanggaran->jenis_pelanggaran = $request->jenis_pelanggaran;

        if ($jenis_pelanggaran->save()) {
            return redirect()->route('jenispelanggarans.index')->with('success', 'Data jenis pelanggaran berhasil ditambahkan');
        } else {
            return redirect()->route('jenispelanggarans.index')->with('error', 'Data jenis pelanggaran gagal ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jenis_pelanggaran = JenisPelanggaran::findOrFail($id);
        return view('jenispelanggarans.show', compact('jenis_pelanggaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jenis_pelanggaran = JenisPelanggaran::findOrFail($id);
        return view('jenispelanggarans.edit', compact('jenis_pelanggaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'jenis_pelanggaran' => 'required',
        ]);

        $jenis_pelanggaran = JenisPelanggaran::findOrFail($id);
        $jenis_pelanggaran->jenis_pelanggaran = $request->jenis_pelanggaran;

        if ($jenis_pelanggaran->save()) {
            return redirect()->route('jenispelanggarans.index')->with('success', 'Data jenis pelanggaran berhasil diubah');
        } else {
            return redirect()->route('jenispelanggarans.index')->with('error', 'Data jenis pelanggaran gagal diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jenis_pelanggaran = JenisPelanggaran::findOrFail($id);

        if ($jenis_pelanggaran->delete()) {
            return redirect()->route('jenispelanggarans.index')->with('success', 'Data jenis pelanggaran berhasil dihapus');
        } else {
            return redirect()->route('jenispelanggarans.index')->with('error', 'Data jenis pelanggaran gagal dihapus');
        }
    }
}
