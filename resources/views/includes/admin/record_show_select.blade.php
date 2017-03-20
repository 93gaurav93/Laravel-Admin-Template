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
                            @if($columnsValues[$columnName])
                                {{$columnsValues[$columnName]}}
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
                            @if($columnsValues[$columnName] and Storage::exists($imageDir.$columnsValues[$columnName]))
                                <img src="{{$imageDir.$columnsValues[$columnName]}}" class="img-responsive"/>
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
                            @if($columnsValues[$columnName] and Storage::exists($fileDir.$columnsValues[$columnName]))
                                <a href="{{$fileDir.$columnsValues[$columnName]}}" target="_blank">Download</a>
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
                            @if($columnsValues[$columnName])
                                <a href="{{$columnsValues[$columnName]}}" target="_blank">{{$columnsValues[$columnName]}}</a>
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