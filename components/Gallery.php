<?php

require_once dirname(__FILE__) . '/Component.php';
require_once dirname(__FILE__) . '/../ressources/Picture.class.php';
require_once dirname(__FILE__) . '/PictureMini.php';
require_once dirname(__FILE__) . '/../ressources/User.class.php';

final class GalleryComponent extends Component {

    private $_pictures;

    public function __construct () {
        $pictures = Picture::fetch_all();

        foreach ($pictures as $pic) {
            $this->_pictures[] = new PictureMiniComponent($pic);
        }
    }

    public function __invoke() {
        if (count($this->_pictures)) {
            foreach ($this->_pictures as $pic) {
                $pic();
            }
        }
    }
}

 ?>
