function changeColorScheme(colorScheme) {
    const recaptcha = document.getElementById('reCaptcha');
    const element = document.body;
    element.classList.toggle(colorScheme);
    recaptcha.setAttribute('data-theme', colorScheme);
}

function get(url) {
    const xmlhttp = new XMLHttpRequest();

    xmlhttp.onerror = function(data) {
        console.error(data);
    }

    xmlhttp.onreadystatechange = function() {
        if(this.response !== null) {
            populateList(this.response);
        }
    };

    xmlhttp.responseType = 'json';
    xmlhttp.open('GET', url, true);
    xmlhttp.send();
}

function populateList(newsletters) {
    const list = document.getElementById("newsletters");
    for (const newsletter in newsletters) {
        const option = document.createElement("option");
        option.setAttribute("title", newsletter.title);
        option.setAttribute("id", newsletter.id);
        option.setAttribute("value", newsletter.id);
        option.text = newsletter.name;

        list.append(option);
    }

    document.getElementById("ufjfnewsletter").setAttribute('selected', 'selected');
}

// Change color scheme of recaptcha
if(window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches)
    changeColorScheme('dark');
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
    changeColorScheme(e.matches?'dark':'light');
});

// Load newsletters list
window.onload = get("https://notiffy.herokuapp.com/newsletters");