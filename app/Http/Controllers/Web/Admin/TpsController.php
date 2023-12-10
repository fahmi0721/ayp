<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class TpsController extends Controller
{
    public function index(){
        return view("admin.tps.index");
    }

    public function form_add(){
        $kabupatens = DB::table("m_kabupaten")->select("nama","id")->get();
        $kecamatans = DB::table("m_kecamatan")->select("nama","id")->get();
        $desas = DB::table("m_desa")->select("nama","id")->get();
        return view("admin.tps.tambah",compact("kabupatens","kecamatans","desas"));
    }

    public function form_edit(){
        $kabupatens = DB::table("m_kabupaten")->select("nama","id")->get();
        $kecamatans = DB::table("m_kecamatan")->select("nama","id")->get();
        $desas = DB::table("m_desa")->select("nama","id")->get();

        return view("admin.tps.edit",compact("kabupatens","kecamatans","desas"));
    }
}
