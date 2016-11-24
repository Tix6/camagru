<?php

require_once dirname(__FILE__) . '/Component.php';
require_once dirname(__FILE__) . '/../ressources/User.class.php';

final class CommentComponent extends Component {

    private $_comment;
    private $_user;
    private $_is_deletable = false;

    private function _parse_date ($raw) {
        $date = date_parse($raw);
        return "{$date['day']}/{$date['month']}/{$date['year']}";
    }

    public function __construct ( array $comment ) {
        if ($comment) {
            $this->_comment = $comment;
            $this->_user = User::get_item_by(array('id' => $comment['user_id']));
            if (isset($_SESSION['id']) && $_SESSION['id'] === $this->_comment['user_id'])
                $this->_is_deletable = true;
        }
    }

    public function __invoke() {
        $com = $this->_comment;
        $date = $this->_parse_date($com['creation']);
        $username = $this->_user['name'];
        echo '
        <div class="comment">
            <p>' . $com['comment'] . '</p>
            <p>' . ucfirst($username) . ' - ' . $date . '</p>
        ';
        if ($this->_is_deletable === true)
            echo '<a class="delete" href="' . $_SERVER['REQUEST_URI'] .'&delete=' . $com['id'] . '">supprimer</a>';
        echo '</div>';
    }
}

 ?>
