<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://www.google.com/recaptcha/enterprise.js"></script>
    <link rel="shortcut icon" href="https://notiffy.laravieira.me/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://notiffy.laravieira.me/assets/notiffy.css">
    <title>Notiffy</title>
</head>
<body>
    <div class="content">
        <h1>Notiffy</h1>
        <div class="message">
            <p>{{$message}}</p>
        </div>
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
    </script>
</body>
</html>