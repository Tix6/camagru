<?php

require_once dirname(__FILE__) . '/Component.php';
require_once dirname(__FILE__) . '/../ressources/Picture.class.php';
require_once dirname(__FILE__) . '/PictureMini.php';
require_once dirname(__FILE__) . '/../ressources/User.class.php';

final class GalleryComponent extends Component {

    private $_pictures;

    const ORDER   = 'DESC';
    const LIMIT   = 21;

    private function _fetch() {
        if (isset($_GET['filter'])) {
            switch ($_GET['filter']) {
                case 'new':
                    $pictures = Picture::get_last_week(self::LIMIT);
                    break ;
                case 'like':
                    $pictures = Picture::get_most_liked(self::LIMIT);
                    break ;
                case 'comment':
                    $pictures = Picture::get_most_commented(self::LIMIT);
                    break ;
                default:
                    $pictures = Picture::fetch_all(self::ORDER, self::LIMIT);
                    break ;
            }
        } else {
            $pictures = Picture::fetch_all(self::ORDER, self::LIMIT);
        }

        foreach ($pictures as $pic) {
            $this->_pictures[] = new PictureMiniComponent($pic);
        }
    }

    public function __construct () {
        $this->_fetch();
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
