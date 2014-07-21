<?php
class webMan extends Controller
{
    public function index()
    {
        header("Location: ". URL);
    }

    public function login() {

    }

    public function CashFlow($page = 0, $action = 0) {
        if($page === 0) {
            header("Location: ". URL);
        }
        // Loading Model
        $ProjectModel = $this->loadModel('projectmodel');
        $WorkerModel = $this->loadModel('workermodel');
        $ItemsModel = $this->loadModel('itemsmodel');

        if($page === 'Project') {
            if($action == 0) {
                // 預設列出所有的project
                $data['project'] = $ProjectModel->getProject();

                //把負責人名字拉回來
                for($i = 0;$i < count($data['project']);$i++) {
                    $data['project'][$i]->project_host = $WorkerModel->getWorkerName($data['project'][$i]->project_host);
                }
            }

            if($action === 'update') {
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
                //先過濾資料 ？
                /*
                $insertData = array('host' => $_POST['host'], 'projectName' => $_POST['name']);
                if(preg_match('/[[:cntrl:][:punct:][:space:]]/', $insertData))
                    echo json_encode('資料中有特殊文字符號')
                */

                //從post收資料
                $insertData['project_host'] = $_POST['host'];
                $insertData['project_name'] = $_POST['name'];
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
            $this->loadView('_templates/header_man');
            $this->loadView('manager/cash_flow/project_man', $data);
            $this->loadView('_templates/footer_man');
        }

        if($page === 'Items') {
            if($action == 0) {
                //step1 先拉回project
                $data['project'] = $ProjectModel->getProject();
                //把負責人名字拉回來
                for($i = 0;$i < count($data['project']);$i++) {
                    $data['project'][$i]->project_host = $WorkerModel->getWorkerName($data['project'][$i]->project_host);
                }

                //拉回item
                for($i = 0;$i < count($data['project']);$i++) {
                    $data['items'][$data['project'][$i]->project_id] = $ItemsModel->getItems($data['project'][$i]->project_id);

                    //把item裡面工人名子找回來
                    for($j = 0;$j <count($data['items'][$data['project'][$i]->project_id]);$j++) {
                        $data['items'][$data['project'][$i]->project_id][$j]->items_applicant = $WorkerModel->getWorkerName($data['items'][$data['project'][$i]->project_id][$j]->items_applicant);
                    }

                    //若有人審核了，順便把審核人的名字找回來
                    for($j = 0;$j <count($data['items'][$data['project'][$i]->project_id]) && $data['items'][$data['project'][$i]->project_id][$j]->items_reviewer != NULL;$j++) {
                        $data['items'][$data['project'][$i]->project_id][$j]->items_reviewer = $WorkerModel->getWorkerName($data['items'][$data['project'][$i]->project_id][$j]->items_reviewer);
                    }
                }
            }

            if($action === 'pass') {
                foreach($_POST['target'] as $target) {
                    $update[]= array(
                        'items_id' => $target,
                        'items_status' => $_POST['status'],
                        'items_reviewer' => $_POST['reviewer'],
                        'items_rev_time' => date('Y-m-d H:i:s'));
                }
                if($ItemsModel->updateItems($update)) {
                    echo json_encode('success');
                }
                exit;
            }

            //呈現頁面
            $this->loadView('_templates/header_man');
            $this->loadView('manager/cash_flow/items_man', $data);
            $this->loadView('_templates/footer_man');
        }

        if($page === 'Worker') {
            if($action == 0) {
                //列出工人
                $data['workerList'] = $WorkerModel->getWorkerList();


                for($i = 0;$i < count($data['workerList']);$i++) {


                    //拉回Project Name
                    $projectKey = explode(',', $data['workerList'][$i]->woker_project);
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
                    $data['workerList'][$i]->woker_project = $projectName;
                }

            }

            //呈現頁面
            $this->loadView('_templates/header_man');
            $this->loadView('manager/cash_flow/worker_man', $data);
            $this->loadView('_templates/footer_man');
        }
    }

}
?>