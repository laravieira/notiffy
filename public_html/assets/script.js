function changeColorScheme(colorScheme) {
    const recaptcha = document.getElementById('reCaptcha');
    const element = document.body;
    element.classList.toggle(colorScheme);
    recaptcha.setAttribute('data-theme', colorScheme);
}

function get(url) {
    let xmlhttp = new XMLHttpRequest();

    xmlhttp.onerror = function(data) {
        console.error(data);
    }

    xmlhttp.onload = function() {
        if(this.readyState === XMLHttpRequest.DONE) {
            populateList(xmlhttp.response);
        }
    };

    xmlhttp.responseType = 'json';
    xmlhttp.open('GET', url, true);
    xmlhttp.send();
}

function populateList(newsletters) {
    let list = document.getElementById("newsletter");
    let first = true;

    newsletters.forEach(function (newsletter) {
        let option = document.createElement("option");
        option.setAttribute("title", newsletter.description);
        option.setAttribute("id", newsletter.id);
        option.setAttribute("value", newsletter.id);
        if(first) {
            first = false;
            option.setAttribute('selected', 'selected');
        }
        option.append(newsletter.name);
        list.appendChild(option);
    });
}

// Change color scheme of recaptcha
if(window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches)
    changeColorScheme('dark');
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
    changeColorScheme(e.matches?'dark':'light');
});

// Load newsletters list
window.onload = get("https://notiffy.herokuapp.com/newsletters");