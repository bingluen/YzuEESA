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

        if($page === 'Project') {
            if($action == 0) {
                // 預設列出所有的project
                $data['project'] = $ProjectModel->getProject();
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
                $data['project_host'] = $_POST['host'];
                $data['project_name'] = $_POST['name'];
                $data['project_time'] = date('Y-m-d H:i:s');

                // 檢查資料庫有沒有工人資料，如果沒有或有人同名同姓，不能指定為負責人
                try {
                    $WorkerModel->checkWorkerExist($data['project_host'])
                } catch {
                    if($e->getCode() == 1)
                        echo json_encode('資料庫沒有這個工人資料，不能指定為負責人，要先新增工人才可以喔～');
                    else
                        echo json_encode($e->getMessage());
                    exit;
                }

                //新增project，並回傳project id值
                $projectId = $ProjectModel->addProject($data);

                //增加該工人權限
                $WorkerModel->setWorkerProject($data['project_host'], $projectId);
            }

            //呈現頁面
            $this->loadView('_templates/header_man');
            $this->loadView('manager/cash_flow/project_man', $data);
            $this->loadView('_templates/footer_man');
        }
    }

}
?>