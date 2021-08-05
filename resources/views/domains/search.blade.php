@extends('master2', ['menu_group' => 'Domains', 'slug' => "DomainSearch", 'page_title' => "Domain Search"])
@section('content')

    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        <div class="widget widget-content-area br-4">
            <div class="widget-one">

                <h5>Start collecting email addresses from company domains</h5>

                <form action="/domain/search" method="POST"  enctype="multipart/form-data">
                    @csrf

                    <div class="form-group" style="margin: 40px 0 0 2px;">
                        <p style="font-size: 16px;">Search Name</p>
                        <input id="t-text" type="text" name="name" class="form-control" placeholder="Manufacturers in Wales" required style="width: 60%;">
                    </div>

                    <div class="form-group" style="margin: 30px 0 0 2px;">
                        <p style="font-size: 16px;">Upload CSV file</p>
                        <input type="file" class="form-control" name="csv" accept=".csv" id="file" required  style="width: 60%; height: 53px;" />
                        <p style="font-size: 15px; margin-top: 15px; color: rgba(255,255,255,0.7)">Please ensure your CSV file only contains a single column with domain names you want to collect email addresses for.</p>
                    </div>

                    <input type="submit" name="txt" class="mt-4 btn btn-primary" value="Upload">
                </form>


            </div>
        </div>
    </div>






@endsection
