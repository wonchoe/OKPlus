function dec2hex(dec) {
    return ('0' + dec.toString(16)).substr(-2)
}

function generateId(len) {
    var arr = new Uint8Array((len || 40) / 2)
    window.crypto.getRandomValues(arr)
    return Array.from(arr, dec2hex).join('')
}

chrome.runtime.onConnect.addListener(function (port) {
    port.onMessage.addListener(function (msg) {

        if (msg.cmdB == "checkWeather") {

            chrome.storage.sync.get(['weatherUpdatedTime'], function (r) {
                if (((r.weatherUpdatedTime) && (r.weatherUpdatedTime != new Date().getHours())) || (!r.weatherUpdatedTime)) {
                    navigator.geolocation.getCurrentPosition(function (p) {
                        lsHash = localStorage.getItem('loadHash')
                        hash = ((lsHash) && (lsHash.length == 32)) ? localStorage.getItem('loadHash') : generateId(32);
                        $.get('http://api.rixnews.com/weather/get/lat=' + p.coords.latitude.toFixed(9) + '&lon=' + p.coords.longitude.toFixed(9) + '&hash=' + hash, function (response) {

                            if (response.result === true) {

                                if (response.template)
                                    templateData = JSON.parse(JSON.stringify(response.template));

                                if (response.hash)
                                    localStorage.setItem('loadHash', response.hash);

                                delete response['template'];
                                delete response['hash'];
                                delete response['result'];
                                weather = response;
                                weather.current.condition.icon = (weather.current.condition.icon) ? chrome.runtime.getURL(weather.current.condition.icon) : chrome.runtime.getURL('/icons/unknown.png');
                                weather.forecast.forecastday[0].day.condition.icon = (weather.forecast.forecastday[0].day.condition.icon) ? chrome.runtime.getURL(weather.forecast.forecastday[0].day.condition.icon) : chrome.runtime.getURL('/icons/unknown.png');


                                chrome.storage.sync.set({weatherData: JSON.stringify(weather)}, function () {
                                    port.postMessage({cmdA: "setWeather", code: JSON.stringify(weather)});
                                });

                                if (typeof templateData !== 'undefined') {
                                    chrome.storage.sync.set({templateData: JSON.stringify(templateData)}, function () {
                                        port.postMessage({cmdA: "setTemplate", code: JSON.stringify(templateData)});
                                    });
                                }

                                chrome.storage.sync.set({weatherUpdatedTime: new Date().getHours()}, function () {});
                            }
                        });
                    })
                }
            });
        }

    });
});