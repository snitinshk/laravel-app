@extends('master2', ['menu_group' => 'Admin', 'slug' => "Queue", 'page_title' => "Snov Queue"])
@section('content')

    <head>
        <link rel="stylesheet" type="text/css" href="/master/plugins/table/datatable/dt-global_style.css">
    </head>


    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">

        <div class="widget-content widget-content-area br-6">
            <table id="zero-config" class="table dt-table-hover" style="width:100%">
                <thead>
                <tr>
                    <th>User</th>
                    <th>Job Name</th>
                    <th>Type</th>
                    <th>Run At</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($TableArray as $TableRow)
                    <?php
                        if($TableRow->status > 0){ $snov_status = "Running"; }else{ $snov_status = "Waiting"; }
                    ?>
                    <tr>
                        <td>{{ $TableRow->first_name }} {{ $TableRow->last_name }}</td>
                        <td>{{ $TableRow->name }}</td>
                        <td>{{ $TableRow->type }}</td>
                        <td>{{ Haki::formatDateTime($TableRow->run_at) }}</td>
                        <td>{{ $snov_status }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <p style="font-size: 16px; font-weight: 500; margin: 25px 0 0 10px; color: white">Key:</p>
        <ul style="font-size: 15px; margin: 5px 0 0 0; color: white">
            <li>SNOV_RUN_1: Posting Leads to SNOV</li>
            <li>SNOV_RUN_2: Collecting Leads from SNOV</li>
        </ul>

    </div>


@endsection
