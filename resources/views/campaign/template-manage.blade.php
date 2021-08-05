@extends('master2', ['menu_group' => 'Campaigns', 'slug' => "CampaignTemplates", 'page_title' => "Campaign Template"])
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
    button.email-config.insert-attr {
        margin-left: 1045px;
    }

</style>
<div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
    <div class="toggle-table full-width-toggle-table" data-controller="toggle-table">
        <div class="row-container active">
            <div class="email-config">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <form method="post" action="{{ route('campaign.manage_template') }}">
                @csrf
                <div class="row-title">
                <div class="caret-icon">
                    <div class="far fa-angle-down"></div>
                </div>
                <div class="row-title-icon pull-left">
                    <div class="fal fa-calendar-alt"></div>
                </div>
                </div>
                
                <div class="email-config form-group">
                    <input class="form-control" id="name-field" value="{{ ($compaign_templates)?$compaign_templates->template_name:'' }}" required name="template_name" placeholder="Name of the template"  type="text">
                </div>
                <div class="email-config trix-editor">
                    <input class="form-control" id="subject-field" value="{{ ($compaign_templates)?$compaign_templates->template_subject:'' }}" required name="template_subject" placeholder="Subject" type="text">
                    <input type="hidden" name="template_id" value="{{ $template_id }}">
                    <input id="body-field" type="hidden" name="template" value="{{ ($compaign_templates)?$compaign_templates->template:'Hi |first_name:there|,' }}">
                    <trix-editor data-trix-editor-target="editor" id="trix-editor" input="body-field" placeholder="Compose your email..." style="min-height: 15em;" role="textbox" spellcheck="false">
                    </trix-editor>
                </div>
                <button id="insert-attr-btn" class="email-config insert-attr btn btn-primary">Insert attribute</button>
                <div class="email-config form-group">
                    <button type="submit" class="btn btn-primary">{{ ($template_id)?'Update':'Save' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="insertAttrModal" tabindex="-1" role="dialog" aria-hidden="true">
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
                    <select class=" form-control" id="attribute-identifier" name="attribute">
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
                <input type="text" class=" form-control" id="fallback" name="fallback" placeholder="Value if the attribute is empty" required="required" >
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="insert-attr" class="btn btn-primary">Insert</button>
            </div>
        </div>
    </div>
</div>
<script src="/master/assets/js/campaign.js"></script>
@endsection