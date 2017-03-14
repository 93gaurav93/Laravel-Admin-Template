@extends('layouts.admin.main')

@section('page-title')
    {{$formType}} {{$pageTitle}} Record
@stop

@section('contents')

    @include('includes.admin.form_header')

    @foreach($columns as $columnName=>$column)
        @include('includes.admin.form_fields')
    @endforeach

    @include('includes.admin.form_footer')
@stop

@section('page-spec-css')
    @include('includes.admin.form_css')
@stop

@section('page-spec-js')
    @include('includes.admin.form_js')
    @include('includes.admin.form_script')
@stop