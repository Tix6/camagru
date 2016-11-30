(function() {

    var container       = document.getElementById('type'),
        canvas          = document.getElementById('canvas'),
        form            = document.getElementById('add-form'),
        ctx             = canvas.getContext('2d'),
        width           = 640,
        height          = 480;

    /* CANVAS */

    canvas.width = width;
    canvas.height = height;

    var CanvasAndForm = {
        'show': function() {
            form.style.display = "block";
            canvas.style.display = "block";
        },
        'hide': function() {
            form.style.display = "none";
            canvas.style.display = "none";
        }
    }

    // Canvas and Form will be displayed after user choose mode.
    CanvasAndForm.hide();

    function cleanCanvas() {
        canvas.width = width;
        canvas.height = height;
    }

    function putImageOnCanvas(img) {
        cleanCanvas();
        ctx.drawImage(img, 0, 0, width, height);
     }

    function cleanContainer() {
        while (container.hasChildNodes()) {
            container.removeChild(container.lastChild);
        }
    }

    function fillFormWithBase64Canvas() {
        pictureInput.setAttribute('value', canvas.toDataURL('image/png'));
    }

    /* WEBCAM */

    var webcam = document.getElementById('webcam');

    webcam.addEventListener('click',
        function(e) {
            CanvasAndForm.hide();
            cleanContainer();
            cleanCanvas();
            var video = document.createElement('video');
            var startButton = document.createElement('button');
            startButton.innerHTML = 'prendre la photo';
            var streaming = false;

            startButton.addEventListener('click', function(e){
                CanvasAndForm.show();
                putImageOnCanvas(video);
                pictureInput.setAttribute('value', canvas.toDataURL('image/png'));
                e.preventDefault();
            }, false);

            container.appendChild(video);
            container.appendChild(startButton);

            navigator.getMedia = ( navigator.getUserMedia ||
                                   navigator.webkitGetUserMedia ||
                                   navigator.mozGetUserMedia ||
                                   navigator.msGetUserMedia);

            navigator.getMedia(
            {
                video: true,
                audio: false
            },
                function(stream) {
                    if (navigator.mozGetUserMedia) {
                        video.mozSrcObject = stream;
                    } else {
                        var vendorURL = window.URL || window.webkitURL;
                        video.src = vendorURL.createObjectURL(stream);
                    }
                    video.play();
                    },
                    function(err) {
                        console.log("An error occured! " + err);
                    }
            );

            video.addEventListener('canplay', function(ev){
              if (!streaming) {
                height = video.videoHeight / (video.videoWidth/width);
                video.setAttribute('width', width);
                video.setAttribute('height', height);
                streaming = true;
              }
            }, false);

            e.preventDefault();
        }, false
    );


    /* UPLOAD */

    var upload = document.getElementById('upload');

    upload.addEventListener('click',
        function(e) {
            CanvasAndForm.hide();
            cleanContainer();
            cleanCanvas();
            var image = document.createElement('img');
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            function readFile(event) {
                var file = event.target.files[0];
                var imageType = /image.*/;

                if (file.type.match(imageType)) {
                    var reader = new FileReader();

                    reader.onload = function() {
                        dataURL = reader.result;
                        image.src = dataURL;
                        image.onload = function() {
                            putImageOnCanvas(image);
                            CanvasAndForm.show();
                            fillFormWithBase64Canvas();
                        };
                    };

                    reader.readAsDataURL(file);
                }
                else {
                    console.error('should be image file.');
                }
            }

            input.addEventListener('change', function(e){
                readFile(e);
                e.preventDefault();
            }, false);

            container.appendChild(input);

            e.preventDefault();
        }, false
    );

})();
