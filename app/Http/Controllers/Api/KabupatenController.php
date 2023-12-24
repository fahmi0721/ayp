<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

use DataTables;

class KabupatenController extends Controller
{
    private $table = "m_kabupaten";
    private $pk_table = "";
    public function index(){
        $data = DB::table($this->table)->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
                $btn = '<div class="btn-group"><a href="'.url("admin/kabupaten/edit").'/'.base64_encode($row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-xs fa-edit"></i></a>';
                $btn .= '<a href="javascript:void(0)" onclick=\'hapus_data("'.base64_encode($row->id).'")\' class="btn btn-danger btn-xs"><i class="fa fa-xs fa-trash"></i></a></div>';
                return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function show_kab(){
        $res = DB::table($this->table)->select("id",DB::raw("nama as text"))->get();
        return response()->json(["status" => "success", "message" => "Success", "data" => $res],200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
        $res = DB::table($this->table)->select("id","nama")->where("id",$this->pk_table)->first();
        return response()->json(["status" => "success", "message" => "Success", "data" => $res],200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
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
