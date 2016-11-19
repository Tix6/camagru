<?php

require_once dirname(__FILE__) . '/Component.php';
require_once dirname(__FILE__) . '/../ressources/Picture.class.php';
require_once dirname(__FILE__) . '/Picture.php';

final class GalleryComponent extends Component {

    private $_pictures;

    public function __construct () {
        $pictures = Picture::fetch_all();
        foreach ($pictures as $pic) {
            $this->_pictures[] = new PictureComponent($pic);
        }
    }

    public function __invoke() {
        echo '
            <h1>Gallerie</h1>
        ';
        foreach ($this->_pictures as $pic) {
            $pic();
        }
    }
}

 ?>
