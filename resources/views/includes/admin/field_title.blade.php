<h2 class="card-inside-title">
        @if($column['requiredInForm'])
            *
        @endif
    {{$column['title']}}
        @if($column['displayRule'])
            <small style="display: inline"><i>{{$column['displayRule']}}</i></small>
        @endif
</h2>
