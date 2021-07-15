<?php

use App\TipePeserta;
use Illuminate\Database\Seeder;

class TipePesertaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipePeserta::create([
            'nama_tipe' => "Umum"
        ]);
        TipePeserta::create([
            'nama_tipe' => "Internal"
        ]);
        TipePeserta::create([
            'nama_tipe' => "Eksternal"
        ]);
    }
}
