<?php

namespace App\Http\Controllers;

use DB, Auth;
use App\Models\{
    Produk,
    Subcategory,
    Foto
};
use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:view_produk', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_produk', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_produk', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_produk', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('produk.index');
    }

    public function data($sekolah_id = null){
        if (!Auth::user()->hasRole('super_admin')) {
            $sekolah_id = Auth::user()->sekolah_id;
        }

        if (!$sekolah_id) {
            abort(403);
        }

        $data = Produk::where('sekolah_id', $sekolah_id)->get();

        return datatables($data)
            ->addIndexColumn()
            ->addColumn('sub', function ($data) {
                return $data->subcategorie->nama;
            })
            ->addColumn('action', function ($data) {
                $action = '';
                $action .= '<a class="btn btn-primary btn-sm rounded mr-2" href="'. route('produk.show', $data->id) .'">Detail</a>';
                if (Auth::user()->can('edit_produk')){
                    $action .= '<a class="btn btn-warning btn-sm rounded" href="'. route('produk.edit', $data->id) .'">Edit</a>';
                }
                if (Auth::user()->can('delete_produk')) {
                    $action .= '<button type="submit" class="btn btn-sm btn-danger rounded ml-2" style="width: 4rem;"
                    onclick="deleteData("'. route('produk.destroy', $data->id) .'")">Hapus</button>';
                }
                return $action;
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tahun_ajaran = getTahunAjaran();

        if (!$tahun_ajaran) {
            return redirect()->route('produk.index')->with('msg_error', 'Tidak ada tahun ajaran ditemukan');
        }

        $kategoris = DB::table('kategoris')
                        ->where('sekolah_id', Auth::user()->sekolah_id)
                        ->where('jenis', 'sarana')
                        ->get();
        return view('produk.form', compact('kategoris'));
    }

    private function generate_kode($request, $kode){   
        $last_produk = DB::table('produks')
                            ->where('sub_kategori_id', $request->sub_kategori_id)
                            ->orderByDesc('id')
                            ->first();
        $kode_kategori = sprintf('%0'. 5 .'d', ($last_produk ? (int)explode($kode, $last_produk->kode)[1] + 1 : 1));
        $result = $kode . $kode_kategori;
        return $result;
    }

    public function store(StoreProdukRequest $request)
    {
        $tahun_ajaran = getTahunAjaran();
        if (!$tahun_ajaran) {
            return redirect()->route('produk.index')->with('msg_error', 'Tidak ada tahun ajaran ditemukan');
        }

        DB::beginTransaction();
        try {                    
            $sub_kategori = DB::table('subcategories')
                            ->where('id', $request->sub_kategori_id)
                            ->first();

            for ($i = 0; $i < $request->jumlah; $i++) {
                $produk = Produk::create([
                    'sekolah_id' => Auth::user()->sekolah_id,
                    'kategori_id' => $request->kategori_id,
                    'tahun_ajaran_id' => $tahun_ajaran->id,
                    'sub_kategori_id' => $request->sub_kategori_id,
                    'nama' => ($request->name_increment ? ($request->start_increment ? ($request->nama . ' ' . $request->start_increment + $i) : ($request->nama . ' ' . $i)) : $request->nama),
                    'kode' => $this->generate_kode($request, $sub_kategori->kode).$i,
                    'merek' => $request->merek,
                    'kondisi' => $request->kondisi,
                    'ket_produk' => $request->ket_produk,
                    'ket_kondisi' => $request->ket_kondisi,
                    'sekali_pakai' => ($request->sekali_pakai ? true : false)
                ]);
            
                if ($request->fotos) {
                    foreach ($request->fotos as $key => $foto) {
                        $randName = Str::random(24);
                        $path = Storage::disk('public')->putFileAs('produk', $foto, $randName.'_'.$i.'.'.$foto->getClientOriginalExtension());
                        Foto::create([
                            'produk_id' => $produk->id,
                            'file' => $path
                        ]);
                    }
                }

                insertLog(Auth::user()->name . " Berhasil menambahkan produk " . $produk['nama']);
            }
            DB::commit();
            return redirect()->route('produk.index')->with('msg_success', 'Berhasil menambahkan produk');
        } catch (\Throwable $th) {
            return dd($th);
            DB::rollback();
            return redirect()->route('produk.index')->with('msg_error', 'Gagal Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $data = Produk::findOrFail($id);
        validateSekolah($data->sekolah_id);
        $page = 'admin';
        return view('produk.show', compact('data', 'page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Produk::findOrFail($id);
        validateSekolah($data->sekolah_id);
        $kategoris = DB::table('kategoris')
                        ->where('sekolah_id', Auth::user()->sekolah_id)
                        ->where('jenis', 'sarana')
                        ->get();
        $subcategories = DB::table('subcategories')->select('subcategories.*')
                                                    ->join('kategoris', 'kategoris.id', 'subcategories.kategori_id')
                                                    ->where('kategoris.sekolah_id', Auth::user()->sekolah_id)
                                                    ->where('subcategories.kategori_id', $data->kategori_id)
                                                    ->get();

        return view('produk.form', compact('data','kategoris', 'subcategories'));
    }
    public function detail($id)
    {
        $data = Produk::findOrFail($id);
        validateSekolah($data->sekolah_id);
        $kategoris = DB::table('kategoris')
                        ->where('sekolah_id', Auth::user()->sekolah_id)
                        ->where('jenis', 'sarana')
                        ->get();
        $subcategories = DB::table('subcategories')->select('subcategories.*')
                                                    ->join('kategoris', 'kategoris.id', 'subcategories.kategori_id')
                                                    ->where('kategoris.sekolah_id', Auth::user()->sekolah_id)
                                                    ->where('subcategories.kategori_id', $data->kategori_id)
                                                    ->get();

        return view('produk.detail', compact('data','kategoris', 'subcategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProdukRequest  $request
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProdukRequest $request, Produk $produk)
    {
        validateSekolah($produk->sekolah_id);
        DB::beginTransaction();
        try {
            $update = [
                'kategori_id' => $request->kategori_id,
                'sub_kategori_id' => $request->sub_kategori_id,
                'jurusan_id' => $request->jurusan_id,
                'nama' => $request->nama,
                'merek' => $request->merek,
                'kondisi' => $request->kondisi,
                'ket_produk' => $request->ket_produk,
                'ket_kondisi' => $request->ket_kondisi,
                'sekali_pakai' => ($request->sekali_pakai ? true : false)   
            ];

            if ($request->kategori_id != $produk->kategori_id) {
                $kategori = DB::table('kategoris')
                                ->where('id', $request->kategori_id)
                                ->first();
                $last_kategori = DB::table('produks')
                                    ->where('kategori_id', $request->kategori_id)
                                    ->orderByDesc('id')
                                    ->first();
                
                $update['kode'] = $this->generate_kode(($last_kategori ? (int)explode($kategori->kode, $last_kategori->kode)[1] + 1 : 1),$kategori, 1);
            }
            
            $produk->update($update);

            if ($request->fotos) {                
                foreach ($request->fotos as $key => $foto) {
                    $randName = Str::random(24);
                    $path = Storage::disk('public')->putFileAs('produk', $foto, $randName.'_'.$produk->id.'.'.$foto->getClientOriginalExtension());
                    Foto::create([
                        'produk_id' => $produk->id,
                        'file' => $path
                    ]);
                }
            }

            insertLog(Auth::user()->name . " Berhasil mengubah produk " . $request->nama);
            DB::commit();
            return redirect()->route('produk.index')->with('msg_success', 'Berhasil mengubah produk');
        } catch (\Throwable $th) {
                DB::rollback();
            return redirect()->route('produk.index')->with('msg_error', 'Gagal Diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Produk::findOrFail($id);
        validateSekolah($data->sekolah_id);
        
        if ($data->peminjaman()->count() > 0) {
            return redirect()->back()->with('msg_error', 'Telah terjadi peminjaman pada produk ini tidak bisa dihapus');
        }
        
        if ($data->ruang_id) {
            return redirect()->back()->with('msg_error', 'Produk ini telah diset diruang tidak bisa dihapus');
        }

        $data->delete();

        insertLog(Auth::user()->name . ' Berhasil menghapus produk ' . $data->nama);

        return redirect()->route('produk.index')->with('msg_success', 'Berhasil menghapus produk');
    }

    public function get($sub){
        $data = Subcategory::findOrFail($sub);
        return response()->json([
            'datas' => $data->produk()->whereNull('ruang_id')->get()
        ], 200);
    }

    public function hapus_foto(Request $request){
        $request->validate([
            'produk_id' => 'required',
            'foto_id' => 'required',
        ]);

        $foto = Foto::where('produk_id', $request->produk_id)
                        ->where('id', $request->foto_id)
                        ->first();

        if (Storage::disk('public')->exists("$foto->file")) {
            Storage::disk('public')->delete("$foto->file");
        }

        $foto->delete();

        return response()->json([
            'message' => 'Berhasil dihapus'
        ], 200);
    }
}
