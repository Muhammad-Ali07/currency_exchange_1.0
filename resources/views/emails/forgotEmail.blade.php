<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <style>
        /* Base */

        body, body *:not(html):not(style):not(br):not(tr):not(code) {
            font-family: Avenir, Helvetica, sans-serif;
            box-sizing: border-box;
        }

        body {
            background-color: #f5f8fa;
            color: #74787e;
            height: 100%;
            hyphens: auto;
            line-height: 1.4;
            margin: 0;
            -moz-hyphens: auto;
            -ms-word-break: break-all;
            width: 100% !important;
            -webkit-hyphens: auto;
            -webkit-text-size-adjust: none;
            word-break: break-all;
            word-break: break-word;
        }

        p,
        ul,
        ol,
        blockquote {
            line-height: 1.4;
            text-align: left;
        }

        a {
            color: #3869d4;
        }

        a img {
            border: none;
        }

        /* Typography */

        h1 {
            color: #2F3133;
            font-size: 19px;
            font-weight: bold;
            margin-top: 0;
            text-align: left;
        }

        h2 {
            color: #2F3133;
            font-size: 16px;
            font-weight: bold;
            margin-top: 0;
            text-align: left;
        }

        h3 {
            color: #2F3133;
            font-size: 14px;
            font-weight: bold;
            margin-top: 0;
            text-align: left;
        }

        p {
            color: #74787e;
            font-size: 16px;
            line-height: 1.5em;
            margin-top: 0;
            text-align: left;
        }

        p.sub {
            font-size: 12px;
        }

        img {
            max-width: 100%;
        }

        /* Layout */

        .wrapper {
            background-color: #f5f8fa;
            margin: 0;
            padding: 0;
            width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;
        }

        .content {
            margin: 0;
            padding: 0;
            width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;
        }

        /* Header */

        .header {
            padding: 10px 0;
            text-align: center;
        }
        .header img.logo{
            max-width: 100%;
            height: 100px;
            max-height: 100px;
            width: 200px;
            -premailer-width: 200px;
            -premailer-height: 100px;
        }

        /* Body */

        .body {
            background-color: #ffffff;
            border-bottom: 1px solid #edeff2;
            border-top: 1px solid #edeff2;
            margin: 0;
            padding: 0;
            width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;
        }

        .su-inner-body {
            background-color: #ffffff;
            margin: 0 auto;
            padding: 0;
            width:100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;
        }

        /* Subcopy */

        .subcopy {
            border-top: 1px solid #edeff2;
            margin-top: 25px;
            padding-top: 25px;
        }

        .subcopy p {
            font-size: 12px;
        }

        /* Footer */

        .footer {
            margin: 0 auto;
            padding: 0;
            text-align: center;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
        }

        .footer p {
            color: #aeaeae;
            font-size: 12px;
            text-align: center;
        }

        /* Tables */

        .table table {
            margin: 30px auto;
            width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;
        }

        .table th {
            color: #74787e;
            padding-bottom: 8px;
            text-align: left;
        }

        .table td {
            color: #74787e;
            font-size: 15px;
            line-height: 18px;
            padding: 10px 0;
        }
        td{
            font-family: Avenir, Helvetica, sans-serif;
            box-sizing: border-box;
        }
        .content-cell {
            padding: 35px;
        }
        .border-bottom {
            border-bottom: 1px solid #edeff2;
        }
        /* Buttons */

        .action {
            margin: 30px auto;
            padding: 0;
            text-align: center;
            width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;
        }

        .button {
            border-radius: 3px;
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
            color: #ffffff;
            display: inline-block;
            text-decoration: none;
            -webkit-text-size-adjust: none;
        }

        .button-blue, .button-primary {
            background-color: #3097d1;
            border-top: 10px solid #3097d1;
            border-right: 18px solid #3097d1;
            border-bottom: 10px solid #3097d1;
            border-left: 18px solid #3097d1;
        }

        .button-green, .button-success {
            background-color: #2ab27b;
            border-top: 10px solid #2ab27b;
            border-right: 18px solid #2ab27b;
            border-bottom: 10px solid #2ab27b;
            border-left: 18px solid #2ab27b;
        }

        .button-red, .button-error {
            background-color: #bf5329;
            border-top: 10px solid #bf5329;
            border-right: 18px solid #bf5329;
            border-bottom: 10px solid #bf5329;
            border-left: 18px solid #bf5329;
        }

        /* Panels */

        .panel {
            margin: 0 0 21px;
        }

        .panel-content {
            background-color: #edeff2;
            padding: 16px;
        }

        .panel-item {
            padding: 0;
        }

        .panel-item p:last-of-type {
            margin-bottom: 0;
            padding-bottom: 0;
        }

        /* Promotions */

        .promotion {
            background-color: #FFFFFF;
            border: 2px dashed #9BA2AB;
            margin: 0;
            margin-bottom: 25px;
            margin-top: 25px;
            padding: 24px;
            width: 100%;
            -premailer-cellpadding: 0;
            -premailer-cellspacing: 0;
            -premailer-width: 100%;
        }

        .promotion h1 {
            text-align: center;
        }

        .promotion p {
            font-size: 15px;
            text-align: center;
        }


        @media  only screen and (max-width: 600px) {
            .su-inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media  only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>
</head>
<body>
<table class="wrapper" width="100%"><tr>
        <td>
            <table class="content" width="100%">
                <tr>
                    <td class="header" >
                        <img class="logo" src="https://www.logodesign.net/logo/line-art-house-roof-and-buildings-4485ld.png" alt="Logo">
                    </td>
                </tr>
                <tr>
                    <td class="body" width="100%">
                        <table class="su-inner-body" width="100%"><tr>
                                <td class="content-cell">
                                    <h1>Dear {{ $data['name'] }}</h1>
                                    <p>You are receiving this email because we received a password reset request for your account.</p>

                                    <div style="margin:10px; text-align: center">
                                        <a href="{{$data['url']}}" class="button button-primary">Reset Password Link</a>
                                    </div>

                                    <p>Best Regards</p>
                                    <p>KSD Team</p>
                                    <table class="subcopy" width="100%" ><tr><td>
                                                <p>If you need any help or assistance, you can access our support resources below.</p>
                                                <p>info@ksd.com</p>
                                            </td></tr></table>
                                </td>
                            </tr></table>
                    </td>
                </tr>
                <tr><td>
                        <table class="footer"  width="100%"><tr>
                                <td class="content-cell">
                                    <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; line-height: 1.5em; margin-top: 0; color: #aeaeae; font-size: 12px; text-align: center;">
                                        ©{{date('Y')}} {{ config('constants.project_name') }}. All rights reserved.</p>
                                </td>
                            </tr></table>
                    </td></tr>
            </table>
        </td>
    </tr></table>
</body>
</html>




