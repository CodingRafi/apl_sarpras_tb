<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'view_users',
            'add_users',
            'edit_users',
            'delete_users',
            'import_users',
            'export_users',

            'view_roles',
            'add_roles',
            'edit_roles',

            'view_tahun_ajaran',
            'add_tahun_ajaran',
            'edit_tahun_ajaran',
            'delete_tahun_ajaran',

            'view_sekolah',
            'add_sekolah',
            'edit_sekolah',
            'delete_sekolah',

            // 'view_jurusan',
            // 'add_jurusan',
            // 'edit_jurusan',
            // 'delete_jurusan',

            'view_kategori',
            'add_kategori',
            'edit_kategori',
            'delete_kategori',

            'view_produk',
            'add_produk',
            'edit_produk',
            'delete_produk',

            'view_kelas',
            'add_kelas',
            'edit_kelas',
            'delete_kelas',

            'view_ruang',
            'add_ruang',
            'edit_ruang',
            'delete_ruang',

            'view_peminjaman',
            'add_peminjaman',
            'edit_peminjaman',
            'delete_peminjaman',

            'view_faq',
            'add_faq',
            'edit_faq',
            'delete_faq',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
       }
    }
}
