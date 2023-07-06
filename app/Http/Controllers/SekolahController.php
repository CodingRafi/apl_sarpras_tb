<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\User;
use App\Models\Peminjaman;
use App\Http\Requests\StoreSekolahRequest;
use App\Http\Requests\UpdateSekolahRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB, Auth;

class SekolahController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:view_sekolah', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_sekolah', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_sekolah', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_sekolah', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schools = Sekolah::all();

        return view('sekolah.index', [
            'schools' => $schools
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sekolah.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSekolahRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSekolahRequest $request)
    {
        DB::beginTransaction();
        try {
            $sekolah = Sekolah::create([
                'nama' => $request->nama_sekolah,
                'kode' => $request->kode,
                'kepala_sekolah' => $request->kepala_sekolah,
                'npsn' => $request->npsn,
                'jenjang' => $request->jenjang,
                'alamat' => $request->alamat,
                'jam_masuk' => $request->jam_masuk,
                'jam_pulang' => $request->jam_pulang,
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Hash::make($request->password),
                'sekolah_id' => $sekolah->id
            ]);

            DB::commit();

            $user->assignRole('admin');
            return redirect()->route('sekolah.index')->with('msg_success', "Berhasil Ditambahkan");
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('sekolah.index')->with('msg_error', "Gagal Ditambahkan");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function show(Sekolah $sekolah)
    {
        if (!Auth::user()->hasRole('super_admin')) {
            abort(403);
        }

        $sekolah_id = $sekolah->id;
        $bulan = (int) request('bulan') ?? date('m');
        $tahun = (int) request('tahun') ?? date('Y');
        
        $sub_terbanyak = Peminjaman::sub_terbanyak($sekolah_id, $bulan, $tahun);
        $ruang_terbanyak = Peminjaman::ruang_terbanyak($sekolah_id, $bulan, $tahun);
        $kelas_terbanyak = Peminjaman::kelas_terbanyak($sekolah_id, $bulan, $tahun);
        $email_terbanyak = Peminjaman::email_terbanyak($sekolah_id, $bulan, $tahun);

        $return = [
            'total_kategori' => DB::table('kategoris')->where('sekolah_id', $sekolah_id)->count(),
            'total_produk' => DB::table('produks')->where('sekolah_id', $sekolah_id)->count(),
            'total_ruang' => DB::table('ruangs')->where('sekolah_id', $sekolah_id)->count(),
            'total_peminjaman' => DB::table('peminjamans')->where('peminjamans.sekolah_id', $sekolah_id)->count(),
            'sub_terbanyak' => $this->parseData($sub_terbanyak),
            'ruang_terbanyak' => $this->parseData($ruang_terbanyak),
            'kelas_terbanyak' => $this->parseData($kelas_terbanyak),
            'email_terbanyak' => $this->parseData($email_terbanyak),
            'tahuns' => DB::table('peminjamans')->selectRaw('distinct(YEAR(created_at)) as year')->get(),
            'sekolah' => $sekolah
        ]; 

        return view('sekolah.show', $return);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function edit(Sekolah $sekolah)
    {
        $sekolah = Sekolah::findOrFail($sekolah->id);
        return view('sekolah.create', compact('sekolah'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSekolahRequest  $request
     * @param  \App\Models\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSekolahRequest $request, Sekolah $sekolah)
    {
        $admin = User::where('sekolah_id', $sekolah->id)->first();
        $data = [
            'nama' => $request->nama_sekolah,
            'kode' => $request->kode,
            'npsn' => $request->npsn,
            'kepala_sekolah' => $request->kepala_sekolah,
            'alamat' => $request->alamat,
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
        ];

        $user = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        $request->password ? $user['password'] = \Hash::make($request->password) : '';

        if($request->profile){
            $path = Storage::disk('public')->putFile('profile', $request->profile);
            $user['profil'] = $path;
        }

        if (Storage::disk('public')->exists("$admin->profil")) {
            Storage::disk('public')->delete("$admin->profil");
        }

        $admin->update($user);

        if ($request->logo) {
            if ($sekolah->logo != '/img/tutwuri.png	') {
                Storage::delete($sekolah->logo);
            }
            $data += ['logo' => $request->file('logo')->store('logo')];
        }

        $sekolah->update($data);
        return redirect()->route('sekolah.index')->with('msg_success', 'Berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sekolah  $sekolah
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sekolah $sekolah)
    {
        $sekolah->kelas()->delete();
        $sekolah->kelas()->delete();
        $sekolah->user->delete();
        $sekolah->delete();

        return redirect()->back()->with('msg_success', 'Sekolah berhasil dihapus');
    }
}
