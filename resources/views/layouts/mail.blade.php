<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="x-apple-disable-message-reformatting">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
  <!--[if mso]>
  <xml>
  <o:OfficeDocumentSettings>
    <o:PixelsPerInch>96</o:PixelsPerInch>
  </o:OfficeDocumentSettings>
  </xml>
  <![endif]-->
  <style>a,div,h1,h2,h3,h4,h5,h6,p,td,th{font-family:"Segoe UI",sans-serif;mso-line-height-rule:exactly}.bg-button-active{background-color:#13aa6a!important}.text-input-active{color:#30302f!important}@media (max-width:600px){.sm-inline-block{display:inline-block!important}.sm-hidden{display:none!important}.sm-justify-center{justify-content:center!important}.sm-text-sm{font-size:14px!important}.sm-text-3xl{font-size:30px!important}.sm-leading-36{line-height:36px!important}.sm-my-16{margin-top:16px!important;margin-bottom:16px!important}.sm-ml-0{margin-left:0!important}.sm-mt-8{margin-top:8px!important}.sm-mb-12{margin-bottom:12px!important}.sm-mt-16{margin-top:16px!important}.sm-mb-16{margin-bottom:16px!important}.sm-mt-20{margin-top:20px!important}.sm-mt-28{margin-top:28px!important}.sm-mb-32{margin-bottom:32px!important}.sm-px-0{padding-left:0!important;padding-right:0!important}.sm-py-20{padding-top:20px!important;padding-bottom:20px!important}.sm-px-24{padding-left:24px!important;padding-right:24px!important}.sm-pb-8{padding-bottom:8px!important}.sm-pt-20{padding-top:20px!important}.sm-pb-24{padding-bottom:24px!important}.sm-text-center{text-align:center!important}.sm-w-full{width:100%!important}}</style>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/mail.css') }}">

</head>
<body style="margin: 0; padding: 0; width: 100%; word-break: break-word; -webkit-font-smoothing: antialiased; background-color: #f3f4f6;">
<div role="article" aria-roledescription="email" aria-label="Magic link email" lang="en">
  <table style="font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'; width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
      <td align="center" class="sm-px-24" style="background-color: #f3f4f6;">
        <table class="sm-w-full" cellpadding="0" cellspacing="0" role="presentation">
          <tr>
            <td class="sm-px-0 sm-py-20" style="background-color: #ffffff; padding-top: 24px; padding-bottom: 24px; padding-left: 44px; padding-right: 44px; text-align: left; width: 100%;">
              <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                  <td class="sm-pt-20 sm-pb-24" style="background-color: #ffffff; border-radius: 4px; padding-top: 24px; padding-bottom: 28px;">
                    @yield('content')
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</div>
</body>
</html>
