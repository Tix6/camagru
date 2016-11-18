<?php

require_once dirname(__FILE__) . '/Controller.class.php';
require_once dirname(__FILE__) . '/../ressources/Sticker.class.php';

final class Treat_Ctrl extends Controller {

    private $_base64_pic;
    private $_stickers;

    public function __construct() {
      $this->_base64_pic = $_POST['picture'];
      $this->_stickers = Sticker::fetch_all();
    }

    public function render() {
        $stickers = array();
        foreach ($this->_stickers as $sticker) {
            $stickers[] = "<option value=\"{$sticker['path']}\">{$sticker['title']}</option>";
        }
        echo '
        <div id="visu">
            <div id="dragItem" draggable="true" style="position:absolute;width:150px;height:100px;" ondragstart="return true;"></div>
            <img id="pictureInput" alt="Embedded Image" src="' . $this->_base64_pic . '" />
        </div>
        <a href="#" onclick="rotateCanvas(\'left\')"><-</a>
        <a href="#" onclick="rotateCanvas(\'right\')">-></a>
        <a href="#" onclick="cinemaMode()">Cinema</a>
        <form action="index.php?page=save" method="POST">
            <input id="inputCanvas" type="hidden" name="canvas" value="">
            <input type="text" name="title" value="" placeholder="indiquez un titre">
            <select id="stickers" name="sticker" onclick="setSticker()">'
                . implode("\n", $stickers) .
            '</select>
            <input id="inputX" type="hidden" name="x" value="">
            <input id="inputY" type="hidden" name="y" value="">
            <button type="submit" class="next">Valider</button>
        </form>
        <script type="text/javascript" src="assets/treat.js"></script>
        ';
    }
    // <div id="drag" draggable="true" style="position:absolute;background-color:red;width:20px;height:20px;"></div>

}

?>
