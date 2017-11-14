@extends('cms::layouts.admin')
@section('content')

@endsection
@section('CSS')

@stop
@section('JS')
    {!! HTML::script("public/js/UiElements/bb_styles.js?v.5") !!}
    <script>
        var dd = console.log;
        $(document).ready(function () {
            var elements = {
                checkbox: function (data, name, label, with_key) {
                    $('.additional-data').removeClass('hide');
                    var text = '<div class="form-group"><label class="col-md-4 control-label" for="checkboxes">' + label + '</label><div class="col-md-4">';
                    $.each(data, function (k, v) {
                        if (typeof with_key != "undefined" && with_key == true) {
                            text += '<div class="radio"><label><input type="radio" name="' + name + '" value="' + k + '">' + v + ' </label></div>';
                        } else {
                            text += '<div class="radio"><label><input type="radio" name="' + name + '" value="' + v + '">' + v + ' </label></div>';
                        }

                    })
                    text += '</div></div>';
                    return text;
                },
                radio: function (data, name, label, with_key) {
                    $('.additional-data').removeClass('hide');
                    var text = '<div class="form-group"><label class="col-md-4 control-label" for="checkboxes">' + label + '</label><div class="col-md-4">';
                    $.each(data, function (k, v) {
                        if (typeof with_key != "undefined" && with_key == true) {
                            text += '<div class="checkbox"><label ><input type="checkbox" name="' + name + '"  value="' + k + '">' + v + ' </label></div>';
                        } else {
                            text += '<div class="checkbox"><label ><input type="checkbox" name="' + name + '"  value="' + v + '">' + v + ' </label></div>';
                        }

                    })
                    text += '</div></div>';
                    return text;
                },
                select: function (data, name, label, with_key) {
                    $('.additional-data').removeClass('hide');
                    var text = '<div class="form-group"><label class="col-md-4 control-label" >' + label + '</label><div class="col-md-4"><select  name="' + name + '" class="form-control">';
                    $.each(data, function (k, v) {
                        if (typeof with_key != "undefined" && with_key == true) {
                            text += ' <option value="' + k + '">' + v + '</option>';
                        } else {
                            text += ' <option value="' + v + '">' + v + '</option>';
                        }
                    });
                    text += '</select></div></div>';
                    return text;
                },
                multy_select: function (data, name, label, with_key) {
                    $('.additional-data').removeClass('hide');
                    var text = '<div class="form-group"><label class="col-md-4 control-label" >' + label + '</label><div class="col-md-4"><select  name="' + name + '"multiple="multiple" class="form-control">';
                    $.each(data, function (k, v) {
                        if (typeof with_key != "undefined" && with_key == true) {
                            text += ' <option value="' + k + '">' + v + '</option>';
                        } else {
                            text += ' <option value="' + v + '">' + v + '</option>';
                        }
                    });
                    text += '</select></div></div>';
                    return text;
                },
                text: function (data, name, label, with_key) {
                    $('.additional-data').addClass('hide');
                },
                textarea: function (data, name, label, with_key) {
                    $('.additional-data').addClass('hide');
                }
            }


            function sendajaxvar(url, data, success) {
                $.ajax({
                    type: "post",
                    datatype: "json",
                    url: url,
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    },
                    success: function (data) {
                        if (success) {
                            success(data);
                        }
                        return data;
                    }
                });
            }

            var table;
            $("body").on('change', '.table-change', function () {
                var value = $(this).val();
                if (value != '') {
                    table = value;
                    var data = {}
                    data['table'] = value;
                    sendajaxvar('/admin/modules/bburl/get-table-columns', data, function (d) {
                        if (d) {
                            var option = ''
                            $('.table-columns').empty()
                            $.each(d, function (k, v) {
                                option += '<option value="' + k + '">' + v + '</option>';

                            })

                            $('.table-columns').append(option);
                            $('.columns').removeClass('hide')
                        }
                    })
                }
            });
            $("body").on('change', '.table-columns', function () {
                var data = {
                    'table': table,
                    'column': $(this).val()
                }
                sendajaxvar('/admin/modules/bburl/get-column-rules', data, function (d) {
                    if (d) {
                        $('.validation-preview').html(d);
                        $('#field_minimum_validation').val(d);
                    }
                })
            });

            var input_type;
            $("body").on('change', '.field-type', function () {
                $('.file-data').addClass('hide')
                var value = $(this).val();
                var label = $('input[name=label]').val();
                input_type = value;
                if ($.isFunction(elements[value])) {
                    var name = $('input[name=name]').val();
                    $('.live-preview').html(elements[value]($('#data-source').val().split(","), name, label));
                } else {
                    $('.additional-data').addClass('hide');
                }

            });

            $('input[type=radio][name=optradio]').change(function () {
                if (this.value == 'data_source') {
                    $('.data_source').removeClass('hide');
                    $('.bbfunction').addClass('hide');
                    $('.file').addClass('hide');
                }
                else if (this.value == 'bbfunction') {
                    $('.bbfunction').removeClass('hide');
                    $('.data_source').addClass('hide');
                    $('.file').addClass('hide');
                }
                else if (this.value == 'file') {
                    $('.file').removeClass('hide');
                    $('.bbfunction').addClass('hide');
                    $('.data_source').addClass('hide');
                }
            });


            $('form').on('input', 'input[name=name]', function () {
                var name = $(this).val();
                var label = $('input[name=label]').val();
                if ($.isFunction(elements[input_type])) {
                    var name = $('input[name=name]').val();
                    $('.live-preview').html(elements[input_type]($('#data-source').val().split(","), name, label));
                }
            });
            $('form').on('input', 'input[name=label]', function () {
                var label = $(this).val();
                var name = $('input[name=name]').val();
                if ($.isFunction(elements[input_type])) {
                    var name = $('input[name=name]').val();
                    $('.live-preview').html(elements[input_type]($('#data-source').val().split(","), name, label));
                }
            });
            $('#data-source').on('input', function () {
                var res = $(this).val().split(",");
                var name = $('input[name=name]').val();
                var label = $('input[name=label]').val();
                if ($.isFunction(elements[input_type])) {
                    $('.live-preview').html(elements[input_type](res, name, label))
                }

            })

            $("body").on('change', '.select-file-dropdown', function () {
                var key = $('.file-key').val();
                var value = $('.file-value').val();
                var id = $('[data-name="file"]').val();
                if (typeof key != "undefined" && typeof value != "undefined"
                    && typeof id != "undefined" && key != '' && value != '' && id != '') {
                    var data = {key: key, value: value, id: id};
                    sendajaxvar('/admin/modules/bburl/get-file-list', data, function (d) {
                        if (!d.error) {
                            var type = $('.field-type').val();
                            var name = $('input[name=name]').val();
                            var label = $('input[name=label]').val();

                            if ($.isFunction(elements[type])) {
                                $('.live-preview').html(elements[type](d.data, name, label, true))
                            }
                        }
                    });
                }
            });

            $("body").on('click', '.file-item-dynamic', function () {
                var value = $(this).find('[data-value]').data('value');
                var data = {value: value};
                sendajaxvar('/admin/modules/bburl/get-file-data', data, function (d) {
                    if (d) {
                        var option;
                        $('.file-key').empty();
                        $('.file-value').empty();
                        option = '<option value="">Select Option</option>';
                        $.each(d.data, function (k, v) {
                            option += '<option value="' + k + '">' + v + '</option>';
                        });

                        $('.file-key').append(option);
                        $('.file-value').append(option);
                        $('.file-data').removeClass('hide')
                    }
                })
            })

        });
    </script>
@endsection