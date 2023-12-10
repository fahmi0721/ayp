@extends("home")
@section("title", "TAMBAH SUARA TPS -")
@section("bardcumb")
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Suara TPS</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('admin/suara') }}">Suara TPS</a></li>
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
          <h3 class="card-title">Tambah Data Suara TPS</h3>

          <div class="card-tools">
            <!-- <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button> -->
          </div>
        </div>
        <div class="card-body">
            <form action="javascript:void(0)" id='FormData'>
                @csrf
                <div class="form-group">
                    <label for="id_kandidat" autocomplete=off class='control-label'>Kandidat <span class='text-danger'>*</span></label>
                    <select name="id_kandidat" id="id_kandidat" class='form-control'>
                        <option value=""></option>
                        @foreach($kandidats as $kandidat)
                        <option value="{{ $kandidat->id }}">{{ $kandidat->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_kabupaten" autocomplete=off class='control-label'>Kabupaten <span class='text-danger'>*</span></label>
                    <select name="id_kabupaten" id="id_kabupaten" class='form-control'>
                        <option value=""></option>
                        @foreach($kabupatens as $kab)
                        <option value="{{ $kab->id }}">{{ $kab->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_kecamatan" autocomplete=off class='control-label'>Kecamatan <span class='text-danger'>*</span></label>
                    <select name="id_kecamatan" id="id_kecamatan" class='form-control'><option value="">Pilih Kecamatan</option></select>
                </div>

                <div class="form-group">
                    <label for="id_desa" autocomplete=off class='control-label'>Desa <span class='text-danger'>*</span></label>
                    <select name="id_desa" id="id_desa" class='form-control'><option value="">Pilih Desa / Kelurahan</option></select>
                </div>

                <div class="form-group">
                    <label for="id_tps" autocomplete=off class='control-label'>TPS <span class='text-danger'>*</span></label>
                    <select name="id_tps" id="id_tps" class='form-control'><option value="">Pilih TPS</option></select>
                </div>

                <div class="form-group">
                    <label for="bukti" autocomplete=off class='control-label'>Bukti <span class='text-danger'>*</span></label>
                    <div class='input-group'>
                        <input type="file" placeholder="Entri Alamat" name='bukti' id='bukti' class='form-control FormIsi'>
                        <span class='input-group-text'><i class='fa fa-file'></i></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="suara_kandidat" autocomplete=off class='control-label'>Suara Kandidat <span class='text-danger'>*</span></label>
                    <input type="text" placeholder="Entri Suara Kandidat" name='suara_kandidat' id='suara_kandidat' class='form-control FormIsi'>
                </div>

                <div class="form-group">
                    <label for="jumlah_pemilih" autocomplete=off class='control-label'>Jumlah Pemilih <span class='text-danger'>*</span></label>
                    <input type="text" placeholder="Entri Jumlah Pemilih" name='jumlah_pemilih' id='jumlah_pemilih' class='form-control FormIsi'>
                </div>

               
                <hr>
                <div class="form-group">
                    <button  class='btn btn-sm btn-success btn-flat'><i class='fa fa-save'></i> Submit</button>
                    <a class='btn btn-sm btn-danger' href="{{ url('admin/suara') }}" data-toggle='tooltip' title='Kembali'><i class="fa fa-reply"></i> Kembali</a>
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
        $('#id_kabupaten').select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih Kabupaten',
            allowClear: true,
        });
        $('#id_kandidat').select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih Kandidat',
            allowClear: true,
        });

        $("#id_kabupaten").on("change", function(e){
            var id = $("#id_kabupaten").val();
            $("#id_kecamatan").val("").trigger("change");
            $("#id_desa").val("").trigger("change");
            $("#id_tps").val("").trigger("change");
            get_kecamatan(id);
        })
        $("#id_kecamatan").on("change", function(e){
            var id = $("#id_kecamatan").val();
            get_desa(id);
        })
        $("#id_desa").on("change", function(e){
            var id = $("#id_desa").val();
            console.log(id);
            get_tps(id);
        })
    })

    function get_kecamatan(id_kab){
        var id_kabupaten = btoa(id_kab);
        $('#id_kecamatan').select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih Kecamatan',
            allowClear: true,
            ajax: {
                url: "{{ url('api/kecamatan/get_data_by_kab/') }}/"+id_kabupaten,
                processResults: function (data) {
                    return {
                        results: data.data
                    };
                }
            }
        })
    }

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
            url		: "{{ url('api/suara/save') }}",
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