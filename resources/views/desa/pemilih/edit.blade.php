@extends("home")
@section("title", "EDIT PEMILIH PASTI -")
@section("bardcumb")
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Pemilih Pasti</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('desa') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('desa/pemilih') }}">Pemilih Pasti</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

@endsection
@section("konten")
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
    <div class='row'>
    <div class='col-sm-6'>
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Edit Data Pemilih Pasti</h3>

          <div class="card-tools">
            <!-- <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button> -->
          </div>
        </div>
        <div class="card-body">
            <form action="javascript:void(0)" id='FormData'>
                @csrf
                @method("put")
                <input type="hidden" id="id" name="id">
                <input type="hidden" id="id_kabupaten" name="id_kabupaten">
                <input type="hidden" id="id_kecamatan" name="id_kecamatan">
                <input type="hidden" id="id_desa" name="id_desa">
                <div class="form-group">
                    <label for="no_ktp" autocomplete=off class='control-label'>No KTP <span class='text-danger'>*</span></label>
                    <input type="text" placeholder="Entri No KTP" name='no_ktp' id='no_ktp' class='form-control FormIsi'>
                </div>

                <div class="form-group">
                    <label for="nama" autocomplete=off class='control-label'>Nama <span class='text-danger'>*</span></label>
                    <input type="text" placeholder="Entri Nama" name='nama' id='nama' class='form-control FormIsi'>
                </div>

                <div class="form-group">
                    <label for="id_tps" autocomplete=off class='control-label'>TPS </label>
                    <select name="id_tps" id="id_tps" class='form-control'>
                        <option value=""></option>
                        @foreach($tpss as $tps)
                        <option value="{{ $tps->id }}">{{ $tps->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="alamat" autocomplete=off class='control-label'>Alamat <span class='text-danger'>*</span></label>
                    <input type="text" placeholder="Entri Alamat" name='alamat' id='alamat' class='form-control FormIsi'>
                </div>

                <div class="form-group">
                    <label for="keterangan" autocomplete=off class='control-label'>Keterangan <span class='text-danger'>*</span></label>
                    <input type="text" placeholder="Entri Keterangan" name='keterangan' id='keterangan' class='form-control FormIsi'>
                </div>
                
                <hr>
                <div class="form-group">
                    <button  class='btn btn-sm btn-success btn-flat'><i class='fa fa-save'></i> Submit</button>
                    <a class='btn btn-sm btn-danger' href="{{ url('desa/pemilih') }}" data-toggle='tooltip' title='Kembali'><i class="fa fa-reply"></i> Kembali</a>
                </div>

            </form>
        </div>
        <!-- /.card-body -->
        
      </div>
      </div>
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection

@section('script')
<script>
    $(document).ready(function(){
        getData("{{ Request::segment(4) }}");

        $('#id_tps').select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih TPS',
            allowClear: true,
        });
        
    })
    function getData(id_data){
        $.ajax({
            type : "GET",
            dataType: "json",
            url : "{{ url('api/pemilih-pasti/get_data') }}/"+id_data,
            data : "input=[]",
            error: function(er){
                console.log(er)
            },
            success: function(data){
                $("#id").val(id_data);
                $("#nama").val(data.data.nama)
                $("#no_ktp").val(data.data.no_ktp)
                $("#keterangan").val(data.data.keterangan)
                $("#alamat").val(data.data.alamat)
                $("#id_kabupaten").val(data.data.id_kabupaten);
                $("#id_kecamatan").val(data.data.id_kecamatan);
                $("#id_desa").val(data.data.id_desa);
                $("#id_tps").val(data.data.id_tps).trigger("change");
                get_tps(data.data.id_tps);
            }
        })
    }
    
    function sweetAlertSucc(status,message){
        var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1000
            });
        Toast.fire({
            icon: status,
            title: message
        });
    }

    function sweetAlertErr(status,message){
        var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });
        Toast.fire({
            icon: status,
            title: message
        });
    }

    $("#FormData").submit(function(e){
        e.preventDefault();
        SubmitData();
    })


    function SubmitData() {
        var idata =new FormData($('#FormData')[0]);
        $.ajax({
            type	: "POST",
            dataType: "json",
            url		: "{{ url('api/pemilih-pasti/update') }}",
            data	: idata,
            processData: false,
            contentType: false,
            cache 	: false,
            beforeSend: function () { 
                // in_load();
            },
            success	:function(data) {
                sweetAlertSucc(data.status,data.messages);
            },
            error: function (error) {
                console.log(error)
                if(error.responseJSON.status){
                    sweetAlertErr(error.responseJSON.status,error.responseJSON.messages)
                }else{
                    sweetAlertErr("warning",error.responseJSON.message)
                }
            }
        });
    }

    
</script>
@endsection