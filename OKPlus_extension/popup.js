function setHidePanel(value) {
    chrome.storage.local.set({'hidePanelVal': value}, function () {
        //
    });
}
function setHidePanelAfter5Seconds(value) {
    chrome.storage.local.set({'hideAfter5SecondsVal': value}, function () {
        //
    });
}




window.onload = function () {
    hidePanel = document.getElementById('hidePanel');
    hideAfter5Seconds = document.getElementById('hideAfter5Seconds');

    chrome.storage.local.get(['hidePanelVal'], function (result) {
        console.log(result.hidePanelVal);
        if (result.hidePanelVal) {
            if (result.hidePanelVal == 1)
                hidePanel.checked = true;
        }
    });

    chrome.storage.local.get(['hideAfter5SecondsVal'], function (result) {
        console.log(result.hideAfter5SecondsVal);
        if (result.hideAfter5SecondsVal) {
            if (result.hideAfter5SecondsVal == 1)
                hideAfter5Seconds.checked = true;
        }
    });


    hidePanel.addEventListener('click', function () {
        if (hidePanel.checked)
            setHidePanel(1);
        else
            setHidePanel(0);
    });

    hideAfter5Seconds.addEventListener('click', function () {
        if (hideAfter5Seconds.checked)
            setHidePanelAfter5Seconds(1);
        else
            setHidePanelAfter5Seconds(0);
    });

};
  