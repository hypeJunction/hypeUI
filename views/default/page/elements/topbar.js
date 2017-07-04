require(['elgg', 'jquery', 'jquery-ui'], function (elgg, $) {

    $(document).on('click', '.nav-toggle', function () {
        if ($(this).is('.is-active')) {
            $('.elgg-page-navbar').slideUp();
            $(this).removeClass('is-active');
        } else {
            $('.elgg-page-navbar').slideDown();
            $(this).addClass('is-active');
        }
    });
});