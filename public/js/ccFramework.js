

$(document).ready(function() {
    $('#ccf_profile_box').hide();
    $('#ccf_overlay_mask').hide();

    // Top Bar Resizing Function
    var usableWidth = $( window ).width();

    if(usableWidth > 1000){
        $('#small_screen').hide();
    }else{
        $('#small_screen').show();
    }


    $( window ).resize(function() {
        usableWidth = $( window ).width();

        if(usableWidth > 1000){
            $('#small_screen').hide();
        }else{
            $('#small_screen').show();
        }

    });


    $( "#ccf_top_bar_usr_box" ).click(function() {
        $('#ccf_profile_box').toggle();
        $('#ccf_overlay_mask').toggle();
    });

    $( "#ccf_overlay_mask" ).click(function() {
        $('#ccf_profile_box').hide();
        $('#ccf_overlay_mask').hide();
        $('#ccf_edit_box_' + active_edit_box).hide();
    });


    var active_edit_box = 0;
    $('.ccf_edit_button').click(function() {
        $('#ccf_edit_box_' + this.id).toggle();
        $('#ccf_overlay_mask').toggle();
        active_edit_box = this.id;
    });






})