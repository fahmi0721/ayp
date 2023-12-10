@extends("home")
@section("title", "TAMBAH KABUPATEN -")
@section("bardcumb")
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Kabupaten</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('admin/kabupaten') }}">Kabupaten</a></li>
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
          <h3 class="card-title">Tambah Data Kabupaten</h3>

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
                    <label for="nama" autocomplete=off class='control-label'>Nama Kabupaten <span class='text-danger'>*</span></label>
                    <input type="text" placeholder="Entri Nama Kabupaten" name='nama' id='nama' class='form-control FormIsi'>
                </div>

                
                <hr>
                <div class="form-group">
                    <button  class='btn btn-sm btn-success btn-flat'><i class='fa fa-save'></i> Submit</button>
                    <a class='btn btn-sm btn-danger' href="{{ url('admin/kabupaten') }}" data-toggle='tooltip' title='Kembali'><i class="fa fa-reply"></i> Kembali</a>
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
            url		: "{{ url('api/kabupaten/save') }}",
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
            }
        });
    }

    
</script>
@endsection