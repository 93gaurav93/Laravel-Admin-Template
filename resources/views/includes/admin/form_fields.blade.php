@if($column['showInForm'])

    @if($column['formType'] == 'text')
        @include('includes.admin.field_title')
        <div class="row clearfix">
            <div class="col-md-{{$column['widthInForm'] or 12}}">
                <div class="form-group">
                    <div class="form-line">
                        <input
                                type="text"
                                name="{{$columnName}}"
                                class="form-control"
                                placeholder="{{$column['title']}}"
                                value="{{$columnsValues[$columnName] or ''}}">
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($column['formType'] == 'password')
        @include('includes.admin.field_title')
        <div class="row clearfix">
            <div class="col-md-{{$column['widthInForm'] or 12}}">
                <div class="form-group">
                    <div class="form-line">
                        <input
                                type="password"
                                name="{{$columnName}}"
                                class="form-control"
                                placeholder="{{$column['title']}}"
                                value="">
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($column['formType'] == 'textArea')
        @include('includes.admin.field_title')
        <div class="row clearfix">
            <div class="col-md-{{$column['widthInForm'] or 12}}">
                <div class="form-group">
                    <div class="form-line">
                    <textarea name="{{$columnName}}"
                              rows="{{$column['rows'] or 2}}"
                              class="form-control no-resize auto-growth"
                              placeholder="{{$column['title']}}">{{$columnsValues[$columnName] or ''}}</textarea>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($column['formType'] == 'date')
        @include('includes.admin.field_title')
        <div class="row clearfix">
            <div class="col-md-{{$column['widthInForm'] or 12}}">
                <div class="form-group">
                    <div class="form-line">
                        <input name="{{$columnName}}"
                               type="date" class="form-control"
                               placeholder="{{$column['title']}}"
                               value="{{$columnsValues[$columnName] or ''}}">
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($column['formType'] == 'file' or $column['formType'] == 'image')
        @include('includes.admin.field_title')

        @if(isset($columnsValues[$columnName]))
            @if($column['formType'] == 'file')
                @if($columnsValues[$columnName] && Storage::exists($fileDir.$columnsValues[$columnName]))
                    <a href="{{url($fileDir.$columnsValues[$columnName])}}" target="_blank">
                        (Download Current File)
                    </a>
                    <i>(Don't change to keep same)</i>
                @endif
            @endif
            @if($column['formType'] == 'image')
                @if($columnsValues[$columnName] && Storage::exists($imageThumbDir.$columnsValues[$columnName]))
                    <img src="{{url($imageThumbDir.$columnsValues[$columnName])}}"
                         class="responsive m-b-10">
                    <i>(Don't change to keep same)</i>
                @endif
            @endif
        @endif

        <div class="row clearfix">
            <div class="col-md-{{$column['widthInForm'] or 12}}">
                <div class="form-group">
                    <div class="form-line">
                        <input type="file" name="{{$columnName}}"/>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($column['formType'] == 'remoteList')
        @include('includes.admin.field_title')
        <div class="row clearfix">
            <div class="col-md-{{$column['widthInForm'] or 12}}">
                <select id="remote_list_{{$columnName}}" name="{{$columnName}}"
                        class="form-control show-tick"
                        data-select-id="{{$columnsValues[$columnName] or ''}}"
                        data-live-search="true"
                        title="{{$column['title']}}">
                    @if(isset($columnsValues[$columnName]) && $columnsValues[$column['remoteColumn']])
                        <option value="{{$columnsValues[$columnName]}}" selected>
                            {{$columnsValues[$column['remoteColumn']]}}
                        </option>
                    @endif
                </select>
            </div>
        </div>
    @endif

    @if($column['formType'] == 'radio')
        @include('includes.admin.field_title')
        <div class="row clearfix">
            <div class="col-md-{{$column['widthInForm'] or 12}}">

                @foreach($column['radioButtonsInForm'] as $i=>$r)
                    @if(isset($columnsValues[$columnName]))
                        <input name="{{$columnName}}" type="radio" id="radio_{{$i}}"
                               value="{{$r['value']}}"
                               class="with-gap radio-col-red"
                                {{$r['value']==$columnsValues[$columnName]?"checked='checked'":''}}
                        />
                    @else
                        <input name="{{$columnName}}" type="radio" id="radio_{{$i}}"
                               value="{{$r['value']}}"
                               class="with-gap radio-col-red"
                                {{isset($r['checked'])?($r['checked']?"checked='checked'":''):''}}
                        />
                    @endif
                    <label for="radio_{{$i}}">{{$r['title']}}</label>
                @endforeach
            </div>
        </div>
    @endif

    @if($column['formType'] == 'email')
        @include('includes.admin.field_title')
        <div class="row clearfix">
            <div class="col-md-{{$column['widthInForm'] or 12}}">
                <div class="form-group">
                    <div class="form-line">
                        <input name="{{$columnName}}"
                               type="text" class="form-control email_mask"
                               placeholder="{{$column['title']}}"
                               value="{{$columnsValues[$columnName] or ''}}">
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($column['formType'] == 'number')
        @include('includes.admin.field_title')
        <div class="row clearfix">
            <div class="col-md-{{$column['widthInForm'] or 12}}">
                <div class="form-group">
                    <div class="form-line">
                        <input
                                type="number"
                                name="{{$columnName}}"
                                class="form-control"
                                placeholder="{{$column['title']}}"
                                value="{{$columnsValues[$columnName] or ''}}">
                    </div>
                </div>
            </div>
        </div>
    @endif



@endif