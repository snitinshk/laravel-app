@extends('master2', ['menu_group' => 'Leads', 'slug' => "MyLeads", 'page_title' => "View Leads"])
@section('content')

    <head>
        <link rel="stylesheet" type="text/css" href="/master/plugins/table/datatable/dt-global_style.css">
    </head>


    <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">

        <div class="widget-content widget-content-area br-6">
            <table id="zero-config" class="table dt-table-hover" style="width:100%">
                <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Personal Email</th>
                    <th>Corporate Email</th>
                    <th>Email Status</th>
                    <th>Current Job Title</th>
                    <th>Current Employer</th>
                    <th>Employer Website</th>
                    <th>Location</th>
                    <th>Profile URL</th>
                    <th>Top Skill 1</th>
                    <th>Top Skill 2</th>
                    <th>Top Skill 3</th>
                </tr>
                </thead>
                <tbody>
                @foreach($Candidates as $Candidate)
                    <?php
                        // Name Splitter
                        $candidate_name = explode(" ", $Candidate->full_name);

                        switch($Candidate->status){
                            case 0:
                                $EmailStatus = "Pending";
                                break;
                            case 1:
                                $EmailStatus = "Unknown";
                                break;
                            case 2:
                                $EmailStatus = "Valid";
                                break;
                        }
                        if(strlen($Candidate->corporate_email) < 2){$EmailStatus = "";}
                    ?>
                    <tr>
                        <td>{{ $candidate_name[0] }}</td>
                        <td>{{ end($candidate_name) }}</td>
                        <td>{{ $Candidate->personal_email }}</td>
                        <td>{{ $Candidate->corporate_email }}</td>
                        <td>{{ $EmailStatus }}</td>
                        <td>{{ $Candidate->current_job_title }}</td>
                        <td>{{ $Candidate->current_employer }}</td>
                        <td>{{ $Candidate->current_employer_website }}</td>
                        <td>{{ $Candidate->location }}</td>
                        <td>{{ $Candidate->sales_link }}</td>
                        <td>{{ $Candidate->top_skill_1 }}</td>
                        <td>{{ $Candidate->top_skill_2 }}</td>
                        <td>{{ $Candidate->top_skill_3 }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


@endsection
