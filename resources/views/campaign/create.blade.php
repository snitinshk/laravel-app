@extends('master2', ['menu_group' => 'Campaigns', 'slug' => "NewCampaign", 'page_title' => "Create Campaign"])
@section('content')

    <head>
        <link rel="stylesheet" type="text/css" href="/master/plugins/table/datatable/dt-global_style.css">
        <link rel="stylesheet" type="text/css" href="/master/assets/css/campaign/trix.css">
        <script src="/master/assets/js/campaign/trix.js"></script>
    </head>
    <style>
    /* style for smtp detail */
    .email-config {
       margin-left: 20px;
       display: block;
    }
    .trix-editor{
        background-color: white;
    }
    .trix-button-group--file-tools {
        display: none !important;
    }
    .email-config > button{
        margin-top: 15px;
    }
    button.email-config.insert-attr-btn {
        margin-left: 950px;
    }
    .email-from{
        margin-bottom: 10px;
    }
    .compose-title {
        padding: 15px 20px;
        background-color: #fafbfb;
        font-weight: 600;
        border-radius: 3px;
        margin-bottom: 25px;
    }
    .compose-title .days-input {
        margin: 0 3px;
    }   
    .remove-campaign-template{
        margin-left: 650px;
    }
    .input-hidden{
        height:0;
        width:0;
        visibility: hidden;
        padding:0;
        margin:0;
        float:right;
    }
    .hidden{
        display: none
    }

</style>
<form method="post" id="create_campaign_form" action="{{ route('campaign.save') }}">
    <div class="email-config create-template-wraper">
        
        {{-- @if ($errors->any()) --}}
            <div class="validationErr alert alert-danger {{ ($errors->any())?'':'hidden' }}">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        {{-- @endif --}}
        
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="col-lg-3">
                <input class="form-control" name="campaign_name" value="New Campaign" placeholder="Camapign Name"  type="text">
            </div>
            <div style="width: 100%; height: 60px; margin-top: -60px;">
                <button id="select_audience" class="btn btn-primary mb-2 mr-2" style="float: right;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Select Audience</button>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="toggle-table full-width-toggle-table" data-controller="toggle-table">
                <div class="row-container active">
                        @csrf
                        <div class="row-title">
                        <div class="caret-icon">
                            <div class="far fa-angle-down"></div>
                        </div>
                        <div class="row-title-icon pull-left">
                            <div class="fal fa-calendar-alt"></div>
                        </div>
                        </div>
                        <div class="form-group email-from">
                            <label>From</label>
                            <select class="form-control col-lg-6" name="email_from">
                                @foreach ($email_config as $config)
                                    <option value="{{ $config->id }}">{{ $config->email_from }}</option>    
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Select Template</label>
                            <select data-seq="0" class="form-control col-lg-4 campaign_template">
                                <option value="">Select a template</option>   
                                @foreach ($compaign_templates as $templates)
                                    <option value="{{ $templates->id }}">{{ $templates->template_name }}</option>    
                                @endforeach
                            </select>
                        </div>
                        <div class="trix-editor">
                            <input class="form-control campaign_subject" name="subject" id="subject-field-0"  placeholder="Subject" type="text">
                            <input type="hidden" name="selected_email_group" id="selected_email_group">
                            <input id="input-template-0" type="text" class="input-hidden campaign_template_data" name="template" >
                            <trix-editor id="email_template-0" input="input-template-0" placeholder="Compose your email..." style="min-height: 15em;" spellcheck="false">
                            </trix-editor>
                        </div>
                        <button data-seq="0" class="email-config btn btn-primary insert-attr-btn">Insert attribute</button>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="email-config">
    <button class="btn add_follow_up">Add Followup</button>
</div>
<div class="modal fade" id="select_email_group" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add People</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="attribute-field">Group Name</label>
                    <br>
                    <select onchange="$('#selected_email_group').val($(this).val())" class="form-control" id="email_group_list">
                        <option value="">Select</option>
                        @foreach ($email_group as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>    
                        @endforeach
                    </select>
                </div>
                <div>
                    <span id="select_group_err" class="alert alert-danger hidden">Please select a group</span>
                </div>
        
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="create_campaign"class="btn btn-primary">Create Campaign</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="insert_attr_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add an attribute</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="attribute-field">Attribute</label>
                    <br>
                    <select class="form-control" id="attribute-identifier" name="attribute">
                        <option value="first_name">First name</option>
                        <option value="last_name">Last name</option>
                        <option value="full_name">Full name</option>
                        <option value="email">Email</option>
                        <option value="job_title">Job title</option>
                        <option value="company">Company</option>
                    </select>
                </div>
                <label for="fallback-field">Fallback</label>
                <br>
                <input type="hidden" id="insert_attr_current_seq" value="">
                <input type="text" class="form-control" id="fallback" name="fallback" placeholder="Value if the attribute is empty">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="insert-attr" class="btn btn-primary">Insert</button>
            </div>
        </div>
    </div>
</div>

<script>
    var client_templates = '<?php echo json_encode($compaign_templates) ?>'
</script>
<script src="/master/assets/js/create-campaign.js"></script>
@endsection