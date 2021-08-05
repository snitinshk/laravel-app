@extends('master2', ['menu_group' => 'Admin', 'slug' => "AdminUsers", 'page_title' => "Edit Admin"])
@section('content')

    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        <div class="widget widget-content-area br-4">
            <div class="widget-one">

                <form action="/admins/edit/{{ $UserData->id }}" method='POST'>
                    @csrf

                    <div class="form-group" style="margin: 20px 0 0 2px;">
                        <p style="font-size: 16px;">First Name</p>
                        <input id="t-text" type="text" name="first_name" class="form-control" required value="{{ $UserData->first_name }}" style="width: 60%;">
                    </div>

                    <div class="form-group" style="margin: 30px 0 0 2px;">
                        <p style="font-size: 16px;">Last Name</p>
                        <input id="t-text" type="text" name="last_name" class="form-control" required value="{{ $UserData->last_name }}" style="width: 60%;">
                    </div>

                    <div class="form-group" style="margin: 30px 0 0 2px;">
                        <p style="font-size: 16px;">Email Address</p>
                        <input id="t-text" type="email" name="email" class="form-control" required value="{{ $UserData->email }}" style="width: 60%;">
                    </div>

                    <input type="submit" name="txt" class="mt-4 btn btn-primary" value="Save">
                </form>


            </div>
        </div>
    </div>

@endsection
