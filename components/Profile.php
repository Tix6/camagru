<?php

require_once dirname(__FILE__) . '/../ressources/User.class.php';
require dirname(__FILE__) . '/Gallery.php';
require dirname(__FILE__) . '/User.php';

final class ProfileComponent extends Component {

    private $_user;

    public function __construct () {
        parent::__construct();

        if (isset($_GET['id']))
            $this->_user = User::get_item_by(array('id' => $_GET['id']));

        if ($this->_user) {
            $this->_user_compo    = new UserComponent($this->_user);
            $this->_gallery_compo = new GalleryComponent();
        }
    }

    public function __invoke() {
        if ($this->_user) {
            ($this->_user_compo)();
            ($this->_gallery_compo)();
        } else {
            echo "<p class=\"error\">Il semblerait que cette utilisateur n'existe pas.</p>";
        }
    }
}

 ?>
