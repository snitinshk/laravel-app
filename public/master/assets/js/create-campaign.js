var follow_up_seq = 1;
var available_templates = JSON.parse(client_templates);

function showError(error_li){
    $('.validationErr ul').append(error_li);
    $('.validationErr').removeClass('hidden')
}
function disable_campaign(id){
    if(confirm("Are you sure you want to delete this campaign?")){
        window.location.href = '/campaign/disable/campaign/'+id
    }
}

$(document).ready(function(){
    $('#select_audience').click(function(){
        $('#select_email_group').modal('show')
        return false;
    })
    $('#create_campaign').click(function(){
        $('.validationErr ul').empty();
        let hasError = false;
        if($('#selected_email_group').val().length == 0){
            $('#select_group_err').removeClass('hidden')
            return false;
        }else{
            $('#select_group_err').addClass('hidden')
        }
        $('.campaign_subject').each(function(index) {
            if($(this).val().length == 0){
                showError('<li>Please create or select a subject</li>')
                hasError = true;
            }
        });
        $('.campaign_template_data').each(function(index) {
            if($(this).val().length == 0){
                showError('<li>Please create or select a template</li>')
                hasError = true;
            }
        });
        if(!hasError){
            $('#create_campaign_form').submit();
            $('#select_email_group').modal('hide');
        }else{
            $('#select_email_group').modal('hide');
        }
        
    })
    /**
     * Setting Campaign subject and template on selecting a pre-defined one
     */
    $(document).on('change','.campaign_template',function(){
        const selected_template = available_templates.filter((template)=> template.id == $(this).val() )
        const current_seq = $(this).attr('data-seq');
        $('#subject-field-'+current_seq).val(selected_template[0].template_name)
        $('#email_template-'+current_seq).html(selected_template[0].template)
    })
    /**
     * Adding a new follow up template
     */
    $('.add_follow_up').click(function(){
        /**
         * Remove the remove template button from all except the last added followup element
         */
        var last_seq = follow_up_seq-1
        if(last_seq > 0){
            $('#remove_follow_up-'+last_seq).hide();
        }
        $('.create-template-wraper').append(newCampaignHtml(follow_up_seq))
        if(follow_up_seq == 3){
            $(this).attr('disabled',true)
        }else{
            follow_up_seq++;
        }
        
    })
    /**
     * Delete a added follow up campaign
     */
    $(document).on('click','.remove-campaign-template',function(){
        var selected_item_followup_seq = $(this).attr('data-seq');
        var last_seq = selected_item_followup_seq-1;
        $('#follow_up_container-'+selected_item_followup_seq).remove();
        $('#remove_follow_up-'+last_seq).show();
        follow_up_seq--;
    });
})

newCampaignHtml = (follow_up_seq)=>{
    var template_names = ``
    available_templates.forEach(element => {
        template_names += `<option value="`+element.id+`">`+element.template_name+`</option>`
    });
    return `<div data-seq="`+follow_up_seq+`" id="follow_up_container-`+follow_up_seq+`" class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
    <div class="toggle-table full-width-toggle-table" data-controller="toggle-table">
        <div class="row-container active">
                <div class="row-title">
                <div class="caret-icon">
                    <div class="far fa-angle-down"></div>
                </div>
                <div class="row-title-icon pull-left">
                    <div class="fal fa-calendar-alt"></div>
                </div>
                </div>
                <div class="compose-title" >
                <strong>Follow up after</strong>
                <select class="days-input" name="campaign[`+follow_up_seq+`][follow_up]">
                    <option value="1">1 day</option>
                    <option value="2">2 days</option>
                    <option value="3">3 days</option>
                    <option value="4">4 days</option>
                    <option value="5">5 days</option>
                    <option value="6">6 days</option>
                    <option value="7">7 days</option>
                    <option value="8">8 days</option>
                    <option value="9">9 days</option>
                    <option value="10">10 days</option>
                    <option value="11">11 days</option>
                    <option value="12">12 days</option>
                    <option value="13">13 days</option>
                    <option value="14">14 days</option>
                </select>
                <em>if no reply</em>
                <button data-seq="`+follow_up_seq+`" id="remove_follow_up-`+follow_up_seq+`" class="btn btn-primary remove-campaign-template pull-right">Remove</button>
            </div>
            <div class="form-group">
            <label>Select Template</label>
            <select data-seq="`+follow_up_seq+`" class="form-control col-lg-4 campaign_template">
                <option value="">Select a template</option>   
                `+template_names+`    
            </select>
            </div>
            <div class="trix-editor">
                <input class="form-control" id="subject-field-`+follow_up_seq+`" name="campaign[`+follow_up_seq+`][subject]" placeholder="Subject" type="text">
                <input id="input-template-`+follow_up_seq+`" type="text" class="input-hidden campaign_template_data" name="campaign[`+follow_up_seq+`][template]" value="">
                <trix-editor input="input-template-`+follow_up_seq+`" id="email_template-`+follow_up_seq+`" placeholder="Compose your email..." style="min-height: 15em;" spellcheck="false">
                </trix-editor>
            </div>
            <button data-seq="`+follow_up_seq+`"  class="email-config btn btn-primary insert-attr-btn">Insert attribute</button>
        </div>
    </div>
</div>`
}

$(document).ready(function(){
    var element = document.getElementById("email_template-0")
    var editor = element.editor
    editor.setSelectedRange((editor.getDocument().toString().length) - 1)
    
    $(document).on('click','.insert-attr-btn',function(){
        var current_seq = $(this).attr('data-seq');
        $('#insert_attr_current_seq').val(current_seq);
        $('#insert_attr_modal').modal('show')
        return false;
    })
    /**
     * Clear bs-modal fields on closing modal
     */
    $("#insert_attr_modal").on("hidden.bs.modal", function(){
        $("#attribute-identifier").val('');
        $("#insert_attr_current_seq").val('');
        $('#fallback').val('');
    });
    $("#select_email_group").on("hidden.bs.modal", function(){
        $('#email_group_list').val('');
    });

    $('#insert-attr').click(function(){
        $('#insertAttrModal').modal('hide')
        var attr_name = $('#attribute-identifier').val();
        var insert_attr_current_seq = $('#insert_attr_current_seq').val();
        var fallback = $('#fallback').val()
        var element = document.getElementById("email_template-"+insert_attr_current_seq);
        var editor = element.editor
        editor.insertString("|"+attr_name+":"+fallback+"|");

        // var currentEle = $('#email_template-'+insert_attr_current_seq);
        // var current = currentEle.html();
        // if(current.includes('<br></div>')){
        //     currentEle.html(current.replace("<br></div>",  "|"+attr_name+":"+fallback+"|</div>"));
        // }else{
        //     currentEle.html(current.replace("</div>",  "|"+attr_name+":"+fallback+"|</div>"));
        // }
    });
    
})