<?php

namespace App\Http\Controllers;

use Auth, DB;
use App\Models\User;
use App\Models\Sekolah;
use App\Models\ref_agama;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request){ 
        if (\Auth::user()->hasRole('super_admin')) {
            $countRole = Role::count() - 1;
            $countAgama = ref_agama::count();
            $countTahunAjaran = TahunAjaran::count();

            return view('dashboard', [
                'countRole' => $countRole,
                'countAgama' => $countAgama,
                'countTahunAjaran' => $countTahunAjaran
            ]);

        }else {
            return view('dashboard');
        }
    }

    private function parseData($datas){
        $result = [
            'key' => [],
            'data' => []
        ];
        foreach ($datas as $key => $data) {
            array_push($result['key'], ucfirst($data->key));
            array_push($result['data'], $data->jml);
        }
        return $result;
    }
    
    public function dash2(){
        return view('dashboard2');
    }
}
