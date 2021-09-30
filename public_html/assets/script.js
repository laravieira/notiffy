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
    let list = document.createElement("datalist");
    let first = true;

    for (let newsletter in newsletters) {
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
    }

    let select = document.getElementById("newsletter");
    select.appendChild(list);

}

// Change color scheme of recaptcha
if(window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches)
    changeColorScheme('dark');
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
    changeColorScheme(e.matches?'dark':'light');
});

// Load newsletters list
window.onload = get("https://notiffy.herokuapp.com/newsletters");