<th class="exportable">#</th>
<th class="no_orderable">View</th>
<th class="no_orderable">Edit</th>
<th class="no_orderable">Delete</th>

@foreach($columns as $column)
    @if($column['showInIndex'])
        <th class="{{$column['indexClasses']}}">{{$column['title']}}</th>
    @endif
@endforeach

<th class="w_100 exportable">Created At</th>
<th class="w_100">Updated At</th>