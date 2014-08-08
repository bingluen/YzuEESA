<?php
class About extends Controller
{
    public function index()
    {
        $this->loadView('_templates/header');
        $this->loadView('page/index');
        $this->loadView('_templates/footer');
    }

}
?>