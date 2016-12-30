<?php

require_once dirname(__FILE__) . '/Component.php';
require_once dirname(__FILE__) . '/../scripts/Image_Merged.class.php';
require_once dirname(__FILE__) . '/../ressources/Picture.class.php';

final class SaveComponent extends Component {

    protected $_need_auth = true;
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

    private $_picture_url_id;

    private $_alerts = array(
        'success' => '<p class="alert-success">Merci, vous allez être redirigé.</p>',
        'err_already_exist' => '<p class="alert-danger">Cette image existe déjà.</p>',
        'err_incomplete' => '<p class="alert-danger">Informations manquantes (titre, photo...).</p>'
    );

    private $_alert = '';

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
        $this->_picture_url_id = bin2hex(random_bytes(4));
    }

    private function _update_database() {
        $this->_init_url_id();

        $sql_params = array(
            'user_id' => $_SESSION['id'],
            'url_id' => $this->_picture_url_id,
            'path' => $this->_image_path,
            'title' => $this->_image_title,
            'md5' => $this->_image_md5
        );

        return Picture::add_item($sql_params);
    }

    public function __construct() {
        parent::__construct();

        $base64 = (isset($_POST['canvas'])) ? $_POST['canvas'] : '';
        $title = (isset($_POST['title'])) ? trim($_POST['title']) : '';

        if ($this->_user_is_auth === true && !empty($base64) && !empty($title)) {
            $this->_canvas_base64 = $base64;
            $this->_image_title = $title;
            $this->_sticker_path = $_POST['sticker'];
            $this->_sticker_opt['x'] = $_POST['x'];
            $this->_sticker_opt['y'] = $_POST['y'];
            $this->_sticker_opt['ratio'] = $_POST['ratio'];
            $this->_sticker_opt['opacity'] = $_POST['opacity'];

            $this->_create_and_save_image_file();
            $this->_compute_md5_image_checksum();
            if ($this->_check_if_image_already_exist() === false) {
                if ($this->_update_database()) {
                    $this->_alert = $this->_alerts['success'];
                    header("refresh:3;url=picture.php?id={$this->_picture_url_id}");
                }
                else
                    $this->_alert = $this->_alerts['err_incomplete'];
            } else {
                $this->_alert = $this->_alerts['err_already_exist'];
            }
        } else {
            $this->_alert = $this->_alerts['err_incomplete'];
        }
    }

    public function __invoke() {
        if (parent::__invoke() === true) {
            echo $this->_alert;
        }
    }
}

?>
