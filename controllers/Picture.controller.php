<?php

require_once dirname(__FILE__) . '/Controller.class.php';
require_once dirname(__FILE__) . '/../ressources/Picture.class.php';

final class Picture_Ctrl extends Controller {

    private $_picture;
    private $_error = '';
    private $_date;

    private function _parse_date ($raw) {
        $date = date_parse($raw);
        return "{$date['day']}-{$date['month']}-{$date['year']}";
    }

    public function __construct ( $picture_id ) {
        if ($picture_id) {
            $this->_picture = Picture::get_item_by('id', $picture_id);
            if ($this->_picture === false) {
                $this->_error = 'Cette image n\'existe pas.';
            }
        } else {
            $this->_error = 'Cette image n\'existe pas.';
        }
    }

    public function render() {
        $pic = $this->_picture;
        $date = $this->_parse_date($pic['creation']);
        // print_r($pic);
        echo $this->_error;
        echo '
            <div class="picture">
                <h1 class="title">' . ucfirst($pic['title']) . '</h1>
                <figure class="figure">
                    <img src="' . $pic['path'] . '" alt="' . $pic['title'] . '">
                </figure>
                <p class="date">Fait le : <span>' . $date . '</span></p>
                <p class="likes">Likes : ' . $pic['likes'] . '</p>
            </div>
        ';
    }
}

 ?>
