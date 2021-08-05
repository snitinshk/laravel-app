@extends('master2', ['menu_group' => 'Campaigns', 'slug' => "CampaignSettings", 'page_title' => ""])
@section('content')

    <head>
        <link rel="stylesheet" type="text/css" href="/master/plugins/table/datatable/dt-global_style.css">
    </head>
    <style>
    /* style for scheduler */


    .toggle-table .row-container .row-title {
        padding: 20px;
        transition: all 100ms ease;
    }
    /* style for scheduler end */
    /* style for smtp detail */
    .email-config {
       margin-left: 20px;
       display: block;
    }
    .email-input > .form-control{
        margin-top: 10px;
    }

    .select-window{
        margin-top: 10px;
        margin-bottom: 13px;
        margin-left: 3px;
    }

</style>
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div class="row-title">
            <h3>Sending window</h3>
            <div class="grey">Indicate when your emails can be sent when they are part of a campaign.</div>
        </div>
        <form method="post" action="{{ route('campaign.schedule') }}">
            @csrf
            <div class="row select-window">
                    @foreach($days as $index => $day)
                    <div class="form-check select-day">
                        <input class="form-check-input select-checkbox" id="schedule-day-{{ $index+1 }}-field" {{ (in_array($index+1,$selected_day))?'checked':'' }} name="user[campaign_schedule_days][]" type="checkbox" value="{{ $index+1 }}">
                        <label class="form-check-label" for="schedule-day-{{ $index+1 }}-field">
                            {{ $day }}
                        </label>
                    </div>
                        @endforeach
                
            </div>
            <div class="row">
                <div class="col-lg-2 form-group">
                    <select class="form-control" name="user[campaign_schedule_time_start]" id="campaign_start_time">
                        @for ($hour = 0; $hour <= 23; $hour++)
                            <option data-hour="{{ $hour }}" {{ $hour > ($campaign_end_time-1)?'disabled':'' }} {{ $campaign_start_time == $hour ?'selected':'' }} value="{{ date("H:i", strtotime("$hour:00")) }}">{{ date("h:i a", strtotime("$hour:00")) }}</option>    
                        @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label>to</label>
                </div>
                <div class="col-lg-2 form-group">
                    <select class="form-control" name="user[campaign_schedule_time_end]" id="campaign_end_time">
                        <@for ($hour = 0; $hour <= 23; $hour++)
                            <option data-hour="{{ $hour }}"  {{ $hour < ($campaign_start_time+1)?'disabled':'' }} {{ $campaign_end_time == $hour?'selected':'' }} value="{{ date("H:i", strtotime("$hour:00")) }}">{{ date("h:i a", strtotime("$hour:00")) }}</option>    
                        @endfor
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <input onclick="return validateCheckbox()" type="submit" value="Update" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row-title">
            <h3>Please provide you smtp details</h3>
            <div class="grey">These details will be used to send emails.</div>
        </div>
        <form method="post" action="{{ route('campaign.config') }}">
            @csrf
            <input type="hidden" name="config_id" value="{{ ($compaign_email_config)?$compaign_email_config->id:'' }}">
            <div class="row">
                <div class="form-group col-lg-3">
                    <input type="text" required class="form-control" value="{{ ($compaign_email_config)?$compaign_email_config->host:'' }}" name="host" placeholder="Please enter your host detail">
                </div>
                <div class="form-group col-lg-3">
                    <input type="number" required class="form-control" value="{{ ($compaign_email_config)?$compaign_email_config->port:'' }}" name="port" placeholder="Please enter port to use">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-3">
                    <input type="text" required class="form-control" value="{{ ($compaign_email_config)?$compaign_email_config->username:'' }}" name="username" placeholder="Please enter username">
                </div>
                <div class="form-group col-lg-3">
                    <input type="text" required class="form-control" value="{{ ($compaign_email_config)?$compaign_email_config->password:'' }}" name="password" placeholder="Please enter password">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-3">
                    <input type="text" required class="form-control" value="{{ ($compaign_email_config)?$compaign_email_config->email_from:'' }}" name="email_from" placeholder="Please enter from address">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <input type="submit" value="Update" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row-title">
            <h3>Unsubscribe sentence</h3>
            <div class="grey">Edit the sentence that indicates your recipients how to unsubscribe from your emails.</div>
        </div>
        <form method="POST" action="{{ route('campaign.save_unsubscription_msg') }}">
            @csrf
            <div class="row">
                <div class="form-group col-lg-6">
                    <label>
                        The unsubscription link will be included between the |link| and |/link| tags.
                    </label>
                </div>
            </div>
            <input type="hidden" name="usubcription_msg_id" value="{{ ($unsubcription_message_detail)?$unsubcription_message_detail->id:'' }}">
            <div class="row">
                <div class="form-group col-lg-12">
                    <input type="text" required  class="form-control" value="{{ ($unsubcription_message_detail)?$unsubcription_message_detail->unsubscribe_text:$default_unsubcription_message }}" name="unsubscribe_text" >
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <input type="submit" value="Update" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
    <script src="/master/assets/js/campaign.js"></script>
@endsection