<script>
    $(function () {


                @foreach($columns as $columnName=>$column)
                @if($column['showInForm'])
                @if($column['formType'] == 'remoteList')

        $listSelect_{{$columnName}} = $('#remote_list_{{$columnName}}');

        var url = '{{$modelIndexUrl
            . 'getRemoteRecords?foreignTableAndTitle='
            . $column['foreignTable']
            . ':'
            . $column['foreignTitleColumn']}}';

        $.getJSON(url, function (result) {

            var list = [];
            $.each(result, function (key, val) {
                if (!(val.id == $listSelect_{{$columnName}}.attr('data-select-id'))) {
                    list.push('<option value="' + val.id + '">' + val.title + '</option>');
                }
            });
            $listSelect_{{$columnName}}.append(list.join(''));
            $listSelect_{{$columnName}}.selectpicker('refresh');
        });
        @endif
        @endif
        @endforeach

        //Textare auto growth
        autosize($('textarea.auto-growth'));

    });

    $('.datepicker').bootstrapMaterialDatePicker({
        format: 'DD-MM-YYYY',
        clearButton: true,
        weekStart: 1,
        time: false
    });

    jQuery.validator.methods["date"] = function (value, element) {
        return true;
    };

    //Email Mask
    $(".email_mask").inputmask({alias: "email"});


    $(function () {
        $('#form_validation').validate({
            rules: {
                {!! $frontRules !!}
            },
            highlight: function (input) {
                $(input).parents('.form-line').addClass('error');
            },
            unhighlight: function (input) {
                $(input).parents('.form-line').removeClass('error');
            },
            errorPlacement: function (error, element) {
                $(element).parents('.form-group').append(error);
            }
        });
    });

</script>