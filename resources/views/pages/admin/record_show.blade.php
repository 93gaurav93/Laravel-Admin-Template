@extends('layouts.admin.main')

@section('page-title')
    {{$pageTitle}}
@stop

@section('contents')

    @include('includes.admin.record_show_prepend')
    @foreach($columns as $columnName => $column)
        @include('includes.admin.record_show_select')
    @endforeach
    @include('includes.admin.record_show_append')

@stop

@section('page-spec-css')
    @include('includes.admin.show_css')
@stop

@section('page-spec-js')
    @include('includes.admin.show_js')
@stop