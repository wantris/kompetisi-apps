<?php

use App\KategoriEvent;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KategoriEvent::create([
            'nama_kategori' => "Seminar"
        ]);
        KategoriEvent::create([
            'nama_kategori' => "Kompetisi"
        ]);
        KategoriEvent::create([
            'nama_kategori' => "Workshop"
        ]);
        KategoriEvent::create([
            'nama_kategori' => "Diesnatalis"
        ]);
    }
}
