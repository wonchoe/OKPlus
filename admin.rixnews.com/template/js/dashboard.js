function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

$().ready(function ()
{
    $('#loader-1').hide();
    $(document).ajaxStart(function () {
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