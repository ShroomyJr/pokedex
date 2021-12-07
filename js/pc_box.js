$(document).ready(function () {
    $(".card").on("click", function (event) {
        $('li[data-action=add]').show();
        $('li[data-action=remove]').hide();
        $(".context-menu").finish().toggle(100).css({
            left: event.pageX + "px",
            top: event.pageY + "px"
        });
    });
    $(".slot").on("click", function (event) {
        $('li[data-action=remove]').show();
        $('li[data-action=add]').hide();
        $(".context-menu").finish().toggle(100).css({
            left: event.pageX + "px",
            top: event.pageY + "px"
        });
    });

    $(".context-menu li").click(function () {
        $(".context-menu").hide(100);
    });

    $("#table").DataTable();

});
$(document).bind("mousedown", function (e) {

    // If the clicked element is not the menu
    if ($(e.target).parents(".context-menu").length <= 0) {
        $(".context-menu").hide(100);
    }
});
