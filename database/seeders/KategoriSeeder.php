<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kategori')->insert([
            [
                'category_name' => 'Surat Masuk',
                'details' => 'Surat Masuk'
            ],
            [
                'category_name' => 'Surat Keluar',
                'details' => 'Surat Keluar'
            ],
            [
                'category_name' => 'Surat Tugas',
                'details' => 'Surat Tugas'
             ]
            ,[
                'category_name' => 'Surat Perintah',
                'details' => 'Surat Perintah'
            ],
            [
                'category_name' => 'Surat Pemberitahuan',
                'details' => 'Surat Pemberitahuan'  
            ]
            ]);
    }
}
