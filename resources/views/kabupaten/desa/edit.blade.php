@extends("home")
@section("title", "EDIT KELURAHAN / DESA -")
@section("bardcumb")
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Kelurahan / Desa</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('kabupaten') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('kabupaten/desa') }}">Kelurahan / Desa</a></li>
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
          <h3 class="card-title">Edit Data Kelurahan / Desa</h3>

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
                <div class="form-group">
                    <label for="nama" autocomplete=off class='control-label'>Nama Kelurahan / Desa <span class='text-danger'>*</span></label>
                    <input type="text" placeholder="Entri Nama Kelurahan / Desa" name='nama' id='nama' class='form-control FormIsi'>
                </div>

                <div class="form-group">
                    <label for="nama" autocomplete=off class='control-label'>Kabupaten <span class='text-danger'>*</span></label>
                    <select name="id_kecamatan" id="id_kecamatan" class='form-control'>
                        <option value=""></option>
                        @foreach($kecamatans as $kecamatan)
                        <option value="{{ $kecamatan->id }}">{{ $kecamatan->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <hr>
                <div class="form-group">
                    <button  class='btn btn-sm btn-success btn-flat'><i class='fa fa-save'></i> Submit</button>
                    <a class='btn btn-sm btn-danger' href="{{ url('kabupaten/desa') }}" data-toggle='tooltip' title='Kembali'><i class="fa fa-reply"></i> Kembali</a>
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
        $('#id_kecamatan').select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih Kecamatan',
            allowClear: true,
        })

    })

    function getData(id_data){
        $.ajax({
            type : "GET",
            dataType: "json",
            url : "{{ url('api/kel-desa/get_data') }}/"+id_data,
            data : "input=[]",
            error: function(er){
                console.log(er)
            },
            success: function(data){
                $("#id").val(id_data);
                $("#nama").val(data.data.nama)
                $("#id_kabupaten").val(data.data.id_kabupaten);
                $("#id_kecamatan").val(data.data.id_kecamatan).trigger("change");
                

            }
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
            // $(".FormIsi").val("");  
        })
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
            url		: "{{ url('api/kel-desa/update') }}",
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