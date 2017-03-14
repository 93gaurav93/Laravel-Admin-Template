@if($column['showInIndex'])
    @if($column['showType'] == 'text')
        {
        data: '{{$columnName}}'
        },
    @endif

    @if($column['showType'] == 'image')
        {
        data: '{{$columnName}}',
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

    @if($column['showType'] == 'file')
        {
        data: '{{$columnName}}',
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

    @if($column['showType'] == 'url')
        {
        data: '{{$columnName}}',
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