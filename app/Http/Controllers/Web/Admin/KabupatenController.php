<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class KabupatenController extends Controller
{
    public function index(){
        return view("admin.kabupaten.index");
    }

    public function form_add(){
        return view("admin.kabupaten.tambah");
    }

    public function form_edit(){
        return view("admin.kabupaten.edit");
    }
}
