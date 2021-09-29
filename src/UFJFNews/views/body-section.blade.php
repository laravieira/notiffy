<tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
    <td width="100%" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
      <table width="100%" role="presentation" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
        <!-- Section Header -->
        <tr class="section-header" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
          <td style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
            <div style="Margin:0px;padding:0px;z-index:1;position:relative;margin-right:-10px;width:10px;height:114px;background-color:#A6333D;"></div>
          </td>
          <td width="100%" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
            <center style="Margin:0px;padding:0px;z-index:1;position:relative;">
              <table width="600" heigth="114" role="presentation" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
                <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
                  <td valign="center" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;"><img height="90" src="{{$group->icon}}" alt="Icon" style="Margin:0px;padding:0px;z-index:1;position:relative;"></td>
                  <td width="100%" valign="bottom" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
                    <h2 style="Margin:0px;padding:0px;z-index:1;position:relative;font-family:'OCR A Extended', monospace;font-weight:200;Margin-top:45px;Margin-left:15px;font-size:48px;color:#A6333D;">{{$group->name}}</h2>
                  </td>
                </tr>
              </table>
            </center>
          </td>
        </tr>
        <!-- Spacing -->
        <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
          <td height="20" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;"></td>
        </tr>
        <!-- Section Body -->
        <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
          <td style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;"></td>
          <td width="100%" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;"><center style="Margin:0px;padding:0px;z-index:1;position:relative;">
              <table width="600" role="presentation" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
                <!-- Posts -->
                @foreach ($group->extract->posts() as $post)
                    @if ($post->new)
                        @include('body-post')
                    @endif
                @endforeach
              </table>
            </center></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;">
    <td height="150" style="Margin:0px;padding:0px;z-index:1;position:relative;border-spacing:0px;border-collapse:collapse;border:none;"><!-- Spacing -->
    </td>
  </tr>