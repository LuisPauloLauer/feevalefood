@extends('admin.layout_master.admin_design')

@section('Stylescss')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('admin/adminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/adminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/adminLTE/plugins/bootstrap-switch/css/bootstrap3/bootstrap-switch.css') }}">
@endsection

@section('content')

    <!-- Modal Delete -->
    <div id="idconfirmDeleteModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Confirma Deletar?</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">Categoria ID: <span id="idspanid"></span></h4>
                    <h4 align="center" style="margin:0;">Nome: <span id="idspanname"></span></h4>
                </div>
                <div class="modal-footer">
                    <form name="formDeleteObject" action="{{ route('categoriesproduct.delete') }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="categoriesProduct_id" id="idDeleteObject" value="">
                        <button class="btn btn-success" type="submit" id="idOkDelete">Sim</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.Modal Delete -->

    <!-- Modal order -->
    <div id="app">
        <table-draggable :categoriesproduct="{{ $listCategoriesProduct }}"></table-draggable>
    </div>
    <!-- Modal order -->


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-1">
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><h5><a href="{{ route('categoriesproduct.create') }}">Cadastrar</a></h5></li>
                            <li class="breadcrumb-item active">Categorias de Kits/Produtos</li>
                        </ol>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col">
                        <ol class="breadcrumb float-sm-right">
                            <button id="idBtnAlterOrder" class="btn btn-primary btn-block"><span style="width: 25px;" class="glyphicon fas fa-list-ol"></span>Definir ordem</button>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.Content Header (Page header) -->

        <!-- Content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- card -->
                        <div class="card">
                            <!-- card-header -->
                            <div class="card-header">
                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success alert-block" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">???</button>
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @elseif ($message = Session::get('error'))
                                    <div class="alert alert-danger alert-block" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">???</button>
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @endif
                            </div>
                            <!-- /.card-header -->
                            <!-- card-body -->
                            <div class="card-body">
                                <table id="idtableCategoriesProduct" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Habilitado</th>
                                        <th>Nome</th>
                                        <th width="90">A????es</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($listCategoriesProduct as $CategoriesProduct)
                                        <tr>
                                            <td>{{ $CategoriesProduct->id }}</td>
                                            <td>
                                                <input id="ckbstatus" name="ckbstatus" class="ckbstatus-bootstrap-switch" type="checkbox" {{ (($CategoriesProduct->status == 'S') ? "checked" : "") }} data-objectid="{{$CategoriesProduct->id}}">
                                            </td>
                                            <td>{{ $CategoriesProduct->name }}</td>
                                            <td>
                                                <div>
                                                    <a id='idBtnEdit' class="btn btn-large btn-warning" href="{{ route('categoriesproduct.edit', ['categoriesproduct' => $CategoriesProduct->id]) }}"><span class="glyphicon fas fa-edit"></span></a>
                                                    <a id='idBtnDelete' class="btn btn-large btn-danger" data-objectid="{{$CategoriesProduct->id}}" data-objectname="{{$CategoriesProduct->name}}" href="#"><span class="glyphicon fas fa-trash"></span></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Habilitado</th>
                                        <th>Nome</th>
                                        <th width="90">A????es</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
        <!-- /.Content -->
    </div>
    <!-- /.Content Wrapper. Contains page content -->

@endsection

@section('javascript')
    <!-- DataTables -->
    <script src="{{ asset('admin/adminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/adminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/adminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin/adminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <!-- Bootstrap Switch -->
    <script src="{{ asset('admin/adminLTE/plugins/bootstrap-switch/js/bootstrap-switch.js') }}"></script>
    <!-- Options components default -->
    <script src="{{ asset('admin/node_modules/js/option-components-default.js') }}"></script>
    <script>
        $(document).ready(function () {

            <!-- DataTables -->
            $(function () {
                $("#idtableCategoriesProduct").DataTable({
                    "responsive": true,
                    "autoWidth": false,
                    "ordering": false
                });
            });

            <!-- Modal Delete show modal -->
            $(document).on('click','#idBtnDelete', function () {

                var object_id = $(this).data("objectid");
                var object_name = $(this).data("objectname");

                $('#idconfirmDeleteModal').modal('show');

                $('#idDeleteObject').val(object_id);
                $('#idspanid').text(object_id);
                $('#idspanname').text(object_name);
            });

            <!-- Modal alter order show modal -->
            $(document).on('click','#idBtnAlterOrder', function () {
                $('#idModalAlterOrdem').modal('show');
            });

            <!-- bootstrap-switch -->
            $('input[class="ckbstatus-bootstrap-switch"]').each(function(){
                var object_id = $(this).data("objectid");

                $(this).bootstrapSwitch({
                    'objectID': object_id,
                    'state' : $(this).prop('checked'),
                    'size': 'normal',
                    'inverse': true,
                    'onColor': 'success',
                    'offColor': 'danger',
                    'onText': 'SIM',
                    'offText': 'N??O'
                });
            });

            $('.bootstrap-switch-id-ckbstatus').on('switchChange.bootstrapSwitch', function (event, state) {

                var object_id = $(this).data("objectid");
                let elementdiv = $(this);

                if(state){
                    var objStatus = 'S';
                }else{
                    var objStatus = 'N';
                }

                $.ajax({

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('categoriesproduct.change.status') }} ",
                    type: "post",
                    data : {
                        object_id : object_id,
                        object_status : objStatus
                    },
                    dataType: "json",
                    success : function (response) {
                        if(response.success){
                            toastr.success(response.message);
                        } else {
                            if(state){
                                elementdiv.find('input[type="checkbox"]').bootstrapSwitch('state', false, true);
                            }else{
                                elementdiv.find('input[type="checkbox"]').bootstrapSwitch('state', true, true);
                            }
                            toastr.error(response.message);
                        }
                    }
                });

            });

        });
    </script>
@endsection
