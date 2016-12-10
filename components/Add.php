<?php

require_once dirname(__FILE__) . '/Component.php';

final class AddComponent extends Component {
    const NEED_AUTH = true;
    const ACTION_NAME = 'ajouter une photo';

    public function __invoke() {
        if (parent::__invoke() === true) {
            echo '
            <div>
            <ul>
            <li><a href="#" id="webcam">webcam</a></li>
            <li><a href="#" id="upload">upload</a></li>
            </ul>
            <div id="type"></div>
            <canvas id="canvas"></canvas>
            <form action="treat.php" method="POST" id="add-form">
            <input id="pictureInput" type="hidden" name="picture" value="">
            <button type="submit" class="next">Etape suivante</button>
            </form>
            <script type="text/javascript" src="assets/add.js"></script>
            </div>
            ';
        }
    }
}

 ?>
