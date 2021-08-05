@extends('master2', ['menu_group' => 'SetupApp', 'slug' => "SetupApp", 'page_title' => "Desktop Application"])
@section('content')


<div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
    <div class="widget widget-content-area br-4">
        <div class="widget-one">

            <h5 style="margin-top: 5px;">Install the relevent below application for your computer</h5>
            <p style="font-size: 17px; margin-top: 15px;">Conversix desktop application is a small agent that collects information via Sales Navigator using your computer. Everything is managed via the Conversix portal and the desktop application can stay minimised on your computer without causing you any interruptions. Please ensure the application is running when adding new jobs and keep it open for the duration.</p>

            <div style="width: 100%; margin-top: 40px; margin-bottom: 20px; display: flex;">
                <div style="width: 47%; background: white; padding: 10px; border-radius: 8px;">
                    <h4 style="color: #030B51; margin: 20px 0 0 10px;">Windows Installation</h4>
                    <ol style="color: #030B51; font-size: 16px; margin-top: 25px; padding-left: 35px;">
                        <li style="margin-top: 10px;">Ensure you have the latest version of Google Chrome installed. (Version 90)</li>
                        <li style="margin-top: 10px;">Click the download button below and run ConversixInstaller.exe as Administrator.</li>
                        <li style="margin-top: 10px;">Once installed you can open Conversix using the icon on your desktop.</li>
                        <li style="margin-top: 10px;">Copy and paste the below Sync ID into the desktop application to sync with the Conversix platform.</li>
                    </ol>

                    <h4 style="font-size: 18px; color: #030B51; margin: 25px 0 0 10px;">Sync ID:</span> {{ $UserInfo->device_id }}</h4>

                    <a href="{{ $SettingsInfo->windows_url }}"><button class="btn btn-primary" style="width: 200px; font-size: 17px; margin: 25px 0 25px 10px;">Download</button></a>
                </div>

                <div style="width: 47%; background: white; margin-left: 3%; padding: 10px; border-radius: 8px;">
                    <h4 style="color: #030B51; margin: 20px 0 0 10px;">MacOS Installation</h4>
                    <ol style="color: #030B51; font-size: 16px; margin-top: 25px; padding-left: 35px;">
                        <li style="margin-top: 10px;">Ensure you have the latest version of Google Chrome installed. (Version 90)</li>
                        <li style="margin-top: 10px;">Click the download button below. Right click and open ConversixInstaller.pkg.</li>
                        <li style="margin-top: 10px;">Click Okay on the pop-up. Once installed you can open Conversix from Launchpad.</li>
                        <li style="margin-top: 10px;">Copy and paste the below Sync ID into the desktop application to sync with the Conversix platform.</li>
                    </ol>

                    <h4 style="font-size: 18px; color: #030B51; margin: 25px 0 0 10px;">Sync ID:</span> {{ $UserInfo->device_id }}</h4>

                    <a href="{{ $SettingsInfo->mac_url }}"><button class="btn btn-primary" style="width: 200px; font-size: 17px; margin: 25px 0 25px 10px;">Download</button></a>
                </div>

            </div>

            <div style="width: 100%; margin-bottom: 20px; display: flex;">
                <div style="width: 47%;">
                    <h4 style="font-size: 15px; color: rgba(255,255,255,0.5); margin: 15px 0 0 20px; text-decoration: underline;">Requirements</h4>
                    <ul style="color: rgba(255,255,255,0.5); font-size: 15px; margin-top: 10px;">
                        <li style="margin-top: 5px;">Operating System: Windows 7 or Windows 10 (64 bit)</li>
                        <li style="margin-top: 5px;">Disk Space: 300mb available disk space</li>
                        <li style="margin-top: 5px;">Network: Fast Broadband Connection</li>
                    </ul>
                </div>

                <div style="width: 47%; margin-left: 3%;">
                    <h4 style="font-size: 15px; color: rgba(255,255,255,0.5); margin: 15px 0 0 20px; text-decoration: underline;">Requirements</h4>
                    <ul style="color: rgba(255,255,255,0.5); font-size: 15px; margin-top: 10px;">
                        <li style="margin-top: 5px;">Operating System: MacOS Big Sur</li>
                        <li style="margin-top: 5px;">Disk Space: 400mb available disk space</li>
                        <li style="margin-top: 5px;">Network: Fast Broadband Connection</li>
                    </ul>
                </div>

            </div>





        </div>
    </div>
</div>


@endsection
