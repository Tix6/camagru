<?php

require_once dirname(__FILE__) . '/Controller.class.php';

final class Add_Ctrl extends Controller {
    public function render() {
        echo '
            <h1>Ajouter</h1>
            <a href="index.php?page=camera">webcam</a>
            <a href="index.php?page=upload">upload</a>
        ';
    }
}

 ?>
