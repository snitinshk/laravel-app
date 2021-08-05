@extends('master2', ['menu_group' => 'Campaigns', 'slug' => "CampaignList", 'page_title' => "View Campaign"])
@section('content')

<head>
    <link rel="stylesheet" type="text/css" href="/master/plugins/table/datatable/dt-global_style.css">
</head>
<style>
    .followup-container{
        margin-top: 15px;
        margin-left: 210px;
    }
    .followup-template{
        margin-top: 35px;
    }
    .card-header {
        background-color: #ffffff;
        color: #000000;
    }
    p.card-text {
        color: #fff;
    }
    .card-body {
        color: #ffffff;
    }
</style>
<div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
    <!--Grid row-->
    <div class="row followup-container">
        <!--Grid column-->
        <div class="col-md-10 mb-6 campaign-template">
            
            <h4>Campaign Name: {{ $campaign_detail->campaign_name }}, Email: {{ $campaign_detail->email_from }}</h4>
            <h4>Selected Group: {{ $campaign_detail->name }}</h4>
            <br>
            <p class="font-weight-bold">Campaign Detail</p>
            <div class="card">
                <div class="card-header">
                  Subject: {{ $campaign_detail->subject }}
                </div>
                <div class="card-body">
                  <p class="card-text">
                    <?php echo $campaign_detail->template; ?>
                  </p>
                </div>
              </div>
        
        </div>
        <!--Grid column-->
        @foreach ($campaign_followups as $followup)
            <!--Grid column-->
            <div class="col-md-10 mb-6 followup-template">
                <p class="font-weight-bold">Followup in {{ $followup->follow_up_days }} days:</p>    
                <div class="card">
                    <div class="card-header">
                        Subject: {{ $followup->subject }}
                    </div>
                    <div class="card-body">
                        {{--  <h5 class="card-title">Special title treatment</h5>  --}}
                        <p class="card-text">
                            <?php echo $followup->template; ?>
                        </p>
                        {{--  <a href="#!" class="btn btn-primary">Go somewhere</a>  --}}
                    </div>
                    </div>
            </div>
            <!--Grid column-->
        @endforeach
    <!--Grid row-->
</div>

@endsection
    
