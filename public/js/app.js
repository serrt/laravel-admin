// 网站 csrf_token
var token = $("meta[name='csrf-token']").attr('content');
// 通用的 select2 config
function selectConfig(data, multiple, ajax) {
    var config = {
        allowClear: true,
        placeholder: '请选择',
        dataType: 'json',
        width: '100%',
        escapeMarkup: function (markup) { return markup; }
    };

    if (ajax) {
        config.ajax = {
            delay: 500,
            data: function (params) {
                return {
                    key: params.term,
                    page: params.page || 1
                };
            },
            processResults: function (data) {
                return {
                    results: data.data,
                    pagination: {
                        more: data.meta?data.meta.current_page < data.meta.last_page:false
                    }
                };
            },
        }
        config.templateResult = function (repo) {
            return repo.text?repo.text:repo.name
        }
        config.templateSelection = function (repo) {
            return repo.text?repo.text:repo.name
        }
    }

    if (data) {
        if (multiple && data.length !== undefined) {
            config.data = data;
        } else {
            config.data = [data];
        }
    }
    return config;
}
$(function () {
    // 切换皮肤
    var currentSkin = 'skin-black-light';

    $('#layout-skins-list [data-skin]').click(function (e) {
        e.preventDefault()
        var skinName = $(this).data('skin')
        $('body').removeClass(currentSkin)
        $('body').addClass(skinName)
        currentSkin = skinName
    });

    // 时间控件
    $('.date').datepicker({
        autoclose: true,
        clearBtn: true,
        format: 'yyyy-mm-dd',
        language: 'zh-CN',
        minViewMode: 'days',
        enableOnReadonly: false,
    });

    // 时间控件
    $('.year').datepicker({
        autoclose: true,
        clearBtn: true,
        format: 'yyyy',
        language: 'zh-CN',
        minViewMode: 'decade',
        enableOnReadonly: false,
    });
    // 时间控件
    $('.month').datepicker({
        autoclose: true,
        clearBtn: true,
        format: 'yyyy-mm',
        language: 'zh-CN',
        minViewMode: 'year',
        enableOnReadonly: false,
    });

    $('.datetime').datetimepicker({
        autoclose: true,
        clearBtn: true,
        format: 'yyyy-mm-dd hh:ii',
        language: 'zh-CN'
    });

    $('.input-daterange').datepicker({
        format: 'yyyy-mm-dd',
        language: 'zh-CN',
        minViewMode: 'days',
        enableOnReadonly: false,
    });
    $('.input-daterange input').each(function() {
        $(this).datepicker('clearDates');
    });

    // Jquery 表单验证
    $.extend($.validator.messages, {
        required: "这是必填字段",
        remote: "请修正此字段",
        email: "请输入有效的电子邮件地址",
        url: "请输入有效的网址, 包含 http://, https://",
        date: "请输入有效的日期",
        dateISO: "请输入有效的日期 (YYYY-MM-DD)",
        number: "请输入有效的数字",
        digits: "只能输入整数",
        creditcard: "请输入有效的信用卡号码",
        equalTo: "你的输入不相同",
        extension: "请输入有效的后缀",
        decimal: "保留 {0} 位小数",
        maxlength: $.validator.format( "最多可以输入 {0} 个字符" ),
        minlength: $.validator.format( "最少要输入 {0} 个字符" ),
        rangelength: $.validator.format( "请输入长度在 {0} 到 {1} 之间的字符串" ),
        range: $.validator.format( "请输入范围在 {0} 到 {1} 之间的数值" ),
        max: $.validator.format( "请输入不大于 {0} 的数值" ),
        min: $.validator.format( "请输入不小于 {0} 的数值" )
    });

    var form_element = $('form.validate');
    var validate_error = 'has-error';
    var validate_success = 'has-success';
    form_element.each(function () {
        var form_validate = $(this);
        form_validate.attr('autocomplete', 'off');
        form_validate.validate({
            // 验证失败后
            showErrors: function (errorMap, errorList) {
                // 遍历错误列表
                for (var obj in errorMap) {
                    // 自定义错误提示效果
                    var ele = $('[name="' + obj + '"]');
                    ele.parents('.form-group').addClass(validate_error).removeClass(validate_success);
                    if (ele.hasClass('select2')) {
                        ele.next('.select2-container').addClass(validate_error).removeClass(validate_success);
                    }
                }
                // 此处注意，一定要调用默认方法，这样保证提示消息的默认效果
                this.defaultShowErrors();
            },
            // 验证成功后调用的方法
            success: function (label, input) {
                $(input).parents('.form-group').removeClass(validate_error).addClass(validate_success);
                label.remove()
            },
            // 错误元素出现的位置
            errorPlacement: function(error, element) {
                error.addClass('text-danger');
                if (element.parent().hasClass('input-group')) {
                    element.parent().after(error);
                } else if (element.attr('type') === 'file') {
                    element.parents('.file-input').after(error);
                }  else {
                    error.appendTo(element.parent());
                }
            },
            submitHandler: function (form) {
                form_validate.find('button[type="submit"]').button('loading');
                return true;
            },
            // 忽略.ignore
            ignore: '.ignore'
        })
    });

    $.extend($.validator.methods, {

        // 重写 remote 验证, {code: 200, message: '错误信息'}
        remote: function (value, element, param) {
            if (this.optional(element)) {
                return 'dependency-mismatch';
            }

            var previous = this.previousValue(element),
                validator, data;

            if (!this.settings.messages[element.name]) {
                this.settings.messages[element.name] = {};
            }
            previous.originalMessage = this.settings.messages[element.name].remote;
            this.settings.messages[element.name].remote = previous.message;

            param = typeof param === 'string' && {url: param} || param;

            if (previous.old === value) {
                return previous.valid;
            }

            previous.old = value;
            validator = this;
            this.startRequest(element);
            data = {};
            data[element.name] = value;
            $.ajax($.extend(true, {
                mode: 'abort',
                port: 'validate' + element.name,
                dataType: 'json',
                data: data,
                context: validator.currentForm,
                success: function (response) {
                    var valid = response.code === 200,
                        errors, message, submitted;

                    validator.settings.messages[element.name].remote = previous.originalMessage;
                    if (valid) {
                        submitted = validator.formSubmitted;
                        validator.prepareElement(element);
                        validator.formSubmitted = submitted;
                        validator.successList.push(element);
                        delete validator.invalid[element.name];
                        validator.showErrors();
                    } else {
                        errors = {};
                        if (typeof response == 'object') {
                            message = response.message || validator.defaultMessage(element, 'remote');
                        } else {
                            message = response || validator.defaultMessage(element, 'remote');
                        }
                        errors[element.name] = previous.message = $.isFunction(message) ? message(value) : message;
                        validator.invalid[element.name] = true;
                        validator.showErrors(errors);
                    }
                    previous.valid = valid;
                    validator.stopRequest(element, valid);
                }
            }, param));
            return 'pending';
        },
        decimal: function (value, element, param) {
            var a = value.indexOf(".")+1;
            if(a === 0){
                a=value.length;
            }
            var b = value.length;
            var c = b-a;
            return this.optional(element) || c<=param;
        },
    });

    // select2 初始化
    $.fn.select2.defaults.set('language', 'zh-CN');
    $.fn.select2.defaults.set('theme', 'bootstrap');
    $('.select2').each(function () {
        var data = $(this).data('json');
        var config_public = selectConfig(data, $(this).attr('multiple'), $(this).data('ajax-url'));
        
        $(this).select2(config_public);

        // 默认选中
        if (config_public.data) {
            if ($(this).attr('multiple') && config_public.data.length !== undefined) {
                var selected = [];
                for (var i in config_public.data) {
                    selected.push(config_public.data[i].id);
                }
                $(this).val(selected).trigger('change');
            } else {
                $(this).val([data.id]).trigger('change');
            }
        }
    });

    // 监听 select2 删除事件, 去掉删除元素
    $('.select2[data-ajax-url]').on('select2:unselecting', function (e) {
        var item = e.params.args.data;
        var data = $(this).select2('data');
        var val = [];
        for (var i in data) {
            if (item.id != data[i].id) {
                val.push(data[i].id);
            }
        }
        $(this).val(val).trigger('change');
        return true;
    });

    // file-input 初始化
    $('.file-input').fileinput({
        language: 'zh',
        dropZoneEnabled: false,
        uploadAsync: false,
        showUpload: false,
        browseClass: 'btn bg-purple',
        initialPreviewDelimiter: ',',
        initialPreviewAsData: true,
        showClose: false,
        browseLabel: '选择',
        removeFromPreviewOnError: true,
        layoutTemplates: {footer: ''},
    }).on('filecleared', function (event) {
        var target = event.target;
        var name = target.name;
        if ($('input[type="hidden"][name="'+name+'"]').length === 0) {
            $(target).parents('.form-group').append('<input type="hidden" name="'+name+'" value=""/>');
        }
    }).on('fileselect', function (event) {
        var target = event.target;
        var name = target.name;
        $('input[type="hidden"][name="'+name+'"]').remove();
    });
});
