<?php
// This array generates the navigation bar rows
$navigation_array = array(
    // Main or Sub, Display Name, URL Slug, Line Icon Name
    array("Main", "Talent Search", "search/"),
    array("Main", "Talent List", "talentlist/"),
    array("Main", "My Account", "myaccount/"),
);

if(Haki::isUserAdmin() == true){
    array_push($navigation_array,
        array("Main", "Admin", "admins/"),
        //array("sub", "Clients", "clients/"),
        //array("sub", "Users", "users/"),
        //array("sub", "Plans", "plans/"),
        //array("sub", "Admins", "admins/"),
    );
}
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <title>{{ env('APP_NAME') }} - {{$page_title}}</title>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <link rel='stylesheet' href='{{ URL::asset('css/ccFramework.css') }}'>
    <script src='{{ URL::asset('js/jquery-3.5.1.min.js') }}'></script>
    <link rel='stylesheet' href='{{ URL::asset('css/bootstrap.min.css') }}'>
    <script src='{{ URL::asset('js/bootstrap.min.js') }}'></script>
    <link rel='stylesheet' href='{{ URL::asset('lineicons/LineIcons.css') }}'>
    <script src='{{ URL::asset('js/ccFramework.js') }}'></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
</head>
<body style="background-color: #120030; font-family: 'Roboto', sans-serif;">
<div class='container-fluid'>
    <div class='row' >
        <div id='ccf_nav_bar'>
            <div style="width: 80px; height: 80px; background: orange; margin: 15px auto 0 auto; background: url('{{ URL::asset('/media/conversix_logo.png') }}'); background-size: 100%, 100%;"></div>


            @foreach($navigation_array as $nav_item)
                <a href='{{ url('/') }}/{{ $nav_item[2] }}' style='text-decoration: none; color: #ffffff;'><div class="ccf_nav_item">
                        <p class="ccf_nav_item_text">{{ $nav_item[1] }}</p>
                        <i class="lni lni-arrow-right-circle" id="ccf_nav_item_icon"></i>
                    </div></a>
            @endforeach




            <a href='{{ url('/') }}/logout' style='text-decoration: none;'><div style="width: 90%; height: 50px; position: absolute; bottom: 15px; left: 5%; border-radius: 12px;">
                    <p class="ccf_nav_item_text">Logout</p>
                    <i class="lni lni-enter" id="ccf_nav_item_icon"></i>
                </div></a>

        </div>
        <div id='ccf_content'>
            <div id='ccf_safe_area'>
                <h3 id='ccf_page_title'>{{$page_title}}</h3>
                <div id="container_panel">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>

<div id='small_screen'>
    <i class='lni lni-display-alt' style='font-size: 38px; color: white; margin: 130px auto 0 auto;'></i>
    <p id='small_screen_label' style='font-size: 18px; color: white; margin-top: 30px;'>Tablet or Desktop is required.<br><br>This website is not optimised for mobile viewing.</p>
</div>

</body>
<script>
    $('#banner').delay(2000).fadeOut();
</script>
</html>
