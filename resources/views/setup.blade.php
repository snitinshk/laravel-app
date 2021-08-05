<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>{{ env('APP_NAME') }} - {{$page_title}}</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico"/>
    <link href="/master/assets/css/loader.css" rel="stylesheet" type="text/css" />
    <script src="/master/assets/js/loader.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="/master/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/master/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="/master/assets/css/users/user-profile.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="/master/plugins/table/datatable/datatables.css">
    <script src="/master/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="/master/bootstrap/js/popper.min.js"></script>
    <script src="/master/bootstrap/js/bootstrap.min.js"></script>
    <script src="/master/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/master/assets/js/app.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        .layout-px-spacing {
            min-height: calc(100vh - 166px)!important;
        }
    </style>
</head>
<body style="font-family: 'Jost', sans-serif;">
<div id="load_screen"> <div class="loader"> <div class="loader-content">
            <div class="spinner-grow align-self-center"></div>
        </div></div></div>

<div class="header-container fixed-top">
    <header class="header navbar navbar-expand-sm">

        <ul class="navbar-item theme-brand flex-row  text-center">
            <li class="nav-item theme-logo">
                <a href="/">
                    <img src="/master/dashboard_logo.png" style="width: 223px; height: 50px; margin: 10px 0 10px 0;" alt="logo">
                </a>
            </li>
        </ul>

        <ul class="navbar-item flex-row ml-md-auto">
            <li class="nav-item dropdown user-profile-dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <div style="width: 40px; height: 40px; border-radius: 12px; background: #3A49A0; text-align: center; padding: 0; margin: 0;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="margin-top: -5px;" color="rgba(255,255,255,0.9)" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sliders"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>
                    </div>
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                    <div class="">
                        <div class="dropdown-item">
                            <a class="" href="/logout"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> Log Out</a>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </header>
</div>


<div style="width: 97%; margin: 120px auto 0 auto;">
    <div class="row layout-top-spacing">
        <h3 style="margin: 5px 0 25px 25px;">{{$page_title}}</h3>

        @yield('content')

    </div>
</div>



<script>
    $(document).ready(function() {
        App.init();
    });
</script>
<script src="/master/assets/js/custom.js"></script>

<script src="/master/plugins/table/datatable/datatables.js"></script>
<script>
    $('#zero-config').DataTable({
        "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [10, 25, 50],
        "pageLength": 10
    });
</script>

</body>
</html>
