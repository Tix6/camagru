<?php

require_once dirname(__FILE__) . '/Controller.class.php';

// http://www.w3schools.com/tags/ref_canvas.asp
// https://openclassrooms.com/courses/dynamisez-vos-sites-web-avec-javascript/l-element-canvas

final class Camera_Ctrl extends Controller {
    public function render() {
        echo '
        <video id="video"></video>
        <button id="startbutton">Prendre une photo</button>
        <button id="cinema">cinema</button>
        <canvas id="canvas"></canvas>
        <script type="text/javascript" src="/camagru/assets/camera.js"></script>
        ';
    }
}
// <img src="http://placekitten.com/g/320/261" id="photo" alt="photo">

 ?>
