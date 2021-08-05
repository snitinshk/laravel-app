<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>{{ env('APP_NAME') }} - Sign Up</title>
    <link rel="icon" type="image/x-icon" href=""/>
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
    </header>
</div>


<div style="width: 97%; margin: 120px auto 0 auto;">
    <div class="row layout-top-spacing">
        <h3 style="margin: 5px 0 25px 25px;">Welcome to Conversix!</h3>

        <div style="width: 100%; margin-top: 20px;">
            <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
                <div class="widget widget-content-area br-4">

                    <h5 style="margin-top: 5px;">Sign up for a 7 day free trial</h5>
                    <p style="font-size: 17px; margin-top: 15px; margin-bottom: 20px;">Ready to supercharge your outreach? get serious about sales with a lead plan from Conversix</p>

                    <form action="/signup" method='POST' style="width: 100%; display: flex;">
                        @csrf

                        <div style="width: 50%;">
                            <div class="form-group" style="margin: 10px 0 0 2px;">
                                <p style="font-size: 16px;">First Name</p>
                                <input id="t-text" type="text" name="first_name" class="form-control" required style="width: 60%; height: 40px;">
                            </div>

                            <div class="form-group" style="margin: 30px 0 0 2px;">
                                <p style="font-size: 16px;">Last Name</p>
                                <input id="t-text" type="text" name="last_name" class="form-control" required style="width: 60%; height: 40px;">
                            </div>

                            <div class="form-group" style="margin: 30px 0 0 2px;">
                                <p style="font-size: 16px;">Email Address</p>
                                <input id="t-text" type="text" name="email" class="form-control" required style="width: 60%; height: 40px;">
                            </div>

                            <div class="form-group" style="margin: 30px 0 0 2px;">
                                <p style="font-size: 16px;">Country</p>
                                <select name="country_code" class="form-control" required style="width: 60%; height: 40px; padding: 1px 10px 0 12px; line-height: 14px;">
                                    <option value="0">Select your Country</option>
                                    {{!! Haki::getSelectCountries() !!}}
                                </select>
                            </div>

                        </div>

                        <div style="width: 50%;">
                            <div class="form-group" style="margin: 10px 0 0 2px;">
                                <p style="font-size: 16px;">Phone Number</p>
                                <input id="t-text" type="text" name="phone_number" class="form-control" required style="width: 60%; height: 40px;">
                            </div>

                            <div class="form-group" style="margin: 30px 0 0 2px;">
                                <p style="font-size: 16px;">Company Name</p>
                                <input id="t-text" type="text" name="company_name" class="form-control" required style="width: 60%; height: 40px;">
                            </div>

                            <div class="form-group" style="margin: 30px 0 0 2px;">
                                <p style="font-size: 16px;">Password</p>
                                <input id="t-text" type="password" name="password" class="form-control" required style="width: 60%; height: 40px;">
                            </div>

                            <div class="form-group" style="margin: 30px 0 0 2px; display: flex;">
                                <input type="checkbox" name="agree_terms" class="form-control" required style="width: 20px; height: 20px; border-radius: 12px;">
                                <p style="font-size: 15px; margin-left: 10px;">By clicking Sign Up, you agree to our <a href="https://www.conversix.com/terms-of-service">Terms</a></p>
                            </div>

                            <input type="submit" name="txt" class="btn" value="Sign Up" style="font-size: 17px; margin: 10px 0 15px 1px; color: white; background-color: #030B51">
                        </div>
                    </form>
                </div>
            </div>



        </div>

    </div>
</div>
<script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="5282ec84-469d-44d8-be48-48764eb230a8";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>
</body>
</html>
