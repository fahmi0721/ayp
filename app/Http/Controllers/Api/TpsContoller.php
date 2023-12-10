<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

use DataTables;
class TpsContoller extends Controller
{
    private $table = "m_tps";
    private $pk_table = "";
    public function index(){
        $data = DB::table($this->table)
                ->join("m_kabupaten",$this->table.".id_kabupaten" ,"=","m_kabupaten.id")
                ->join("m_kecamatan",$this->table.".id_kecamatan" ,"=","m_kecamatan.id")
                ->join("m_desa",$this->table.".id_desa" ,"=","m_desa.id")
                ->select($this->table.".*",DB::raw("m_kabupaten.nama as kabupaten"),DB::raw("m_kecamatan.nama as kecamatan"),DB::raw("m_desa.nama as desa"))
                ->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $btn = '<div class="btn-group"><a href="'.url("admin/tps/edit").'/'.base64_encode($row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-xs fa-edit"></i></a>';
            $btn .= '<a href="javascript:void(0)" onclick=\'hapus_data("'.base64_encode($row->id).'")\' class="btn btn-danger btn-xs"><i class="fa fa-xs fa-trash"></i></a></div>';

                return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function index_kabupaten($id_kab){
        $id_kabupaten = base64_decode($id_kab);
        $data = DB::table($this->table)
                ->join("m_kabupaten",$this->table.".id_kabupaten" ,"=","m_kabupaten.id")
                ->join("m_kecamatan",$this->table.".id_kecamatan" ,"=","m_kecamatan.id")
                ->join("m_desa",$this->table.".id_desa" ,"=","m_desa.id")
                ->select($this->table.".*",DB::raw("m_kabupaten.nama as kabupaten"),DB::raw("m_kecamatan.nama as kecamatan"),DB::raw("m_desa.nama as desa"))
                ->where($this->table.".id_kabupaten",$id_kabupaten)
                ->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $btn = '<div class="btn-group"><a href="'.url("kabupaten/tps/edit").'/'.base64_encode($row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-xs fa-edit"></i></a>';
            $btn .= '<a href="javascript:void(0)" onclick=\'hapus_data("'.base64_encode($row->id).'")\' class="btn btn-danger btn-xs"><i class="fa fa-xs fa-trash"></i></a></div>';

                return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function index_kecamatan($id_kec){
        $id_kecamatan = base64_decode($id_kec);
        $data = DB::table($this->table)
                ->join("m_kabupaten",$this->table.".id_kabupaten" ,"=","m_kabupaten.id")
                ->join("m_kecamatan",$this->table.".id_kecamatan" ,"=","m_kecamatan.id")
                ->join("m_desa",$this->table.".id_desa" ,"=","m_desa.id")
                ->select($this->table.".*",DB::raw("m_kabupaten.nama as kabupaten"),DB::raw("m_kecamatan.nama as kecamatan"),DB::raw("m_desa.nama as desa"))
                ->where($this->table.".id_kecamatan",$id_kecamatan)
                ->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $btn = '<div class="btn-group"><a href="'.url("kecamatan/tps/edit").'/'.base64_encode($row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-xs fa-edit"></i></a>';
            $btn .= '<a href="javascript:void(0)" onclick=\'hapus_data("'.base64_encode($row->id).'")\' class="btn btn-danger btn-xs"><i class="fa fa-xs fa-trash"></i></a></div>';

                return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function index_desa($id_des){
        $id_desa = base64_decode($id_des);
        $data = DB::table($this->table)
                ->join("m_kabupaten",$this->table.".id_kabupaten" ,"=","m_kabupaten.id")
                ->join("m_kecamatan",$this->table.".id_kecamatan" ,"=","m_kecamatan.id")
                ->join("m_desa",$this->table.".id_desa" ,"=","m_desa.id")
                ->select($this->table.".*",DB::raw("m_kabupaten.nama as kabupaten"),DB::raw("m_kecamatan.nama as kecamatan"),DB::raw("m_desa.nama as desa"))
                ->where($this->table.".id_desa",$id_desa)
                ->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $btn = '<div class="btn-group"><a href="'.url("desa/tps/edit").'/'.base64_encode($row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-xs fa-edit"></i></a>';
            $btn .= '<a href="javascript:void(0)" onclick=\'hapus_data("'.base64_encode($row->id).'")\' class="btn btn-danger btn-xs"><i class="fa fa-xs fa-trash"></i></a></div>';

                return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function show_by_desa($id_desa){
        $id_desa = base64_decode($id_desa);
        $res = DB::table($this->table)->select("id",DB::raw("nama as text"))->where("id_desa",$id_desa)->get();
        return response()->json(["status" => "success", "message" => "Success", "data" => $res],200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_kabupaten' => 'required',
            'id_kecamatan' => 'required',
            'id_desa' => 'required',
            'nama' => 'required',
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
                "id_kabupaten" => $request->id_kabupaten,
                "id_kecamatan" => $request->id_kecamatan,
                "id_desa" => $request->id_desa,
                "nama" => $request->nama,
                "created_at" => Carbon::now()
            );
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
                ->join("m_kabupaten",$this->table.".id_kabupaten" ,"=","m_kabupaten.id")
                ->join("m_kecamatan",$this->table.".id_kecamatan" ,"=","m_kecamatan.id")
                ->join("m_desa",$this->table.".id_desa" ,"=","m_desa.id")
                ->select($this->table.".*",DB::raw("m_kabupaten.nama as kabupaten"),DB::raw("m_kecamatan.nama as kecamatan"),DB::raw("m_desa.nama as desa"))
                ->where($this->table.".id",$this->pk_table)->first();
        return response()->json(["status" => "success", "message" => "Success", "data" => $res],200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'id_kabupaten' => 'required',
            'id_kecamatan' => 'required',
            'id_desa' => 'required',
            'nama' => 'required',
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
                "id_kabupaten" => $request->id_kabupaten,
                "id_kecamatan" => $request->id_kecamatan,
                "id_desa" => $request->id_desa,
                "nama" => $request->nama,
                "updated_at" => Carbon::now()
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
