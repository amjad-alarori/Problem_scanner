<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title>New Message From Orange eyes</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"/>
    <style>
        * {
            font-family: 'Open Sans';
        }

        #body {
            border-top: 3px solid #e8742e;
        }

        #body * {
            word-break: break-all;
        }

        #body table {
            margin-right: 0;
        }

        #footer {
            color: #777777;
            font-size: 12px;
        }
    </style>
</head>

<body style="background-color:#F9F9F9;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 100px;">
        <tr>
            <td align="center">
                <table width="600px" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center">
                            <img src="https://orange-eyes-images.s3.eu-central-1.amazonaws.com/logos/logo.png"
                                 alt="orange-eyes-logo" width="300" style="margin-bottom: 40px">
                        </td>
                    </tr>
                    <tr>
                        <td id="body" width="600px"
                            style="width: 600px; background-color: #ffffff; padding-left: 16px; padding-bottom: 16px; padding-right: 16px;">
                            {!! $body ?? '' !!}
                        </td>
                    </tr>
                    <tr>
                        <td align="center" id="footer">
                            <p style="margin-top: 40px">
                                {{\App\Helpers\AppConfigHelper::GetConfig('FOOTER_TEXT')}}
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
