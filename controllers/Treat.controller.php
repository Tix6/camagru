<?php

require_once dirname(__FILE__) . '/Controller.class.php';

final class Treat_Ctrl extends Controller {

    private $_base64_pic;

    public function __construct() {
      $this->_base64_pic = $_POST['picture'];
    }

    public function render() {
        echo '
        <img alt="Embedded Image" src="' . $this->_base64_pic . '" />
        ';
    }

}

?>
