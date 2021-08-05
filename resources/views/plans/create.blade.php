@extends('master2', ['menu_group' => 'Admin', 'slug' => "Plans", 'page_title' => "Add Plan"])
@section('content')

<div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
    <div class="widget widget-content-area br-4">
        <div class="widget-one">

            <h6>Create a new Plan for users to subscribe to</h6>

            <form action="/plans/add" method="POST">
                @csrf

                <div class="form-group" style="margin: 40px 0 0 2px;">
                    <p style="font-size: 16px;">Plan Name</p>
                    <input id="t-text" type="text" name="name" class="form-control" required style="width: 60%;">
                </div>

                <div class="form-group" style="margin: 30px 0 0 2px;">
                    <p style="font-size: 16px;">Lead Credits</p>
                    <input id="t-text" type="text" name="lead_credits" class="form-control" required style="width: 60%;">
                </div>

                <div class="form-group" style="margin: 30px 0 0 2px;">
                    <p style="font-size: 16px;">Email Accounts</p>
                    <input id="t-text" type="text" name="email_accounts" class="form-control" required style="width: 60%;">
                </div>

                <div class="form-group" style="margin: 30px 0 0 2px;">
                    <p style="font-size: 16px;">Renewal Frequency</p>
                    <select class="form-control" name="frequency" style="width: 60%;">
                        <option value="monthly">Monthly</option>
                        <option value="annually">Annually</option>
                    </select>
                </div>

                <div class="form-group" style="margin: 30px 0 0 2px;">
                    <p style="font-size: 16px;">Stripe Price ID</p>
                    <input id="t-text" type="text" name="stripe_price_id" class="form-control" required style="width: 60%;">
                </div>

                <div class="form-group" style="margin: 30px 0 0 2px;">
                    <p style="font-size: 16px;">Price ($)</p>
                    <input id="t-text" type="text" name="price" class="form-control" required style="width: 60%;">
                </div>

                <input type="submit" name="txt" class="mt-4 btn btn-primary" value="Add Plan">
            </form>


        </div>
    </div>
</div>

@endsection
