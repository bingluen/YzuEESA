<?php
class about extends Controller {
    public function index() {
        $this->loadView('_templates/header');
        $this->loadView('page/about-page');
        $this->loadView('_templates/footer');
    }
}
?>