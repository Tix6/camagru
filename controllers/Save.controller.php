<?php

require_once dirname(__FILE__) . '/Controller.class.php';
require_once dirname(__FILE__) . '/../ressources/Sticker.class.php';

final class Save_Ctrl extends Controller {

    private $_base64_pic;
    private $_sticker = array(
        'path' => '',
        'x' => 0,
        'y' => 0
    );

    public function __construct() {
        $this->_base64_pic = $_POST['canvas'];
        $this->_sticker['path'] = $_POST['sticker'];
        $this->_sticker['x'] = $_POST['x'];
        $this->_sticker['y'] = $_POST['y'];
    }

    public function render() {
        echo '';
    }
}

?>
