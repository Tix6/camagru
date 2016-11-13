<?php

require_once dirname(__FILE__) . '/Controller.class.php';

final class Upload_Ctrl extends Controller {

    public function __construct() {}

    public function render() {
        echo '
        <input type="file" name="picture" accept="image/*" onchange="readFile(event)">
        <form action="index.php?page=treat" method="POST">
            <input id="pictureInput" type="hidden" name="picture" value="">
            <button id="upload" type="submit" class="next">Etape suivante</button>
        </form>
        <h2>Visualisation</h2>
        <div id="visu"></div>
        <script type="text/javascript" src="/assets/upload.js"></script>
        ';
    }

}

?>
