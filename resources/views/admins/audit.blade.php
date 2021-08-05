@extends('master2', ['menu_group' => 'Admin', 'slug' => "Audit", 'page_title' => "Job Audit"])
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
                    <th>Note</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                @foreach($TableArray as $TableRow)
                    <tr>
                        <td>{{ $TableRow->first_name }} {{ $TableRow->last_name }}</td>
                        <td>{{ $TableRow->name }}</td>
                        <td>{{ $TableRow->note }}</td>
                        <td>{{ Haki::formatDateTime($TableRow->created_at) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


@endsection
