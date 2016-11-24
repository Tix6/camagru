<?php

abstract class Component {

    protected $_need_to_refresh = false;

    public function need_to_refresh() {
        return $this->_need_to_refresh;
    }

}

?>