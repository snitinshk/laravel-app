@extends('master2', ['menu_group' => 'Admin', 'slug' => "LeadJobList", 'page_title' => "Lead Job List"])
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
                    <th>Search Name</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Collected</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($TableArray as $TableRow)
                    <tr>
                        <td>{{ Haki::getNameByUserID($TableRow[5]) }}</td>
                        <td>{{ $TableRow[1] }}</td>
                        <td>{{ Haki::formatDateTime($TableRow[2]) }}</td>
                        <td>{{ $TableRow[3] }}</td>
                        <td>{{ $TableRow[4] }}</td>
                        <td>
                            <a href="/lead/view/{{ $TableRow[0] }}" style="width: 27px; height: 27px; margin-right: 10px; float: left;"><div class="table_button">
                                <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' color='white' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-search'><circle cx='11' cy='11' r='8'></circle><line x1='21' y1='21' x2='16.65' y2='16.65'></line></svg>
                            </div></a>
                            <a href="/lead/export/{{ $TableRow[0] }}" style="width: 27px; height: 27px; margin-right: 10px; float: left;"><div class="table_button">
                                <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' color='white' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-download'><path d='M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4'></path><polyline points='7 10 12 15 17 10'></polyline><line x1='12' y1='15' x2='12' y2='3'></line></svg>
                            </div></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


@endsection
