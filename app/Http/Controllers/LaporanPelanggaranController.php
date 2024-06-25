<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use App\Models\Pelanggaran;
use App\Models\LaporanPelanggaran;
use Illuminate\Support\Facades\Auth;

class LaporanPelanggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $laporanPelanggarans = LaporanPelanggaran::with('pelanggaran.jenisPelanggaran', 'pelanggaran.parpol')->orderBy('id', 'DESC')->paginate(10);

        return view('laporanpelanggaran.index', compact('laporanPelanggarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pelanggarans = Pelanggaran::with(['parpol', 'jenisPelanggaran'])->get();
        $provinces = Province::all();
        return view('laporanpelanggaran.create', compact(['pelanggarans', 'provinces']));
    }

    public function getRegency($province_id)
    {
        $regencies = Regency::where('province_id', $province_id)->get();
        return response()->json($regencies);
    }

    public function getDistricts($regency_id)
    {
        $districts = District::where('regency_id', $regency_id)->get();
        return response()->json($districts);
    }

    public function getVillages($district_id)
    {
        $villages = Village::where('district_id', $district_id)->get();
        return response()->json($villages);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'pelanggaran_id' => 'required',
            'alamat' => 'required',
            'provinsi_id' => 'required',
            'regency_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        try {
            // Create a new instance of LaporanPelanggaran
            $laporan = new LaporanPelanggaran();

            // Assign validated data to the model
            $laporan->pelanggaran_id = $request->pelanggaran_id;
            $laporan->address = $request->alamat;
            $laporan->province_id = $request->provinsi_id;
            $laporan->regency_id = $request->regency_id;
            $laporan->district_id = $request->district_id;
            $laporan->village_id = $request->village_id;
            $laporan->latitude = $request->latitude;
            $laporan->longitude = $request->longitude;
            $laporan->user_id = Auth::user()->id;

            if ($laporan->save()) {
                return redirect()->route('laporanpelanggarans.index')->with('success', 'Laporan berhasil disimpan');
            } else {
                return redirect()->route('laporanpelanggarans.index')->with('error', 'Laporan gagal disimpan');
            }
        } catch (\Exception $e) {
            return redirect()
                ->route('laporanpelanggarans.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $laporanPelanggaran = LaporanPelanggaran::with(['pelanggaran', 'province', 'regency', 'district', 'village'])
            ->where('id', $id)
            ->first();
        return view('laporanpelanggaran.show', compact('laporanPelanggaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $laporanPelanggaran = LaporanPelanggaran::with(['pelanggaran', 'province', 'regency', 'district', 'village'])
            ->where('id', $id)
            ->first();

        $pelanggarans = Pelanggaran::with(['parpol', 'jenisPelanggaran'])->get();
        $provinces = Province::all();
        $regencies = Regency::where('province_id', $laporanPelanggaran->provinsi_id)->get();
        $districts = District::where('regency_id', $laporanPelanggaran->kabupaten_id)->get();
        $villages = Village::where('district_id', $laporanPelanggaran->kecamatan_id)->get();

        return view('laporanpelanggaran.edit', compact('laporanPelanggaran', 'pelanggarans', 'provinces', 'regencies', 'districts', 'villages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $laporanPelanggaran = LaporanPelanggaran::find($id);

        if ($laporanPelanggaran->delete()) {
            return redirect()->route('laporanpelanggarans.index')->with('success', 'Laporan berhasil dihapus');
        } else {
            return redirect()->route('laporanpelanggarans.index')->with('error', 'Laporan gagal dihapus');
        }
    }
}
