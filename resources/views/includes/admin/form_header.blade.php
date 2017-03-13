<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <form id="form_validation" action="{{$formAction}}" method="post" enctype="multipart/form-data">
                <div class="header">
                    @include('includes.admin.form_buttons')
                    <div class="clearfix"></div>
                    @if(count($errors) > 0)
                        <div class="p-t-10">
                            <ul class="list-group">
                                @foreach ($errors->all() as $error)
                                    <li class="list-group-item list-group-item-danger m-b-5">{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>
                <div class="body">

{{csrf_field()}}

@if($formType == 'Update')
    {{ method_field('PUT') }}
@endif