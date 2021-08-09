@extends('site.layout_master.site_design')

@section('content')
    <div id="demands">
        <div-demands :listdemand="{{$listDemand}}" :listdemanditens="{{$listDemandItens}}" :appurl="{{$appUrl}}"></div-demands>
    </div>
@endsection
@section('javascript')
    <script>
        const demands = new Vue({
            el: '#demands'
        });
    </script>
@endsection
