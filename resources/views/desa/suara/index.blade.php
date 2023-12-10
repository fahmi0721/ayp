@extends("home")
@section("title", "SUARA TPS -")
@section("bardcumb")
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Suara TPS</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('desa') }}">Home</a></li>
            <li class="breadcrumb-item active">Suara TPS</li>
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
          <h3 class="card-title">Detail Suara Tps</h3>

          <div class="card-tools">
            </a> 
          </div>
        </div>
        <div class="card-body">
          <div class='table-responsive'>
                <table class='table table-striped table-bordered' id="TableData">
                    <thead>
                        <tr>
                            <th width="5px">No</th>
                            <th>Kandidat</th>
                            <th>Suara Kandidat</th>
                            <th>Jumlah Pemilih</th>
                            <th>TPS</th>
                            <th>Status</th>
                            <th>Bukti</th>
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
            ajax: "{{ url('api/suara/desa') }}/{{ base64_encode(auth()->user()->id_desa) }}",
            columns: [
                { data: 'DT_RowIndex', className: "text-center",'searchable':false,"orderable": false },
                { data: 'kandidat', name: 'kandidat' },
                { data: 'total_suara', name: 'total_suara' },
                { data: 'jumlah_pemilih', name: 'jumlah_pemilih' },
                { data: 'tps', name: 'tps' },
                { data: 'status', name: 'status',className: "text-center" },
                { data: 'bukti', name: 'bukti',className: "text-center",'searchable':false,"orderable": false },
            ],
            "drawCallback": function( settings ) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
    });


    function hapus_data(id){
        Swal.fire({
            title: "Do you want to delete data?",
            showCancelButton: true,
            confirmButtonText: "Yes",
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type	: "POST",
                    dataType: "json",
                    url		: "{{ url('api/suara/delete') }}/"+id,
                    data	: "_method=DELETE&_token="+tokenCSRF,
                    success	:function(data) {
                        console.log(data);
                        var Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        Toast.fire({
                            icon: data.status,
                            title: data.messages
                        }).then((result) => {
                            var table = $('#TableData').DataTable();
                            table.ajax.reload(null, false);  
                        })
                       
                    },
                    error: function(er){
                        console.log(er);
                    }
                });
            }
        });
    }

    
</script>
@endsection