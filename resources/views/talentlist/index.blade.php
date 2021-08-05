@extends('master', ['slug' => "Talent List", 'page_title' => "Talent List"])
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

    <div style="width: 96%; height: 45px; background: #120030; border-radius: 10px; margin: 25px 0 0 2%; font-weight: 500; color: white;">
        <div style="width: 22%; float: left;"><p style="margin: 13px 0 0 12px;">Search Name</p></div>
        <div style="width: 22%; float: left;"><p style="margin: 13px 0 0 12px;">Date Created</p></div>
        <div style="width: 22%; float: left;"><p style="margin: 13px 0 0 12px;">Status</p></div>
        <div style="width: 22%; float: left;"><p style="margin: 13px 0 0 12px;">Progress</p></div>
        <div style="width: 22%; float: left;"></div>
    </div>

    @foreach($TableArray as $TableRow)
        <div style="width: 96%; height: 45px; background: white; border-radius: 10px; margin: 15px 0 0 2%; font-weight: 500; color: #120030;">
            <div style="width: 22%; float: left;"><p style="margin: 13px 0 0 12px;">{{ $TableRow[1] }}</p></div>
            <div style="width: 22%; float: left;"><p style="margin: 13px 0 0 12px;">{{ Haki::formatDateTime($TableRow[2]) }}</p></div>
            <div style="width: 22%; float: left;"><p style="margin: 13px 0 0 12px;">{{ $TableRow[3] }}</p></div>
            <div style="width: 17%; float: left;"><p style="margin: 13px 0 0 12px;">{{ $TableRow[4] }}</p></div>
            <div style="width: 17%; float: left;">
                <?php
                    if($TableRow[0] > 0){
                        echo "<a href='/talentlist/view/" . $TableRow[0] . "' style='text-decoration: none; color: #120030;'><div style='width: 31px; height: 31px; background: rgba(0,0,0,0.1); border-radius: 6px; margin: 7px; float: left;'>
                                <i class='lni lni-keyword-research' style='font-size: 20px; margin: 5px;'></i>
                            </div></a>
                            <a href='/talentlist/export/" . $TableRow[0] . "' style='text-decoration: none; color: #120030;'><div style='width: 31px; height: 31px; background: rgba(0,0,0,0.1); border-radius: 6px; margin: 7px; float: left;'>
                                <i class='lni lni-download' style='font-size: 20px; margin: 5px;'></i>
                            </div></a>
                            <a href='/talentlist/delete/" . $TableRow[0] . "' style='text-decoration: none; color: #120030;'><div style='width: 31px; height: 31px; background: rgba(0,0,0,0.1); border-radius: 6px; margin: 7px; float: left;'>
                                <i class='lni lni-close' style='font-size: 20px; margin: 5px;'></i>
                            </div></a>";
                    }
                ?>
            </div>
        </div>
    @endforeach




    <br><br><br><br><br><br><br><br><br>




@endsection
