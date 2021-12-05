@extends('site.layout_master.site_design')

@section('content')
    <div id="demands">
        <div-demands :listdemand="{{$listDemand}}" :listdemanditens="{{$listDemandItens}}"></div-demands>
    </div>
@endsection


