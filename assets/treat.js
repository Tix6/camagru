(function() {

    var parentDiv = document.querySelector('#visu');

    var canvas = document.createElement('canvas');
    var canvasWidth = 640;
    var canvasHeight = 480;

    var ctx = canvas.getContext('2d');

    var image = document.querySelector('#pictureInput');
    var textField = document.querySelector('#textField');
    var stickers = document.querySelector('#stickers');
    var sticker = document.querySelector('#dragItem');
    var ratio = document.querySelector('#ratio');
    var opacity = document.querySelector('#opacity');

    var text = {
        'top': document.getElementById('top-text'),
        'bottom': document.getElementById('bottom-text')
    };

    text.top.addEventListener('change', function(e) {
        e.preventDefault();
        ctx.drawImage(image, 0, 0, canvasWidth, canvasHeight / 2, 0, 0, canvasWidth, canvasHeight / 2);
        ctx.save();
        ctx.font = 'small-caps bold 40px Dosis';
        ctx.textAlign = 'center';
        ctx.fillStyle = 'white';
        ctx.shadowColor = 'black';
        ctx.shadowBlur = 3;
        ctx.shadowOffsetX = 1;
        ctx.shadowOffsetY = 1;
        var x = canvasWidth / 2;
        ctx.fillText(text.top.value, x, 50, canvasWidth - 40);
        putCanvasDataToForm();
        ctx.restore();
    });

    text.bottom.addEventListener('change', function(e) {
        e.preventDefault();
        ctx.drawImage(image, 0, canvasHeight / 2, canvasWidth, canvasHeight / 2, 0, canvasHeight / 2, canvasWidth, canvasHeight / 2);
        ctx.save();
        ctx.font = 'small-caps bold 40px Dosis';
        ctx.textAlign = 'center';
        ctx.fillStyle = 'white';
        ctx.shadowColor = 'black';
        ctx.shadowBlur = 3;
        ctx.shadowOffsetX = 1;
        ctx.shadowOffsetY = 1;
        var x = canvasWidth / 2;
        ctx.fillText(text.bottom.value, x, canvasHeight - 30, canvasWidth - 40);
        putCanvasDataToForm();
        ctx.restore();
    });


    stickers.addEventListener('change', function(e) {
        setSticker();
        e.preventDefault();
    });

    ratio.addEventListener('change', function(e) {
        setSticker();
        e.preventDefault();
    });

    opacity.addEventListener('change', function(e) {
        setSticker();
        e.preventDefault();
    });

    function setSticker() {
        var stickerSelected = stickers.options[stickers.selectedIndex].value;
        sticker.src = stickerSelected;

        var opacitySelected = opacity.options[opacity.selectedIndex].value;
        sticker.style.opacity = opacitySelected;

        var ratioSelected = ratio.options[ratio.selectedIndex].value;
        var image = new Image();
        image.onload = function(){
            sticker.style.width = this.width * ratioSelected + 'px';
        };
        image.src = stickerSelected;
        image = null;

        sticker.style.backgroundColor = 'transparent';
        sticker.style.border = '1px dashed black';
        putStickerDataToForm();
    }

    function setCanvas() {
        canvas.addEventListener('dragover', function(e) {
            e.preventDefault();
        }, false);
        canvas.addEventListener('drop', function(e) {
            e.preventDefault();
            setStickerPos(e.clientX, e.clientY);
        }, false);
        canvas.width = canvasWidth;
        canvas.height = canvasHeight;
        ctx.drawImage(image, 0, 0, canvasWidth, canvasHeight);
        putCanvasDataToForm();
        var callback = (function() { parentDiv.appendChild(canvas) });
        setTimeout(callback, 200);
    }

    function resetCanvas() {
        canvas.width = canvasWidth;
        canvas.height = canvasHeight;
        ctx.fillStyle = 'white';
        ctx.fill();
        putCanvasDataToForm();
    }

    function putCanvasDataToForm() {
        var canvasInputForm = document.querySelector('#inputCanvas');
        canvasInputForm.setAttribute('value', canvas.toDataURL());
    }

    function getStickerPosFromCanvas() {
        var canvasBounds = canvas.getBoundingClientRect();
        var stickerBounds = sticker.getBoundingClientRect();
        var x = stickerBounds.left - canvasBounds.left;
        var y = stickerBounds.top - canvasBounds.top;
        return {x: x, y: y};
    }

    function putStickerDataToForm() {
        var stickerPos = getStickerPosFromCanvas();
        var stickerInputX = document.querySelector('#inputX');
        var stickerInputY = document.querySelector('#inputY');
        var stickerInputRatio = document.querySelector('#inputRatio');
        var stickerInputOpacity = document.querySelector('#inputOpacity');
        var x = (stickerPos.x / canvas.getBoundingClientRect().width) * canvasWidth;
        var y = (stickerPos.y / canvas.getBoundingClientRect().height) * canvasHeight;
        stickerInputX.setAttribute('value', x);
        stickerInputY.setAttribute('value', y);
        stickerInputRatio.setAttribute('value', ratio.options[ratio.selectedIndex].value);
        stickerInputOpacity.setAttribute('value', opacity.options[opacity.selectedIndex].value);
    }

    function setStickerPos(windowX, windowY) {
        var new_x = windowX - (parseInt(sticker.width) / 2);
        var new_y = windowY - (parseInt(sticker.height) / 2);
        sticker.style.left = new_x + 'px';
        sticker.style.top = new_y + 'px';
        setTimeout(correctStickerPos, 300);
    }

    /* like setStickerPos but invoked with timeout to inform user about misplacing sticker */
    function correctStickerPos() {
        var stickerPos = getStickerPosFromCanvas();
        var stickerBounds = sticker.getBoundingClientRect();
        var canvasBounds = canvas.getBoundingClientRect();
        if (stickerPos.x < 0)
            sticker.style.left = canvasBounds.left + 'px';
        else if (stickerPos.x + stickerBounds.width > canvasBounds.width)
            sticker.style.left = canvasBounds.left + canvasBounds.width - stickerBounds.width + 'px';
        if (stickerPos.y < 0)
            sticker.style.top = canvasBounds.top + 'px';
        else if (stickerPos.y + stickerBounds.height > canvasBounds.height)
            sticker.style.top = canvasBounds.top + canvasBounds.height - stickerBounds.height + 'px';
        putStickerDataToForm();
    }

    parentDiv.removeChild(image);
    setCanvas();
    /* firefox draggable compat. */
    sticker.addEventListener('dragstart', function(e) {
        e.dataTransfer.setData('text/plain', '');
        e.dataTransfer.effectAllowed = 'move';
    });
})();
