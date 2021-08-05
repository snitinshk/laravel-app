@extends('master2', ['menu_group' => 'Companies', 'slug' => "CompanyList", 'page_title' => "View Companies"])
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
                    <th>Website</th>
                    <th>Industry</th>
                    <th>Head Office Location</th>
                    <th>Type</th>
                    <th>Founded</th>
                    <th>Specialities</th>
                    <th>Overview</th>
                    <th>Head Count</th>
                    <th>Sales Nav URL</th>
                </tr>
                </thead>
                <tbody>
                @foreach($Companies as $Company)
                    <tr>
                        <td>{{ $Company->name }}</td>
                        <td>{{ $Company->website }}</td>
                        <td>{{ $Company->industry_desc }}</td>
                        <td>{{ $Company->headquarters_location }}</td>
                        <td>{{ $Company->incorporation_type }}</td>
                        <td>{{ $Company->founded_year }}</td>
                        <td>{{ $Company->specialities }}</td>
                        <td>{{ $Company->overview }}</td>
                        <td>{{ $Company->headcount }}</td>
                        <td>{{ $Company->sales_link }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


@endsection
