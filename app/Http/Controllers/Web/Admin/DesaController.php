<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class DesaController extends Controller
{
    public function index(){
        return view("admin.desa.index");
    }

    public function form_add(){
        $kabupatens = DB::table("m_kabupaten")->select("nama","id")->get();
        $kecamatans = DB::table("m_kecamatan")->select("nama","id")->get();
        return view("admin.desa.tambah",compact("kabupatens","kecamatans"));
    }

    public function form_edit(){
        $kabupatens = DB::table("m_kabupaten")->select("nama","id")->get();
        $kecamatans = DB::table("m_kecamatan")->select("nama","id")->get();
        return view("admin.desa.edit",compact("kabupatens","kecamatans"));
    }
}
