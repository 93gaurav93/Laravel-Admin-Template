<h2 class="card-inside-title">
    @if(isset($field['required']))
        @if($field['required'])
            *
        @endif
    @endif
    {{$field['title']}}
    @if(isset($field['rule']))
        @if($field['rule'])
            <small style="display: inline"><i>{{$field['rule']}}</i></small>
        @endif
    @endif
</h2>
