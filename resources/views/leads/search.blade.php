@extends('master2', ['menu_group' => 'Leads', 'slug' => "LeadSearch", 'page_title' => "Lead Search"])
@section('content')

<script type="text/javascript">
    $(document).ready(function(){
        var LinkedInStatus = <?php echo $LinkedInStatus ?>;
        if(LinkedInStatus < 1){
            $("#linkedin_details").modal('show');
        }
    });
</script>



<div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
    <div class="widget widget-content-area br-4">
        <div class="widget-one">

            <h5>Create a new search to start obtaining leads from Sales Navigator</h5>

            <form action="/lead/search" method="POST">
                @csrf

                <div class="form-group" style="margin: 40px 0 0 2px;">
                    <p style="font-size: 16px;">Search Name</p>
                    <input id="t-text" type="text" name="name" class="form-control" placeholder="Sales in Newcastle" required style="width: 60%;">
                </div>

                <div class="form-group" style="margin: 30px 0 0 2px;">
                    <div style="width: 60%;">
                        <p style="font-size: 16px; float: left;">Sales Navigator URL</p>
                        <p style="font-size: 16px; float: right;"><a href="https://www.linkedin.com/sales/search/people" target="_blank">Open in new window</a></p>
                    </div>
                    <input id="t-text" type="text" name="url" class="form-control" placeholder="https://www.linkedin.com/sales/search/people" required style="width: 60%;">
                </div>

                <input type="submit" name="txt" class="mt-4 btn btn-primary" value="Search">
            </form>

        </div>
    </div>
</div>






<div class="modal fade" id="linkedin_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="/myaccount/linkedin" method="POST">
                @csrf

                <div class="modal-body">
                    <h4 class="modal-heading mb-4 mt-2">We need your LinkedIn credentials</h4>
                    <p class="modal-text" style="font-size: 17px;">Conversix uses your LinkedIn credentials to collect data from Sales Navigator. Please input your LinkedIn login details below in order to use the platform.</p>

                    <div class="form-group" style="margin: 30px 0 0 0;">
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
