<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class SuaraController extends Controller
{
    public function index(){
        return view("admin.suara.index");
    }

    public function form_add(){
        $kabupatens = DB::table("m_kabupaten")->select("nama","id")->get();
        $kandidats = DB::table("m_kandidat")->select("nama","id")->get();
        return view("admin.suara.tambah",compact("kabupatens","kandidats"));
    }

    public function form_edit(){
        $kabupatens = DB::table("m_kabupaten")->select("nama","id")->get();
        $kandidats = DB::table("m_kandidat")->select("nama","id")->get();
        return view("admin.suara.edit",compact("kabupatens","kandidats"));
    }
}
