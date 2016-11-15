var width = 640;
var height = 480;

var parentDiv = document.querySelector('#visu');
var image = document.querySelector('#pictureInput');
var canvas = document.createElement('canvas');
var ctx = canvas.getContext('2d');
var textField = document.querySelector('#textField');
var stickers = document.querySelector('#stickers');

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

// var dragItem = document.querySelector("#drag");
var sticker = document.querySelector('#dragItem');

function setSticker() {
    var opt = stickers.options[stickers.selectedIndex];
    sticker.style.background = 'url("' + opt.value  + '")';
    sticker.style.backgroundSize = 'contain';
    sticker.style.backgroundRepeat = 'no-repeat';
}

// function setText() {
//     textDrag = document.createElement('p');
//     textDrag.innerHTML = textField.value;
//     textDrag.setAttribute('draggable', true);
//     textDrag.style.position = 'absolute';
//     console.log(textDrag);
//     parentDiv.appendChild(textDrag);
// }

function rotateCanvas(direction) {
    resetCanvas();
    ctx.save();
    ctx.translate(canvas.width/2,canvas.height/2);
    ctx.rotate(rotate[direction]() * (Math.PI/180));
    ctx.drawImage(image, -width/2, -height/2, width, height);
    ctx.restore();
}

function setCanvas() {
    canvas.addEventListener('dragover', function(e) {
        e.preventDefault();
    }, false);
    canvas.addEventListener('drop', function(e) {
        e.preventDefault();
        setBounds(sticker, e.clientX, e.clientY);
        // console.log(dragItem.getBoundingClientRect(), e.clientX, e.clientY);
    }, false);
    canvas.width = width;
    canvas.height = height;
    ctx.drawImage(image, 0, 0, width, height);
}

function resetCanvas() {
    ctx.clearRect(0,0,canvas.width,canvas.height);
}

function setBounds(element, x, y) {
    var new_x = x - (parseInt(element.style.width) / 2);
    var new_y = y - (parseInt(element.style.height) / 2);
    element.style.left = new_x + 'px';
    element.style.top = new_y + 'px';
}

function cinemaMode() {
    isCinemaMode = !isCinemaMode;
    console.log('cinema mode: ', isCinemaMode);
    if (isCinemaMode === true) {
        ctx.fillRect(0, 0, width, 60);
        ctx.fillRect(0, height - 60, width, 60);
    } else {
        rotateCanvas('reset');
    }
}

(function() {
    parentDiv.removeChild(image);
    setCanvas();
    parentDiv.appendChild(canvas);
})();
