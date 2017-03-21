@extends('layouts.admin.main')

@section('page-title')
    Dashboard
@stop

@section('contents')

    @foreach($tablesIndex as $tblName=>$tblMeta)
        @include('includes.admin.dashboard_links')
    @endforeach

@stop

@section('page-spec-css')

@stop

@section('page-spec-js')
    @include('includes.admin.dashboard_js')
@stop