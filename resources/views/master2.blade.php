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
                            <a class="" href="/myaccount"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> My Account</a>
                        </div>
                        <div class="dropdown-item">
                            <a class="" href="/logout"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> Log Out</a>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </header>
</div>


<div class="main-container" id="container">
    <div class="overlay"></div>
    <div class="search-overlay"></div>

    <div class="sidebar-wrapper sidebar-theme">
        <nav id="sidebar">
            <ul class="list-unstyled menu-categories" id="accordionExample">
                <li class="menu">
                    <a href="#menu-leads" data-active="<?php echo $menu_group == "Leads" ? "true" : "collapse"; ?>" data-toggle="collapse" aria-expanded="<?php echo $menu_group == "Leads" ? "true" : "false"; ?>" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-compass"><circle cx="12" cy="12" r="10"></circle><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon></svg>
                            <span>Leads</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </div>
                    </a>
                    <ul class="<?php echo $menu_group == "Leads" ? "show" : "collapse"; ?> submenu list-unstyled" id="menu-leads" data-parent="#accordionExample">
                        <li class="<?php echo $slug == "LeadSearch" ? "active" : ""; ?>">
                            <a href="/lead/search"> Search</a>
                        </li>
                        <li class="<?php echo $slug == "MyLeads" ? "active" : ""; ?>">
                            <a href="/lead/list"> My Leads</a>
                        </li>
                    </ul>
                </li>

                <li class="menu">
                    <a href="#menu-companies" data-toggle="<?php echo $menu_group == "Companies" ? "true" : "collapse"; ?>" aria-expanded="<?php echo $menu_group == "Companies" ? "true" : "false"; ?>" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-briefcase"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                            <span>Companies</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </div>
                    </a>
                    <ul class="<?php echo $menu_group == "Companies" ? "show" : "collapse"; ?> submenu list-unstyled" id="menu-companies" data-parent="#accordionExample">
                        <li class="<?php echo $slug == "CompanySearch" ? "active" : ""; ?>">
                            <a href="/company/search"> Search</a>
                        </li>
                        <li class="<?php echo $slug == "CompanyList" ? "active" : ""; ?>">
                            <a href="/company/list"> List</a>
                        </li>
                    </ul>
                </li>

                <li class="menu">
                    <a href="#menu-domain" data-toggle="<?php echo $menu_group == "Domains" ? "true" : "collapse"; ?>" aria-expanded="<?php echo $menu_group == "Domains" ? "true" : "false"; ?>" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                            <span>Domain Search</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </div>
                    </a>
                    <ul class="<?php echo $menu_group == "Domains" ? "show" : "collapse"; ?> submenu list-unstyled" id="menu-domain" data-parent="#accordionExample">
                        <li class="<?php echo $slug == "DomainSearch" ? "active" : ""; ?>">
                            <a href="/domain/search"> Search</a>
                        </li>
                        <li class="<?php echo $slug == "DomainList" ? "active" : ""; ?>">
                            <a href="/domain/list"> List</a>
                        </li>
                    </ul>
                </li>

                <li class="menu">
                    <a href="#menu-campaigns" data-toggle="<?php echo $menu_group == "Campaigns" ? "true" : "collapse"; ?>" aria-expanded="<?php echo $menu_group == "Campaigns" ? "true" : "false"; ?>" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path></svg>
                            <span>Campaigns</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </div>
                    </a>
                    <ul class="<?php echo $menu_group == "Campaigns" ? "show" : "collapse"; ?> submenu list-unstyled" id="menu-campaigns" data-parent="#accordionExample">
                        <li class="<?php echo $slug == "NewCampaign" ? "active" : ""; ?>">
                            <a href="/campaign/new"> New</a>
                        </li>
                        <li class="<?php echo $slug == "CampaignList" ? "active" : ""; ?>">
                            <a href="/campaign/list"> My Campaigns</a>
                        </li>
                        <li class="<?php echo $slug == "CampaignTemplates" ? "active" : ""; ?>">
                            <a href="/campaign/templates"> Templates</a>
                        </li>
                        <li class="<?php echo $slug == "CampaignSettings" ? "active" : ""; ?>">
                            <a href="/campaign/settings"> Settings</a>
                        </li>
                    </ul>
                </li>

                <li class="menu">
                    <a href="/myaccount/" aria-expanded="false" class="dropdown-toggle">
                        <div  class="<?php echo $slug == "MyAccount" ? "active" : ""; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            <span>My Account</span>
                        </div>
                    </a>
                </li>

                <li class="menu">
                    <a href="/setup/app/" aria-expanded="false" class="dropdown-toggle">
                        <div  class="<?php echo $slug == "SetupApp" ? "active" : ""; ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-monitor"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                            <span>Desktop App</span>
                        </div>
                    </a>
                </li>

                <li class="menu" style="display: <?php if(Haki::isUserAdmin() == true){}else{echo "none";} ?>" >
                    <a href="#menu-admin" data-toggle="<?php echo $menu_group == "Admin" ? "true" : "collapse"; ?>" aria-expanded="<?php echo $menu_group == "Admin" ? "true" : "false"; ?>" class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                            <span>Admin</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </div>
                    </a>
                    <ul class="<?php echo $menu_group == "Admin" ? "show" : "collapse"; ?> submenu list-unstyled" id="menu-admin" data-parent="#accordionExample">
                        <li class="<?php echo $slug == "AdminUsers" ? "active" : ""; ?>">
                            <a href="/admins/"> Admin Users</a>
                        </li>
                        <li class="<?php echo $slug == "Plans" ? "active" : ""; ?>">
                            <a href="/plans/"> Plans</a>
                        </li>
                        <li class="<?php echo $slug == "TrialPlan" ? "active" : ""; ?>">
                            <a href="/trialplan/"> Trial Plan</a>
                        </li>
                        <li class="<?php echo $slug == "Clients" ? "active" : ""; ?>">
                            <a href="/clients/"> Clients</a>
                        </li>
                        <li class="<?php echo $slug == "Users" ? "active" : ""; ?>">
                            <a href="/users/"> Users</a>
                        </li>
                        <li class="<?php echo $slug == "LeadJobList" ? "active" : ""; ?>">
                            <a href="/leadjoblist/"> Lead Job List</a>
                        </li>
                        <li class="<?php echo $slug == "Queue" ? "active" : ""; ?>">
                            <a href="/queue/"> Snov Queue</a>
                        </li>
                        <li class="<?php echo $slug == "Audit" ? "active" : ""; ?>">
                            <a href="/audit/"> Audit</a>
                        </li>
                    </ul>
                </li>
            </ul>

        </nav>
    </div>


    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <h3 style="margin: 5px 0 25px 25px;">{{$page_title}}</h3>

                @yield('content')

            </div>
        </div>
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
        "lengthMenu": [50, 100, 150],
        "pageLength": 50
    });
</script>

</body>
</html>
