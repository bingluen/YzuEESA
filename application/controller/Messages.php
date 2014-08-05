<?php
class Messages extends Controller
{
    public function index()
    {
        $ArticleModel = $this->loadModel('articlemodel');
        try {
            $data['pages'] = $ArticleModel->getPages(30);
        } catch (Exception $e) {
            $data['errorMessage'] = $e->getMessage();
            $data['errorCode'] = $e->getCode();
        }
        $this->loadView('_templates/header');
        $this->loadView('messages/list', $data);
        $this->loadView('_templates/footer');

    }

    public function Page($page = 0)
    {
        if(is_numeric($page) && $page > 0) {
            //撈列表
            $ArticleModel = $this->loadModel('articlemodel');

            try {
                $data = $ArticleModel->listPost($page - 1, 5);
            } catch (Exception $e) {
                $data['errorMessage'] = $e->getMessage();
                $data['errorCode'] = $e->getCode();
            }
            echo json_encode($data);
            exit;
        }
    }

    public function View($id) {
        if(is_numeric($id) && $id > 0) {
            $ArticleModel = $this->loadModel('articlemodel');
            $WorkerModel = $this->loadModel('workermodel');
            //撈文章內容
            try {
                $data['article'] = $ArticleModel->viewPost($id);
                //把編輯者名字名字拉回來
                try {
                    $data['article']->author = $WorkerModel->getWorkerName($data['article']->author);
                } catch (Exception $e) {
                    $data['article']->author = $e->getMessage();
                }

            } catch (Exception $e) {
                $data['errorMessage'] = $e->getMessage();
                $data['errorCode'] = $e->getCode();
            }

            $this->loadView('_templates/header');
            $this->loadView('messages/view_post', $data);
            $this->loadView('_templates/footer');
        }
    }

}