@extends('master2', ['menu_group' => 'Admin', 'slug' => "Users", 'page_title' => "Users"])
@section('content')

<head>
    <link rel="stylesheet" type="text/css" href="/master/plugins/table/datatable/dt-global_style.css">
</head>


<div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
    <div class="widget-content widget-content-area br-6">
        <table id="zero-config" class="table dt-table-hover" style="width:100%">
            <thead>
            <tr>
                <th>Name</th>
                <th>Client</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>User Plan</th>
                <th>Credits Left</th>
                <th>Country</th>
                <th>Date Joined</th>
            </tr>
            </thead>
            <tbody>

                @foreach($TableArray as $TableRow)
                    <tr>
                        <td>{{ $TableRow->first_name }} {{ $TableRow->last_name }}</td>
                        <td>{{ Haki::getUserClient($TableRow->client_id) }}</td>
                        <td>{{ $TableRow->email }}</td>
                        <td>{{ $TableRow->phone_number }}</td>
                        <td>{{ Haki::getUserPlan($TableRow->plan_id) }}</td>
                        <td>{{ $TableRow->scrape_limit - $TableRow->scrape_count }}</td>
                        <td>{{ Haki::getCountryByID($TableRow->country_code) }}</td>
                        <td>{{ $TableRow->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>



@endsection
