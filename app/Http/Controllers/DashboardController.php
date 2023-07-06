<?php

namespace App\Http\Controllers;

use Auth, DB;
use App\Models\User;
use App\Models\Sekolah;
use App\Models\ref_agama;
use App\Models\Peminjaman;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request){
        $return = [];
        
        if (\Auth::user()->hasRole('super_admin')) {
            $countRole = Role::count() - 1;
            $countTahunAjaran = TahunAjaran::count();
            $return = [
                'countRole' => $countRole,
                'countTahunAjaran' => $countTahunAjaran
            ];
        }else {
            $sekolah_id = Auth::user()->sekolah_id;
            $bulan = (int) request('bulan') ?? date('m');
            $tahun = (int) request('tahun') ?? date('Y');
            $return += [
                'tahuns' => DB::table('peminjamans')->selectRaw('distinct(YEAR(created_at)) as year')->get(),
            ]; 

            // if (Auth::user()->can('view_produk')) {
                $sub_terbanyak = Peminjaman::sub_terbanyak($sekolah_id, $bulan, $tahun);
                $return += [
                    'total_produk' => DB::table('produks')->where('sekolah_id', $sekolah_id)->count(),
                    'sub_terbanyak' => $this->parseData($sub_terbanyak),
                ];
            // }

            // if (Auth::user()->can('view_ruang')) {
                $ruang_terbanyak = Peminjaman::ruang_terbanyak($sekolah_id, $bulan, $tahun);
                $return += [
                    'total_ruang' => DB::table('ruangs')->where('sekolah_id', $sekolah_id)->count(),
                    'ruang_terbanyak' => $this->parseData($ruang_terbanyak),
                ];
            // }

            // if (Auth::user()->can('view_kelas')) {
                $kelas_terbanyak = Peminjaman::kelas_terbanyak($sekolah_id, $bulan, $tahun);
                $return += [
                    'kelas_terbanyak' => $this->parseData($kelas_terbanyak),
                ];
            // }

            // if (Auth::user()->can('view_kategori')){
                $return += [
                    'total_kategori' => DB::table('kategoris')->where('sekolah_id', $sekolah_id)->count(),
                ];
            // }

            // if (Auth::user()->can('view_peminjaman')) {
                $email_terbanyak = Peminjaman::email_terbanyak($sekolah_id, $bulan, $tahun);
                $return += [
                    'total_peminjaman' => DB::table('peminjamans')->where('peminjamans.sekolah_id', $sekolah_id)->count(),
                    'email_terbanyak' => $this->parseData($email_terbanyak),
                ];
            // }
        }

        return view('dashboard', $return);
    }
}
