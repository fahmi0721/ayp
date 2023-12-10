<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

use DataTables;
class KecamatanContoller extends Controller
{
    private $table = "m_kecamatan";
    private $pk_table = "";
    public function index(){
        $data = DB::table($this->table)
                ->join("m_kabupaten",$this->table.".id_kabupaten" ,"=","m_kabupaten.id")
                ->select($this->table.".*",DB::raw("m_kabupaten.nama as kabupaten"))
                ->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $btn = '<div class="btn-group"><a href="'.url("admin/kecamatan/edit").'/'.base64_encode($row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-xs fa-edit"></i></a>';
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
                ->select($this->table.".*",DB::raw("m_kabupaten.nama as kabupaten"))
                ->where($this->table.".id_kabupaten",$id_kabupaten)
                ->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $btn = '<div class="btn-group"><a href="'.url("kabupaten/kecamatan/edit").'/'.base64_encode($row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-xs fa-edit"></i></a>';
            $btn .= '<a href="javascript:void(0)" onclick=\'hapus_data("'.base64_encode($row->id).'")\' class="btn btn-danger btn-xs"><i class="fa fa-xs fa-trash"></i></a></div>';

                return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_kabupaten' => 'required',
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
    
    public function show_by_kab($id_kab){
        $id_kabupaten = base64_decode($id_kab);
        $res = DB::table($this->table)->select("id",DB::raw("nama as text"))->where("id_kabupaten",$id_kabupaten)->get();
        return response()->json(["status" => "success", "message" => "Success", "data" => $res],200);
    }

    public function show($id)
    {
        $this->pk_table = base64_decode($id);
        $res = DB::table($this->table)
                ->join("m_kabupaten",$this->table.".id_kabupaten", "=","m_kabupaten.id")
                ->select($this->table.".*",DB::raw("m_kabupaten.nama as kabupaten"))
                ->where($this->table.".id",$this->pk_table)->first();
        return response()->json(["status" => "success", "message" => "Success", "data" => $res],200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'id_kabupaten' => 'required',
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
