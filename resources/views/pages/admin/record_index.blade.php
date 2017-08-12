@extends('layouts.admin.main')

@section('page-title')
    {{$pageTitle}}
@stop

@section('contents')

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">

                <div>
                    <button id="addFormBtn" onclick="window.location.href = '{{$modelIndexUrl.'create'}}'"
                            type="button"
                            class="btn btn-primary waves-effect m-t-10 m-l-10">Add New Record
                    </button>

                </div>
                <div class="header">
                    <div class="clearfix"></div>
                    <div id="export_buttons"></div>
                </div>

                <div class="clearfix"></div>

                {{--<div>

                    <div class="clearfix">
                        <div class="col-md-6">
                            <p><b>Scroll Table</b></p>
                            <div id="nouislider_basic_example"></div>
                            <div class="m-t-20 font-12"><b>Value: </b><span class="js-nouislider-value"></span></div>
                        </div>
                    </div>

                </div>--}}

                <div class="body">
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                        <thead>
                        <tr>
                            @include('includes.admin.index_columns')
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            @include('includes.admin.index_columns')
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>


@stop

@section('page-spec-css')
    @include('includes.admin.index_css')
@stop

@section('page-spec-js')
    @include('includes.admin.index_js')
    @include('includes.admin.index_script')
@stop