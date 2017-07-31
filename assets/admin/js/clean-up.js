jQuery(function ($) {

    $('[data-select-all]').click(function () {

        var checkbox = $(this);

        var checked = checkbox.prop('checked');

        var name = $(this).data('select-all');
        $('[data-selectable="' + name + '"]').each(function () {
            $(this).prop('checked', checked);
        })
    })
});