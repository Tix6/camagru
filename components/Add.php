<?php

require_once dirname(__FILE__) . '/Component.php';

final class AddComponent extends Component {
    public function __invoke() {
        echo '
            <h1>Ajouter une image</h1>
            <ul>
            <li><a href="#" id="webcam">webcam</a></li>
            <li><a href="#" id="upload">upload</a></li>
            </ul>
            <div id="type"></div>
            <canvas id="canvas"></canvas>
            <form action="treat.php" method="POST">
                <input id="pictureInput" type="hidden" name="picture" value="">
                <button type="submit" class="next">Etape suivante</button>
            </form>
            <script type="text/javascript" src="assets/add.js"></script>
        ';
    }
}

 ?>
