<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use App\Models\PelanggaranImages;
use App\Models\Parpol;
use App\Models\JenisPelanggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PelanggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasRole('bawaslu-provinsi') || Auth::user()->hasRole('bawaslu-kabupaten-kota')) {
            // Using eager loading to avoid N+1 query problem
            $pelanggarans = Pelanggaran::with(['parpol', 'jenisPelanggaran'])
                ->orderBy('id', 'DESC')
                ->paginate(10);
            return view('pelanggarans.index', compact('pelanggarans'));
        } else {
            // Using eager loading to avoid N+1 query problem
            $pelanggarans = Pelanggaran::with(['parpol', 'jenisPelanggaran'])
                ->where('pelapor_id', Auth::user()->id)
                ->orderBy('id', 'DESC')
                ->paginate(10);
            return view('pelanggarans.index', compact('pelanggarans'));
        }

        // legacy code
        // Using eager loading to avoid N+1 query problem
        $pelanggarans = Pelanggaran::with(['parpol', 'jenisPelanggaran'])
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return view('pelanggarans.index', compact('pelanggarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parpol = Parpol::orderBy('id', 'ASC')->get();
        $jenispelanggaran = JenisPelanggaran::orderBy('id', 'ASC')->get();
        return view('pelanggarans.create', compact('parpol', 'jenispelanggaran'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'parpol_id' => 'required',
            'jenis_pelanggaran_id' => 'required',
            'status_peserta_pemilu' => 'required',
            'nama_bacaleg' => 'required',
            'dapil' => 'required',
            'tanggal_input' => 'required',
            'keterangan' => 'required',
            'image' => 'required|array|min:1|max:5',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $pelanggaran = new Pelanggaran();
            $pelanggaran->parpols_id = $request->parpol_id;
            $pelanggaran->jenis_pelanggaran_id = $request->jenis_pelanggaran_id;
            $pelanggaran->status_peserta_pemilu = $request->status_peserta_pemilu;
            $pelanggaran->nama_bacaleg = $request->nama_bacaleg;
            $pelanggaran->dapil = $request->dapil;
            $pelanggaran->tanggal_input = $request->tanggal_input;
            $pelanggaran->keterangan = $request->keterangan;
            $pelanggaran->pelapor_id = Auth::user()->id;
            $pelanggaran->save();

            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $image) {
                    // Store the file and get the file name
                    $path = $image->store('public/pelanggarans');
                    $filename = basename($path);

                    $PelanggaranImage = new PelanggaranImages();
                    $PelanggaranImage->pelanggaran_id = $pelanggaran->id;
                    $PelanggaranImage->image = $filename;
                    $PelanggaranImage->save();
                }
            }

            return redirect()->route('pelanggarans.index')->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()
                ->route('pelanggarans.index')
                ->with('error', 'Data gagal disimpan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pelanggaran = Pelanggaran::with(['parpol', 'jenisPelanggaran', 'pelanggaranImages'])->find($id);
        $parpol = Parpol::all();
        $jenispelanggaran = JenisPelanggaran::all();
        return view('pelanggarans.show', compact('pelanggaran', 'parpol', 'jenispelanggaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pelanggaran = Pelanggaran::with(['parpol', 'jenisPelanggaran', 'pelanggaranImages'])->find($id);
        $parpol = Parpol::all();
        $jenispelanggaran = JenisPelanggaran::all();
        return view('pelanggarans.edit', compact('pelanggaran', 'parpol', 'jenispelanggaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'parpol_id' => 'required',
            'jenis_pelanggaran_id' => 'required',
            'status_peserta_pemilu' => 'required',
            'nama_bacaleg' => 'required',
            'dapil' => 'required',
            'tanggal_input' => 'required',
            'keterangan' => 'required',
            'image' => 'array|min:1|max:5',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $pelanggaran = Pelanggaran::find($id);
            $pelanggaran->parpols_id = $request->parpol_id;
            $pelanggaran->jenis_pelanggaran_id = $request->jenis_pelanggaran_id;
            $pelanggaran->status_peserta_pemilu = $request->status_peserta_pemilu;
            $pelanggaran->nama_bacaleg = $request->nama_bacaleg;
            $pelanggaran->dapil = $request->dapil;
            $pelanggaran->tanggal_input = $request->tanggal_input;
            $pelanggaran->keterangan = $request->keterangan;
            $pelanggaran->pelapor_id = Auth::user()->id;
            $pelanggaran->save();

            if ($request->hasFile('image')) {
                // Delete old images
                foreach ($pelanggaran->pelanggaranImages as $oldImage) {
                    // Delete from storage
                    Storage::delete('public/pelanggarans/' . $oldImage->image);
                    // Delete from database
                    $oldImage->delete();
                }

                // Save new images
                foreach ($request->file('image') as $image) {
                    // Store the file and get the file name
                    $path = $image->store('public/pelanggarans');
                    $filename = basename($path);

                    $PelanggaranImage = new PelanggaranImages();
                    $PelanggaranImage->pelanggaran_id = $pelanggaran->id;
                    $PelanggaranImage->image = $filename;
                    $PelanggaranImage->save();
                }
            }

            return redirect()->route('pelanggarans.index')->with('success', 'Data berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()
                ->route('pelanggarans.index')
                ->with('error', 'Data gagal diupdate: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pelanggaran = Pelanggaran::find($id);

        if ($pelanggaran) {
            // Delete the images first
            $pelanggaranImages = PelanggaranImages::where('pelanggaran_id', $id)->get();

            foreach ($pelanggaranImages as $image) {
                try {
                    // Delete the file from storage
                    Storage::disk('public')->delete('pelanggarans/' . $image->image);
                    // Delete the image record from the database
                    $image->delete();
                } catch (\Exception $e) {
                    // Log the error or handle it as needed
                    return redirect()
                        ->route('pelanggarans.index')
                        ->with('error', 'Gagal menghapus gambar: ' . $e->getMessage());
                }
            }

            // Delete the Pelanggaran record
            try {
                $pelanggaran->delete();
                return redirect()->route('pelanggarans.index')->with('success', 'Data berhasil dihapus');
            } catch (\Exception $e) {
                return redirect()
                    ->route('pelanggarans.index')
                    ->with('error', 'Data gagal dihapus: ' . $e->getMessage());
            }
        }

        return redirect()->route('pelanggarans.index')->with('error', 'Data tidak ditemukan');
    }
}
