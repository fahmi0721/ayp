@extends("home")
@section("title", "TAMBAH KANDIDAT -")
@section("bardcumb")
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Kandidat</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('admin/kandidat') }}">Kandidat</a></li>
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
          <h3 class="card-title">Tambah Data Kandidat</h3>

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
                    <label for="nama" autocomplete=off class='control-label'>Nama Kandidat <span class='text-danger'>*</span></label>
                    <input type="text" placeholder="Entri Nama Kandidat" name='nama' id='nama' class='form-control FormIsi'>
                </div>

                <div class="form-group">
                    <label for="kategori" autocomplete=off class='control-label'>Kategori <span class='text-danger'>*</span></label>
                    <select name="kategori" id="kategori" class='form-control'>
                        <option value="">Pilih Kategori</option>
                        <option value="caleg">Caleg</option>
                        <option value="lawan">Lawan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_partai" autocomplete=off class='control-label'>Partai <span class='text-danger'>*</span></label>
                    <select name="id_partai" id="id_partai" class='form-control'>
                        <option value=""></option>
                        @foreach($partais as $partai)
                        <option value="{{ $partai->id }}">{{ $partai->nama }}</option>
                        @endforeach
                    </select>
                </div>

                
                
                <hr>
                <div class="form-group">
                    <button  class='btn btn-sm btn-success btn-flat'><i class='fa fa-save'></i> Submit</button>
                    <a class='btn btn-sm btn-danger' href="{{ url('admin/kandidat') }}" data-toggle='tooltip' title='Kembali'><i class="fa fa-reply"></i> Kembali</a>
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
        $('#id_partai').select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih Partai',
            allowClear: true,
        })

        $('#kategori').select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih Kategori',
            allowClear: true,
        })
    })
    
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
            $("#id_partai").val("").trigger("change");
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
            url		: "{{ url('api/kandidat/save') }}",
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