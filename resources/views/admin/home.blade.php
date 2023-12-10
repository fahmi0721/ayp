@extends("home")
@section("title", "DASHBOARD -")

@section("bardcumb")
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Dashboard</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

@endsection
@section("konten")
    <!-- Main content -->
    <section class="content">
        <div class='container-fluid'>
            <div class="row">
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-box-tissue"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">TPS</span>
                        <span class="info-box-number">
                        <span id="tot_tps">0</span>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Pemilih Pasti</span>
                        <span class="info-box-number"><span id="tot_pemilih">0</span></span>
                    </div>
                    <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box mb-3">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-solid fa-person-booth"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Saksi</span>
                        <span class="info-box-number"><span id="tot_saksi">0</span></span>
                    </div>
                    <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>

            <div class='row'>
                <div  class="col-12 col-sm-6 col-md-8">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Perolehan Suara Kandidat</h3>

                            <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="perolehan_suara" style="min-height: 250px;  max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div  class="col-12 col-sm-6 col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Pogress Suara Masuk</h3>

                            <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="pogress_suara" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection


@section('script')
<script>
    $(document).ready(function(){
        get_data_statistik();
        get_data_progress_suara();
        get_data_suara_kandidat(); 
    })

    function get_data_suara_kandidat(){
        $.ajax({
            type : "GET",
            dataType : "json",
            url : "{{ url('perolehan_suara') }}",
            data : "input=[]",
            success:function(res){
                var iData = res.data;
                console.log(res);
                grafik_bar(iData)
            },
            error: function(er){
                console.log(er)
            }
        })
    }
    
    function get_data_statistik(){
        $.ajax({
            type : "GET",
            dataType : "json",
            url : "{{ url('statistik') }}",
            data : "input=[]",
            success:function(res){
                var iData = res.data;
                // console.log(iData);
                $("#tot_tps").html(iData.total_tps);
                $("#tot_pemilih").html(iData.total_pemilih);
                $("#tot_saksi").html(iData.total_saksi);
            },
            error: function(er){
                console.log(er)
            }
        })
    }

    function get_data_progress_suara(){
        $.ajax({
            type : "GET",
            dataType : "json",
            url : "{{ url('progres_suara') }}",
            data : "input=[]",
            success:function(res){
                var iData = res.data;
                // console.log(iData);
                var datas = [iData.total_suara_mausk,iData.total_suara_belum_mausk];
                grafik_donut(datas);
               
            },
            error: function(er){
                console.log(er)
            }
        })
    }

    function grafik_bar(iData){
        const labels = iData.labels;
        const data = {
            labels: labels,
            datasets: [{
                label: 'Perolehan Suara',
                data: iData.values,
                backgroundColor: iData.bg_color,
                borderColor: iData.bg_color,
                borderWidth: 1
            }]
        };
        const config  =  {
            type: 'bar',
            data,
            options: {
                indexAxis: 'y',
            }
        }; 
        var canvas = $('#perolehan_suara').get(0).getContext('2d')
        new Chart(canvas,config);
    }

    function grafik_donut(iData){
        const labels = ['Suara Masuk',"Suara Belum Masuk"];
        const data = {
            labels: labels,
            datasets: [{
                label: 'Progress Suara TPS',
                data: iData,
                backgroundColor: [
                'rgba(45, 47, 147,0.8)',
                'rgba(255, 99, 132,0.8)',
                ],
                borderColor: [
                'rgb(45, 47, 147)',
                'rgb(255, 99, 132)'
                ],
                borderWidth:1
            }]
        };
      
        const config  =  {
            type: 'doughnut',
            data: data, 
            options: {
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {

                                let label = context.dataset.label || '';

                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                }
            }
            // indexAxis: 'y',
        }; 
        var canvas = $('#pogress_suara').get(0).getContext('2d')
        new Chart(canvas,config);
    }
</script>

@endsection