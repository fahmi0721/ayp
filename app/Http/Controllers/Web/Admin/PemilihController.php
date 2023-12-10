<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class PemilihController extends Controller
{
    public function index(){
        return view("admin.pemilih.index");
    }

    public function form_add(){
        $kabupatens = DB::table("m_kabupaten")->select("nama","id")->get();
        return view("admin.pemilih.tambah",compact("kabupatens"));
    }

    public function form_edit(){
        $kabupatens = DB::table("m_kabupaten")->select("nama","id")->get();
        return view("admin.pemilih.edit",compact("kabupatens"));
    }
}
