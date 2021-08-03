<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\endpoint\ApiDosenController;
use App\Pengguna;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    protected $api_dosen;

    public function __construct()
    {
        $this->api_dosen = new ApiDosenController;
    }

    public function index()
    {
        $api_dosen = $this->api_dosen;

        $dosens = Pengguna::where('is_dosen', 1)->get();

        if ($dosens->count() > 0) {
            foreach ($dosens as $item) {
                $item->dosenRef = null;
                $dosen = $api_dosen->getDosenOnlySomeField($item->nidn);
                if ($dosen) {
                    $item->dosenRef = $dosen;
                }
            }

            return response()->json([
                'status' => 200,
                'message' => "Get data success!",
                'data' => $dosens
            ], 200);
        }
    }

    public function detail($nidn)
    {
        $dosen = Pengguna::with('wadir3Ref', 'pembinaRef')->where('nidn', $nidn)->first();

        if ($dosen) {
            $dosen->dosenRef = null;
            $getdosen = $this->api_dosen->getDosenOnlySomeField($nidn);
            if ($getdosen) {
                $dosen->dosenRef  = $getdosen;
            }

            return response()->json([
                'status' => 200,
                'message' => "Get data success!",
                'data' => $dosen
            ], 200);
        }

        return response()->json([
            'status' => 404,
            'message' => "Data not found!",
            'data' => null
        ], 404);
    }
}
