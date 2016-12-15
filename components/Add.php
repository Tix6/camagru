<?php

require_once dirname(__FILE__) . '/Component.php';

final class AddComponent extends Component {
    protected $_need_auth = true;
    protected $_action_name = 'ajouter une photo';

    public function __invoke() {
        if (parent::__invoke() === true) {
            echo '
            <ul>
            <li><a href="#" id="webcam"><i class="icon-camera"></i>Webcam</a></li>
            <li><a href="#" id="upload"><i class="icon-folder-open-empty"></i>Fichier</a></li>
            </ul>
            <div id="type"></div>
            <canvas id="canvas"></canvas>
            <form action="treat.php" method="POST" id="add-form">
                <input id="pictureInput" type="hidden" name="picture" value="">
                <button type="submit" class="next">Etape suivante</button>
            </form>
            <script type="text/javascript" src="assets/add.js"></script>
            ';
        }
    }
}

 ?>
