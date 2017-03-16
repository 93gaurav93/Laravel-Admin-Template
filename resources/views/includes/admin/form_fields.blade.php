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
                                value="{{$column['value'] or ''}}">
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
                              placeholder="{{$column['title']}}">{{$column['value'] or ''}}</textarea>
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
                               type="text" class="datepicker form-control"
                               placeholder="{{$column['title']}}"
                               value="{{$column['value'] or ''}}">
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($column['formType'] == 'file' or $column['formType'] == 'image')
        @include('includes.admin.field_title')

        @if(isset($column['value']))
            @if($column['formType'] == 'file')
                @if($column['value'] && Storage::exists($fileDir.$column['value']))
                    <a href="{{url($fileDir.$column['value'])}}" target="_blank">
                        (Download Current File)
                    </a>
                    <i>(Don't change to keep same)</i>
                @endif
            @endif
            @if($column['formType'] == 'image')
                @if($column['value'] && Storage::exists($imageThumbDir.$column['value']))
                    <img src="{{url($imageThumbDir.$column['value'])}}"
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
                <select id="remote_list_{{$columnName}}" data-remote-url="{{$column['remoteListUrl']}}" name="{{$columnName}}"
                        class="form-control show-tick"
                        data-select-id="{{$column['value'] or ''}}"
                        data-live-search="true"
                        title="{{$column['title']}}">
                    @if(isset($column['value']) && $column['remoteRecordTitle'])
                        <option value="{{$column['value']}}" selected>{{$column['remoteRecordTitle']}}</option>
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
                    @if(isset($column['value']))
                        <input name="{{$columnName}}" type="radio" id="radio_{{$i}}"
                               value="{{$r['value']}}"
                               class="with-gap radio-col-red"
                                {{$r['title']==$column['value']?"checked='checked'":''}}
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
                               value="{{$column['value'] or ''}}">
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
                                value="{{$column['value'] or ''}}">
                    </div>
                </div>
            </div>
        </div>
    @endif



@endif