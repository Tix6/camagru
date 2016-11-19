<?php

require_once dirname(__FILE__) . '/Component.php';
require_once dirname(__FILE__) . '/Comment.php';

final class CommentsComponent extends Component {

    private $_comments;

    public function __construct ( $picture_id ) {
        $comments = Comment::get_all_items_by('picture_id', $picture_id);
        foreach ($comments as $com) {
            $this->_comments[] = new CommentComponent($com);
        }
    }

    public function __invoke() {
        echo '
            <div class="comments">
                <h1>Commentaires</h1>
        ';
        if (count($this->_comments)) {
            foreach ($this->_comments as $com) {
                $com();
            }
        }
        echo '<div>';
    }
}

 ?>
