@extends('layouts.admin.main')

@section('contents')

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <form action="{{url('SubmitForm')}}" method="post" enctype="multipart/form-data">
                    <div class="header">
                        <button type="submit" class="btn btn-primary waves-effect">Add Record</button>
                        <button type="reset" class="btn btn-primary waves-effect">Reset</button>
                        <button type="button" class="btn btn-primary waves-effect">Cancel</button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="body">

                        {{csrf_field()}}

                        <h2 class="card-inside-title">Name</h2>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="name" class="form-control" placeholder="Name"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h2 class="card-inside-title">About</h2>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <textarea name="about"
                                                  rows="2"
                                                  class="form-control no-resize auto-growth"
                                                  placeholder="About Student">
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h2 class="card-inside-title">Date of Birth</h2>
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input name="dob"
                                               type="text" class="datepicker form-control"
                                               placeholder="Please choose a date...">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h2 class="card-inside-title">Info File</h2>
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="file" name="info_file"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h2 class="card-inside-title">Photo</h2>
                        <div class="row clearfix">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="file" name="image"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h2 class="card-inside-title">Book</h2>
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <select name="book" class="form-control show-tick"
                                        data-live-search="true" title="Book">
                                    <option>Default</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                    <option value="4">Four</option>
                                </select>
                            </div>
                        </div>

                        <h2 class="card-inside-title">Profile Link</h2>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <textarea name="profile_link"
                                                  rows="1" class="form-control no-resize auto-growth"
                                                  placeholder="Profile Link"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h2 class="card-inside-title">Gender</h2>
                        <div class="row clearfix">
                            <div class="col-sm-12">

                                <input name="gender" type="radio" id="radio_30"
                                       value="1"
                                       class="with-gap radio-col-red"/>
                                <label for="radio_30">Male</label>

                                <input name="gender" type="radio" id="radio_31"
                                       value="2"
                                       class="with-gap radio-col-red"/>
                                <label for="radio_31">Female</label>

                                <input name="gender" type="radio" id="radio_32"
                                       value="3"
                                       class="with-gap radio-col-red"/>
                                <label for="radio_32">N/A</label>

                            </div>
                        </div>

                        <h2 class="card-inside-title">Email</h2>
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input name="email"
                                               type="text" class="form-control email_mask"
                                               placeholder="Ex: example@example.com">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h2 class="card-inside-title">Age</h2>
                        <div class="row clearfix">
                            <div class="col-md-2">
                                <div class="input-group spinner" data-trigger="spinner">
                                    <div class="form-line">
                                        <input name="age"
                                               type="text" class="form-control text-center"
                                               value="1" data-rule="quantity">
                                    </div>
                                    <span class="input-group-addon">
                                            <a href="javascript:;" class="spin-up" data-spin="up"><i
                                                        class="glyphicon glyphicon-chevron-up"></i></a>
                                            <a href="javascript:;" class="spin-down" data-spin="down"><i
                                                        class="glyphicon glyphicon-chevron-down"></i></a>
                                        </span>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="header">
                        <button type="submit" class="btn btn-primary waves-effect">Add Record</button>
                        <button type="reset" class="btn btn-primary waves-effect">Reset</button>
                        <button type="button" class="btn btn-primary waves-effect">Cancel</button>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop

@section('page-spec-css')
    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="{{url('plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"
          rel="stylesheet"/>
    <!-- Bootstrap Select Css -->
    <link href="{{url('plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet"/>
    <!-- Bootstrap Spinner Css -->
    <link href="{{url('plugins/jquery-spinner/css/bootstrap-spinner.css')}}" rel="stylesheet">
@stop

@section('page-spec-js')
    <!-- Autosize Plugin Js -->
    <script src="{{url('plugins/autosize/autosize.js')}}"></script>
    <!-- Moment Plugin Js -->
    <script src="{{url('plugins/momentjs/moment.js')}}"></script>
    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="{{url('plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
    <!-- Input Mask Plugin Js -->
    <script src="{{url('plugins/jquery-inputmask/jquery.inputmask.bundle.js')}}"></script>
    <!-- Jquery Spinner Plugin Js -->
    <script src="{{url('plugins/jquery-spinner/js/jquery.spinner.js')}}"></script>

    <script>
        $(function () {
            //Textare auto growth
            autosize($('textarea.auto-growth'));

        });

        $('.datepicker').bootstrapMaterialDatePicker({
            format: 'dddd DD MMMM YYYY (DD-MM-YYYY)',
            clearButton: true,
            weekStart: 1,
            time: false
        });

        //Email Mask
        $(".email_mask").inputmask({alias: "email"});


    </script>
@stop