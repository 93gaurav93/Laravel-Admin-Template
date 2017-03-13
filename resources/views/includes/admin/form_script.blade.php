<script>
    $(function () {


        $listSelect = $('#remote_list');
        $.getJSON($listSelect.attr('data-remote-url'), function (result) {
            var list = [];
            $.each(result, function (key, val) {
                if (!(val.id == $listSelect.attr('data-select-id'))) {
                    list.push('<option value="' + val.id + '">' + val.title + '</option>');
                }
            });
            $listSelect.append(list.join(''));
            $listSelect.selectpicker('refresh');
        });

        //Textare auto growth
        autosize($('textarea.auto-growth'));

    });

    $('.datepicker').bootstrapMaterialDatePicker({
        format: 'DD-MMM-YYYY',
        clearButton: true,
        weekStart: 1,
        time: false
    });

    jQuery.validator.methods["date"] = function (value, element) { return true; };

    //Email Mask
    $(".email_mask").inputmask({alias: "email"});


    $(function () {
        $('#form_validation').validate({
            rules: {
        {!! $frontEndRules !!}
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