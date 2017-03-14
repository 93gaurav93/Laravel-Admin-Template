@if($column['showInView'])
    @if($column['showType'] == 'text')
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            {{$column['title']}}
                        </h2>
                    </div>
                    <div class="body">
                        <p class="lead">
                            @if($column['value'])
                                {{$column['value']}}
                            @else
                                Not Set
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($column['showType'] == 'image')
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            {{$column['title']}}
                        </h2>
                    </div>
                    <div class="body">
                        <p class="lead">
                            @if($column['value'] and Storage::exists($imageDir.$column['value']))
                                <img src="{{$imageDir.$column['value']}}" class="img-responsive"/>
                            @else
                                Not Set
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($column['showType'] == 'file')
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            {{$column['title']}}
                        </h2>
                    </div>
                    <div class="body">
                        <p class="lead">
                            @if($column['value'] and Storage::exists($fileDir.$column['value']))
                                <a href="{{$fileDir.$column['value']}}" target="_blank">Download</a>
                            @else
                                Not Set
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($column['showType'] == 'url')
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            {{$column['title']}}
                        </h2>
                    </div>
                    <div class="body">
                        <p class="lead">
                            @if($column['value'])
                                <a href="{{$column['value']}}" target="_blank">{{$column['value']}}</a>
                            @else
                                Not Set
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif