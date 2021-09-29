<!DOCTYPE html>
<html lang="en" style="Margin:0px;padding:0px;z-index:1;position:relative;">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notiffy | Fail Log</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap">
    <style>
      a:visited{font-family:'Open Sans', sans-serif;color:#0D0D0D}
      a:hover{color:#A6333D}
      a:focus{color:#A6333D}
    </style>
    <style type="text/css">
      @font-face {
          font-family: 'OCR A Extended';
          src: url('https://notiffy.laravieira.me/assets/ocr-a-extended.ttf') format('truetype');
      }
      /* General pre-sets */
    </style>
  </head>
  <body style="Margin:0px;padding:0px;z-index:1;position:relative;max-width:800px;">
    <table width="100%" role="presentation" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
      <!-- Header -->
      <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
        <td width="100%" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
          <table width="100%" role="presentation" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
            <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
              <td style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;background-color:#BFBFBF;"></td>
              <td width="30" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;background-color:#BFBFBF;"></td>
              <td width="10" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;"></td>
              <td width="560" height="100" valign="bottom" style="vertical-align:bottom;Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
                <h1 style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'OCR A Extended', monospace;font-weight:200;color:#731616;">Notiffy</h1>
                <h2 style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'OCR A Extended', monospace;font-weight:200;">Fail Log</h2>
              </td>
              <td style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;"></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
        <td height="50" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;"><!-- Spacing -->
        </td>
      </tr>
      <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
        <td width="100%" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
          <table width="100%" role="presentation" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
            @foreach($logs as $line)
                <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
                <td style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;background-color:#BFBFBF;"></td>
                <td width="30" height="18" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;background-color:#BFBFBF;vertical-align:top;" valign="top">
                    <p style="Margin:2px;padding:0px;z-index:1;position:relative;font-size:15px;font-family:'Open Sans', sans-serif;color:#0D0D0D;text-align:right;font-family:'OCR A Extended', monospace;font-weight:200;color:#731616;">
                        @if ($loop->iteration < 10)
                            0{{$loop->iteration}}.
                        @else
                            {{$loop->iteration}}.
                        @endif
                    </p>
                </td>
                <td width="10" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;background-color:#F3F3F3;"></td>
                <td width="560" height="18" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;background-color:#F3F3F3;">
                    <div style="Margin:0px;padding:0px;z-index:1;position:relative;width:560px;word-wrap: break-word;">
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-size:14px;font-family:'Open Sans', sans-serif;color:#0D0D0D;">
                        @foreach(str_split($line, 80) as $line)
                            {{$line}}<br>
                        @endforeach
                    </p>
                    </div>
                </td>
                <td style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;"></td>
                </tr>
            @endforeach
          </table>
        </td>
      </tr>
      <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
        <td height="50" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;"><!-- Spacing -->
        </td>
      </tr>
      <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
        <td width="100%" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
          <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;width:100%;text-align:right;">2019 - {{date('Y')}} | &copy; <a href="{{UFJFNews\UFJFNews::LARA_SITE[1]}}" style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;">Lara Vieira</a></p>
        </td>
      </tr>
    </table>
  </body>
</html>
