<!DOCTYPE html>
<html>
<head>
    <title>{{ env('APP_NAME') }} | Login</title>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <script src='https://code.jquery.com/jquery-3.5.1.min.js'
            integrity='sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=' crossorigin='anonymous'></script>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'
          integrity='sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u' crossorigin='anonymous'>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'
            integrity='sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa'
            crossorigin='anonymous'></script>
    <link href='https://cdn.lineicons.com/2.0/LineIcons.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500&display=swap" rel="stylesheet">
</head>
<body style="background-color: #030B51;">
<div class="container">
    <div class="row">
        <div class="col-md-4" style="position: fixed; top: 15rem; left: 12rem; ">

            <div style="height: 480px; width: 400px; padding-bottom: 40px; position: relative; z-index: 100;">
                <div style="width: 40rem; margin-bottom: 20px;">
                    <img alt="logo" src="/media/login_logo.png" style="width: 100%">
                </div>

                <p style="font-size: 17px; font-weight: 400; padding: 25px 0 0 0; color: #ffffff;">Email Address</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="text" name="email" require autofocus style="width: 40rem; height: 45px; margin: 1px 0 10px 0; font-size: 18px; font-weight: 500; padding: 7px 13px 7px 13px; border: 0; border-radius: 12px; background: white;">

                    <p style="font-size: 17px; font-weight: 400; padding: 35px 0 0 0; color: #ffffff;">Password</p>
                    <input type="password" name="password" require style="width: 40rem; height: 45px; margin: 1px 0 10px 0; font-size: 18px; font-weight: 500; padding: 7px 13px 7px 13px; border: 0; border-radius: 12px; background: white;">

                    <a href="/forgot-password" style="text-decoration: none; color: white;"><p style="font-size: 14px; color: white; text-align: right;">Forgot Password?</p></a>

                    <x-auth-validation-errors class="mb-4" :errors="$errors"/>

                    <div style="width: 40rem;">
                        <div style="width: 55px; height: 55px; margin: 40px auto 0 auto;">
                            <input type="submit" value="" style="width: 55px; height: 55px; background: transparent; border: 0; position: absolute; z-index: 200;">
                            <img alt="logo" src="/media/login_button.png" style="width: 55px; height: 55px; ">
                        </div>
                    </div>


                    <div style="width: 100%; height: 60px; margin-left: auto; justify-content: center; margin-right: auto; display: flex; align-items: center;">

                    </div>


                </form>
            </div>
        </div>

        <div class="col-md-6" style="position: fixed; top: -20rem; right:5rem; z-index: -1; ">
            <div id="circle" style="position: fixed; height: 100em; z-index: -1; width: 100em; border-radius: 50%; background-color: #3A49A0">

                <div style="width: 45%; position: fixed; top: 26rem; right: 3rem;">
                    <h2 style="text-align: right; font-weight: 600; font-size: 46px; line-height: 44px; color: #ffffff;">Development System</h2>
                    <p style="text-align: right; font-weight: 400; font-size: 26px; line-height: 46px; margin-top: 30px; color: #ffffff;">Not for public use</p>

                    <a href="/register" style="display: none; text-decoration: none;"><div id="signup_button" style="width: 200px; height: 45px; background: white; border-radius: 12px; margin: 0 auto 0 auto; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
                        <p style="font-size: 20px; font-weight: 500; color: #030B51; text-align: center; padding-top: 9px;">Sign up today!</p>
                    </div></a>

                </div>


            </div>
        </div>
    </div>

</div>

</body>
<style>
    body {
        font-family: 'Jost', sans-serif;
    }

    #signup_button:hover{transform: scale(1.02); box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;}

    #login_button {
        width: 120px;
        height: 35px;
        background: #0078D3;

        border: 0;
        color: white;
        font-size: 16px;

    }

    #login_button:hover {
        background: #006ec1;
    }

    input:focus {
        outline: none;
    }

</style>
</html>
