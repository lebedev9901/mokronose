<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'МокроНос' }}</title>
</head>
<body style="margin:0;padding:0;background:#FAF7F2;font-family:Arial,sans-serif;color:#2c241d;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#FAF7F2;padding:30px 0;">
    <tr>
        <td align="center">

            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:18px;overflow:hidden;">

                <tr>
                    <td style="background:#A86E2C;padding:25px;text-align:center;color:#fff;">
                        <h1 style="margin:0;font-size:28px;">МокроНос</h1>
                        <p style="margin:8px 0 0;">Натуральные лакомства для собак</p>
                    </td>
                </tr>

                <tr>
                    <td style="padding:30px;">
                        @yield('content')
                    </td>
                </tr>

                <tr>
                    <td style="background:#2c241d;color:#fff;padding:20px;text-align:center;font-size:14px;">
                        <p style="margin:0 0 8px;">+7 (977) 291-47-61</p>
                        <p style="margin:0 0 8px;">mokronose@mail.ru</p>
                        <p style="margin:0;">© {{ date('Y') }} МокроНос</p>
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>