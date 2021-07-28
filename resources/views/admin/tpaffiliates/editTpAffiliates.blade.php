@extends('admin.layout_master.admin_design')

@section('Stylescss')
    <style>
        @media (min-width: 700px) {
            .card-body-content{
                width: 55%;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-1">
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><h5><a href="{{ route('tpaffiliates.index') }}">Voltar</a></h5></li>
                            <li class="breadcrumb-item active">Alteração de Tipos de Afiliados</li>
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
                                    <div class="alert alert-success alert-block">
                                        <button type="button" class="close" data-dismiss="alert">✔</button>
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @endif
                            </div>
                            <!-- /.card-header -->
                            <!-- card-body -->
                            <div class="card-body">
                                <div class="card-body-content align-self-center">
                                    <form action="{{ route('tpaffiliates.update', ['tpaffiliate' => $TpAffiliate->id]) }}" method="post">
                                        @csrf
                                        @method('PUT')

                                        <div class="form-row">
                                            <div class="col">
                                                <label for="inputName">Nome:</label><span class="text-danger col-1">{{$errors->first('name')}}</span>
                                                <input value="{{$TpAffiliate->name}}" type="text" class="form-control" id="idname"  name="name">
                                            </div>
                                            <div class="col col-4">
                                                <label for="inputStatus">Habilitado:</label>
                                                <select id="idstatus" name="status" class="custom-select d-block w-100">
                                                    <option value="S"
                                                        {{(($TpAffiliate->status == 'S') ? "selected" : "")}}>Sim
                                                    </option>
                                                    <option value="N"
                                                        {{(($TpAffiliate->status == 'N') ? "selected" : "")}}>Não
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="md-form">
                                                    <label for="inputDescription">Descrição:</label>
                                                    <textarea name="description" id="iddescription" class="md-textarea form-control" rows="4">{{$TpAffiliate->description}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col">
                                                <hr class="mb-4">
                                                <button class="btn btn-primary btn-lg btn-block" type="submit" value="Submit">Alterar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
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
    <!-- /.Content Wrapper. Contains page content-->
@endsection
