<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

use DataTables;

class PemilihController extends Controller
{
    private $table = "t_pemilih_pasti";
    private $pk_table = "";
    public function index(){
        $data = DB::table($this->table)
        ->join("m_kabupaten", $this->table.".id_kabupaten", "=","m_kabupaten.id")
        ->join("m_kecamatan", $this->table.".id_kecamatan", "=","m_kecamatan.id")
        ->join("m_desa", $this->table.".id_desa", "=","m_desa.id")
        ->join("m_tps", $this->table.".id_tps", "=","m_tps.id")
        ->select($this->table.".*",DB::raw("m_kabupaten.nama as kabupaten"),DB::raw("m_kecamatan.nama as kecamatan"),DB::raw("m_desa.nama as desa"),DB::raw("m_tps.nama as tps"))
                ->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $btn = '<div class="btn-group"><a href="'.url("admin/pemilih/edit").'/'.base64_encode($row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-xs fa-edit"></i></a>';
            $btn .= '<a href="javascript:void(0)" onclick=\'hapus_data("'.base64_encode($row->id).'")\' class="btn btn-danger btn-xs"><i class="fa fa-xs fa-trash"></i></a></div>';

                return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function index_desa($id_des){
        $id_desa = base64_decode($id_des);
        $data = DB::table($this->table)
        ->join("m_kabupaten", $this->table.".id_kabupaten", "=","m_kabupaten.id")
        ->join("m_kecamatan", $this->table.".id_kecamatan", "=","m_kecamatan.id")
        ->join("m_desa", $this->table.".id_desa", "=","m_desa.id")
        ->join("m_tps", $this->table.".id_tps", "=","m_tps.id")
        ->select($this->table.".*",DB::raw("m_kabupaten.nama as kabupaten"),DB::raw("m_kecamatan.nama as kecamatan"),DB::raw("m_desa.nama as desa"),DB::raw("m_tps.nama as tps"))
        ->where($this->table.".id_desa",$id_desa)
                ->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $btn = '<div class="btn-group"><a href="'.url("desa/pemilih/edit").'/'.base64_encode($row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-xs fa-edit"></i></a>';
            $btn .= '<a href="javascript:void(0)" onclick=\'hapus_data("'.base64_encode($row->id).'")\' class="btn btn-danger btn-xs"><i class="fa fa-xs fa-trash"></i></a></div>';

                return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function index_kabupaten($id_kab){
        $id_kabupaten = base64_decode($id_kab);
        $data = DB::table($this->table)
        ->join("m_kabupaten", $this->table.".id_kabupaten", "=","m_kabupaten.id")
        ->join("m_kecamatan", $this->table.".id_kecamatan", "=","m_kecamatan.id")
        ->join("m_desa", $this->table.".id_desa", "=","m_desa.id")
        ->join("m_tps", $this->table.".id_tps", "=","m_tps.id")
        ->select($this->table.".*",DB::raw("m_kabupaten.nama as kabupaten"),DB::raw("m_kecamatan.nama as kecamatan"),DB::raw("m_desa.nama as desa"),DB::raw("m_tps.nama as tps"))
        ->where($this->table.".id_kabupaten",$id_kabupaten)
                ->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($row){
            $btn = '<div class="btn-group"><a href="'.url("kabupaten/pemilih/edit").'/'.base64_encode($row->id).'" class="btn btn-primary btn-xs"><i class="fa fa-xs fa-edit"></i></a>';
            $btn .= '<a href="javascript:void(0)" onclick=\'hapus_data("'.base64_encode($row->id).'")\' class="btn btn-danger btn-xs"><i class="fa fa-xs fa-trash"></i></a></div>';

                return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_ktp' => 'required|min:16|max:16|unique:t_pemilih_pasti,no_ktp',
            'nama' => 'required',
            'id_kabupaten' => 'required',
            'id_kecamatan' => 'required',
            'id_desa' => 'required',
            'id_tps' => 'required',
            'alamat' => 'required',
            'keterangan' => 'required',

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
                "no_ktp" => $request->no_ktp,
                "id_kabupaten" => $request->id_kabupaten,
                "id_kecamatan" => $request->id_kecamatan,
                "id_desa" => $request->id_desa,
                "id_tps" => $request->id_tps,
                "alamat" => $request->alamat,
                "keterangan" => $request->keterangan,
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
                ->join("m_kabupaten", $this->table.".id_kabupaten", "=","m_kabupaten.id")
                ->join("m_kecamatan", $this->table.".id_kecamatan", "=","m_kecamatan.id")
                ->join("m_desa", $this->table.".id_desa", "=","m_desa.id")
                ->join("m_tps", $this->table.".id_tps", "=","m_tps.id")
                ->select($this->table.".*",DB::raw("m_kabupaten.nama as kabupaten"),DB::raw("m_kecamatan.nama as kecamatan"),DB::raw("m_desa.nama as desa"),DB::raw("m_tps.nama as tps"))
                ->where($this->table.".id",$this->pk_table)->first();
        return response()->json(["status" => "success", "message" => "Success", "data" => $res],200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nama' => 'required',
            'no_ktp' => 'required|min:16|max:16|unique:t_pemilih_pasti,no_ktp,'.base64_decode($request->id),
            'id_kabupaten' => 'required',
            'id_kecamatan' => 'required',
            'id_desa' => 'required',
            'id_tps' => 'required',
            'alamat' => 'required',
            'keterangan' => 'required',
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
                "no_ktp" => $request->no_ktp,
                "id_kabupaten" => $request->id_kabupaten,
                "id_kecamatan" => $request->id_kecamatan,
                "id_desa" => $request->id_desa,
                "id_tps" => $request->id_tps,
                "alamat" => $request->alamat,
                "keterangan" => $request->keterangan,
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
