let xMsg = (function () {
    const myMsg = {};

    _checkPermission = function (){
        const readPerm = navigator.permissions.query({
            name: 'clipboard-read', allowWithoutGesture: false
        });
        const writePerm = navigator.permissions.query({
            name: 'clipboard-write', allowWithoutGesture: false
        });
        xMsg.alert('permission:<br/>&nbsp;clipboard-read: ' + readPerm.state + '<br/>&nbsp;clipboard-write: ' + writePerm.state);
    }

    let _createCustomAlert = function (txt, title_txt, btn_txt) {
        let doc = document, mObj, alertObj;
        let h1, msg, btn;

        if (doc.getElementById("modalContainer")) return;

        mObj = doc.getElementsByTagName("body")[0].appendChild(doc.createElement("div"));
        mObj.id = "modalContainer";
        mObj.style.height = doc.documentElement.scrollHeight + "px";

        alertObj = mObj.appendChild(doc.createElement("div"));
        alertObj.id = "alertBox";
        if (doc.all && !window.opera) alertObj.style.top = document.documentElement.scrollTop + "px";
        alertObj.style.left = (doc.documentElement.scrollWidth - alertObj.offsetWidth) / 2 + "px";
        alertObj.style.visiblity = "visible";

        h1 = alertObj.appendChild(doc.createElement("h1"));
        h1.appendChild(doc.createTextNode(title_txt));

        msg = alertObj.appendChild(doc.createElement("p"));
        //msg.appendChild(d.createTextNode(txt));
        msg.innerHTML = txt;

        btn = alertObj.appendChild(doc.createElement("a"));
        btn.id = "closeBtn";
        btn.appendChild(doc.createTextNode(btn_txt));
        btn.href = "#";
        btn.focus();
        btn.onclick = function () {
            _removeCustomAlert();
            return false;
        }

        alertObj.style.display = "block";
    }

    let _removeCustomAlert = function () {
        document.getElementsByTagName("body")[0].removeChild(document.getElementById("modalContainer"));
    }

    myMsg.alert = function (txt, title_txt="Внимание!", btn_txt="OK") {
        //txt = myMsg._checkPermission();
        if (document.getElementById) {
            _createCustomAlert(txt, title_txt, btn_txt);
        }
    }

    myMsg.checkPermission = function () {
        const isFirefox = navigator.userAgent.toLowerCase().includes('firefox');
        if (isFirefox) {
            navigator.permissions.query({name: 'notifications', allowWithoutGesture: false})
                .then(function (result) {
                    if (result.state === 'granted') {
                        xMsg.alert('notifications: ' + result.state, 'Permission!', 'OK');
                    } else if (result.state === 'prompt') {
                        xMsg.alert('notifications: ' + result.state, 'Permission!', 'OK');
                    }else if (result.state === 'denied') {
                        xMsg.alert('notifications: ' + result.state, 'Permission!', 'OK');
                    }
                    result.onchange = function () {
                        xMsg.alert('notifications: ' + state, 'Permission!', 'OK');
                    }
                });
        }else{
            navigator.permissions.query({name: 'clipboard-write', allowWithoutGesture: false})
                .then(function (result) {
                    if (result.state === 'granted') {
                        xMsg.alert('clipboard-write: ' + result.state, 'Permission!', 'OK');
                    } else if (result.state === 'prompt') {
                        xMsg.alert('clipboard-write: ' + result.state, 'Permission!', 'OK');
                    } else if (result.state === 'denied') {
                        xMsg.alert('clipboard-write: ' + result.state, 'Permission!', 'OK');
                    }
                    result.onchange = function () {
                        xMsg.alert('clipboard-write: ' + state, 'Permission!', 'OK');
                    }
                });
        }
    }

    let _isFirefox = function () {
        const isFirefox = navigator.userAgent.toLowerCase().includes('firefox');
        if (isFirefox) {
            console.log("Your browser is Firefox");
            return true;
        } else {
            console.log("Your browser is not Firefox");
            return false;
        }
    }

    let _checkBrowser = function () {
        if ((navigator.userAgent.indexOf("Opera") || navigator.userAgent.indexOf('OPR')) !== -1) {
            return 'Opera';
        } else if (navigator.userAgent.indexOf("Edg") !== -1) {
            return 'Edge';
        } else if (navigator.userAgent.indexOf("Chrome") !== -1) {
            return 'Chrome';
        } else if (navigator.userAgent.indexOf("Safari") !== -1) {
            return 'Safari';
        } else if (navigator.userAgent.indexOf("Firefox") !== -1) {
            return 'Firefox';
        } else if ((navigator.userAgent.indexOf("MSIE") !== -1) || (!!document.documentMode === true)) {
            return 'IE';
        } else {
            return 'unknown';
        }
    }

    return myMsg;
})();

let gCopy = (function () {
    const myMsg2 = {};

    let _permissionsCheck = async function () {
        const read = await navigator.permissions.query({
            name: 'clipboard-read',
        });
        const write = await navigator.permissions.query({
            name: 'clipboard-write',
        });
        return write.state === 'granted' && read.state !== 'denied';
    }

    _updateClipboard = async function (content) {
        await navigator.clipboard.writeText(content);
        console.log('Copied links!');
    }

    myMsg2.init = async function (content) {
        try {
            const hasPermissions = await _permissionsCheck();

            if (hasPermissions && document.hasFocus()) {
                _updateClipboard(content);
            } else {
                alert('NOT ALLOWED');
            }
        } catch (err) {
            console.error(err);
        }
    }

    return myMsg2;
})();
