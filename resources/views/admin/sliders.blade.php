@extends('adminlayouts.adminlayout')
@section('content')
{{Form::hidden('',$increment = 1)}}
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sliders</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Sliders</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    @if (Session::has('status'))

    <div class="alert alert-success">
      {{Session::get('status')}}
    </div>
@endif
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">All Sliders</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Num.</th>
                    <th>Picture</th>
                    <th>Description one</th>
                    <th>Description Two</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($sliders as $slider)
                        
                    
                  <tr>
                    <td>{{$increment}}</td>
                    <td>
                      <img src="storage/sliderImages/{{$slider->sliderImage}}" style="height : 50px; width : 50px" class="img-circle elevation-2" alt="User Image">
                    </td>
                    <td>{{$slider->description1}}
                    </td>
                    <td>{{$slider->description2}}</td>
                    <td>
                      
                      <a href="{{url('/editSlider/'.$slider->id)}}" class="btn btn-primary"><i class="nav-icon fas fa-edit"></i></a>
                      <a href="{{url('/deleteSlider/'.$slider->id)}}" id="delete" class="btn btn-danger" ><i class="nav-icon fas fa-trash"></i></a>
                      @if ($slider->status == 0)
                        <a href="{{url('/activateSlider/'.$slider->id)}}" class="btn btn-warning">Unactive</a>
                        @else
                        <a href="{{url('/unactivateSlider/'.$slider->id)}}" class="btn btn-success">Active</a>
                        @endif
                    </td>
                  </tr>
                  {{Form::hidden('',$increment = 1+1)}}
                  @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Num.</th>
                    <th>Picture</th>
                    <th>Description one</th>
                    <th>Description Two</th>
                    <th>Actions</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  @endsection

  @section('style')
  <!-- DataTables css -->
  <link rel="stylesheet" href="backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  @endsection

  @section('scripts')
            <!-- DataTables -->
        <script src="backend/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="backend/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
        <!-- AdminLTE App -->
        <script src="backend/dist/js/adminlte.min.js"></script>
        <script src="backend/dist/js/bootbox.min.js"></script>
        <!-- page script -->

        <script>
        $(document).on("click", "#delete", function(e){
        e.preventDefault();
        var link = $(this).attr("href");
        bootbox.confirm("Do you really want to delete this element ?", function(confirmed){
            if (confirmed){
                window.location.href = link;
            };
            });
        });
        </script>
        <!-- page script -->
        <script>
        $(function () {
            $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false,
            });
            $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            });
        });
        </script>
  @endsection