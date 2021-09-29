<td style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
    <a href="{{$calendar->link}}" title="{{$calendar->description}}" target="_blank" style="Margin:0px;padding:0px;z-index:1;position:relative;text-decoration:none;">
        <table width="176" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;width:176px;">
            <tr bgcolor="#F3F3F3" style="background-color:#F3F3F3;Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;text-align:center;width:100%;">
                <td height="36" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;text-align:center;width:100%;"></td>
            </tr>
            <tr bgcolor="#F3F3F3" style="background-color:#F3F3F3;Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;text-align:center;width:100%;">
                <td style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;text-align:center;width:100%;">
                    <a href="{{$calendar->link}}" title="{{$calendar->description}}" target="_blank" style="Margin:0px;padding:0px;z-index:1;position:relative;text-decoration:none;">
                        <img height="78" src="https://notiffy.laravieira.me/assets/ufjf_calendar/event.png" alt="Icon" style="Margin:0px;padding:0px;z-index:1;position:relative;">
                    </a>
                </td>
            </tr>
            <tr bgcolor="#F3F3F3" style="background-color:#F3F3F3;Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;text-align:center;width:100%;">
                <td height="33" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;text-align:center;width:100%;"></td>
            </tr>

            @if($calendar->new)
                <tr bgcolor="#A6333D" style="background-color:#A6333D;Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;text-align:center;width:100%;">
                    <td height="10" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;text-align:center;width:100%;"></td>
                </tr>
            @else
                <tr bgcolor="#F3F3F3" style="background-color:#F3F3F3;Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;text-align:center;width:100%;">
                    <td height="10" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;text-align:center;width:100%;"></td>
                </tr>
            @endif

            <tr bgcolor="#BFBFBF" style="background-color:#BFBFBF;Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;text-align:center;width:100%;">
                <td style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;text-align:center;width:100%;">
                    <a href="{{$calendar->link}}" title="{{$calendar->description}}" target="_blank" style="Margin:0px;padding:0px;z-index:1;position:relative;text-decoration:none;">
                        <h2 style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;font-weight:400;text-align:center;width:100%;font-size:16px;color:#8C0404;">{{$calendar->title}}</h2>
                    </a>
                </td>
            </tr>
            <tr bgcolor="#BFBFBF" style="background-color:#BFBFBF;Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;text-align:center;width:100%;">
                <td height="10" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;text-align:center;width:100%;"></td>
            </tr>
            <tr bgcolor="#BFBFBF" style="background-color:#BFBFBF;Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;text-align:center;width:100%;">
                <td style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;text-align:center;width:100%;">
                    <a href="{{$calendar->link}}" title="{{$calendar->description}}" target="_blank" style="Margin:0px;padding:0px;z-index:1;position:relative;text-decoration:none;">
                        <h2 style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;font-weight:200;text-align:center;width:100%;font-size:14px;color:#0D0D0D;">{{$calendar->date->format('d/m/Y')}}</h2>
                    </a>
                </td>
            </tr>
        </table>
    </a>
</td>