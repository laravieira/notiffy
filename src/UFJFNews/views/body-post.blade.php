<tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
 <td height="30" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;"></td>
</tr>
<tr id="{{$post->id}}" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
    <td style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
        <table width="600" class="post" role="presentation" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;max-height:135px;background-color:#F6F6F6;">
        <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
            @isset($post->tumbnail)
                <td rowspan="5" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
                    <div style="Margin:0px;padding:0px;z-index:1;position:relative;height:135px;"><img width="239" height="135" src="{{$post->tumbnail}}" alt="tumbnail" style="Margin:0px;padding:0px;z-index:1;position:relative;"></div>
                </td>                    
            @endisset
            <td rowspan="5" width="17" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;"></td>
            <td height="3" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;"></td>
            <td rowspan="5" width="4" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;"></td>
        </tr>
        <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;height:fit-content;">
            <td valign="top" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;vertical-align:top;">
            <h3 style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;font-size:14px;font-weight:800;line-height:18px;">{{$post->title}}</h3>
            </td>
        </tr>
        <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;height:fit-content;">
            <td height="16" valign="top" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;vertical-align:top;">
                @isset($post->category)
                    <p class="category" style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;font-size:12px;line-height:16px;">
                        @if(isset($post->category->link))
                            <a href="{{$post->category->link}}" target="_black" style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;">{{$post->category->name}}</a>
                        @else
                            {{$post->category->name}}
                        @endif
                    </p>
                @endisset
            </td>
        </tr>
        <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
            <td style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">&nbsp;</td>
        </tr>
        <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
            <td colspan="2" valign="bottom" height="30" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
            <table width="100%" height="30" class="post-footer" role="presentation" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
                <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
                <td valign="center" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;vertical-align: middle;">
                    <p class="date" style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;font-size:12px;line-height:16px;">{{$post->printDate()}}</p>
                </td>
                <td width="137" height="30" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;"><a href="{{$post->link}}" target="_blank" style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'Open Sans', sans-serif;color:#0D0D0D;text-decoration:none;background-color:#BFBFBF;">
                    <div style="Margin:0px;padding:0px;z-index:1;position:relative;height:8px;width:137px;background-color:#BFBFBF;font-size:4px;">&nbsp;</div>
                    <h4 class="button" style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'OCR A Extended', monospace;font-weight:200;font-size:14px;line-height:14px;color:#731616;background-color:#BFBFBF;width:137px;text-align:center;">Ler Notícia</h4>
                    <div style="Margin:0px;padding:0px;z-index:1;position:relative;height:8px;width:137px;background-color:#BFBFBF;font-size:4px;">&nbsp;</div>
                    </a></td>
                </tr>
            </table>
            </td>
        </tr>
        </table>
    </td>
</tr>