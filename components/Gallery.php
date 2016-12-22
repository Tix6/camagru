<?php

require_once dirname(__FILE__) . '/Component.php';
require_once dirname(__FILE__) . '/../ressources/Picture.class.php';
require_once dirname(__FILE__) . '/PictureMini.php';
require_once dirname(__FILE__) . '/../ressources/User.class.php';

final class GalleryComponent extends Component {

    const ORDER   = 'DESC';
    const LIMIT   = 12;

    private $_pictures;
    private $_pic_count;

    /* warning: first page is equal to zero */
    private $_page = 0;
    private $_offset = 0;

    private function _fetch() {
        if (isset($_GET['id'])) {
            $this->_pic_count = Picture::get_row_count_by(array('user_id' => $_GET['id']));
            $pictures = Picture::get_all_items_by(array('user_id' => $_GET['id']), self::ORDER, self::LIMIT, $this->_offset);
        }
        else if (isset($_GET['filter'])) {
            switch ($_GET['filter']) {
                case 'like':
                    $this->_pic_count = Like::get_row_count();
                    $pictures = Picture::get_most_liked(self::LIMIT, $this->_offset);
                    break ;
                case 'comment':
                    $this->_pic_count = Comment::get_row_count();
                    $pictures = Picture::get_most_commented(self::LIMIT, $this->_offset);
                    break ;
                default:
                    $this->_pic_count = Picture::get_row_count();
                    $pictures = Picture::fetch_all(self::ORDER, self::LIMIT, $this->_offset);
                    break ;
            }
        } else {
            $this->_pic_count = Picture::get_row_count();
            $pictures = Picture::fetch_all(self::ORDER, self::LIMIT, $this->_offset);
        }

        if ($pictures) {
            foreach ($pictures as $pic) {
                $this->_pictures[] = new PictureMiniComponent($pic);
            }
        } else {
            $this->_redirect($_SERVER['SCRIPT_NAME']);
        }
    }

    private function _compute_offset() {
        if (isset($_GET['page'])) {
            $page = intval($_GET['page']);
            $this->_page = ($page >= 0) ? $page : 0;
            $this->_offset = intval($this->_page * self::LIMIT);
        }
    }

    private function _update_url_params($name, $value) {
        $params = $_GET;
        unset($params[$name]);
        $params[$name] = $value;
        return basename($_SERVER['PHP_SELF']).'?'.http_build_query($params);
    }

    private function _pagination() {
        if ($this->_pic_count > self::LIMIT) {
            $page_count = ceil($this->_pic_count / self::LIMIT);
            $page_link = range($this->_page - 5, $this->_page + 5);

            echo '<ul>';
            if ($this->_page != 0) {
                echo '<li><a href="'.($this->_update_url_params('page', '0')).'"><<</a></li>';
            }
            if ($this->_page > 0) {
                echo '<li><a href="'.($this->_update_url_params('page', $this->_page - 1)).'"><</a></li>';
            }
            foreach ($page_link as $page) {
                if ($page >= 0 && $page + 1 <= $page_count) {
                    if ($page != $this->_page)
                        echo '<li><a href="'.($this->_update_url_params('page', $page)).'">'.($page + 1).'</a></li>';
                    else
                        echo '<li><a class="selected" href="#">' . ($this->_page + 1) . '</a></li>';
                }
            }
            if ($this->_page + 1 < $page_count) {
                echo '<li><a href="'.($this->_update_url_params('page', $this->_page + 1)).'">></a></li>';
                echo '<li><a href="'.($this->_update_url_params('page', $page_count - 1)).'">>></a></li>';
            }
            echo '</ul>';
        }
    }

    public function __construct () {
        $this->_compute_offset();
        $this->_fetch();
    }

    public function __invoke() {
        if (count($this->_pictures)) {
            foreach ($this->_pictures as $pic) {
                $pic();
            }
            echo '<div class="pagination">';
            $this->_pagination();
            echo '</div>';
        }
        else {
            echo '<p>Aucun résultats.</p>';
        }
    }
}

 ?>
