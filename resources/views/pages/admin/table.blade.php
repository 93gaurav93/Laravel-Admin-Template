@extends('layouts.admin.main')

@section('contents')

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Student Table
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);">Action</a></li>
                                <li><a href="javascript:void(0);">Another action</a></li>
                                <li><a href="javascript:void(0);">Something else here</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>About</th>
                            <th>DOB</th>
                            <th>Info File</th>
                            <th>Photo</th>
                            <th>Book</th>
                            <th>Profile Link</th>
                            <th>Gender</th>
                            <th>Email</th>
                            <th>Age</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($students as $s)
                            <tr>
                                <th scope="row">{{$s->id}}</th>
                                <td>{{$s->name}}</td>
                                <td>{{$s->about}}</td>
                                <td>{{$s->dob}}</td>
                                <td>{{$s->file}}</td>
                                <td>
                                    {{--<div class="col-xs-6 col-md-3">
                                        <a href="javascript:void(0);" class="thumbnail">
                                            <img src="{{$s->photo}}" class="img-responsive">
                                        </a>
                                    </div>--}}
                                    {{$s->photo}}
                                </td>
                                <td>{{$s->book}}</td>
                                <td>{{$s->profile_link}}</td>
                                <td>{{$s->gender}}</td>
                                <td>{{$s->email}}</td>
                                <td>{{$s->age}}</td>
                                <td>@mdo</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop

@section('page-spec-css')

@stop

@section('page-spec-js')

@stop