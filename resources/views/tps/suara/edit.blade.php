@extends("home")
@section("title", "EDIT SUARA TPS -")
@section("bardcumb")
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Suara TPS</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('tps') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('tps/suara') }}">Suara TPS</a></li>
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
          <h3 class="card-title">Edit Data Suara TPS</h3>

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
                <input type="hidden" id="id_tps" name="id_tps">
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
                    <a class='btn btn-sm btn-danger' href="{{ url('tps/suara') }}" data-toggle='tooltip' title='Kembali'><i class="fa fa-reply"></i> Kembali</a>
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

        $('#id_kandidat').select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih Kandidat',
            allowClear: true,
        });
    })

 

    function selected_data(id,id_data,text){
        $("#"+id).append("<option value='"+id_data+"'>"+text+"</option>");
    }

    function getData(id_data){
        $.ajax({
            type : "GET",
            dataType: "json",
            url : "{{ url('api/suara/get_data') }}/"+id_data,
            data : "input=[]",
            error: function(er){
                console.log(er)
            },
            success: function(data){
                $("#id").val(id_data);
                $("#suara_kandidat").val(data.data.total_suara)
                $("#jumlah_pemilih").val(data.data.jumlah_pemilih)
                $("#id_kandidat").val(data.data.id_kandidat).trigger("change");
                $("#id_kabupaten").val(data.data.id_kabupaten);
                $("#id_kecamatan").val(data.data.id_kecamatan);
                $("#id_desa").val(data.data.id_desa);
                $("#id_tps").val(data.data.id_tps);
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
            url		: "{{ url('api/suara/update') }}",
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