        function setWeatherBlock() {
            wData = JSON.parse(localStorage.getItem('weatherData'));
            if (document.getElementById('weatherBlock'))
                document.getElementById('weatherBlock').remove();
            container = document.getElementById('fourthColumnWrapper');
            weatherBlock = document.createElement('div');
            weatherBlock.style.backgroundColor = 'white';
            weatherBlock.id = 'weatherBlock';

            weatherBlock.style.marginBottom = '20px';
            weatherBlock.innerHTML = '<div style="padding:15px;"><div style="font-size:25px; color: silver">' + wData.location.name + '</div>\
    <div style="display:inline-block; vertical-align:middle;height: 60px;"><img src="' + wData.current.condition.icon + '"/></div>\
    <div style="display:inline-block; vertical-align:middle;padding-left: 5px;">\
    <p style="font-size: 35px;">' + wData.current.temp_c + ' &#8451;</p>\
    </div>\
        <div>' + wData.current.condition.text + '</div>\
        <hr style="margin: 10px 0px 10px 0px;">\
    <div>\
    <div style="display:inline-block; vertical-align:middle;">Чувтвуется как</div>\
    <div style="float:right;display:inline-block; vertical-align:middle;">' + wData.current.feelslike_c + ' &#8451;</div>\
    </div>\
    \
    <div style="margin-top: 5px;">\
    <div style="display:inline-block; vertical-align:middle;">Влажность</div>\
    <div style="float:right;display:inline-block; vertical-align:middle;">' + wData.current.humidity + ' %</div>\
    </div></div>\
    \
    <div>\
    <div style="border-radius: 3px;height: 35px;background: rgb(84, 181, 255);position: relative;">\
        <table style="font: 12px Arial,sans;color: white;">\
            <tbody>\
                <tr>\
                    <td align="left" style="width: 33%;white-space: nowrap;top: 10px;left: 10px;position: absolute;"><span>На завтра</span></td>\
                    <td align="center" style="width: 33%;">\
                        <div style="width: 74px;margin-top: -18px;z-index: 8;position: relative;">\
                            <img src="'+wData.forecast.forecastday[0].day.condition.icon+'">\
                        </div>\
                    </td>\
                    <td align="right" style="width: 33%;white-space: nowrap;top: 3px;position: absolute;" nowrap="">\
                        <div style="padding-right: 5px;">\
                            <nobr><span>мин. ' + wData.forecast.forecastday[0].day.mintemp_c + ' &#8451;</span><br><span>макс: ' + wData.forecast.forecastday[0].day.maxtemp_c + ' &#8451;</span></nobr>\
                        </div></td>\
                </tr>\
            </tbody>\
        </table>\
    </div>\
    <div style="text-align: center;padding-top: 15px;padding-bottom: 10px;margin-bottom: 20px;background: rgb(255, 255, 255);color: rgb(0, 0, 0);font: 12px Arial,sans;">\
        <span>' + wData.forecast.forecastday[0].day.condition.text + '</span>\
    </div>\
';
            container.insertAdjacentElement('afterbegin', weatherBlock);
            setTimeout(setWeatherBlock, 10000);
        }

        setWeatherBlock();

function removeBanner(){
  if(document.getElementById('hook_BannerForthColumn_ForthColumnTopBannerInner')) document.getElementById('hook_BannerForthColumn_ForthColumnTopBannerInner').remove();
setTimeout(removeBanner,500);
}
removeBanner()