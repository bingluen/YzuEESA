<?php
/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Home extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
        //loading Model
        $ArticleModel = $this->loadModel('articlemodel');
        //撈訊息
        $data['messages'] = $ArticleModel->listPost(0, 5);
        //呈現頁面
        $View['isHome'] = true;
        $this->loadView('_templates/header', $View);
        $this->loadView('home/index', $data);
        $this->loadView('_templates/footer');
    }
    /**
     * PAGE: exampleone
     * This method handles what happens when you move to http://yourproject/home/exampleone
     * The camelCase writing is just for better readability. The method name is case insensitive.
     */
}
