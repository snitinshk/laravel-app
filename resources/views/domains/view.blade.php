@extends('master2', ['menu_group' => 'Domains', 'slug' => "DomainList", 'page_title' => "View Domain Emails"])
@section('content')

    <head>
        <link rel="stylesheet" type="text/css" href="/master/plugins/table/datatable/dt-global_style.css">
    </head>


    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">

        <div class="widget-content widget-content-area br-6">
            <table id="zero-config" class="table dt-table-hover" style="width:100%">
                <thead>
                <tr>
                    <th>Domain</th>
                    <th>Company</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Email Status</th>
                    <th>Position</th>
                    <th>Source</th>
                </tr>
                </thead>
                <tbody>
                @foreach($CompanyEmails as $CompanyEmail)
                    <tr>
                        <td>{{ $CompanyEmail->domain }}</td>
                        <td>{{ $CompanyEmail->name }}</td>
                        <td>{{ $CompanyEmail->first_name }}</td>
                        <td>{{ $CompanyEmail->last_name }}</td>
                        <td>{{ $CompanyEmail->email }}</td>
                        <td>{{ ucwords($CompanyEmail->status) }}</td>
                        <td>{{ $CompanyEmail->position }}</td>
                        <td>{{ $CompanyEmail->source }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


@endsection
