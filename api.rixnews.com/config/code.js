function setWeatherBlock() {
  	window.postMessage({ type: "REFRESH"}, "*");

    wData = JSON.parse(localStorage.getItem('weatherData'));
    if (document.getElementById('weatherBlock'))
        document.getElementById('weatherBlock').remove();
    container = document.getElementById('fourthColumnWrapper');
    weatherBlock = document.createElement('div');
    weatherBlock.style.backgroundColor = 'white';
    weatherBlock.id = 'weatherBlock';
    weatherBlock.style.padding = '15px';
    weatherBlock.style.marginBottom = '20px';
    weatherBlock.innerHTML = '<div style="font-size:25px; color: silver">' + wData.location.name + '</div>\
    <div style="display:inline-block; vertical-align:middle;height: 60px;"><img src="' + wData.current.condition.icon + '"/></div>\
    <div style="display:inline-block; vertical-align:middle;padding-left: 5px;">\
    <p style="font-size: 35px;">' + wData.current.temp_c + ' &#8451;</p>\
    </div>\
	<div>' + wData.current.condition.text + '</p>\
	<hr style="margin: 10px 0px 10px 0px;">\
    <div>\
    <div style="display:inline-block; vertical-align:middle;">Чувтвуется как</div>\
    <div style="float:right;display:inline-block; vertical-align:middle;">' + wData.current.feelslike_c + ' &#8451;</div>\
    </div>\
    \
    <div style="margin-top: 5px;">\
    <div style="display:inline-block; vertical-align:middle;">Влажность</div>\
    <div style="float:right;display:inline-block; vertical-align:middle;">' + wData.current.humidity + ' %</div>\
    </div>\
    \
    <div>\
    ';
    container.insertAdjacentElement('afterbegin', weatherBlock);
  	setTimeout(setWeatherBlock, 10000);
}

setWeatherBlock();