<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\Sekolah;
use App\Models\Subcategory;
use App\Models\Produk;
use App\Models\Peminjaman;
use App\Http\Requests\PeminjamanPublicStore;
use Illuminate\Support\Facades\Mail;
use App\Mail\PeminjamanMail;
use Illuminate\Database\Eloquent\Builder;

class PeminjamanController extends Controller
{
    public function create(){
        $page = 'public';
        $tahun_ajaran = getTahunAjaran();

        if (!$tahun_ajaran) {
            abort(403);
        }

        $sekolahs = DB::table('sekolahs')->select('id', 'nama','logo','npsn')->get();
        return view('peminjaman_public.create', compact('sekolahs', 'page'));
    }

    public function cek_kode(Request $request){
        $request->validate([
            'sekolah_id' => 'required',
            'kode' => 'required'
        ]);

        $sekolah = Sekolah::findOrFail($request->sekolah_id);

        if ($sekolah->kode == $request->kode) {
            if (date('H:i:s') >= $sekolah->jam_masuk && date('H:i:s') <= $sekolah->jam_pulang) {
                $kelas = DB::table('kelas')->select('id', 'nama')->where('sekolah_id', $sekolah->id)->get();
                return response()->json([
                    'message' => 'Success',
                    'identifier' => encodeText($sekolah->id),
                    'kelas' => $kelas
                ], 200);
            }else{
                return response()->json([
                    'message' => 'Failed'
                ], 401);
            }
        }else{
            return response()->json([
                'message' => 'Kode Salah'
            ], 401);
        }
    }

    public function get_kategori(Request $request){
        $request->validate([
            'identifier' => 'required',
            'jenis' => 'required',
        ]);

        $datas = DB::table('kategoris')
                            ->select('id', 'nama')
                            ->where('sekolah_id', decodeText($request->identifier)['identifier'])
                            ->where('jenis', $request->jenis)
                            ->get();

        return response()->json([
            'datas' => $datas,
        ], 200);
    }

    public function get_subcategori(Request $request){
        $request->validate([
            'identifier' => 'required',
            'kategori_id' => 'required',
            'jenis' => 'required'
        ]);

        $datas = DB::table(($request->jenis == 'sarana' ? 'subcategories' : 'ruangs'))
                            ->when($request->jenis == 'sarana', function($q) use($request){
                                $q->select('id', 'nama');
                            })
                            ->when($request->jenis == 'prasarana', function($q) use($request){
                                $q->select('id', 'name')
                                    ->where('ruang_dipinjam', 1);
                            })
                            ->where('sekolah_id', decodeText($request->identifier)['identifier'])
                            ->where('kategori_id', $request->kategori_id)
                            ->get();

        return response()->json([
            'datas' => $datas,
        ], 200);
    }

    public function get_produk(Request $request){
        $request->validate([
            'id' => 'required',
            'page' => 'required'
        ]);

        $datas = Produk::select('produks.id', 'produks.nama')
                            ->join('ruangs', 'ruangs.id', 'produks.ruang_id')
                            ->where('produks.sub_kategori_id', $request->id)
                            ->where('ruangs.produk_dipinjam', 1)
                            ->where('produks.kondisi', 'B')
                            ->when(!$request->peminjaman_id, function($q) use($request){
                                $q->where('produks.dipinjam', 0);
                            });

        if ($request->page == 'public') {
            $datas = $datas->count();
        }else{
            $datas = $datas->when($request->peminjaman_id, function($q) use($request){
                $q->whereHas('peminjaman', function(Builder $query) use($request){
                    $query->where('peminjaman_produk.peminjaman_id', $request->peminjaman_id);
                })->orWhere('produks.dipinjam', 0)->where('produks.kondisi', 'B');
            })->get();
        }

        return response()->json([
            'datas' => $datas
        ], 200);
    }

    private function genereate_kode($sekolah_id){
        $last = Peminjaman::where('sekolah_id', $sekolah_id)->orderByDesc('id')->first();
        $kode = 'PM' . $sekolah_id . sprintf('%0'. 5 .'d', ($last ? ((int)explode('PM' . $sekolah_id, $last->kode)[1] + 1) : 1));
        return $kode;
    }

    public function store(PeminjamanPublicStore $request){
        DB::beginTransaction();
        try {
            $tahun_ajaran = getTahunAjaran();
            $data = [
                'nama' => $request->nama,
                'jenis' => $request->jenis,
                'email' => $request->email,
                'kelas_id' => $request->kelas,
                'tahun_ajaran_id' => $tahun_ajaran->id,
                'kategori_id' => $request->kategori_id,
                'sekolah_id' => decodeText($request->identifier)['identifier'],
                'kode' => $this->genereate_kode(decodeText($request->identifier)['identifier'])
            ];
            
            if ($request->jenis == 'sarana') {
                $request->validate([
                    'sub_kategori_id' => 'required',
                    'jml_peminjaman' => 'required',
                ]);

                $data += [
                    'sub_kategori_id' => $request->sub_kategori_id,
                    'jml_peminjaman' => $request->jml_peminjaman,
                ];
            }else{
                $request->validate([
                    'ruang_id' => 'required',
                ]);

                $data += [
                    'ruang_id' => $request->ruang_id
                ];
            }

            $peminjaman = Peminjaman::create($data);
            Mail::to($request->email)->send(new PeminjamanMail(encodeText($peminjaman->kode)));
            DB::commit();
            return response()->json([
                'message' => 'Berhasil dikirim'
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Gagal'
            ], 401);
        }
    }

    public function show($kode){
        $data = Peminjaman::where('kode', decodeText($kode)['identifier'])->first();
        $page = 'public';
        if (!$data) {return abort(403);}
        return view('peminjaman.public', compact('data', 'page'));
    }
}
