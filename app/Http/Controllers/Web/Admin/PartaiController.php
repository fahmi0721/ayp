<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class PartaiController extends Controller
{
    public function index(){
        return view("admin.partai.index");
    }

    public function form_add(){
        return view("admin.partai.tambah");
    }

    public function form_edit(){
        return view("admin.partai.edit");
    }
}
