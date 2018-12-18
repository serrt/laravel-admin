/**
 * 无限级分类checkbox选中
 */

/**
 * tree view permission
 * @param element Input Checkbox
 * @param checkParent 是否勾选父级
 */
function permissionCheckbox(element, checkParent) {
    var id = element.value;
    var bol = element.checked;
    var pid = element.getAttribute('data-pid');

    // 勾选本身
    if (typeof(permissionCheckSelected) === 'function') {
        permissionCheckSelected($(element), bol)
    }
    // 勾选子级
    permissionCheckboxChildren(id, bol);
    // 勾选父级
    if (checkParent) {
        permissionCheckboxParents(pid, bol);
    }
    window.event.stopPropagation();
}

// 元素选中方法
function permissionCheckSelected(element, bol) {
    var active = 'list-group-item-success';
    if (bol) {
        element.parent().addClass(active);
    } else {
        element.parent().removeClass(active);
    }
}

// 勾选子级
function permissionCheckboxChildren(id, bol) {
    $('.permission-checkbox[data-pid=' + id + ']').each(function () {
        $(this)[0].checked = bol;
        if (typeof(permissionCheckSelected) === 'function') {
            permissionCheckSelected($(this), bol)
        }
        permissionCheckboxChildren($(this).val(), bol);
    });
}
// 勾选父级
function permissionCheckboxParents(pid ,bol) {
    var parent_element = $('.permission-checkbox[value=' + pid + ']');
    if (parent_element.length > 0) {
        if (bol) {
            parent_element[0].checked = bol;
            if (typeof(permissionCheckSelected) === 'function') {
                permissionCheckSelected(parent_element, bol)
            }
        } else {
            // 查看同级中的选中数量
            if ($('.permission-checkbox[data-pid='+pid+']:checked').length === 0) {
                parent_element[0].checked = bol;
                if (typeof(permissionCheckSelected) === 'function') {
                    permissionCheckSelected(parent_element, bol)
                }
            }
        }
        permissionCheckboxParents(parent_element.data('pid'), bol);
    }
}

// 打开/关闭 层级 ul
$('.collapse').on('hide.bs.collapse', function () {
    var id = $(this).attr('id')
    var element = $('[data-target="#'+id+'"]')
    element.find('.fa.pull-right').addClass('fa-angle-left').removeClass('fa-angle-down');
}).on('show.bs.collapse', function () {
    var id = $(this).attr('id')
    var element = $('[data-target="#'+id+'"]')
    element.find('.fa.pull-right').addClass('fa-angle-down').removeClass('fa-angle-left');
})