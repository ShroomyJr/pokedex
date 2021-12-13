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

    $(".context-menu li").click(function (e) {
        // print($(this).data());
        $(".context-menu").hide(100);
        var pokemon_species_id = $('.context-menu').data('id');
        var action = $(e.target).data('action');
        if (action == 'status') {
            location.assign('status.php?pokemon-id='+pokemon_species_id);
        } else {
            request = $.ajax({
                url: 'post_pcbox.php',
                type: 'post',
                data: { ajax: 1, name: action, pokemon_species_id: pokemon_species_id },
                success: function (response) {
                    console.log(response);
                    location.reload();
                }
            });
        }
    });

    $("#table").DataTable();

});
$(document).bind("mousedown", function (e) {

    // If the clicked element is not the menu
    if ($(e.target).parents(".context-menu").length <= 0) {
        $(".context-menu").hide(100);
    }
    var pokemon_species_id = $(e.target).closest(".card").data('id') ?
        $(e.target).closest(".card").data('id') :
        $(e.target).closest(".slot").data('id');
    $('.context-menu').data('id', pokemon_species_id);
});
