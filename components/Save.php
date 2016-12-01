<?php

require_once dirname(__FILE__) . '/Component.php';
require_once dirname(__FILE__) . '/../scripts/Image_Merged.class.php';
require_once dirname(__FILE__) . '/../ressources/Picture.class.php';

final class SaveComponent extends Component {

    private $_canvas_base64;
    private $_sticker_path;
    private $_sticker_opt = array(
        'x' => 0,
        'y' => 0,
        'ratio' => 0.2,
        'opacity' => 1
    );
    private $_image_title;
    private $_image_path;
    private $_image_md5;

    private function _create_and_save_image_file() {
        $merged = new ImageMerged($this->_canvas_base64, $this->_sticker_path, $this->_sticker_opt);
        $this->_image_path = $merged();
    }

    private function _compute_md5_image_checksum() {
        $this->_image_md5 = hash_file('md5', $this->_image_path);
    }

    private function _check_if_image_already_exist() {
        return Picture::get_item_by(array('md5' => $this->_image_md5));
    }

    private function _init_url_id() {
        /* php 7 only */
        return bin2hex(random_bytes(4));
    }

    private function _update_database() {
        $sql_params = array(
            'user_id' => $_SESSION['id'],
            'url_id' => $this->_init_url_id(),
            'path' => $this->_image_path,
            'title' => $this->_image_title,
            'md5' => $this->_image_md5
        );
        $fields = Picture::get_fields();
        Picture::add_item($sql_params);
    }

    public function __construct() {
        $this->_canvas_base64 = $_POST['canvas'];
        $this->_sticker_path = $_POST['sticker'];
        $this->_sticker_opt['x'] = $_POST['x'];
        $this->_sticker_opt['y'] = $_POST['y'];
        $this->_sticker_opt['ratio'] = $_POST['ratio'];
        $this->_sticker_opt['opacity'] = $_POST['opacity'];
        $this->_image_title = $_POST['title'];

        $this->_create_and_save_image_file();
        $this->_compute_md5_image_checksum();
        if ($this->_check_if_image_already_exist() === false) {
            $this->_update_database();
        } else {
            Picture::delete_image_file($this->_image_path);
        }
    }

    public function __invoke() {
        echo '<img src="' . $this->_image_path . '" alt="' . $this->_image_title . '">';
    }
}

?>
