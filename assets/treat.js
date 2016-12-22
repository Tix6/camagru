(function() {
    var parentDiv = document.querySelector('#visu');

    var canvas = document.createElement('canvas');
    var canvasWidth = 640;
    var canvasHeight = 480;

    var ctx = canvas.getContext('2d');

    var image = document.querySelector('#pictureInput');
    var textField = document.querySelector('#textField');

    var sticker = {
        'dragItem': document.querySelector('#dragItem'),
        'selector': document.querySelector('#stickers'),
        'ratio': document.querySelector('#sticker-ratio'),
        'opacity': document.querySelector('#sticker-opacity')
    };

    var text = {
        'top': document.getElementById('text-top'),
        'bottom': document.getElementById('text-bottom'),
        'color': document.getElementById('text-color'),
        'shadow': document.getElementById('text-shadow')
    };

    var border = {
        'size': document.getElementById('border-size'),
        'color': document.getElementById('border-color')
    };

    var draw = {
        'isActive': document.getElementById('draw-checkbox'),
        'size': document.getElementById('draw-size'),
        'color': document.getElementById('draw-color'),
        'reset': document.getElementById('draw-reset')
    }

    var mousePressed = false;
    var mousePos;
    var lastX, lastY;

    var steps = {
        'selected': 0,
        'nextButton': document.getElementById('next-step'),
        'prevButton': document.getElementById('prev-step'),
        'allSteps': [
            document.querySelector('.step-1'),
            document.querySelector('.step-2'),
            document.querySelector('.step-3'),
            document.querySelector('.step-4'),
            document.querySelector('.step-5')
        ]
    }

    var validationButton = document.querySelector('.validation');

/* -------------------------------------------------------------------------- */
/* LISTENERS ---------------------------------------------------------------- */

    window.addEventListener('resize', function(e) {
        correctStickerPos();
        e.preventDefault();
    });

    canvas.addEventListener('mousedown', function (e) {
        mousePressed = true;
        mousePos = getMousePos(canvas, e);
        drawWithMouseOnCanvas(mousePos.x, mousePos.y, false);
        e.preventDefault();
    });

    canvas.addEventListener('mousemove', function (e) {
        if (mousePressed) {
            mousePos = getMousePos(canvas, e);
            drawWithMouseOnCanvas(mousePos.x, mousePos.y, true);
        }
        e.preventDefault();
    });

    canvas.addEventListener('mouseup', function (e) {
        if (mousePressed) {
            mousePressed = false;
            putCanvasDataToForm();
        }
        e.preventDefault();
    });

    canvas.addEventListener('mouseleave', function (e) {
        if (mousePressed) {
            mousePressed = false;
            putCanvasDataToForm();
        }
        e.preventDefault();
    });

    sticker.selector.addEventListener('change', function(e) {
        setSticker();
        e.preventDefault();
    });

    sticker.ratio.addEventListener('change', function(e) {
        setSticker();
        e.preventDefault();
    });

    sticker.opacity.addEventListener('change', function(e) {
        setSticker();
        e.preventDefault();
    });

    Object.keys(text).forEach(function(key) {
        var eventType = (key == 'color' || key == 'shadow') ? 'change' : 'keyup';
        text[key].addEventListener(eventType, function(e) {
            doCanvasStuff();
            e.preventDefault();
        });
    });

    Object.keys(border).forEach(function(key) {
        border[key].addEventListener('change', function(e) {
            doCanvasStuff();
            e.preventDefault();
        });
    });

    draw.reset.addEventListener('click', function(e) {
        doCanvasStuff();
        e.preventDefault();
    })

    steps.nextButton.addEventListener('click', function(e) {
        if (steps.selected < steps.allSteps.length) {
            steps.selected += 1;
        }
        displayStep();
        e.preventDefault();
    })

    steps.prevButton.addEventListener('click', function(e) {
        if (steps.selected > 0) {
            steps.selected -= 1;
        }
        displayStep();
        e.preventDefault();
    })

/* -------------------------------------------------------------------------- */
/* STEPS -------------------------------------------------------------------- */

    displayStep();

    function displayStep() {
        steps.prevButton.style.display = (steps.selected == 0) ? 'none' : 'inline';
        steps.nextButton.style.display = (steps.selected == steps.allSteps.length - 1) ? 'none' : 'inline';
        validationButton.style.display = (steps.selected == steps.allSteps.length - 1) ? 'block' : 'none';
        steps.allSteps.forEach(function (step, index) {
            if (index != steps.selected) {
                step.style.display = 'none';
            } else {
                step.style.display = 'block';
            }
        });
    }

/* -------------------------------------------------------------------------- */
/* CANVAS ------------------------------------------------------------------- */

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

    function getMousePos(canvas, evt) {
        var rect = canvas.getBoundingClientRect();
        var canvasZoom = canvasWidth / rect.width;
        return {
            x: (evt.clientX - rect.left) * canvasZoom,
            y: (evt.clientY - rect.top) * canvasZoom
        };
    }

    function drawWithMouseOnCanvas(x, y, isDown) {
    if (draw.isActive.checked && isDown) {
        ctx.save();
        ctx.beginPath();
        ctx.strokeStyle = draw.color.value;
        ctx.lineWidth = draw.size.options[draw.size.options.selectedIndex].value;
        ctx.lineJoin = "round";
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(x, y);
        ctx.closePath();
        ctx.stroke();
        ctx.restore();
    }
        lastX = x; lastY = y;
    }

    function doCanvasStuff() {
        resetCanvas();
        drawBorderOnCanvas(border.size.value, border.color.value);
        writeTextOnCanvas(text.top.value, 'top', text.color.value, text.shadow.checked);
        writeTextOnCanvas(text.bottom.value, 'bottom', text.color.value, text.shadow.checked);
        putCanvasDataToForm();
    }

    function resetCanvas() {
        canvas.width = canvasWidth;
        canvas.height = canvasHeight;
        ctx.fillStyle = 'white';
        ctx.fill();
        ctx.drawImage(image, 0, 0, canvasWidth, canvasHeight);
    }

    function drawBorderOnCanvas(size, color) {
        if (size > 0) {
            ctx.save();
            ctx.beginPath();
            ctx.rect(0, 0, canvasWidth, canvasHeight);
            ctx.fillStyle = 'transparent';
            ctx.fill();
            ctx.lineWidth = size;
            ctx.strokeStyle = color;
            ctx.stroke();
            ctx.restore();
        }
    }

    function writeTextOnCanvas(string, position, color, isShadow) {
        ctx.save();
        string = string.trim();
        ctx.font = '44px Khula, sans-serif';
        ctx.textAlign = 'center';
        ctx.fillStyle = color;
        if (isShadow) {
            ctx.shadowColor = 'black';
            ctx.shadowBlur = 3;
            ctx.shadowOffsetX = 1;
            ctx.shadowOffsetY = 1;
        }
        var x = canvasWidth / 2;
        if (position == 'top')
            ctx.fillText(string, x, 56, canvasWidth - 30);
        else if (position == 'bottom')
            ctx.fillText(string, x, canvasHeight - 30, canvasWidth - 40);
        ctx.restore();
    }

    function putCanvasDataToForm() {
        var canvasInputForm = document.querySelector('#inputCanvas');
        canvasInputForm.setAttribute('value', canvas.toDataURL());
    }

/* -------------------------------------------------------------------------- */
/* STICKER ------------------------------------------------------------------ */

    function setSticker() {
        var stickerSelected = sticker.selector.options[sticker.selector.selectedIndex].value;
        sticker.dragItem.src = stickerSelected;

        var opacitySelected = sticker.opacity.options[sticker.opacity.selectedIndex].value;
        sticker.dragItem.style.opacity = opacitySelected;

        var ratioSelected = sticker.ratio.options[sticker.ratio.selectedIndex].value;
        var image = new Image();
        image.onload = function() {
            var canvasZoom = canvas.getBoundingClientRect().width / canvasWidth;
            var width = (this.width * canvasZoom) * ratioSelected;
            sticker.dragItem.style.width = width + 'px';
        };
        image.src = stickerSelected;
        image = null;

        sticker.dragItem.style.backgroundColor = 'transparent';
        sticker.dragItem.style.border = '1px dashed black';
        putStickerDataToForm();
    }

    function setStickerPos(windowX, windowY) {
        var new_x = windowX - (parseInt(sticker.dragItem.width) / 2);
        var new_y = windowY - (parseInt(sticker.dragItem.height) / 2);
        sticker.dragItem.style.left = new_x + 'px';
        sticker.dragItem.style.top = new_y + 'px';
        setTimeout(correctStickerPos, 300);
    }

    /* like setStickerPos but invoked with timeout to inform user about misplacing sticker */
    function correctStickerPos() {
        var stickerPos = getStickerPosFromCanvas();
        var stickerBounds = sticker.dragItem.getBoundingClientRect();
        var canvasBounds = canvas.getBoundingClientRect();
        if (stickerPos.x < 0)
            sticker.dragItem.style.left = canvasBounds.left + 'px';
        else if (stickerPos.x + stickerBounds.width > canvasBounds.width)
            sticker.dragItem.style.left = canvasBounds.left + canvasBounds.width - stickerBounds.width + 'px';
        if (stickerPos.y < 0)
            sticker.dragItem.style.top = canvasBounds.top + 'px';
        else if (stickerPos.y + stickerBounds.height > canvasBounds.height)
            sticker.dragItem.style.top = canvasBounds.top + canvasBounds.height - stickerBounds.height + 'px';
        putStickerDataToForm();
    }

    function getStickerPosFromCanvas() {
        var canvasBounds = canvas.getBoundingClientRect();
        var stickerBounds = sticker.dragItem.getBoundingClientRect();
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
        stickerInputRatio.setAttribute('value', sticker.ratio.options[sticker.ratio.selectedIndex].value);
        stickerInputOpacity.setAttribute('value', sticker.opacity.options[sticker.opacity.selectedIndex].value);
    }

    parentDiv.removeChild(image);
    setCanvas();
    /* firefox draggable compat. */
    sticker.dragItem.addEventListener('dragstart', function(e) {
        e.dataTransfer.setData('text/plain', '');
        e.dataTransfer.effectAllowed = 'move';
    });
})();
