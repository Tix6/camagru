var width = 640;
var height = 400;
var dataURL;

var parentDiv = document.querySelector('#visu');
var pictureInput = document.querySelector('#pictureInput');
var canvas = document.createElement('canvas');
var ctx = canvas.getContext('2d');
var image = document.createElement('img');

var degrees = 0;
var rotate = {
    "left": function() {
        degrees -= 90;
        return degrees;
    },
    "right": function() {
        degrees += 90;
        return degrees;
    }
};

function rotateCanvas(direction) {
    ctx.clearRect(0,0,canvas.width,canvas.height);
    ctx.save();
    ctx.translate(canvas.width/2,canvas.height/2);
    ctx.rotate(rotate[direction]()*(Math.PI/180));
    ctx.drawImage(image, -width/2, -height/2, width, height);
    ctx.restore();
    updateForm();
}

function setCanvas() {
    canvas.width = width;
    canvas.height = height;
    ctx.drawImage(image, 0, 0, width, height);
    parentDiv.appendChild(canvas);
    updateForm();
}

function updateForm() {
    pictureInput.setAttribute('value', canvas.toDataURL());
}

function readFile(event) {
    var file = event.target.files[0];
    var imageType = /image.*/;

    if (file.type.match(imageType)) {
        var reader = new FileReader();

        reader.onload = function() {
            dataURL = reader.result;
            image.src = dataURL;
            setTimeout(setCanvas, 200);
        };

        reader.readAsDataURL(file);
    }
    else {
        // error case
        console.error('should be image file.');
    }
}
