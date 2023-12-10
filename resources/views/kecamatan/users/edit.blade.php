@extends("home")
@section("title", "EDIT USERS -")
@section("bardcumb")
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>USERS</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('kecamatan') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('kecamatan/users') }}">Users</a></li>
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
          <h3 class="card-title">Edit Data Users</h3>

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
                <input type="hidden" id="id_kabupaten" name="id_kabupaten" value="{{ auth()->user()->id_kabupaten }}">
                <input type="hidden" id="id_kecamatan" name="id_kecamatan" value="{{ auth()->user()->id_kecamatan }}">
                <div class="form-group">
                    <label for="no_ktp" autocomplete=off class='control-label'>No KTP <span class='text-danger'>*</span></label>
                    <input type="text" placeholder="Entri No KTP" name='no_ktp' id='no_ktp' class='form-control FormIsi'>
                </div>

                <div class="form-group">
                    <label for="nama" autocomplete=off class='control-label'>Nama <span class='text-danger'>*</span></label>
                    <input type="text" placeholder="Entri Nama" name='nama' id='nama' class='form-control FormIsi'>
                </div>

                <div class="form-group">
                    <label for="username" autocomplete=off class='control-label'>Username <span class='text-danger'>*</span></label>
                    <input type="text" placeholder="Entri Username" name='username' id='username' class='form-control FormIsi'>
                </div>

                <div class="form-group">
                    <label for="password" autocomplete=off class='control-label'>Password </label>
                    <div class='input-group'>
                        <label for="label" class='input-group-text'><input type="checkbox" value='0' id='cek_pass' data-toggle='tooltip' title='Ubah Password'></label>
                        <input type="text" placeholder="Entri Password" name='password' id='password' readonly class='form-control FormIsi'>
                    </div>
                </div>

                <div class="form-group">
                    <label for="level" autocomplete=off class='control-label'>Level <span class='text-danger'>*</span></label>
                    <select name="level" id="level" class='form-control'>
                        <option value=""></option>
                        @foreach($levels as $level)
                        <option value="{{ $level }}">{{ ucwords($level) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_desa" autocomplete=off class='control-label'>Desa / Kelurahan </label>
                    <select name="id_desa" id="id_desa" class='form-control'>
                        <option value=""></option>
                        @foreach($desas as $desa)
                        <option value="{{ $desa->id }}">{{ $desa->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_tps" autocomplete=off class='control-label'>TPS</label>
                    <select name="id_tps" id="id_tps" class='form-control'></select>
                </div>

                <div class="form-group">
                    <label for="alamat" autocomplete=off class='control-label'>Alamat <span class='text-danger'>*</span></label>
                    <input type="text" placeholder="Entri Alamat" name='alamat' id='alamat' class='form-control FormIsi'>
                </div>
                
                <hr>
                <div class="form-group">
                    <button  class='btn btn-sm btn-success btn-flat'><i class='fa fa-save'></i> Submit</button>
                    <a class='btn btn-sm btn-danger' href="{{ url('kecamatan/users') }}" data-toggle='tooltip' title='Kembali'><i class="fa fa-reply"></i> Kembali</a>
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
        $("#cek_pass").on("click", function(e){
            if($(this).is(':checked')){
                $("#password").prop("readonly",false).focus();

            }else{
                $("#password").prop("readonly",true);
            }
        })

        $('#id_desa').select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih Desa / Kelurahan',
            allowClear: true,
        });
        $('#level').select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih Level',
            allowClear: true,
        });

        $("#id_desa").on("change", function(e){
            var id = $("#id_desa").val();
            $("#id_tps").val("").trigger("change");
            console.log(id);
            get_tps(id);
        })
    })

    function selected_data(id,id_data,text){
        $("#"+id).append("<option value='"+id_data+"'>"+text+"</option>");
    }

    function get_tps(id){
        var id_desa = btoa(id);
        $('#id_tps').select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih TPS',
            allowClear: true,
            ajax: {
                url: "{{ url('api/tps/get_data_by_des/') }}/"+id_desa,
                processResults: function (data) {
                    return {
                        results: data.data
                    };
                }
            }
        })
    }

    function getData(id_data){
        $.ajax({
            type : "GET",
            dataType: "json",
            url : "{{ url('api/user/get_data') }}/"+id_data,
            data : "input=[]",
            error: function(er){
                console.log(er)
            },
            success: function(data){
                $("#id").val(id_data);
                $("#nama").val(data.data.nama)
                $("#no_ktp").val(data.data.no_ktp)
                $("#username").val(data.data.username)
                $("#alamat").val(data.data.alamat)
                $("#level").val(data.data.level).trigger("change");
                $("#id_kabupaten").val(data.data.id_kabupaten)
                $("#id_kecamatan").val(data.data.id_kecamatan)
                $("#id_desa").val(data.data.id_desa).trigger("change");
                get_tps(data.data.id_desa);
                selected_data("id_tps",data.data.id_tps,data.data.tps);
                

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
            url		: "{{ url('api/user/update') }}",
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
                sweetAlertErr(error.responseJSON.status,error.responseJSON.messages)
            }
        });
    }

    
</script>
@endsection