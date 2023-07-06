<?php

namespace App\Http\Controllers\User;

use DB, Auth;
use App\Models\User;
use App\Models\Sekolah;
use App\Mail\RegisterMail;
use Illuminate\Http\Request;
use \Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\StoreSekolahRegRequest;

class SekolahController extends Controller
{
    public function __construct(){
        $count_tahun_ajaran = DB::table('tahun_ajarans')->count();
        if ($count_tahun_ajaran < 1) {
            abort(404);
        }
    }

    public function create(){
        return view('myauth.register');
    }
    
    public function store(StoreSekolahRegRequest $request)
    {   
        $sekolah = Sekolah::create([
            'nama' => $request->nama_sekolah,
            'kepala_sekolah' => $request->kepala_sekolah,
            'npsn' => $request->npsn,
            'ref_provinsi_id' => $request->ref_provinsi_id,
            'ref_kabupaten_id' => $request->ref_kabupaten_id,
            'ref_kecamatan_id' => $request->ref_kecamatan_id,
            'ref_kelurahan_id' => $request->ref_kelurahan_id,
            'jalan' => $request->jalan,
            'jenjang' => $request->jenjang,
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => \Hash::make($request->password),
            'sekolah_id' => $sekolah->id
        ]);

        $user->assignRole('admin');

        DB::table('profile_users')->insert([
            'name' => $request->name,
            'user_id' => $user->id
        ]);

        Mail::to($user->email)->send(new RegisterMail($user, $request->password));

        Auth::login($user);

        return redirect()->intended(RouteServiceProvider::HOME)->with('msg_success', "Berhasil Login"); 
    }

    public function edit(){
        $sekolah = Auth::user()->sekolah;
        return view('sekolah.edit', compact('sekolah'));
    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'nama_sekolah' => 'required',
            'kode' => 'required',
            'npsn' => 'required',
            'kepala_sekolah' => 'required',
            'alamat' => 'required',
            'jam_masuk' => 'required',
            'jam_pulang' => 'required',
        ]);

        $sekolah = Auth::user()->sekolah;
        $sekolah->update($validatedData);

        return redirect()->route('dashboard')->with('msg_success', 'Data Sekolah Berhasil Terupdate');
    }
}
