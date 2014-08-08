<?php
class About extends Controller
{
    public function index()
    {
        $this->loadView('_templates/header');
        $this->loadView('page/about_page');
        $this->loadView('_templates/footer');
    }

}
?>