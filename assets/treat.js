(function() {

    var width = 640;
    var height = 480;

    var parentDiv = document.querySelector('#visu');
    var image = document.querySelector('#pictureInput');
    var canvas = document.createElement('canvas');
    var ctx = canvas.getContext('2d');
    var textField = document.querySelector('#textField');

    var rotateLeftButton = document.getElementById('rotateLeft');
    var rotateRightButton = document.getElementById('rotateRight');
    var cinemaButton = document.getElementById('cinema');
    var stickers = document.querySelector('#stickers');

    rotateLeftButton.addEventListener('click', function(e) {
        rotateCanvas('left');
        e.preventDefault();
    });

    rotateRightButton.addEventListener('click', function(e) {
        rotateCanvas('right');
        e.preventDefault();
    });

    cinemaButton.addEventListener('click', function(e) {
        isCinemaMode = !isCinemaMode;
        cinemaMode();
        e.preventDefault();
    });

    stickers.addEventListener('click', function(e) {
        setSticker();
        e.preventDefault();
    });

    var degrees = 0;
    var rotate = {
        "reset": function () {
            return degrees;
        },
        "left": function() {
            degrees -= 90;
            return degrees;
        },
        "right": function() {
            degrees += 90;
            return degrees;
        }
    };
    var isCinemaMode = false;

    var sticker = document.querySelector('#dragItem');

    function setSticker() {
        var opt = stickers.options[stickers.selectedIndex];
        sticker.style.background = 'url("' + opt.value  + '")';
        sticker.style.backgroundSize = 'contain';
        sticker.style.backgroundRepeat = 'no-repeat';
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
        canvas.width = width;
        canvas.height = height;
        ctx.drawImage(image, 0, 0, width, height);
        putCanvasDataToForm();
        var callback = (function() { parentDiv.appendChild(canvas) });
        setTimeout(callback, 200);
    }

    function resetCanvas() {
        canvas.width = width;
        canvas.height = height;
        putCanvasDataToForm();
    }

    function rotateCanvas(direction) {
        isCinemaMode = false;
        resetCanvas();
        ctx.save();
        ctx.translate(canvas.width/2,canvas.height/2);
        ctx.rotate(rotate[direction]() * (Math.PI/180));
        ctx.drawImage(image, -width/2, -height/2, width, height);
        ctx.restore();
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
        stickerInputX.setAttribute('value', stickerPos.x);
        stickerInputY.setAttribute('value', stickerPos.y);
    }

    function setStickerPos(windowX, windowY) {
        var new_x = windowX - (parseInt(sticker.style.width) / 2);
        var new_y = windowY - (parseInt(sticker.style.height) / 2);
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

    function cinemaMode() {
        if (isCinemaMode === true) {
            ctx.fillRect(0, 0, width, 60);
            ctx.fillRect(0, height - 60, width, 60);
        } else {
            rotateCanvas('reset');
        }
        putCanvasDataToForm();
    }

    parentDiv.removeChild(image);
    setCanvas();
    /* firefox draggable compat. */
    sticker.addEventListener('dragstart', function(e) {
        e.dataTransfer.setData('text/plain', '');
        e.dataTransfer.effectAllowed = 'move';
    });
})();
