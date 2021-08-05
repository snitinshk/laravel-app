@extends('master', ['slug' => "Talent List View", 'page_title' => "Talent List View"])
@section('content')

    <style>
        .ccf_list_action_item:hover{
            background-color:#00264d;
        }
        .ccf_list_action_bar{
            background-color: #120030;
        }
        .table.table-hover tbody tr:hover{
            background-color: #120030;
        }
    </style>

<br>


    <div style="width: 96%; min-height: 400px; margin: 15px 0 0 2%; padding-bottom: 20px; white-space: nowrap; position: relative; overflow-x:scroll;">
        <div style="width: 3500px; height: 45px; background: #120030; border-radius: 10px; margin-top: 25px; font-weight: 500; color: white;">
            @foreach($TableColumns as $Column)
                <div style="width: 350px; display: inline-block;"><p style="margin: 13px 0 0 12px;">{{ $Column }}</p></div>
            @endforeach
        </div>


            @foreach($TableArray as $TableRow)
            <div style="width: 3500px; height: 45px; background: white; border-radius: 10px; margin-top: 10px; font-weight: 500; color: #120030;">
                <div style="width: 350px; display: inline-block; "><p style="margin: 13px 0 0 12px;">{{ $TableRow->full_name }}</p></div>
                <div style="width: 350px; display: inline-block;"><p style="margin: 13px 0 0 12px;">{{ $TableRow->personal_email }}</p></div>
                <div style="width: 350px; display: inline-block; "><p style="margin: 13px 0 0 12px;">{{ $TableRow->corporate_email }}</p></div>
                <div style="width: 350px; display: inline-block;"><p style="margin: 13px 0 0 12px;">{{ $TableRow->current_job_title }}</p></div>
                <div style="width: 350px; display: inline-block;"><p style="margin: 13px 0 0 12px;">{{ $TableRow->current_employer }}</p></div>
                <div style="width: 350px; display: inline-block;"><p style="margin: 13px 0 0 12px;">{{ $TableRow->location }}</p></div>
                <div style="width: 350px; display: inline-block;"><p style="margin: 13px 0 0 12px;">{{ substr($TableRow->profile_url,0,40) }}</p></div>
                <div style="width: 350px; display: inline-block;"><p style="margin: 13px 0 0 12px;">{{ $TableRow->top_skill_1 }}</p></div>
                <div style="width: 350px; display: inline-block;"><p style="margin: 13px 0 0 12px;">{{ $TableRow->top_skill_2 }}</p></div>
                <div style="width: 350px; display: inline-block;"><p style="margin: 13px 0 0 12px;">{{ $TableRow->top_skill_3 }}</p></div>
            </div>
            @endforeach


    </div>


@endsection
