@extends("home")
@section("title", "TAMBAH USERS -")
@section("bardcumb")
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>USERS</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('kabupaten') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('kabupaten/users') }}">Users</a></li>
            <li class="breadcrumb-item active">Tambah</li>
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
          <h3 class="card-title">Tambah Data Users</h3>

          <div class="card-tools">
            <!-- <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button> -->
          </div>
        </div>
        <div class="card-body">
            <form action="javascript:void(0)" id='FormData'>
                @csrf
                <input type="hidden" name="id_kabupaten" id="id_kabupaten" value="{{ auth()->user()->id_kabupaten }}">
                <div class="form-group">
                    <label for="no_ktp" autocomplete=off class='control-label'>No KTP <span class='text-danger'>*</span></label>
                    <input type="text" placeholder="Entri No KTP" name='no_ktp' id='no_ktp' class='form-control FormIsi'>
                </div>

                <div class="form-group">
                    <label for="nama" autocomplete=off class='control-label'>Nama <span class='text-danger'>*</span></label>
                    <input type="text" placeholder="Entri Nama" name='nama' id='nama' class='form-control FormIsi'>
                </div>

                <div class="form-group">
                    <label for="no_hp" autocomplete=off class='control-label'>No HP <span class='text-danger'>*</span></label>
                    <input type="text" placeholder="Entri No HP" name='no_hp' id='no_hp' class='form-control FormIsi'>
                </div>

                <div class="form-group">
                    <label for="username" autocomplete=off class='control-label'>Username <span class='text-danger'>*</span></label>
                    <input type="text" placeholder="Entri Username" name='username' id='username' class='form-control FormIsi'>
                </div>

                <div class="form-group">
                    <label for="password" autocomplete=off class='control-label'>Password <span class='text-danger'>*</span></label>
                    <input type="text" placeholder="Entri Password" name='password' id='password' class='form-control FormIsi'>
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
                    <label for="id_kecamatan" autocomplete=off class='control-label'>Kecamatan</label>
                    <select name="id_kecamatan" id="id_kecamatan" class='form-control'>
                        <option value="">Pillih Kecamatan</option>
                        @foreach($kecamatans as $kecamatan)
                        <option value="{{ $kecamatan->id }}">{{ ucwords($kecamatan->nama) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_desa" autocomplete=off class='control-label'>Desa</label>
                    <select name="id_desa" id="id_desa" class='form-control'><option value="">Pilih Desa / Kelurahan</option></select>
                </div>

                <div class="form-group">
                    <label for="id_tps" autocomplete=off class='control-label'>TPS</label>
                    <select name="id_tps" id="id_tps" class='form-control'><option value="">Pilih TPS</option></select>
                </div>

                <div class="form-group">
                    <label for="alamat" autocomplete=off class='control-label'>Alamat <span class='text-danger'>*</span></label>
                    <input type="text" placeholder="Entri Alamat" name='alamat' id='alamat' class='form-control FormIsi'>
                </div>
                
                <hr>
                <div class="form-group">
                    <button  class='btn btn-sm btn-success btn-flat'><i class='fa fa-save'></i> Submit</button>
                    <a class='btn btn-sm btn-danger' href="{{ url('kabupaten/users') }}" data-toggle='tooltip' title='Kembali'><i class="fa fa-reply"></i> Kembali</a>
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
        $('#id_kecamatan').select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih Kecamatan',
            allowClear: true,
        });
        $('#level').select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih Level',
            allowClear: true,
        });

        $("#id_kecamatan").on("change", function(e){
            $("#id_desa").val("").trigger("change");
            $("#id_tps").val("").trigger("change");
            var id = $("#id_kecamatan").val();
            get_desa(id);
        })
        $("#id_desa").on("change", function(e){
            var id = $("#id_desa").val();
            console.log(id);
            get_tps(id);
        })
    })


    function get_desa(id_kec){
        var id_kecamatan = btoa(id_kec);
        $('#id_desa').select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih Desa / Kelurahan',
            allowClear: true,
            ajax: {
                url: "{{ url('api/kel-desa/get_data_by_kec/') }}/"+id_kecamatan,
                processResults: function (data) {
                    return {
                        results: data.data
                    };
                }
            }
        })
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
        }).then((result) => {
            $(".FormIsi").val("");  
            $("#id_kabupaten").val("").trigger("change");
            $("#id_kecamatan").val("").trigger("change");
            $("#id_desa").val("").trigger("change");
            $("#id_tps").val("").trigger("change");
            $("#level").val("").trigger("change");
        })
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
            url		: "{{ url('api/user/save') }}",
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