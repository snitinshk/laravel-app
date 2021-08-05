@extends('master2', ['menu_group' => 'Admin', 'slug' => "TrialPlan", 'page_title' => "Trial Plan Settings"])
@section('content')

    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        <div class="widget widget-content-area br-4">
            <div class="widget-one">

                <form action="/trialplan/edit" method='POST'>
                    @csrf

                    <div class="form-group" style="margin: 40px 0 0 2px;">
                        <p style="font-size: 16px;">Trial Days</p>
                        <input type="text" name="trial_days" class="form-control" required value="{{ $SettingsInfo->trial_days }}" style="width: 60%;">
                    </div>

                    <div class="form-group" style="margin: 30px 0 0 2px;">
                        <p style="font-size: 16px;">Trial Credits</p>
                        <input type="text" name="trial_credits" class="form-control" required value="{{ $SettingsInfo->trial_credits }}" style="width: 60%;">
                    </div>

                    <input type="submit" name="txt" class="mt-4 btn btn-primary" value="Save Changes">
                </form>


            </div>
        </div>
    </div>

@endsection
