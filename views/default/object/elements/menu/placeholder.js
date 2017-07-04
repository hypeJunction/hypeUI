define(function (require) {

    var elgg = require('elgg');
    var $ = require('jquery');
    var Ajax = require('elgg/Ajax');

    /**
     * For a menu clicked, load the menu into all matching placeholders
     *
     * @param {String} mac Machine authorization code for the menu clicked
     */
    function loadMenu(mac) {
        var $all_placeholders = $(".elgg-object-menu-popup[rel='" + mac + "']");

        // find the <ul> that contains data for this menu
        var $placeholder = $all_placeholders.filter('[data-elgg-menu-data]');

        if (!$placeholder.length) {
            return;
        }

        var ajax = new Ajax(false);
        ajax.view('object/elements/menu/contents', {
            data: $placeholder.data('elggMenuData')
        }).done(function (data) {
            // replace all existing placeholders with new menu
            $all_placeholders.removeClass('is-loading');
            $all_placeholders.html($(data));
        });
    }

    $(document).on('click', ".elgg-object-menu-toggle", function (e) {

        e.preventDefault();

        var $icon = $(this);

        var $placeholder = $icon.closest('.elgg-object-menu').find('.elgg-object-menu-popup');

        if ($placeholder.length) {
            loadMenu($placeholder.attr("rel"));
        }

        // check if we've attached the menu to this element already
        var $hovermenu = $icon.data('hovermenu') || null;

        if (!$hovermenu) {
            $hovermenu = $placeholder;
            $icon.data('hovermenu', $hovermenu);
        }

        require(['elgg/popup'], function (popup) {
            if ($hovermenu.is(':visible')) {
                // close hovermenu if arrow is clicked & menu already open
                popup.close($hovermenu);
            } else {
                popup.open($icon, $hovermenu, {
                    'my': 'right top',
                    'at': 'right bottom',
                    'of': $icon.closest(".elgg-object-menu"),
                    'collision': 'fit fit'
                });
            }
        });
    });
});