<?php

require_once dirname(__FILE__) . '/Controller.class.php';

// http://www.w3schools.com/tags/ref_canvas.asp
// https://openclassrooms.com/courses/dynamisez-vos-sites-web-avec-javascript/l-element-canvas

final class Camera_Ctrl extends Controller {
    public function render() {
        echo '
        <video id="video"></video>
        <button id="startbutton">Prendre une photo</button>
        <hr>
        <h2>Visualisation</h2>
        <canvas id="canvas"></canvas>
        <form action="index.php?page=treat" method="POST">
            <input id="pictureInput" type="hidden" name="picture" value="">
            <button type="submit" class="next">Etape suivante</button>
        </form>
        <script type="text/javascript" src="assets/camera.js"></script>
        ';
    }
}

 ?>
