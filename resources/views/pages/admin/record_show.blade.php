@extends('layouts.admin.main')

@section('page-title')
    {{$pageTitle}}
@stop

@section('contents')

    @foreach($columns as $columnName=>$column)
        @include('includes.admin.record_show_select')
    @endforeach

@stop

@section('page-spec-css')
    @include('includes.admin.show_css')
@stop

@section('page-spec-js')
    @include('includes.admin.show_js')
@stop