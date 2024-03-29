var gSCR = (function () {
    const myScreen = {};

    let _screenShot = function() {
        var canvas = $('canvas')[0];
        var data = canvas.toDataURL('image/png').replace(/data:image\/png;base64,/, '');
        _save(canvas);
        $("canvas").remove();
        $.post('https://example.com/calendar/shablons/screen.php', {
            data: data
        }, function(rep){
            alert('Изображение сохранено');
        });
    }

    let _save = function(canvas){
        canvas.toBlob(function (blob) {
            saveAs(blob, "image.png");
        }, "image/png");
        window.location.href = canvas.toDataURL('image/png').replace("image/png", "image/octet-stream");
    }

    myScreen.go = function() {
        html2canvas($('.container'), {
            onrendered: function (canvas) {
                document.body.appendChild(canvas);
                _screenShot();
            }
        });
    }

    let _exportImageLocal = function() {
        html2canvas($('.container'), {
            onrendered: function (canvas) {
                canvas.toBlob(function (blob) {
                    saveAs(blob, "image.png");
                }, "image/png");
                window.location.href = canvas.toDataURL('image/png').replace("image/png", "image/octet-stream");
            }
        });
    }

    myScreen.exportImage = function(selector) {
        html2canvas(document.getElementById(selector), {
            onrendered: function (canvas) {
                canvas.toBlob(function (blob) {
                    saveAs(blob, 'calendar_' + Date.now() + '.png');
                }, "image/png");
                window.location.href = canvas.toDataURL('image/png');
            }
        });
    }
    return myScreen;
})();