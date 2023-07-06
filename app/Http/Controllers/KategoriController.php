<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Sekolah;
use App\Models\Subcategory;
use App\Http\Requests\StoreKategoriRequest;
use App\Http\Requests\UpdateKategoriRequest;
use App\Http\Requests\UpdateSubcategoriRequest;
use Illuminate\Http\Request;
use DB, Auth;

class KategoriController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:view_kategori', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_kategori', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_kategori', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_kategori', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('kategori.index');
    }

    public function data($sekolah_id = null){
        if (!Auth::user()->hasRole('super_admin')) {
            $sekolah_id = Auth::user()->sekolah_id;
        }

        if (!$sekolah_id) {
            abort(403);
        }

        $data = Kategori::where('sekolah_id', $sekolah_id)->get();

        return datatables($data)
            ->addIndexColumn()
            ->addColumn('sub', function ($data) {
                $tbl = '<table class="border-black table-auto">';
                foreach ($data->subcategory as $sub){
                    $tbl .= ' <tr><td>'. $sub->nama .'</td><td>'. $sub->kode .'</td></tr>';
                }
                $tbl .= '</table>';
                return $tbl;
            })
            ->addColumn('action', function ($data) {
                $action = '';
                if ($data->jenis == 'sarana') {
                    $action .= '<a class="btn btn-secondary btn-sm rounded mr-2" target="_blank" href="'. route('produk.qrcode', ['kategori_id' => $data->id]) .'">qrcode</a>';
                }else{
                    $action .= '<a class="btn btn-secondary btn-sm rounded mr-2" target="_blank" href="'. route('ruang.qrcode', ['kategori_id' => $data->id]) .'">qrcode</a>';
                }
                if (Auth::user()->can('edit_kategori')){
                    $action .= '<a class="btn btn-warning btn-sm rounded" href="'. route('kategori.edit', $data->id) .'">Edit</a>';
                }
                if (Auth::user()->can('delete_kategori')) {
                    $action .= '<button type="submit" class="btn btn-sm btn-danger rounded ml-2" style="width: 4rem;"
                    onclick="deleteData("'. route('kategori.destroy', $data->id) .'")">Hapus</button>';
                }
                return $action;
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function create()
    {
        return view('kategori.form');
    }

    public function store(StoreKategoriRequest $request)
    {
        DB::beginTransaction();
        try {
            $kategori = Kategori::create([
                'nama' => $request->nama,
                'sekolah_id' => Auth::user()->sekolah_id,
                'jenis' => $request->jenis,
            ]);

            insertLog(Auth::user()->name . ' Berhasil menambahkan kategori ' . $request->nama);
            if ($request->sub) {
                foreach ($request->sub as $i => $sub) {
                    Subcategory::create([
                        'kategori_id' => $kategori->id,
                        'sekolah_id' => Auth::user()->sekolah_id,
                        'nama' => $sub,
                        'kode' => $request->kode[$i]
                    ]);
                    insertLog(Auth::user()->name . ' Berhasil menambahkan sub kategori ' . $sub);
                }
            }
            DB::commit();
            return redirect()->route('kategori.index')->with('msg_success', 'Berhasil menambahkan kategori');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('kategori.create')->with('msg_error', "Gagal Ditambahkan");
        }
    }

    public function show($id)
    {
        $kategori = Kategori::findOrFail($id);
        return $kategori;
    }

    public function edit($id)
    {
        $data = Kategori::findOrFail($id);
        validateSekolah($data->sekolah_id);
        return view('kategori.form', compact('data'));
    }

    public function update(UpdateKategoriRequest $request, $id)
    {
        $kategori = Kategori::findOrFail($id);
        validateSekolah($kategori->sekolah_id);
        DB::beginTransaction();
        try {
            $kategori->update([
                'nama' => $request->nama,
            ]);

            insertLog(Auth::user()->name . ' Berhasil mengubah kategori ' . $request->nama);

            if ($request->sub) {
                foreach ($request->sub as $i => $sub) {
                    Subcategory::create([
                        'kategori_id' => $kategori->id,
                        'sekolah_id' => Auth::user()->sekolah_id,
                        'nama' => $sub,
                        'kode' => $request->kode[$i]
                    ]);
                    insertLog(Auth::user()->name . ' Berhasil menambahkan sub kategori ' . $sub);
                }
            }

            DB::commit();
            return redirect()->route('kategori.index')->with('msg_success', 'Berhasil mengubah kategori');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('kategori.create')->with('msg_error', "Gagal Ditambahkan");
        }
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        validateSekolah($kategori->sekolah_id);

        if ($kategori->subcategory()->count() > 0) {
            return redirect()->back()->with('msg_error', 'Kategori ini sudah digunakan pada sub kategori tidak dapat dihapus');
        }

        if ($kategori->ruang()->count() > 0) {
            return redirect()->back()->with('msg_error', 'Kategori ini sudah digunakan pada ruang tidak bisa dihapus');
        }

        $delete = $kategori->delete();
        return redirect()->back()->with('msg_success', 'Berhasil dihapus');
    }

    public function updateSub(UpdateSubcategoriRequest $request, $id)
    {
        $data = Subcategory::findOrFail($id);
        $data->update([
            'nama' => $request->sub,
            'kode' => $request->kode,
        ]);
        insertLog(Auth::user()->name . ' Berhasil mengubah sub kategori');
        return response()->json([
            'data' => $data,
        ], 200);
    }

    public function deleteSub(Request $request, $id)
    {
        $data = Subcategory::findOrFail($id)->delete();
        insertLog(Auth::user()->name . ' Berhasil menghapus sub kategori');
        return response()->json([
            'message' => 'Berhasil dihapus'
        ], 200);
    }

    public function getSub($kategori_id)
    {
        try {
            $kategori = Kategori::with(['subcategory'])->findOrFail($kategori_id);
            return response()->json([
                'datas' => $kategori->subcategory
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
