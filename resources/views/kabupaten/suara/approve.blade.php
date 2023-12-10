@extends("home")
@section("title", "APPROVE SUARA TPS -")
@section("bardcumb")
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Suara TPS</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('kabupaten') }}">Home</a></li>
            <li class="breadcrumb-item active">Approve Suara TPS</li>
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
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Detail Approve Suara Tps</h3>

          <div class="card-tools">
          </div>
        </div>
        <div class="card-body">
          <div class='table-responsive'>
                <table class='table table-striped table-bordered' id="TableData">
                    <thead>
                        <tr>
                            <th width="5px">No</th>
                            <th>Kandidat</th>
                            <th>Total Suara</th>
                            <th>Jumlah Pemilih</th>
                            <th>TPS</th>
                            <th>Kabupaten</th>
                            <th>Kecamatan</th>
                            <th>Desa / Kelurahan</th>
                            <th width='5%'>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
          </div>
        </div>
        <!-- /.card-body -->
        
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection

@section('script')
<script>
    $(function() {
       $('#TableData').DataTable({
            stateSave: true,
            processing: true,
            responsive: true,
            serverSide: true,
            ajax: "{{ url('api/suara/get_approve') }}/{{ base64_encode(auth()->user()->id_kabupaten) }}",
            columns: [
                { data: 'DT_RowIndex', className: "text-center",'searchable':false,"orderable": false },
                { data: 'kandidat', name: 'kandidat' },
                { data: 'total_suara', name: 'total_suara' },
                { data: 'jumlah_pemilih', name: 'jumlah_pemilih' },
                { data: 'tps', name: 'tps' },
                { data: 'kabupaten', name: 'kabupaten' },
                { data: 'kecamatan', name: 'kecamatan' },
                { data: 'desa', name: 'desa' },
                { data: 'action', name: 'action',className: "text-center",'searchable':false,"orderable": false },
            ],
            "drawCallback": function( settings ) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
    });


    function update_status(id,status){
        var msg = status == "invalid" ? "Do you want to unapprove data?" : "Do you want to approve data?";
        Swal.fire({
            title: msg,
            showCancelButton: true,
            confirmButtonText: "Yes",
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type	: "POST",
                    dataType: "json",
                    url		: "{{ url('api/suara/approve') }}",
                    data	: "_method=PUT&_token="+tokenCSRF+"&status="+status+"&id="+id,
                    success	:function(data) {
                        console.log(data);
                        var Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1000
                            });
                        Toast.fire({
                            icon: data.status,
                            title: data.messages
                        }).then((result) => {
                            var table = $('#TableData').DataTable();
                            load_notif();
                            table.ajax.reload(null, false);  
                        })
                       
                    },
                    error: function(er){
                        console.log(er)
                        if(er.responseJSON.status){
                            var Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1000
                            });
                            Toast.fire({
                                icon: er.responseJSON.status,
                                title: er.responseJSON.messages
                            })
                        }else{
                            var Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1000
                            });
                            Toast.fire({
                                icon: "warning",
                                title: er.responseJSON.message
                            })
                        }
                    }
                });
            }
        });
    }

    
</script>
@endsection