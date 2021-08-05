@extends('master2', ['menu_group' => 'Admin', 'slug' => "Clients", 'page_title' => "Clients"])
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
                    <th>Contact Name</th>
                    <th>Email</th>
                    <th>Date Joined</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>

                @foreach($TableArray as $TableRow)
                    <tr>
                        <td>{{ $TableRow->name }}</td>
                        <td>{{ $TableRow->contact_name }}</td>
                        <td>{{ $TableRow->email_address }}</td>
                        <td>{{ $TableRow->created_at->format('d/m/Y') }}</td>
                        <td>{{ Haki::getUserStatus($TableRow->status) }}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>



@endsection
