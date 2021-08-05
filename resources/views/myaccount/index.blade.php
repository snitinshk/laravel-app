@extends('master2', ['menu_group' => 'MyAccount', 'slug' => "MyAccount", 'page_title' => "My Account"])
@section('content')


<div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
    <div class="widget widget-content-area br-4">
        <div class="widget-one" style="display: flex;">
            <div style="width: 50%;">
                <h4 style="margin: 5px 0 20px 0;">Profile</h4>

                <ul class="contacts-block list-unstyled">
                    <p style="font-size: 14px; color: rgba(255,255,255,0.7); margin-bottom: 3px;">Name</p>
                    <p style="font-size: 19px; color: rgba(255,255,255,0.9); margin-bottom: 17px;">{{ $UserData->first_name }} {{ $UserData->last_name }}</p>

                    <p style="font-size: 14px; color: rgba(255,255,255,0.7); margin-bottom: 3px;">Email</p>
                    <p style="font-size: 19px; color: rgba(255,255,255,0.9); margin-bottom: 17px;">{{ $UserData->email }}</p>

                    <p style="font-size: 14px; color: rgba(255,255,255,0.7); margin-bottom: 3px;">Company</p>
                    <p style="font-size: 19px; color: rgba(255,255,255,0.9); margin-bottom: 17px;">{{ $UserData->company_name }}</p>

                    <p style="font-size: 14px; color: rgba(255,255,255,0.7); margin-bottom: 3px;">Lead Credits Remaining</p>
                    <p style="font-size: 19px; color: rgba(255,255,255,0.9); margin-bottom: 17px;">{{ number_format($UserData->scrape_limit - $UserData->lead_credits_used) }}</p>

                    <p id="change_creds" style="font-size: 16px; font-weight: 500; margin-top: 30px; color: white; cursor: pointer;">Change my LinkedIn Credentials</p>

                </ul>
            </div>
            <div style="width: 50%;">
                <h4 style="margin: 5px 0 20px 0;">My Plan</h4>

                <p style="font-size: 19px; color: rgba(255,255,255,0.9); margin-bottom: 5px;">{{ $PlanData->name }}</p>
                <p style="font-size: 16px; color: rgba(255,255,255,0.8);">{{ number_format($PlanData->lead_credits) }} Lead Credits | Sync {{ number_format($PlanData->email_accounts) }} Email Account</p>


                <div style="width: 60%; background: white; border-radius: 8px; margin-top: 25px; margin-bottom: 20px; padding: 15px;">
                    <p style="font-size: 18px; font-weight: 500; color: #030B51;">Manage my plan</p>
                    <p style="font-size: 16px; color: #030B51;">Started: {{ date_format(date_create($UserData->stripe_sub_start),"jS M Y") }}</p>
                    <p style="font-size: 16px; color: #030B51;">Frequency: {{ ucwords($PlanData->frequency) }}</p>
                    <p style="font-size: 16px; color: #030B51;">Price: ${{ number_format($PlanData->price, 2) }}</p>
                    <a href="/subscription/cancel"><p style="font-size: 16px; font-weight: 500; margin-top: 20px; color: #ee3d49">Cancel my Subscription</p></a>
                </div>

            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    $(document).ready(function(){
        $("#change_creds").click(function() {
            $("#linkedin_details").modal('show');
        });
    });
</script>

<div class="modal fade" id="linkedin_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="/myaccount/linkedin" method="POST">
                @csrf

                <div class="modal-body">
                    <h4 class="modal-heading mb-4 mt-2">Change your LinkedIn credentials</h4>

                    <div class="form-group" style="margin: 40px 0 0 0;">
                        <p style="font-size: 16px;">LinkedIn Email Address</p>
                        <input type="email" name="linkedin_email" class="form-control" required>
                    </div>

                    <div class="form-group" style="margin: 20px 0 15px 0;">
                        <p style="font-size: 16px;">LinkedIn Password</p>
                        <input type="password" name="linkedin_password" class="form-control" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" />
                </div>
            </form>
        </div>
    </div>
</div>



@endsection
