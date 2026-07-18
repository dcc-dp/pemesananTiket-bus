<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\USer;
use App\Models\JenisUsaha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    private $menu = 'dokumen';
    /**
     * Menampilkan semua data dokumen
     */
    public function index()
    {
        $menu = $this->menu;

        $datas = Dokumen::with(['kategori', 'user'])
            ->latest()
            ->get();

        return view('pages.admin.umkm.index', compact('datas', 'menu'));
    }

    public function create()
    {
        $menu = $this->menu;
        $users = User::where('role', 'user')->get();
        $jenisUsahas = JenisUsaha::all(); // Perbaikan: ambil semua data dari model JenisUsaha

        return view('pages.admin.umkm.create', compact('menu', 'users', 'jenisUsahas'));
    }

    /**
     * Menyimpan dokumen baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id'      => 'required|exists:jenis_usahas,id',
            'nomor_dokumen'    => 'required|unique:dokumens,nomor_dokumen',
            'judul'            => 'required|string|max:255',
            'deskripsi'        => 'nullable|string',
            'tanggal_dokumen'  => 'required|date',
            'versi'            => 'nullable|string|max:20',
            'status'           => 'required',
            'file'             => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240'
        ]);

        $filePath = null;

        if ($request->hasFile('file')) {
            $filePath = $request
                ->file('file')
                ->store('dokumen', 'public');
        }

        $dokumen = Dokumen::create([
            'kategori_id'      => $request->kategori_id,
            'user_id'          => Auth::id(),
            'nomor_dokumen'    => $request->nomor_dokumen,
            'judul'            => $request->judul,
            'deskripsi'        => $request->deskripsi,
            'file_path'        => $filePath,
            'tanggal_dokumen'  => $request->tanggal_dokumen,
            'versi'            => $request->versi,
            'status'           => $request->status,
        ]);

        return redirect()->route('umkm.index')->with('message', 'Data UMKM berhasil ditambahkan');
    }

    /**
     * Menampilkan detail dokumen
     */
    public function show($id)
    {
        $dokumen = Dokumen::with(['kategori', 'unit', 'user'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $dokumen
        ]);
    }

    public function edit($id)
    {
        // $data = User::findOrFail($id);
        $data = Dokumen::with('user')->findOrFail($id);
        $jenisUsahas = JenisUsaha::all(); // Perbaikan: ambil semua data dari model JenisUsaha

        $menu = $this->menu;

        return view('pages.admin.umkm.edit', compact('data', 'jenisUsahas', 'menu'));
    }

    /**
     * Update dokumen
     */
    public function update(Request $request, $id)
    {
        $dokumen = Dokumen::findOrFail($id);

        $request->validate([
            'kategori_id'      => 'required|exists:jenis_usahas,id',
            'nomor_dokumen'    => 'required|unique:dokumens,nomor_dokumen,' . $id,
            'judul'            => 'required|string|max:255',
            'deskripsi'        => 'nullable|string',
            'tanggal_dokumen'  => 'required|date',
            'versi'            => 'nullable|string|max:20',
            'status'           => 'required',
            'file'             => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240'
        ]);

        if ($request->hasFile('file')) {

            if (
                $dokumen->file_path &&
                Storage::disk('public')->exists($dokumen->file_path)
            ) {

                Storage::disk('public')
                    ->delete($dokumen->file_path);
            }

            $dokumen->file_path = $request
                ->file('file')
                ->store('dokumen', 'public');
        }

        $dokumen->update([
            'kategori_id'      => $request->kategori_id,
            'nomor_dokumen'    => $request->nomor_dokumen,
            'judul'            => $request->judul,
            'deskripsi'        => $request->deskripsi,
            'tanggal_dokumen'  => $request->tanggal_dokumen,
            'versi'            => $request->versi,
            'status'           => $request->status,
            'file_path'        => $dokumen->file_path,
        ]);

        return redirect()->route('umkm.index')
            ->with('message', 'Data UMKM berhasil diperbarui');
    }

    /**
     * Hapus dokumen
     */
    public function destroy($id)
    {
        $dokumen = Dokumen::findOrFail($id);

        if (
            $dokumen->file_path &&
            Storage::disk('public')->exists($dokumen->file_path)
        ) {
            Storage::disk('public')->delete($dokumen->file_path);
        }

        $dokumen->delete();

        return redirect()->route('umkm.index')
                ->with('message', 'Data berhasil dihapus');
    }

    /**
     * Download dokumen
     */
    public function download($id)
    {
        $dokumen = Dokumen::findOrFail($id);

        if (!Storage::disk('public')->exists($dokumen->file_path)) {
            return response()->json([
                'success' => false,
                'message' => 'File tidak ditemukan'
            ], 404);
        }

        return Storage::disk('public')
            ->download($dokumen->file_path);
    }
}
