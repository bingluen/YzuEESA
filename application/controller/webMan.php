<?php
@session_start();

class webMan extends Controller
{

    private function getIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
          $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
          $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
          $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    private function deleteSession() {
        unset($_SESSION['auth']);
        unset($_SESSION['user']);
        unset($_SESSION['user_id']);
        unset($_SESSION['user_ip']);
        unset($_SESSION['login_time']);
    }

    private function checkLogin() {
        if(!(isset($_SESSION['auth'])
            && $_SESSION['auth'] == 'yes')) {
            //沒過驗證轉回首頁
            $this->deleteSession();
            header("Location: ". URL);
        } else if(!(isset($_SESSION['user_ip'])
            && $_SESSION['user_ip'] == $this->getIP())) {
            //ip位址和登入時不同轉回首頁
            $this->deleteSession();
            header("Location: ". URL);
        } else if(!(isset($_SESSION['login_time'])
            && time() - strtotime($_SESSION['login_time']) <= 1800)) {
            //超過30分鐘沒動作 轉回登入頁面
            $this->deleteSession();
            header("Location: ". URL."webMan/login/doLogin");
        } else if(!(isset($_SESSION['level'])
            && $_SESSION['level'] > 0)) {
            //停權
            $this->deleteSession();
            header("Location: ". URL."webMan/login/doLogin/AuthError0");
        } else {
            //刷新最後動作時間
            $_SESSION['login_time'] = date('Y-m-d H:i:s');
        }
    }

    public function index()
    {
        header("Location: ". URL);
    }

    public function login($page = 0, $msg = 0) {
        if($page === 0) {
            header("Location: ". URL);
        }

        $WorkerModel = $this->loadModel('workermodel');
        $ClassModel = $this->loadModel('classmodel');
        if($page === 'doLogin') {
            if($msg === 'AuthError0' )
                $data['msg'] = '此帳號已經被停權';
            $page = 'login';
            $this->loadView('_templates/header_man', $page);
            if(isset($data['msg']))
                $this->loadView('manager/login', $data['msg']);
            else
                $this->loadView('manager/login');
            $this->loadView('_templates/footer_man');
        }

        if($page === 'Auth') {
            if(isset($_POST['username']) && isset($_POST['password'])) {

                //驗證是否已透過md5加密，並收下登入資訊
                /*
                if(strlen($_POST['password']) == 32)
                    $authData = array('user' => $_POST['username'], 'pw' => $_POST['password']);
                */

                $authData = array('user' => $_POST['username'], 'pw' => $this->loadModel('hashmodel')->passwordHash($_POST['password']));

                //驗證登入資料
                try {
                    $authResult = $WorkerModel->authUser($authData);
                } catch (Exception $e) {
                    echo json_encode($e->getMessage());
                    exit;
                }

                //驗證成功 寫入session & 更新登入紀錄
                if($authResult['auth']) {
                    $_SESSION['auth'] = 'yes';
                    $_SESSION['user'] = $authData['user'];
                    $_SESSION['user_id'] = $authResult['userid'];
                    $_SESSION['level'] = $authResult['level'];
                    $_SESSION['user_project'] = $authResult['project'];
                    $_SESSION['user_ip'] = $this->getIP();
                    $_SESSION['login_time'] = date('Y-m-d H:i:s');

                    $WorkerModel->updateWorker(array(
                        'worker_id' => $_SESSION['user_id'],
                        'worker_lastIP' => $_SESSION['user_ip'],
                        'worker_lastlogin' => $_SESSION['login_time']));

                    echo json_encode('success');
                    exit;
                }

                exit;
            }

            header("Location: ". URL);
        }

        if($page === 'AuthSuccess') {
            $this->checkLogin();

            $data['class'] = $ClassModel->getClassName($_SESSION['level']);
            try {
                $data['name'] = $WorkerModel->getWorkerName($_SESSION['user_id']);
            } catch (Exception $e) {
                $data['name'] = $e->getMessage();
            }
            $active = 'home';
            $this->loadView('_templates/header_man');
            $this->loadView('manager/sidebar', $active);
            $this->loadView('manager/user_information', $data);
            $this->loadView('_templates/footer_man');
        }

        if($page === 'Logout') {
            $this->deleteSession();
            header("Location: ". URL."webMan/login/doLogin/");
        }

    }

    public function CashFlow($page = 0, $action = 0) {

        if($page === 0) {
            header("Location: ". URL);
        }

        $this->checkLogin();

        // Loading Model
        $ProjectModel = $this->loadModel('projectmodel');
        $WorkerModel = $this->loadModel('workermodel');
        $ItemsModel = $this->loadModel('itemsmodel');
        $ClassModel = $this->loadModel('classmodel');

        if($page === 'Project') {
            if(!$ClassModel->checkAuthority($_SESSION['level'], 'project'))
                exit;
            if($action == 0) {
                // 預設列出所有的project
                $data['project'] = $ProjectModel->getProject();

                //把負責人名字拉回來
                for($i = 0;$i < count($data['project']);$i++) {
                    try {
                        $data['project'][$i]->project_host = $WorkerModel->getWorkerName($data['project'][$i]->project_host);
                    } catch (Exception $e) {
                        $data['project'][$i]->project_host = $e->getMessage();
                    }
                }

                //把分類名稱拉回來

                for($i = 0;$i < count($data['project']);$i++) {
                    try {
                        $data['project'][$i]->project_category = $ProjectModel->getCategory($data['project'][$i]->project_category);
                    } catch (Exception $e) {
                        $data['project'][$i]->project_category = $e->getMessage();
                    }
                }

                //把可以選的分類拉回來
                try {
                    $data['categoryList'] = $ProjectModel->listCategory();
                } catch (Exception $e) {
                    $data['categoryList'] = $e->getMessage();
                }
            }

            if($action === 'update') {
                if(!$ClassModel->checkAuthority($_SESSION['level'], 'project-update', true))
                    exit;
                foreach($_POST['target'] as $target) {
                    $update[]= array(
                        'project_id' => $target,
                        'project_status' => $_POST['status']);
                }
                if($ProjectModel->updateProject($update)) {
                    echo json_encode('success');
                    exit;
                }
            }

            if($action === 'delete') {
                if(!$ClassModel->checkAuthority($_SESSION['level'], 'project-delete', true))
                    exit;
                foreach($_POST['target'] as $target) {
                    $delete[] = $target;
                }
                $doDelete = $ProjectModel->deleteProject($delete);
                if($doDelete['result']) {
                    echo json_encode('已經刪除'.$doDelete['deleted'].'筆資料, '.$doDelete['notDelete'].'筆刪除失敗。');
                    exit;
                }
            }

            if($action === 'insert') {
                if(!$ClassModel->checkAuthority($_SESSION['level'], 'project-insert', true))
                    exit;
                //先過濾資料 ？
                /*
                $insertData = array('host' => $_POST['host'], 'projectName' => $_POST['name']);
                if(preg_match('/[[:cntrl:][:punct:][:space:]]/', $insertData))
                    echo json_encode('資料中有特殊文字符號')
                */

                //從post收資料
                $insertData['project_host'] = $_POST['host'];
                $insertData['project_name'] = $_POST['name'];
                $insertData['project_category'] = $_POST['category'];
                $insertData['project_time'] = date('Y-m-d H:i:s');

                // 檢查資料庫有沒有工人資料，如果沒有或有人同名同姓，不能指定為負責人

                try {
                    $WorkerModel->checkWorkerExist($insertData['project_host']);
                } catch (Exception $e) {
                    if($e->getCode() == 1) {
                        echo json_encode('資料庫沒有這個工人資料，不能指定為負責人，要先新增工人才可以喔～');
                        exit;
                    } else {
                        echo json_encode($e->getMessage());
                        exit;
                    }
                }

                //取得工人id
                try {
                    $insertData['project_host'] = $WorkerModel->getWorkerID($insertData['project_host']);
                } catch (Exception $e) {
                    echo json_encode($e->getMessage());
                    exit;
                }

                //新增project，並回傳project id值
                $projectId = $ProjectModel->addProject($insertData);

                //增加該工人權限
                $WorkerModel->setWorkerProject($insertData['project_host'], $projectId);

                echo json_encode('success');
                exit;

            }

            //呈現頁面
            $active = 'CashFlow';
            $this->loadView('_templates/header_man');
            $this->loadView('manager/sidebar', $active);
            $this->loadView('manager/cash_flow/project_man', $data);
            $this->loadView('_templates/footer_man');
        }

        if($page === 'Items') {
            if(!$ClassModel->checkAuthority($_SESSION['level'], 'Items'))
                exit;
            if($action == 0) {
                //step1 先拉回project
                $data['project'] = $ProjectModel->getProject();
                //把負責人名字拉回來
                for($i = 0;$i < count($data['project']);$i++) {
                    try {
                        $data['project'][$i]->project_host = $WorkerModel->getWorkerName($data['project'][$i]->project_host);
                    } catch (Exception $e) {
                        $data['project'][$i]->project_host = $e->getMessage();
                    }

                }

                //拉回item
                for($i = 0;$i < count($data['project']);$i++) {
                    $data['items'][$data['project'][$i]->project_id] = $ItemsModel->getItems($data['project'][$i]->project_id);

                    //把item裡面工人名子找回來
                    for($j = 0;$j <count($data['items'][$data['project'][$i]->project_id]);$j++) {
                        try {
                            $data['items'][$data['project'][$i]->project_id][$j]->items_applicant = $WorkerModel->getWorkerName($data['items'][$data['project'][$i]->project_id][$j]->items_applicant);
                        } catch (Exception $e) {
                            $data['items'][$data['project'][$i]->project_id][$j]->items_applicant = $e->getMessage();
                        }
                    }

                    //若有人審核了，順便把審核人的名字找回來
                    for($j = 0;$j <count($data['items'][$data['project'][$i]->project_id]) && $data['items'][$data['project'][$i]->project_id][$j]->items_reviewer != NULL;$j++) {
                        try {
                            $data['items'][$data['project'][$i]->project_id][$j]->items_reviewer = $WorkerModel->getWorkerName($data['items'][$data['project'][$i]->project_id][$j]->items_reviewer);
                        } catch (Exception $e) {
                            $data['items'][$data['project'][$i]->project_id][$j]->items_reviewer = $e->getMessage();
                        }
                    }
                }
            }

            if($action === 'pass') {
                if(!$ClassModel->checkAuthority($_SESSION['level'], 'Items-pass', true))
                    exit;
                foreach($_POST['target'] as $target) {
                    $update[]= array(
                        'items_id' => $target,
                        'items_status' => $_POST['status'],
                        'items_reviewer' => $_SESSION['user_id'],
                        'items_rev_time' => date('Y-m-d H:i:s'));
                }

                $result = $ItemsModel->updateItems($update);
                if($result === true) {
                    echo json_encode('success');
                } else {
                    echo json_encode($result);
                }
                exit;
            }

            //呈現頁面
            $active = 'CashFlow';
            $this->loadView('_templates/header_man');
            $this->loadView('manager/sidebar', $active);
            $this->loadView('manager/cash_flow/items_man', $data);
            $this->loadView('_templates/footer_man');
        }

        if($page === 'AppItem') {
            if($_SESSION['user_project'] == '' && !$ClassModel->checkAuthority($_SESSION['level'], 'AppItem'))
                exit;
            if($action == 0) {
                //撈出自己申請的東西
                try {
                    $data['appItems'] = $ItemsModel->userItems($_SESSION['user_id']);

                    //若有人審核了，順便把審核人的名字找回來
                    for($i = 0;$i <count($data['appItems']);$i++) {
                        if($data['appItems'][$i]->items_reviewer != NULL)
                        {
                            try {
                                $data['appItems'][$i]->items_reviewer = $WorkerModel->getWorkerName($data['appItems'][$i]->items_reviewer);
                            } catch (Exception $e) {
                                $data['appItems'][$i]->items_reviewer = $e->getMessage();
                            }
                        }
                    }
                } catch (Exception $e) {
                    $data['message'] = $e->getMessage();
                }

                //撈出可以申請的Project 和 活動的名字
                //拉回Project Name
                $projectKey = explode(',', $_SESSION['user_project']);
                for ($j = 0; $j < count($projectKey);$j++) {
                    $projectKey[$j] = str_replace(' ', '', $projectKey[$j]);
                }

                for($i = 0;$i < count($projectKey);$i++) {
                    if($name = $ProjectModel->getProjectName($projectKey[$i])) {
                       $data['project'][$i]['name'] = $name;
                       $data['project'][$i]['key'] = $projectKey[$i];
                    }
                }
            }

            if($action === 'sendApp') {
                if($_SESSION['user_project'] == '' && !$ClassModel->checkAuthority($_SESSION['level'], 'sendApp', true))
                    exit;
                //收post
                $appData['applicant'] = $_SESSION['user_id'];
                $appData['time'] = date('Y-m-d H:i:s');
                $appData['type'] = $_POST['type'];
                $appData['name'] = $_POST['name'];
                $appData['cost'] = $_POST['cost'];
                $appData['project'] = $_POST['project'];
                //先檢查是否已經結案
                if(!$ProjectModel->ProjectIsActive($appData['project'])) {
                    echo json_encode('該Project/活動已經結案，不能在申報');
                    exit;
                }
                //開始送資料
                for($i = 0 ; $i < count($appData['type']) ; $i++) {
                    try {
                        $ItemsModel->appItme(array(
                            'project' => $appData['project'],
                            'type' => $appData['type'][$i],
                            'cost' => $appData['cost'][$i],
                            'name' => $appData['name'][$i],
                            'applicant' => $appData['applicant'],
                            'time' => $appData['time']));
                    } catch (Exception $e) {
                        echo json_encode($e->getMessage());
                        exit;
                    }
                }
                echo json_encode('success');
                exit;
            }

            //呈現頁面
            $active = 'CashFlow';
            $this->loadView('_templates/header_man');
            $this->loadView('manager/sidebar', $active);
            $this->loadView('manager/cash_flow/appItem', $data);
            $this->loadView('_templates/footer_man');
        }
    }

    public function Worker($page = 0, $action = 0) {
        if($page === 0) {
            header("Location: ". URL);
        }

        $this->checkLogin();

        // Loading Model
        $ProjectModel = $this->loadModel('projectmodel');
        $WorkerModel = $this->loadModel('workermodel');
        $ItemsModel = $this->loadModel('itemsmodel');
        $ClassModel = $this->loadModel('classmodel');

        if($page === 'Worker') {
            if($action == 0) {
                if(!$ClassModel->checkAuthority($_SESSION['level'], 'Worker'))
                    exit;
                //列出工人
                $data['workerList'] = $WorkerModel->getWorkerList();


                for($i = 0;$i < count($data['workerList']);$i++) {


                    //拉回Project Name
                    $projectKey = explode(',', $data['workerList'][$i]->worker_project);
                    for ($j = 0; $j < count($projectKey);$j++) {
                      $projectKey[$j] = str_replace(' ', '', $projectKey[$j]);
                    }

                    $projectName = '';

                    foreach ($projectKey as $key) {
                        if($name = $ProjectModel->getProjectName($key)) {
                            if($projectName != '')
                            $projectName = $projectName . ', ';
                            $projectName = $projectName.$name;
                        }
                    }

                    //回填Project Name
                    $data['workerList'][$i]->worker_project = $projectName;
                }
            }

            if($action === 'searchProject') {
                //撈回進行中的Project，供編輯時使用
                try {
                    $searchProject = $ProjectModel->getProject('active', $_POST['key']);
                } catch (Exception $e) {
                    echo json_encode($e->getMessage());
                    exit;
                }
                    echo json_encode($searchProject);
                    exit;
            }

            if($action === 'delete') {
                if(!$ClassModel->checkAuthority($_SESSION['level'], 'Worker-delete', true))
                    exit;
                foreach($_POST['target'] as $target) {
                    $delete[] = $target;
                }
                $doDelete = $WorkerModel->deleteWorker($delete);
                if($doDelete['result']) {
                    echo json_encode('已經刪除'.$doDelete['deleted'].'筆資料, '.$doDelete['notDelete'].'筆刪除失敗。');
                    exit;
                }
            }

            if($action === 'disable') {
                if(!$ClassModel->checkAuthority($_SESSION['level'], 'Worker-disable', true))
                    exit;
                foreach ($_POST['target'] as $target) {
                    $disable[] = array(
                        'worker_id' => $target,
                        'worker_level' => 0);
                }
                $doDisable = $WorkerModel->updateWorker($disable, true);

                if($doDisable) {
                    echo json_encode('已經將所選取工人帳號停權。');
                    exit;
                }
            }

            if($action === 'addWorker') {
                if(!$ClassModel->checkAuthority($_SESSION['level'], 'Worker-addWorker', true))
                    exit;
                //收資料
                $workerData['worker_name'] = $_POST['name'];
                $workerData['worker_username'] = $_POST['username'];
                $workerData['worker_password'] = $this->loadModel('hashmodel')->passwordHash($_POST['password']);
                $workerData['worker_level'] = $_POST['level'];

                //新增工人
                try {
                    $WorkerModel->addWorker($workerData);
                } catch (Exception $e) {
                    echo json_encode($e->getMessage());
                    exit;
                }

                echo json_encode('success');
                exit;
            }

            if($action === 'editWorker') {
                if(!$ClassModel->checkAuthority($_SESSION['level'], 'Worker-editWorker', true))
                    exit;
                if(isset($_POST['doing'])) {
                    if($_POST['doing'] === 'getDetail' && isset($_POST['userid'])) {
                        try {
                            $data = $WorkerModel->getWorkerDetail($_POST['userid']);
                        } catch(Expection $e) {
                            echo json_encode($e->getMessage());
                            exit;
                        }

                        $detail = array(
                            'worker_name' => $data->worker_name,
                            'worker_username' => $data->worker_username,
                            'worker_level' => $data->worker_level);

                        if($data->worker_project != '')
                        {
                            //剖析project id
                            $projectKey = explode(',', $data->worker_project);
                            for($j = 0; $j < count($projectKey);$j++) {
                                $projectKey[$j] = str_replace(' ', '', $projectKey[$j]);
                            }

                            foreach ($projectKey as $key) {
                                if($name = $ProjectModel->getProjectName($key)) {
                                    $detail['worker_project'][$i]['project_id'] = $key;
                                    $detail['worker_project'][$i]['project_name'] = $name;
                                }
                            }
                        }

                        echo json_encode($detail);
                    }
                    if($_POST['doing'] === 'updateWorker' && isset($_POST['userid'])) {
                        $data = array(
                            'worker_id' => $_POST['userid'],
                            'worker_name' => $_POST['name'],
                            'worker_level' => $_POST['level'],
                            'worker_project' => $_POST['project']);
                        if($_POST['password'] != 'false')
                            $data['worker_password'] = $this->loadModel('hashmodel')->passwordHash($_POST['password']);

                        $executeR = $WorkerModel->updateWorker($data);
                        if($executeR === true)
                            echo json_encode('success');
                        else
                            echo json_encode($executeR);
                    }
                }
                exit;
            }

            //呈現頁面
            $active = 'Worker';
            $this->loadView('_templates/header_man');
            $this->loadView('manager/sidebar', $active);
            $this->loadView('manager/worker/worker_man', $data);
            $this->loadView('_templates/footer_man');
        }
    }

    public function MessagesSystem($page = 0, $action = 0) {
        if($page === 0) {
            header("Location: ". URL);
        }

        $this->checkLogin();

        //Loading Model
        $ArticleModel = $this->loadModel('articlemodel');
        $WorkerModel = $this->loadModel('workermodel');
        $ClassModel = $this->loadModel('classmodel');


        if($page === 'editor') {
            $data = false;

            if(is_numeric($action)) {

                //action 是數字 => 文章id => 編輯模式

                //開始撈資料
                $article = $ArticleModel->getPost($action);

                $data['post_id'] = $action;
                $data['title'] = $article->messages_title;
                $data['content'] = $article->messages_content;

            } else if($action != 'NewPost') {
                if(!$ClassModel->checkAuthority($_SESSION['level'], 'Messages-new'))
                    exit;
                header("Location: ". URL. "webMan/MessagesSystem/PostList");
            }

            $active = 'Messages';
            $this->loadView('_templates/header_man');
            $this->loadView('manager/sidebar', $active);
            $this->loadView('manager/messages/editor', $data);
            $this->loadView('_templates/footer_man');
        }

        if($page === 'post') {
            if($action === 'new') {
                if(!$ClassModel->checkAuthority($_SESSION['level'], 'Messages-new', true))
                    exit;
                $postData['title'] = $_POST['title'];
                $postData['content'] = $_POST['content'];
                $postData['draft'] = $_POST['draft'];
                $postData['author'] = $_SESSION['user_id'];
                $postData['time'] = date('Y-m-d H:i:s');

                try {
                    $ArticleModel->post($postData);
                } catch (Exception $e) {
                    echo json_encode('fail :'.$e->getMessage());
                    exit;
                }
                echo json_encode('success');
                exit;
            }


            if($action === 'update') {
                $postData['post_id'] = $_POST['id'];
                $postData['title'] = $_POST['title'];
                $postData['content'] = $_POST['content'];
                $postData['draft'] = $_POST['draft'];
                $postData['author'] = $_SESSION['user_id'];
                $postData['time'] = date('Y-m-d H:i:s');

                try {
                    $ArticleModel->updatePost($postData);
                    echo json_encode('success');
                } catch (Exception $e) {
                    echo json_encode('fail :'.$e->getMessage());
                }
                exit;
            }
        }

        if($page === 'PostList') {
            if(is_numeric($action) && $action > 0) {
                //先決定第幾頁
                $pageNumber = $action - 1;

                //開始撈資料
                try {
                    $data = $ArticleModel->listPost($pageNumber, 30, 1, $_SESSION['level'], $_SESSION['user_id']);
                     //把編輯者名字名字拉回來
                    for($i = 0;$i < count($data);$i++) {
                        try {
                            $data[$i]->messages_author = $WorkerModel->getWorkerName($data[$i]->messages_author);
                        } catch (Exception $e) {
                            $data[$i]->messages_author = $e->getMessage();
                        }
                    }
                    echo json_encode($data);
                } catch (Exception $e) {
                    echo json_encode($e->getMessage());
                }
                exit;
            } else {
                $data['pages'] =  $ArticleModel->getPages(30);
                $active = 'Messages';
                $this->loadView('_templates/header_man');
                $this->loadView('manager/sidebar', $active);
                $this->loadView('manager/messages/postList', $data);
                $this->loadView('_templates/footer_man');
            }
        }

        if($page === 'delete') {
            foreach ($_POST['target'] as $target) {
                if($ArticleModel->getAuthor($target) == $_SESSION['user_id'])
                    $list[] = $target;
            }

            try {
                $ArticleModel->deletePost($list);
                echo json_encode('success');
            } catch (Exception $e) {
                echo json_encode('fail'. $e->getMessage());
            }
            exit;
        }

        if($page === 'draft') {
            foreach ($_POST['target'] as $target) {
                if($ArticleModel->getAuthor($target) == $_SESSION['user_id'])
                    $list[] = $target;
            }

            try {
                $ArticleModel->draftPost($list);
                echo json_encode('success');
            } catch (Exception $e) {
                echo json_encode('fail'. $e->getMessage());
            }
            exit;

        }

        if($page === 'public') {
            foreach ($_POST['target'] as $target) {
                if($ArticleModel->getAuthor($target) == $_SESSION['user_id'])
                    $list[] = $target;
            }

            try {
                $ArticleModel->publicPost($list);
                echo json_encode('success');
            } catch (Exception $e) {
                echo json_encode('fail'. $e->getMessage());
            }
            exit;
        }
    }

    public function Event($page = 0, $action = 0) {
        $this->checkLogin();

        $ClassModel = $this->loadModel('classmodel');
        $EventModel = $this->loadMOdel('eventmodel');

        if($page === 0) {
            if(!$ClassModel->checkAuthority($_SESSION['level'], 'Event'))
                exit;
            $active = 'Event';
            $this->loadView('_templates/header_man');
            $this->loadView('manager/sidebar', $active);
            $this->loadView('manager/page/event_introduction');
            $this->loadView('_templates/footer_man');
        }

        if($page === 'EventCreate') {
            if(!$ClassModel->checkAuthority($_SESSION['level'], 'EventCreate'))
                exit;

            if($action === 'catchEvent') {
                $catchData = $EventModel->catchEventDetail($_POST['url']);
                echo json_encode($catchData);
                exit;
            }

            if($action === 'insertToDatabase') {
                $data['name'] = $_POST['name'];
                $data['path'] = $_POST['url'];
                $data['host'] = $_SESSION['user_id'];
                $insertExecute = $EventModel->addEvent($data);

                //+到活動系統
                try {
                    $insertExecute = $EventModel->addEvent($data);
                } catch (Exception $e) {
                    echo json_encode($e->getMessage());
                    exit;
                }

                //開project
                //從post收資料
                $insertData['project_host'] = $_SESSION['user_id'];
                $insertData['project_name'] = $_POST['name'];
                $insertData['project_category'] = '2';
                $insertData['project_time'] = date('Y-m-d H:i:s');

                //新增project，並回傳project id值
                $projectId = $ProjectModel->addProject($insertData);

                //增加該工人權限
                $WorkerModel->setWorkerProject($insertData['project_host'], $projectId);


                echo json_encode('success');
                exit;
            }

            $active = 'Event';
            $this->loadView('_templates/header_man');
            $this->loadView('manager/sidebar', $active);
            $this->loadView('manager/event/EventCreate');
            $this->loadView('_templates/footer_man');
        }


    }
}
?>