@extends('master2', ['menu_group' => 'Companies', 'slug' => "CompanySearch", 'page_title' => "Company Search"])
@section('content')

    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        <div class="widget widget-content-area br-4">
            <div class="widget-one">

                <h5>Create a new search to start generating a list of companies</h5>

                <form action="/company/search" method="POST">
                    @csrf

                    <div class="form-group" style="margin: 40px 0 0 2px;">
                        <p style="font-size: 16px;">Search Name</p>
                        <input id="t-text" type="text" name="name" class="form-control" placeholder="Accountants in Cardiff" required style="width: 60%;">
                    </div>

                    <div class="form-group" style="margin: 30px 0 0 2px;">
                        <div style="width: 60%;">
                            <p style="font-size: 16px; float: left;">Sales Navigator URL</p>
                            <p style="font-size: 16px; float: right;"><a href="https://www.linkedin.com/sales/search/company" target="_blank">Open in new window</a></p>
                        </div>
                        <input id="t-text" type="text" name="url" class="form-control" placeholder="https://www.linkedin.com/sales/search/company" required style="width: 60%;">
                    </div>

                    <input type="submit" name="txt" class="mt-4 btn btn-primary" value="Search">
                </form>


            </div>
        </div>
    </div>






@endsection
