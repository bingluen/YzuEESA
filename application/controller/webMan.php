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

            //呈現頁面
            $this->loadView('_templates/header_man');
            $this->loadView('manager/cash_flow/project_man', $data);
            $this->loadView('_templates/footer_man');
        }
    }

}
?>