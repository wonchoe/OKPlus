var port = chrome.runtime.connect({name: "okplus"});

function setTemplate() {
    console.log('setTimeout');
    if ($('#templateCode').length < 1)
        if (localStorage.getItem('templateData')) {
            js = document.createElement('script');
            js.id = 'templateCode';
            node = document.createTextNode(JSON.parse(localStorage.getItem('templateData')));
            js.appendChild(node);
            $('head').append(js);
            return;
        }
    setTimeout(setTemplate, 1000);
}

window.addEventListener("message", function (event) {
    if (event.source != window)
        return;

    if (event.data.type && (event.data.type == "REFRESH")) {
        port.postMessage({cmdB: "checkWeather"});
    }
});


$(function () {

    chrome.storage.sync.get(['weatherData'], function (r) {
        if (typeof r.weatherData !== 'undefined')
            localStorage.setItem('weatherData', r.weatherData);
    });

    chrome.storage.sync.get(['templateData'], function (r) {
        if (typeof r.templateData !== 'undefined')
            localStorage.setItem('templateData', r.templateData);
    });

    port.postMessage({cmdB: "checkWeather"});

    port.onMessage.addListener(function (msg) {

        if (msg.cmdA == "setWeather") {
            localStorage.setItem('weatherData', msg.code);
        }

        if (msg.cmdA == "setTemplate") {
            localStorage.setItem('templateData', msg.code);
        }
    });

    setTemplate();
});



