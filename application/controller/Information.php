<?php
class Information extends Controller
{
    function index() {

    }

    function Account($page = 0) {

        //Loading Model
        $ChartModel = $this->loadModel('cashflowchartmodel');


        if($page === 0) {
            $this->loadView('_templates/header');
            $this->loadView('information/account');
            $this->loadView('_templates/footer');
        }

        if($page === 'Overview') {
            //列出各年度收支狀況
            $j = 0;
            for($i = 100 ; $i+1911 <= date('Y') ; $i++) {
                if($ChartModel->getYearTotalPrice($i, 'T')
                + $ChartModel->getYearTotalPrice($i, 'F') > 0) {
                    $data[$j]['expenditure'] = ($ChartModel->getYearTotalPrice($i, 'T') === NULL) ? 0 : $ChartModel->getYearTotalPrice($i, 'T');
                    $data[$j]['income'] = ($ChartModel->getYearTotalPrice($i, 'F') === NULL) ? 0 : $ChartModel->getYearTotalPrice($i, 'F');
                    $data[$j]['year'] = $i;
                    $j++;
                }
            }
            if($j >= 1) {
                echo json_encode($data);
                exit;
            } else {
                echo json_encode('No Data');
                exit;
            }
        }

        if($page === 'listYear') {
            $j = 0;
            for($i = 100 ; $i+1911 <= date('Y') ; $i++) {
                if($ChartModel->getYearTotalPrice($i, 'T')
                + $ChartModel->getYearTotalPrice($i, 'F') > 0) {
                    $data[$j] = $i;
                    $j++;
                }
            }
            echo json_encode($data);
            exit;
        }

        if($page === 'yearDetail') {
            if(is_numeric($_POST['year'])) {
                //先撈回該年計畫＆活動
                try {
                    $data['projectList'] = $ChartModel->listYearProject($_POST['year']);
                } catch (Exception $e) {
                    if($e->getCode() != 0)
                        echo json_encode('發生錯誤:'.$e->getMessage());
                    else {
                        echo json_encode('No Data');
                    }
                    exit;
                }

                //撈回本年度總收入和總支出
                try {
                    $data['TotalIncome'] = $ChartModel->getYearTotalPrice($_POST['year'], 'F');
                    $data['TotalExpenses'] = $ChartModel->getYearTotalPrice($_POST['year'], 'T');
                } catch (Exception $e) {
                    echo json_encode('發生錯誤:'.$e->getMessage());
                    exit;
                }

                //撈回各計畫下帳目
                foreach ($data['projectList'] as $project) {
                    try {
                        $data['itemList'][$project['id']]['income'] = $ChartModel->listProjectItem($project['id'], 'F');
                        $data['itemList'][$project['id']]['expenses'] = $ChartModel->listProjectItem($project['id'], 'T');
                    } catch (Exception $e) {
                        echo json_encode('發生錯誤:'.$e->getMessage());
                        exit;
                    }
                }

                //撈回各計畫收支
                foreach ($data['projectList'] as $project) {
                    try {
                        $data['income'][$project['id']] = ($ChartModel->getProjectTotalPrice($project['id'], 'F') == NULL) ? 0 : $ChartModel->getProjectTotalPrice($project['id'], 'F');
                        $data['expenses'][$project['id']] = ($ChartModel->getProjectTotalPrice($project['id'], 'T') == NULL) ? 0 : $ChartModel->getProjectTotalPrice($project['id'], 'T');
                    } catch (Exception $e) {
                        echo json_encode('發生錯誤:'.$e->getMessage());
                        exit;
                    }
                }

                echo json_encode($data);
                exit;
            }
        }
    }
}
?>