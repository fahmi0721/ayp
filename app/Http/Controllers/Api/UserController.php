<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;

use DataTables;
class UserController extends Controller
{
    private $table = "users";
    private $pk_table = "";
    public function index(){
        $data = DB::table($this->table)
                ->leftJoin("m_kabupaten", $this->table.".id_kabupaten", "=","m_kabupaten.id")
                ->leftJoin("m_kecamatan", $this->table.".id_kecamatan", "=","m_kecamatan.id")
                ->leftJoin("m_desa", $this->table.".id_desa", "=","m_desa.id")
                ->leftJoin("m_tps", $this->table.".id_tps", "=","m_tps.id")
                ->select($this->table.".*",DB::raw("m_kabupaten.nama as kabupaten"),DB::raw("m_kecamatan.nama as kecamatan"),DB::raw("m_desa.nama as desa"),DB::raw("m_tps.nama as tps"))
                ->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $btn = '<div class="btn-group"><a href="'.url("admin/users/edit").'/'.base64_encode($row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-xs fa-edit"></i></a>';
            $btn .= '<a href="javascript:void(0)" onclick=\'hapus_data("'.base64_encode($row->id).'")\' class="btn btn-danger btn-xs"><i class="fa fa-xs fa-trash"></i></a></div>';

                return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function index_kabupaten($id_kab){
        $id_kabupaten = base64_decode($id_kab);
        $data = DB::table($this->table)
                ->leftJoin("m_kabupaten", $this->table.".id_kabupaten", "=","m_kabupaten.id")
                ->leftJoin("m_kecamatan", $this->table.".id_kecamatan", "=","m_kecamatan.id")
                ->leftJoin("m_desa", $this->table.".id_desa", "=","m_desa.id")
                ->leftJoin("m_tps", $this->table.".id_tps", "=","m_tps.id")
                ->select($this->table.".*",DB::raw("m_kabupaten.nama as kabupaten"),DB::raw("m_kecamatan.nama as kecamatan"),DB::raw("m_desa.nama as desa"),DB::raw("m_tps.nama as tps"))->where($this->table.".id_kabupaten",$id_kabupaten)->whereIn($this->table.".level",array("kecamatan","desa","tps"))
                ->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $btn = '<div class="btn-group"><a href="'.url("kabupaten/users/edit").'/'.base64_encode($row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-xs fa-edit"></i></a>';
            $btn .= '<a href="javascript:void(0)" onclick=\'hapus_data("'.base64_encode($row->id).'")\' class="btn btn-danger btn-xs"><i class="fa fa-xs fa-trash"></i></a></div>';

                return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function index_kecamatan($id_kec){
        $id_kecamatan = base64_decode($id_kec);
        $data = DB::table($this->table)
                ->leftJoin("m_kabupaten", $this->table.".id_kabupaten", "=","m_kabupaten.id")
                ->leftJoin("m_kecamatan", $this->table.".id_kecamatan", "=","m_kecamatan.id")
                ->leftJoin("m_desa", $this->table.".id_desa", "=","m_desa.id")
                ->leftJoin("m_tps", $this->table.".id_tps", "=","m_tps.id")
                ->select($this->table.".*",DB::raw("m_kabupaten.nama as kabupaten"),DB::raw("m_kecamatan.nama as kecamatan"),DB::raw("m_desa.nama as desa"),DB::raw("m_tps.nama as tps"))->where($this->table.".id_kecamatan",$id_kecamatan)->whereIn($this->table.".level",array("desa","tps"))
                ->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $btn = '<div class="btn-group"><a href="'.url("kecamatan/users/edit").'/'.base64_encode($row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-xs fa-edit"></i></a>';
            $btn .= '<a href="javascript:void(0)" onclick=\'hapus_data("'.base64_encode($row->id).'")\' class="btn btn-danger btn-xs"><i class="fa fa-xs fa-trash"></i></a></div>';

                return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function index_desa($id_des){
        $id_desa = base64_decode($id_des);
        $data = DB::table($this->table)
                ->leftJoin("m_kabupaten", $this->table.".id_kabupaten", "=","m_kabupaten.id")
                ->leftJoin("m_kecamatan", $this->table.".id_kecamatan", "=","m_kecamatan.id")
                ->leftJoin("m_desa", $this->table.".id_desa", "=","m_desa.id")
                ->leftJoin("m_tps", $this->table.".id_tps", "=","m_tps.id")
                ->select($this->table.".*",DB::raw("m_kabupaten.nama as kabupaten"),DB::raw("m_kecamatan.nama as kecamatan"),DB::raw("m_desa.nama as desa"),DB::raw("m_tps.nama as tps"))->where($this->table.".id_desa",$id_desa)->whereIn($this->table.".level",array("tps"))
                ->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $btn = '<div class="btn-group"><a href="'.url("desa/users/edit").'/'.base64_encode($row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-xs fa-edit"></i></a>';
            $btn .= '<a href="javascript:void(0)" onclick=\'hapus_data("'.base64_encode($row->id).'")\' class="btn btn-danger btn-xs"><i class="fa fa-xs fa-trash"></i></a></div>';

                return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_ktp' => 'required|min:16|max:16|unique:users,no_ktp',
            'nama' => 'required',
            'no_hp' => 'required|min:10|max:16',
            'username' => 'required|unique:users,username',
            'password' => 'required',
            'level' => 'required',
            'alamat' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json([
                "status"    => "warning",
                "messages"   => $validator->errors()->first(),
            ], 400);
        }
        DB::beginTransaction();
        try {
            $pushdata = array(
                "nama" => $request->nama,
                "no_hp" => $request->no_hp,
                "username" => $request->username,
                "password" => Hash::make($request->password),
                "level" => $request->level,
                "no_ktp" => $request->no_ktp,
                "alamat" => $request->alamat,
                "created_at" => Carbon::now()
            );
            if(!empty($request->id_kabupaten)){
                $pushdata += array("id_kabupaten" => $request->id_kabupaten);
            }
            if(!empty($request->id_kecamatan)){
                $pushdata += array("id_kecamatan" => $request->id_kecamatan);
            }
            if(!empty($request->id_desa)){
                $pushdata += array("id_desa" => $request->id_desa);
            }
            if(!empty($request->id_desa)){
                $pushdata += array("id_tps" => $request->id_tps);
            }
            DB::table($this->table)->insert($pushdata);
            DB::commit();
            return response()->json(['status'=>'success','messages'=>'success'], 200);
        } catch(QueryException $e) { 
            DB::rollback();
            return response()->json(['status'=>'error','messages'=> $e->errorInfo[2] ], 400);
        }

    }

    public function show($id)
    {
        $this->pk_table = base64_decode($id);
        $res = DB::table($this->table)
                    ->leftJoin("m_kabupaten", $this->table.".id_kabupaten", "=","m_kabupaten.id")
                    ->leftJoin("m_kecamatan", $this->table.".id_kecamatan", "=","m_kecamatan.id")
                    ->leftJoin("m_desa", $this->table.".id_desa", "=","m_desa.id")
                    ->leftJoin("m_tps", $this->table.".id_tps", "=","m_tps.id")
                    ->select($this->table.".*",DB::raw("m_kabupaten.nama as kabupaten"),DB::raw("m_kecamatan.nama as kecamatan"),DB::raw("m_desa.nama as desa"),DB::raw("m_tps.nama as tps"))
                ->where($this->table.".id",$this->pk_table)->first();
        return response()->json(["status" => "success", "message" => "Success", "data" => $res],200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_ktp' => 'required|min:16|max:16|unique:users,no_ktp,'.base64_decode($request->id),
            'nama' => 'required',
            'no_hp' => 'required|min:10|max:16',
            'username' => 'required|unique:users,username,'.base64_decode($request->id),
            'level' => 'required',
            'alamat' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status"    => "warning",
                "messages"   => $validator->errors()->first(),
            ], 400);
        }
        DB::beginTransaction();
        try {
            $this->pk_table = base64_decode($request->id);
            $pushdata = array(
                "no_ktp" => $request->no_ktp,
                "username" => $request->username,
                "nama" => $request->nama,
                "no_hp" => $request->no_hp,
                "level" => $request->level,
                "alamat" => $request->alamat,
                "updated_at" => Carbon::now()
            );
            if(!empty($request->password)){
                $pushdata += array("password" => Hash::make($request->password));
            }
            if(!empty($request->id_kabupaten)){
                $pushdata += array("id_kabupaten" => $request->id_kabupaten);
            }
            if(!empty($request->id_kecamatan)){
                $pushdata += array("id_kecamatan" => $request->id_kecamatan);
            }
            if(!empty($request->id_desa)){
                $pushdata += array("id_desa" => $request->id_desa);
            }
            if(!empty($request->id_desa)){
                $pushdata += array("id_tps" => $request->id_tps);
            }
            DB::table($this->table)->where("id",$this->pk_table)->update($pushdata);
            DB::commit();
            return response()->json(['status'=>'success','messages'=>'success'], 200);
        } catch(QueryException $e) { 
            DB::rollback();
            return response()->json(['status'=>'error','messages'=> $e->errorInfo[2] ], 400);
        }
    }

    private function uploadImg($request,$filename,$folder){
        if(!File::exists("dokumen-file")){
            File::makeDirectory("dokumen-file", 0777, true, true);
        }

        if(!File::exists("dokumen-file/gambar_".$folder)){
            File::makeDirectory("dokumen-file/gambar_".$folder, 0777, true, true);
        }
        $request->foto->move("dokumen-file/gambar_".$folder."/",$filename);
        return "dokumen-file/gambar_".$folder."/".$filename;

    }

    private function del_temp_image($filename){
        if(File::exists($filename) && !empty($filename)){
            File::delete($filename);
        }
        return true;
    }
    
    public function update_foto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'foto' => 'required|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status"    => "warning",
                "messages"   => $validator->errors()->first(),
            ], 400);
        }
        DB::beginTransaction();
        try {
            $this->pk_table = base64_decode($request->id);
            $temp_data = DB::table($this->table)->select("foto")->where("id",$this->pk_table)->first();
            $filename = "foto_".time().".".$request->foto->extension();
            $folder = "foto";
            $foto = $this->uploadImg($request,$filename,$folder);
            if(!$foto){
                return response()->json([
                    "status"    => "warning",
                    "messages"   => "Terjadi kesalahan mengupload dokumen",
                ], 400);
            }
            $this->del_temp_image($temp_data->foto);
            $pushdata = array(
                "foto" => $foto
            );
            DB::table($this->table)->where("id",$this->pk_table)->update($pushdata);
            DB::commit();
            return response()->json(['status'=>'success','messages'=>'success'], 200);
        } catch(QueryException $e) { 
            DB::rollback();
            return response()->json(['status'=>'error','messages'=> $e->errorInfo[2] ], 400);
        }
    }

    public function destroy($id)
    {
        $this->pk_table = base64_decode($id);
        DB::beginTransaction();
        try {
            DB::table($this->table)->where("id",$this->pk_table)->delete();
            DB::commit();
            return response()->json(['status'=>'success','messages'=>'success'], 200);
        } catch(QueryException $e) { 
            DB::rollback();
            return response()->json(['status'=>'error','messages'=> $e->errorInfo[2] ], 400);
        }
    }
}
