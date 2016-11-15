var width = 640;
var height = 480;
var dataURL;

var parentDiv = document.querySelector('#visu');
var pictureInput = document.querySelector('#pictureInput');
var canvas = document.createElement('canvas');
var ctx = canvas.getContext('2d');
var image = document.createElement('img');

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
