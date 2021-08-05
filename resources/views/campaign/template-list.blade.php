@extends('master2', ['menu_group' => 'Campaigns', 'slug' => "CampaignTemplates", 'page_title' => "Campaign Template"])
@section('content')

    <head>
        <link rel="stylesheet" type="text/css" href="/master/plugins/table/datatable/dt-global_style.css">
    </head>


    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
        <div style="width: 100%; height: 60px; margin-top: -60px;">
            <a href="/campaign/add-template"><button class="btn btn-primary mb-2 mr-2" style="float: right;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Add</button></a>
        </div>

        <div class="widget-content widget-content-area br-6">
            <table id="zero-config" class="table dt-table-hover" style="width:100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Subject</th>
                    <th>Template</th>
                    <th>Date Added</th>
                    <th class="no-content">Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach($compaign_templates as $templates)
                    <tr>
                        <td>{{ $templates->template_name }}</td>
                        <td>{{ $templates->template_subject }}</td>
                        <td>{{ strip_tags($templates->template) }}</td>
                        <td>{{ date('d/m/Y',strtotime($templates->created_at)) }}</td>
                        <td>
                            <a href="/campaign/add-template/{{ $templates->id }}" style="width: 27px; height: 27px; margin-right: 10px; float: left;"><div class="table_button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                            </div></a>
                            <a onclick="disable_template({{$templates->id}})" style="cursor: pointer; width: 27px; height: 27px; margin-right: 10px; float: left;"><div class="table_button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </div></a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>

<script src="/master/assets/js/campaign.js"></script>
@endsection
