<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta property="og:url" content="https://notiffy.laravieira.me">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Notiffy">
    <meta property="og:locate" content="pt-br">
    <meta property="og:description" content="Uma pequena newsletter pra te deixar informado.">
    <meta property="og:image" content="https://notiffy.laravieira.me/assets/logo.png">
    <script src="https://www.google.com/recaptcha/enterprise.js"></script>
    <link rel="favicon" href="https://notiffy.laravieira.me/assets/logo.png">
    <link rel="stylesheet" href="/assets/notiffy.css">
    <title>Notiffy</title>
</head>
<body class="light">
    <div class="content">
        <form method="POST" action="subscribe">
            <h1>Notiffy</h1>
            <label for="name">
                <div class="name">
                    <input type="text" title="Digita o nome que vai aparecer quando vc receber os e-mails." name="name" id="name" placeholder="Seu Nome" required="required">
                </div>
            </label>
            <label for="email">
                <div class="email">
                    <input type="email" title="Digita o e-mail no qual vc quer receber a newsletter." name="email" id="email" placeholder="email@exemple.com" required="required">
                </div>
            </label>
            
            <label for="newsletter">
                <div class="select">
                    <select name="newsletter" id="newsletter">
                        <datalist>
                            @foreach ($newsletters as $newsletter)
                                <option title="{{$newsletter['description']}}" id="{{$newsletter['id']}}" value="{{$newsletter['id']}}">{{$newsletter['name']}}</option>
                            @endforeach
                        </datalist>
                    </select>
                </div>
            </label>
            <div class="captcha">
                <div class="g-recaptcha" data-sitekey="6Lcx1dMaAAAAAAJxfxYHmZzm4NYYUQi7Ig0ZDzZI" data-theme="light" id="reCaptcha"></div>
            </div>
            <div class="submit">
                <input type="submit" value="INSCREVER">
            </div>
        </form>
    </div>
    <div class="footer footer-left">
        <p>{{Notiffy\Notiffy::NAME}}&nbsp;{{Notiffy\Notiffy::VERSION}}</p>
    </div>
    <div class="footer footer-right">
        <p>2018 - {{date('Y')}} | &copy; by <a href="https://laravieira.me" title="Vititar página pessoal">Lara Vieira</a>.</p>
    </div>
    <script>
        function changeColorScheme(colorScheme) {
            var recaptcha = document.getElementById('reCaptcha');
            var element = document.body;
            element.classList.toggle(colorScheme);
            recaptcha.setAttribute('data-theme', colorScheme);
        }
        if(window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches)
            changeColorScheme('dark');

        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            changeColorScheme(e.matches?'dark':'light');
        });

        document.getElementById("ufjfnewsletter").setAttribute('selected', 'selected');
    </script>
</body>
</html>