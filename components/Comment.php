<?php

require_once dirname(__FILE__) . '/Component.php';
require_once dirname(__FILE__) . '/../ressources/User.class.php';

final class CommentComponent extends Component {

    private $_comment;
    private $_picture;
    private $_auth_user;
    private $_is_deletable = false;

    private function _parse_date ( $raw ) {
        $month = array(
            '01' => 'jan.',
            '02' => 'fev.',
            '03' => 'mar.',
            '04' => 'avr.',
            '05' => 'mai',
            '06' => 'juin',
            '07' => 'juillet',
            '08' => 'aout',
            '09' => 'sept',
            '10' => 'oct.',
            '11' => 'nov.',
            '12' => 'dec.'
        );
        $date = date_parse($raw);
        return "{$date['day']} {$month[$date['month']]} {$date['year']}";
    }

    public function __construct ( array $comment, array $picture, $user ) {
        if ($comment) {
            $this->_comment = $comment;
            $this->_picture = $picture;
            $this->_auth_user = $user;
            if ($this->_auth_user && $this->_auth_user['id'] === $this->_comment['user_id'])
                $this->_is_deletable = true;
        }
    }

    public function __invoke() {
        $com = $this->_comment;
        $date = $this->_parse_date($com['creation']);
        $pic_id = $this->_picture['url_id'];
        $author = User::get_item_by(array('id' => $this->_comment['user_id']));
        echo '
        <div class="comment">
            <div class="comment-info">
                <p>' . ucfirst($author['name']) . ' - ' . $date . '</p>';
        if ($this->_is_deletable === true) {
            echo '
                <form action="picture.php?id=' . $pic_id . '&comment=del" method="POST">
                <input type="hidden" name="comment_id" value="' . $com['id'] . '">
                <input type="hidden" name="comment_user_id" value="' . $com['user_id'] . '">
                <button type="submit" class="icon-trash">supprimer</button>
                </form>';
        }
        echo '
            </div>
            <div class="comment-text">
                <i class="icon-quote-left"></i>
                <span>' . $com['comment'] . '</span>
                <i class="icon-quote-right"></i>
            </div>
        </div>';
    }
}

 ?>
