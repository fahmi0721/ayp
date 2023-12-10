<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class KandidatController extends Controller
{
    public function index(){
        return view("admin.kandidat.index");
    }

    public function form_add(){
        $partais = DB::table("m_partai")->select("nama","id")->get();
        return view("admin.kandidat.tambah",compact("partais"));
    }

    public function form_edit(){
        $partais = DB::table("m_partai")->select("nama","id")->get();
        return view("admin.kandidat.edit",compact("partais"));
    }
}
