var gCl = (function () {
    const myClip = {};

    myClip.copyToClipboard = function (text) {
        if (navigator.clipboard !== undefined) {
            navigator.clipboard.writeText(text)
                .catch(() => {
                    alert("clipboard-write: error");
                });
        } else if (window.clipboardData) {
            window.clipboardData.setData("Text", text);
        }
    }

    myClip.checkPermission = async function (){
        const readPerm = await navigator.permissions.query({
            name: 'clipboard-read', allowWithoutGesture: false
        });
        const writePerm = await navigator.permissions.query({
            name: 'clipboard-write', allowWithoutGesture: false
        });
        alert('permission:\nclipboard-read: ' + readPerm.state + '\nclipboard-write: '+ writePerm.state);
    }

    return myClip;
})();

const gShrd = (function () {
    const myShared = {};

    myShared.refresh = function (timeout) {
        setTimeout(function () {
            window.location.reload()
        }, timeout);
    }

    let _urlWithRndQueryParam = function (url, paramName) {
        const ulrArr = url.split('#');
        const urlQry = ulrArr[0].split('?');
        const usp = new URLSearchParams(urlQry[1] || '');
        usp.set(paramName || '_z', `${Date.now()}`);
        urlQry[1] = usp.toString();
        ulrArr[0] = urlQry.join('?');
        return ulrArr.join('#');
    }

    let _handleHardReload = async function (url) {
        const newUrl = _urlWithRndQueryParam(url);
        await fetch(newUrl, {
            headers: {
                Pragma: 'no-cache',
                Expires: '-1',
                'Cache-Control': 'no-cache',
            },
        });
        window.location.href = url;
        window.location.reload();
    }

    let _handleHardReload2 = function () {
        $.ajax({
            url: window.location.href,
            headers: {
                "Pragma": "no-cache",
                "Expires": -1,
                "Cache-Control": "no-cache"
            }
        }).done(function () {
            window.location.reload(true);
        });
    }

    myShared.checkboxRun = function (elem, cookie_name) {
        let chb = document.getElementById(elem);
        if (chb.checked) document.cookie = cookie_name + " = true";
        else document.cookie = cookie_name + " = false";
        gShrd.refresh(300);
    }

    myShared.cookieExists = function (name) {
        const cks = document.cookie.split(';');
        for(i = 0; i < cks.length; i++)
            if (cks[i].split('=')[0].trim() === name) return true;
    }

    let _getCookieValue = function (name) {
        let cookie = {};
        window.document.cookie.split(';').forEach(function (el) {
            let split = el.split('=');
            cookie[split[0].trim()] = split.slice(1).join("=");
        })
        return cookie[name];
    }

    myShared.readCookie = function (name) {
        let nameEQ = name + "=", ca = document.cookie.split(';');
        for(let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c[0] === ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    myShared.setVisibleUidFromCookie = function (elem, cookie_name, str_uid) {
        const h_elem = document.getElementById(elem);
        const h_elem_pre = document.getElementById(elem + '-pre');
        if(_getCookieValue(cookie_name) === 'true'){
            h_elem.innerHTML = str_uid;
            h_elem.style.display = 'block';
            h_elem_pre.style.display = 'block';
        }else {
            h_elem.style.display = 'none';
            h_elem_pre.style.display = 'none';
        }
    }

    myShared.hideLoadingButtonDivBlock = function (elem, timeout) {
        setTimeout(function(){
            document.getElementById(elem).style.display = 'none';
        }, timeout)
    }

    myShared.showLoadingButtonDivBlock = function (elem) {
        document.getElementById(elem).style.display = 'block';
    }

    myShared.showWidthScreen = function (elem) {
        $(window).resize(function() {
            document.getElementById(elem).innerHTML = window.innerWidth
                || document.documentElement.clientWidth
                || document.body.clientWidth;
        });
    }

    myShared.showWidthScreenAdd = function (elem, show=false) {
        if(show) {
            $(window).resize(function () {
                let wd = window.innerWidth
                    || document.documentElement.clientWidth
                    || document.body.clientWidth;
                document.getElementById(elem).innerHTML = 'Width | ' + wd;
            });
        }
    }

    return myShared;
})();