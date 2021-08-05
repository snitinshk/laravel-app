$(document).ready(function(){
    /**
     * Clear bs-modal fields on closing modal
     */
    $("#insertAttrModal").on("hidden.bs.modal", function(){
        $("#attribute-identifier").val('');
        $("#insert_attr_current_seq").val('');
        $('#fallback').val('');
    });
})
function validateCheckbox(){
    if($('input:checkbox:checked').length){
        return true;
    }else{
        alert('Please select alteast a day');
        return false;
    }
}
/**
 * Script for settings start
 */
$(document).ready(function(){
    
    $('#campaign_start_time').change(function(){
        var selected_hour = parseInt($(this).find(':selected').attr('data-hour'));
        $("#campaign_end_time > option").each(function() {
            if($(this).attr('data-hour') < selected_hour+1){
                $(this).prop('disabled', true);
            }else{
                $(this).prop('disabled', false);
            }
        });
    })
    $('#campaign_end_time').change(function(){
        var selected_hour = parseInt($(this).find(':selected').attr('data-hour'));
        $("#campaign_start_time > option").each(function() {
            console.log(selected_hour-1);
            if($(this).attr('data-hour') > selected_hour-1){
                $(this).prop('disabled', true);
            }else{
                $(this).prop('disabled', false);
            }
        });
    })
})
/**
 * Script settings end
 */
function disable_template(id){
    if(confirm("Are you sure you want to delete this template?")){
        window.location.href = '/campaign/disable/template/'+id
    }
}

