<?php

require_once dirname(__FILE__) . '/Controller.class.php';
require_once dirname(__FILE__) . '/../scripts/image_merged.class.php';
require_once dirname(__FILE__) . '/../ressources/Picture.class.php';

final class Save_Ctrl extends Controller {

    private $_canvas_base64;
    private $_sticker_path;
    private $_sticker_opt = array(
        'x' => 0,
        'y' => 0,
        'ratio' => 0.1
    );
    private $_image_title;
    private $_image_path;

    public function __construct() {
        $this->_canvas_base64 = $_POST['canvas'];
        $this->_sticker_path = $_POST['sticker'];
        $this->_sticker_opt['x'] = $_POST['x'];
        $this->_sticker_opt['y'] = $_POST['y'];
        $merged = new ImageMerged($this->_canvas_base64, $this->_sticker_path, $this->_sticker_opt);
        $this->_image_title = $_POST['title'];
        $this->_image_path = $merged();
    }

    public function render() {
        echo '<img src="' . $this->_image_path . '" alt="' . $this->_image_title . '">';
    }
}

?>
