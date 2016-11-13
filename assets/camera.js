(function() {

  var streaming = false,
      video        = document.querySelector('#video'),
      cover        = document.querySelector('#cover'),
      startbutton  = document.querySelector('#startbutton'),
      canvas       = document.querySelector('#canvas'),
      context      = canvas.getContext('2d'),
      pictureInput = document.querySelector('#pictureInput'),
      width = 640,
      height = 400;

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
      canvas.setAttribute('width', width);
      canvas.setAttribute('height', height);
      streaming = true;
    }
  }, false);

  function takepicture() {
    canvas.setAttribute('width', width);
    canvas.setAttribute('height', height);
    context.drawImage(video, 0, 0, width, height);
  }

  // function cinema_switch() {
  //     cinemaMode = !cinemaMode;
  //     console.log('ciinema: ', cinemaMode);
  //     if (cinemaMode === true) {
  //         context.fillRect(0, 0, width, 100);
  //         context.fillRect(0, height - 100, width, 100);
  //     } else {
  //         context.clearRect(0, 0, width,100);
  //     }
  // }

  startbutton.addEventListener('click', function(ev){
    takepicture();
    pictureInput.setAttribute('value', canvas.toDataURL('image/png'));
    ev.preventDefault();
  }, false);
  //
  // cinemaButton.addEventListener('click', function(ev){
  //     cinema_switch();
  //   ev.preventDefault();
  // }, false);
})();
