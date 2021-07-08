<?php

use App\Ormawa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class OrmawaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Ormawa::create([
            'nama_ormawa' => "Himpunan Mahasiswa Teknik Informatika",
            'username' => 'himatif123',
            'password' => Hash::make('himatif123'),
        ]);
    }
}
