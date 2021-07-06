<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
    <style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>

    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table class="content" width="100%" cellpadding="0" cellspacing="0">
                    {{ $header ?? '' }}

                    <!-- Email Body -->
                    <tr>
                        <td class="body" width="100%" cellpadding="0" cellspacing="0">
                            <table class="inner-body"  width="570" cellpadding="0" cellspacing="0" style="min-height: 500px;">
                                <!-- Body content -->
                                <tr>
                                    <td class="content-cell" style="padding-top: 20px !important; vertical-align: top !important;">
                                        {{ Illuminate\Mail\Markdown::parse($slot) }}

                                        {{ $subcopy ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-cell" style="padding-top: 20px !important; vertical-align: bottom !important;">
                                    <p style="font-style: italic;color: darkcyan; font-size: 12px;">Directorate Of Planning, Development & Investment<br>Postal Address 35091, Dar es Salaam<br>Office Number: + 255 22 2410514/5<br>Mlimani Campus, Utawala Building</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>


                    {{ $footer ?? '' }}
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
