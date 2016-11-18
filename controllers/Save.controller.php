<?php

require_once dirname(__FILE__) . '/Controller.class.php';
require_once dirname(__FILE__) . '/../scripts/Image_Merged.class.php';
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
    private $_image_md5;

    private function _create_and_save_image_file() {
        $merged = new ImageMerged($this->_canvas_base64, $this->_sticker_path, $this->_sticker_opt);
        $this->_image_path = $merged();
    }

    private function _compute_md5_image_checksum() {
        $this->_image_md5 = hash_file('md5', $this->_image_path);
    }

    private function _check_if_image_already_exist() {
        return Picture::get_item_by('md5', $this->_image_md5);
    }

    private function _update_database() {
        $sql_params = array(
            ':user_id' => $_SESSION['id'],
            ':path' => $this->_image_path,
            ':title' => $this->_image_title,
            ':md5' => $this->_image_md5
        );
        $fields = Picture::get_fields();
        $sql_params = array_intersect_key($sql_params, $fields);
        // print_r($sql_params);
        return Picture::add_item($sql_params);
    }

    public function __construct() {
        $this->_canvas_base64 = $_POST['canvas'];
        $this->_sticker_path = $_POST['sticker'];
        $this->_sticker_opt['x'] = $_POST['x'];
        $this->_sticker_opt['y'] = $_POST['y'];
        $this->_image_title = $_POST['title'];

        $this->_create_and_save_image_file();
        $this->_compute_md5_image_checksum();
        if ($this->_check_if_image_already_exist() === false) {
            $this->_update_database();
        } else {
            Picture::delete_image_file($this->_image_path);
        }
    }

    public function render() {
        echo '<img src="' . $this->_image_path . '" alt="' . $this->_image_title . '">';
    }
}

?>
