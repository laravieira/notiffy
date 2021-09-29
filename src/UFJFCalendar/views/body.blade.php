<!DOCTYPE html>
<html lang="pt-br" style="Margin:0px;padding:0px;z-index:1;position:relative;">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{UFJFCalendar\UFJFCalendar::NAME}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap">
    <style>
      a:visited{font-family:'Open Sans', sans-serif;color:#0D0D0D}
      a:hover{color:#A6333D}
      a:focus{color:#A6333D}
      .post-footer a:hover h4.button{font-size:15px;color:#0D0D0D}
      .post-footer a:focus h4.button{font-size:15px;color:#0D0D0D}
    </style>
    <style type="text/css">
      @font-face {
          font-family: 'OCR A Extended';
          src: url('https://notiffy.laravieira.me/assets/ufjf_calendar/ocr-a-extended.ttf') format('truetype');
      }
    </style>
  </head>
  <body style="Margin:0px;padding:0px;z-index:1;position:relative;max-width:800px;">
    <table width="100%" role="presentation" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
      <!-- Header -->
      <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
        <td width="100%" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
          <table width="100%" role="presentation" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
            <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
              <td width="50%" height="100%" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;background-color:#BFBFBF;">
                <table width="100%" role="presentation" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
                  <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
                    <td width="100%" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;"></td>
                    <td height="128" valign="center" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
                      <div style="Margin:0px;padding:0px;z-index:1;position:relative;Margin-right:15px;">
                        <img height="88" src="https://notiffy.laravieira.me/assets/ufjf_calendar/logo.png" alt="UFJF Logo" style="Margin:0px;padding:0px;z-index:1;position:relative;">
                      </div>
                    </td>
                  </tr>
                </table>
              </td>
              <td width="50%" height="100%" valign="bottom" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
                <h1 style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'OCR A Extended', monospace;font-weight:200;Margin-left:15px;font-size:48px;color:#A6333D;">Calendar</h1>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
        <td height="100" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;"><!-- Spacing -->
        </td>
      </tr>
      
      <!-- Calendars -->
      <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
        <td width="100%" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
            <center style="Margin:0px;padding:0px;z-index:1;position:relative;">
            <table width="600" role="presentation" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
              @foreach(array_chunk($calendars, 3) as $lines)
                @if($loop->index*3 < UFJFCalendar\UFJFCalendar::SHOW)
                    <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
                        @foreach($lines as $calendar)
                            @include('calendar')
                        @endforeach
                    </tr>
                @endif
                <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
                  <td height="20" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;"><!-- Spacing --></td>
                </tr>
              @endforeach
            </table>
            </center>
        </td>
        </tr>

      <!-- Footer -->
      <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
        <td width="100%" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;background-color:#BFBFBF;">
          <center style="Margin:0px;padding:0px;z-index:1;position:relative;">
            <table width="600" class="footer" role="presentation" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
              <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
                <td colspan="7" height="30" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;"></td>
              </tr>
              <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
                <td width="137" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
                  <div style="Margin:0px;padding:0px;z-index:1;position:relative;height:100%;">
                    <h4 style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'OCR A Extended', monospace;font-weight:200;font-size:16px;color:#731616;">Referências</h4>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;">&nbsp;</p>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;"><a target="_black" href="{{UFJFCalendar\UFJFCalendar::REF_CDARA[1]   }}" style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;">{{UFJFCalendar\UFJFCalendar::REF_CDARA[0]   }}</a></p>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;"><a target="_black" href="{{UFJFCalendar\UFJFCalendar::REF_PROGRAD[1] }}" style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;">{{UFJFCalendar\UFJFCalendar::REF_PROGRAD[0] }}</a></p>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;">&nbsp;</p>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;">&nbsp;</p>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;">&nbsp;</p>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;">&nbsp;</p>
                  </div>
                </td>
                <td width="17" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;"></td>
                <td width="137" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
                  <div style="Margin:0px;padding:0px;z-index:1;position:relative;height:100%;">
                    <h4 style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'OCR A Extended', monospace;font-weight:200;font-size:16px;color:#731616;">Notiffy</h4>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;">&nbsp;</p>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;">{{Notiffy\Notiffy::NAME.' '.Notiffy\Notiffy::VERSION}}</p>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;"><a target="_black" href="{{Notiffy\Notiffy::PAGE}}" style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;">Home Page</a></p>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;"><a target="_black" href="{{Notiffy\Notiffy::UNSUBSCRIBE}}" style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;">Desinscrever</a></p>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;"><a target="_black" href="{{Notiffy\Notiffy::GITHUB}}" style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;">GitHub</a></p>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;">&nbsp;</p>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;">&nbsp;</p>
                  </div>
                </td>
                <td width="17" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;"></td>
                <td width="137" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
                  <div style="Margin:0px;padding:0px;z-index:1;position:relative;height:100%;">
                    <h4 style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'OCR A Extended', monospace;font-weight:200;font-size:16px;color:#731616;">Lara Vieira</h4>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;">&nbsp;</p>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;"><a target="_black" href="{{UFJFCalendar\UFJFCalendar::LARA_SITE[1]    }}" style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;">{{UFJFCalendar\UFJFCalendar::LARA_SITE[0]    }}</a></p>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;"><a target="_black" href="{{UFJFCalendar\UFJFCalendar::LARA_FACEBOOK[1]}}" style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;">{{UFJFCalendar\UFJFCalendar::LARA_FACEBOOK[0]}}</a></p>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;"><a target="_black" href="{{UFJFCalendar\UFJFCalendar::LARA_GITHUB[1]  }}" style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;">{{UFJFCalendar\UFJFCalendar::LARA_GITHUB[0]  }}</a></p>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;"><a target="_black" href="{{UFJFCalendar\UFJFCalendar::LARA_MYSIGA[1]  }}" style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;">{{UFJFCalendar\UFJFCalendar::LARA_MYSIGA[0]  }}</a></p>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;">&nbsp;</p>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;">&nbsp;</p>
                  </div>
                </td>
                <td width="17" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;"></td>
                <td width="137" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
                  <div style="Margin:0px;padding:0px;z-index:1;position:relative;height:100%;">
                    <h4 style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'OCR A Extended', monospace;font-weight:200;font-size:16px;color:#731616;">Considere</h4>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;">&nbsp;</p>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;"><a target="_black" href="{{UFJFCalendar\UFJFCalendar::MORE_SIGA[1]      }}" style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;">{{UFJFCalendar\UFJFCalendar::MORE_SIGA[0]      }}</a></p>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;"><a target="_black" href="{{UFJFCalendar\UFJFCalendar::MORE_MOODLE[1]    }}" style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;">{{UFJFCalendar\UFJFCalendar::MORE_MOODLE[0]    }}</a></p>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;"><a target="_black" href="{{UFJFCalendar\UFJFCalendar::MORE_APP_BUSTIC[1]}}" style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;">{{UFJFCalendar\UFJFCalendar::MORE_APP_BUSTIC[0]}}</a></p>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;"><a target="_black" href="{{UFJFCalendar\UFJFCalendar::MORE_APP_SIGA[1]  }}" style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;">{{UFJFCalendar\UFJFCalendar::MORE_APP_SIGA[0]  }}</a></p>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;"><a target="_black" href="{{UFJFCalendar\UFJFCalendar::MORE_APP_MOODLE[1]}}" style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;">{{UFJFCalendar\UFJFCalendar::MORE_APP_MOODLE[0]}}</a></p>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;"><a target="_black" href="{{UFJFCalendar\UFJFCalendar::MORE_APP_UFJF[1]  }}" style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;">{{UFJFCalendar\UFJFCalendar::MORE_APP_UFJF[0]  }}</a></p>
                  </div>
                </td>
              </tr>
              <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
                <td colspan="7" height="30" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;"></td>
              </tr>
              <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
                <td colspan="7" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;"><center style="Margin:0px;padding:0px;z-index:1;position:relative;">
                    <h4 style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'OCR A Extended', monospace;font-weight:200;font-size:16px;color:#731616;">Demais Informações</h4>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;">&nbsp;</p>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;">Informações obtidas automaticamente dos sites de UFJF.</p>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;">Este e-mail não é monitorado, favor não responder.</p>
                    <p style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;height:17px;font-size:12px;">2019 - {{date('Y')}} | Lara Vieira © Todos os direitos reservados.</p>
                  </center></td>
              </tr>
              <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
                <td colspan="7" height="30" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;"></td>
              </tr>
            </table>
          </center>
        </td>
      </tr>
    </table>
  </body>
</html>