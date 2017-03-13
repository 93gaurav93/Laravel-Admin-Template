@if($column['showInIndex'])
    @if($column['type'] == 'text')
        {
        data: '{{$column['tableColumn']}}'
        },
    @endif

    @if($column['type'] == 'image')
        {
        data: '{{$column['tableColumn']}}',
        render: function (data) {
        if (data) {
        return "<img src='{{$imageThumbDir}}" + data + "' class='img-responsive'>";
        }
        else {
        return "<i>Not set</i>";
        }
        }
        },
    @endif

    @if($column['type'] == 'file')
        {
        data: '{{$column['tableColumn']}}',
        render: function (data) {
        if (data) {
        return "<a target='_blank' href='{{$fileDir}}" + data + "'><button type='button' class='btn btn-circle bg-amber waves-effect waves-circle'><i class='material-icons'>file_download</i></button></a>";
        }
        else {
        return "<i>Not set</i>";
        }
        }
        },
    @endif

    @if($column['type'] == 'url')
        {
        data: '{{$column['tableColumn']}}',
        render: function (data) {
        if (data) {
        return "<a target='_blank' href='" + data + "'><button type='button' class='btn btn-circle btn-primary waves-effect waves-circle'><i class='material-icons'>open_in_new</i></button></a>";
        }
        else {
        return "<i>Not set</i>";
        }
        }
        },
    @endif
@endif