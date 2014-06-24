<?php
class about extends Controller {
    public function index() {
        require 'application/views/_templates/header.php';
        require 'application/views/about/index.php';
        require 'application/views/_templates/footer.php';
    }
}
?>