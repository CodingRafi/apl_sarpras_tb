<?php

namespace App\Http\Controllers;

use DB, Hash, Auth;
use App\Models\User;
use App\Models\Kelas;
use App\Models\ref_agama;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:view_users', ['only' => ['index','show']]);
         $this->middleware('permission:add_users', ['only' => ['create','store']]);
         $this->middleware('permission:edit_users', ['only' => ['edit','update']]);
         $this->middleware('permission:delete_users', ['only' => ['destroy']]);
         $this->middleware('permission:import_users', ['only' => ['import', 'saveimport']]);
         $this->middleware('permission:export_users', ['only' => ['export']]);
    }
    
    public function index(Request $request, $role)
    {   
        $users = User::getUser($role, false, true);
        return view('users.index', compact('users', 'role'));
    }

    public function create(Request $request, $role)
    {   
        return view('users.create', compact('role'));
    }

    public function store(StoreUserRequest $request, $role)
    {   
        $user = User::create([
            'profil' => isset($request->profil) ? $request->file('profil')->store('profil') : '/img/profil.png',
            'sekolah_id' => Auth::user()->sekolah_id,
            'email' => $request->email,
            'nip' => $request->nip,
            'name' => $request->name,
            'jk' => $request->jk,
            'password' => $request->password ? Hash::make($request->password) : null
        ]);

        $user->assignRole($role);
        insertLog(Auth::user()->name. " Berhasil menambahkan " . $role . ' dengan name '. $user->name);
        return redirect()->route('users.index', [$role])->with('msg_success', 'Berhasil menambahkan ' . $role);
    }

    public function show(Request $request, $role, $id){
        $this->check_user($id, $role);
        $user = User::findUser($role, $id);
        return view('users.show', compact('user', 'role'));
    }

    public function edit(Request $request, $role, $id)
    {   
        $this->check_user($id, $role);
        $data = User::findUser($role, $id);
       
        return view('users.update', compact('role', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $role, $id)
    {
        $user = User::findOrFail($id);
        $data = [
            'sekolah_id' => Auth::user()->sekolah_id,
            'email' => $request->email,
            'nip' => $request->nip,
            'name' => $request->name,
            'jk' => $request->jk,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }
        
        if ($request->file('profil')) {
            if($user->profil != '/img/profil.png'){
                Storage::delete($user->profil);
            }
            $data['profil'] = $request->file('profil')->store('profil');
        }
        
        $user->update($data);
        insertLog(Auth::user()->name. " Berhasil mengubah " . $role . ' dengan name '. $user->name);
        return TahunAjaran::redirectWithTahunAjaranManual(route('users.index', [$role]), $request,  'Berhasil mengupdate ' . $role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $role, $id)
    {   
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $user->delete();
            DB::commit();
            return redirect()->back()->with('msg_success', 'Berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('msg_success', 'Gagal dihapus');
        }
    }

    public function import(Request $request, $role){
        $data = ['role' => $role];
        return view('users.import',$data);
    }

    public function store_import(Request $request, $role){
        $excel = Excel::import(new UsersImport($role, $request), $request->file('file'));
        return TahunAjaran::redirectWithTahunAjaranManual(route('users.index', [$role]), $request,  'Berhasil mengimport ' . $role);
    }

    public function export(Request $request, $role){
        return Excel::download(new UsersExport($role, $request), $role.'.xlsx');
    }
    
    public function list(Request $request, $role){
        $users = User::getUser($role, true, true, ['search' => $request->search]);
        return response()->json($users, 200);
    }
}
