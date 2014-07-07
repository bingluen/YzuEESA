<?php
class istudy extends Controller {
    public function index() {
        $this->loadView('_templates/header');
        $this->loadView('istudy/homepage');
        $this->loadView('_templates/footer');
    }
}
?>