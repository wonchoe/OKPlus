var isUpdating = false;

function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function drawTotalChart(dates, total, chrome, yandex, amigo) {
    var ctx = document.getElementById('totalChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates,

            datasets: [{
                    label: 'Total',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 199, 132)',
                    data: total,
                    fill: false,
                },
                {
                    label: 'Chrome',
                    backgroundColor: 'rgb(0, 162, 255)',
                    borderColor: 'rgb(255, 255, 0)',
                    data: chrome,
                    fill: false,
                },
                {
                    label: 'Yandex',
                    backgroundColor: 'rgb(190, 0, 0)',
                    borderColor: 'rgb(255, 3, 3)',
                    data: yandex,
                    fill: false,
                },
                {
                    label: 'Amigo',
                    backgroundColor: 'rgb(0, 196, 4)',
                    borderColor: 'rgb(0, 255, 85)',
                    data: amigo,
                    fill: false,
                }
            ]

        },

        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 0
            }
        }
    });
}

function fillTable(dates, total, chrome, yandex, amigo) {
    dates = dates.reverse();
    total = total.reverse();
    chrome = chrome.reverse();
    yandex = yandex.reverse();
    amigo = amigo.reverse();

    $('#tableBody').html('');

    previousTotal = 0;
    cTable = '';
    $.each(dates, function (index, value) {
        sign = '';
        if (index !== 0) {
            sign = (previousTotal > total[index]) ? '<i class="fa fa-arrow-up"></i>' : '<i class="fa fa-arrow-down"></i>';
        }
        if ((index === 0) && (total[index]>total[index+1])) {
            sign = '<i class="fa fa-arrow-up"></i>';
        }
        
        console.log(previousTotal);
        cTable += '<tr>' +
                '<td>' + value + sign + '</td>' +
                '<td>' + total[index] + '</td>' +
                '<td>' + chrome[index] + '</td>' +
                '<td>' + yandex[index] + '</td>' +
                '<td>' + amigo[index] + '</td>' +
                '</tr>';

        previousTotal = JSON.parse(JSON.stringify(total[index]));
    })
    $('#tableBody').append(cTable);

}

function updateInfo() {
    isUpdating = true;
    console.log('updateing');
    $.post('http://api.rixnews.com/analytic/getTotal/count=100', {}, function (response) {
        $('#usersToday').text(response.totalToday);
        $('#usersYesterday').text(response.totalYesterday);

        lastVisit = response.lastVisit;
        lastVisit = lastVisit.split(' ');
        $('#lastVisitDate').text(lastVisit[0]);
        $('#lastVisitTime').text(lastVisit[1]);
        $('#locationCountry').text(response.country);
        $('#locationCity').text(response.city);

        drawTotalChart(response.analyticDates, response.analyticTotal, response.analyticChrome, response.analyticYandex, response.analyticAmigo);
        fillTable(response.analyticDates, response.analyticTotal, response.analyticChrome, response.analyticYandex, response.analyticAmigo);

        console.log(response);
    });
    isUpdating = false;
    setTimeout(updateInfo, 10000);
}


$().ready(function ()
{
    $('#totalChart').css('width', $('.market-updates').width() - 150 + 'px', 'important');
    $('#totalChart').css('height', '400px', 'important');
    updateInfo();

    $('#loader-1').hide();
    $(document).ajaxStart(function () {
        if (!isUpdating)
            $('#loader-1').show();
    });

    $(document).ajaxComplete(function () {
        $('#loader-1').hide();
    });

    jwt = (localStorage.getItem('JWT') !== null) ? localStorage.getItem('JWT') : '';

    $('#logout').click(function () {
        localStorage.removeItem('JWT');
        setCookie('JWT', '', -1);
        location.href = '/';
        return false;
    });

});