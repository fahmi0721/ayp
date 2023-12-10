<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class KecamatanController extends Controller
{
    public function index(){
        return view("admin.kecamatan.index");
    }

    public function form_add(){
        $kabupatens = DB::table("m_kabupaten")->select("nama","id")->get();
        return view("admin.kecamatan.tambah",compact("kabupatens"));
    }

    public function form_edit(){
        $kabupatens = DB::table("m_kabupaten")->select("nama","id")->get();
        return view("admin.kecamatan.edit",compact("kabupatens"));
    }
}
