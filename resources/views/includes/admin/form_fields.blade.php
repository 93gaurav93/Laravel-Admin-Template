@if($field['type'] == 'text')
    @include('includes.admin.field_title')
    <div class="row clearfix">
        <div class="col-md-{{$field['width'] or 12}}">
            <div class="form-group">
                <div class="form-line">
                    <input
                            type="text"
                            name="{{$fieldName}}"
                            class="form-control"
                            placeholder="{{$field['title']}}"
                            value="{{$field['value'] or ''}}">
                </div>
            </div>
        </div>
    </div>
@endif

@if($field['type'] == 'textArea')
    @include('includes.admin.field_title')
    <div class="row clearfix">
        <div class="col-md-{{$field['width'] or 12}}">
            <div class="form-group">
                <div class="form-line">
                    <textarea name="{{$fieldName}}"
                              rows="{{$field['rows'] or 2}}"
                              class="form-control no-resize auto-growth"
                              placeholder="{{$field['title']}}">{{$field['value'] or ''}}</textarea>
                </div>
            </div>
        </div>
    </div>
@endif

@if($field['type'] == 'date')
    @include('includes.admin.field_title')
    <div class="row clearfix">
        <div class="col-md-{{$field['width'] or 12}}">
            <div class="form-group">
                <div class="form-line">
                    <input name="{{$fieldName}}"
                           type="text" class="datepicker form-control"
                           placeholder="{{$field['title']}}"
                           value="{{$field['value'] or ''}}">
                </div>
            </div>
        </div>
    </div>
@endif

@if($field['type'] == 'file')
    @include('includes.admin.field_title')

    @if(isset($field['value']))
        @if($field['value'] && Storage::exists($field['dirName'].$field['value']))
            @if($field['isImage'])
                <img src="{{url($field['dirName'].$field['value'])}}"
                     class="responsive m-b-10">
                <i>(Don't change to keep same)</i>
            @else
                <a href="{{url($field['dirName'].$field['value'])}}" target="_blank">(Download
                    Current File)</a>
                <i>(Don't change to keep same)</i>
            @endif
        @endif
    @endif

    <div class="row clearfix">
        <div class="col-md-{{$field['width'] or 12}}">
            <div class="form-group">
                <div class="form-line">
                    <input type="file" name="{{$fieldName}}"/>
                </div>
            </div>
        </div>
    </div>
@endif

@if($field['type'] == 'remoteList')
    @include('includes.admin.field_title')
    <div class="row clearfix">
        <div class="col-md-{{$field['width'] or 12}}">
            <select id="remote_list" data-remote-url="{{$field['remoteUrl']}}" name="{{$fieldName}}"
                    class="form-control show-tick"
                    data-select-id="{{$field['value'] or ''}}"
                    data-live-search="true"
                    title="{{$field['title']}}">
                @if(isset($field['value']) && $field['remoteRecordTitle'])
                    <option value="{{$field['value']}}" selected>{{$field['remoteRecordTitle']}}</option>
                @endif
            </select>
        </div>
    </div>
@endif

@if($field['type'] == 'radio')
    @include('includes.admin.field_title')
    <div class="row clearfix">
        <div class="col-md-{{$field['width'] or 12}}">

            @foreach($field['radios'] as $i=>$r)
                @if(isset($field['value']))
                    <input name="{{$fieldName}}" type="radio" id="radio_{{$i}}"
                           value="{{$r['value']}}"
                           class="with-gap radio-col-red"
                            {{$r['title']==$field['value']?"checked='checked'":''}}
                    />
                @else
                    <input name="{{$fieldName}}" type="radio" id="radio_{{$i}}"
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

@if($field['type'] == 'email')
    @include('includes.admin.field_title')
    <div class="row clearfix">
        <div class="col-md-{{$field['width'] or 12}}">
            <div class="form-group">
                <div class="form-line">
                    <input name="{{$fieldName}}"
                           type="text" class="form-control email_mask"
                           placeholder="{{$field['title']}}"
                           value="{{$field['value'] or ''}}">
                </div>
            </div>
        </div>
    </div>
@endif

@if($field['type'] == 'number')
    @include('includes.admin.field_title')
    <div class="row clearfix">
        <div class="col-md-{{$field['width'] or 12}}">
            <div class="form-group">
                <div class="form-line">
                    <input
                            type="number"
                            name="{{$fieldName}}"
                            class="form-control"
                            class="form-control"
                            placeholder="{{$field['title']}}"
                            value="{{$field['value'] or ''}}">
                </div>
            </div>
        </div>
    </div>
@endif


