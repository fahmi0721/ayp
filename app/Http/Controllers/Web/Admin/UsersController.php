<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class UsersController extends Controller
{
    public function index(){
        return view("admin.users.index");
    }

    public function form_add(){
        $kabupatens = DB::table("m_kabupaten")->select("nama","id")->get();
        $levels = array('admin','kabupaten','kecamatan','desa','tps');
        return view("admin.users.tambah",compact("kabupatens","levels"));
    }

    public function form_edit(){
        $kabupatens = DB::table("m_kabupaten")->select("nama","id")->get();
        $levels = array('admin','kabupaten','kecamatan','desa','tps');
        return view("admin.users.edit",compact("kabupatens","levels"));
    }
}
