<?php

require_once dirname(__FILE__) . '/Component.php';

final class PictureComponent extends Component {

    private $_picture;
    private $_error = false;

    private function _parse_date ($raw) {
        $date = date_parse($raw);
        return "{$date['day']}/{$date['month']}/{$date['year']}";
    }

    public function __construct ( array $picture ) {
        if ($picture) {
            $this->_picture = $picture;
        } else {
            $this->_error = true;
        }
    }

    public function __invoke() {
        if ($this->_error) {
            echo 'Cette image n\'existe pas.';
        } else {
            $pic = $this->_picture;
            $date = $this->_parse_date($pic['creation']);
            echo '
            <div class="picture-component">
                <a class="title" href="picture.php?id='. $pic['url_id'] .'">' . ucfirst($pic['title']) . '</a>
                <figure>
                    <img src="' . $pic['path'] . '" alt="' . $pic['title'] . '">
                </figure>
                <div class="picture-info">
                    <span class="date">' . $date . '</span>
                    <span class="comments">' . $pic['comments'] . ' commentaires</span>
                    <span class="likes">' . $pic['likes'] . ' likes</span>
                </div>
            </div>
            ';
        }
    }
}

 ?>
