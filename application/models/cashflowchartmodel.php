<?php
class CashFlowChartModel
{
    /**
     * Every model needs a database connection, passed to the model
     * @param object $db A PDO database connection
     */
    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    /**
     * Get simple "stats". This is just a simple demo to show
     * how to use more than one model in a controller (see application/controller/songs.php for more)
     */

    private function transAcademicToDate($AcademicYear) {
        //常數設定
        $monthStart = 8;
        $monthEnd = 7;

        $dayStart = 1;
        $dayEnd = 31;

        //先轉回西元年
        $AdYear = $AcademicYear + 1911;

        $timeRange['start'] = "$AdYear-$monthStart-$dayStart";
        $AdYear++;
        $timeRange['end'] = "$AdYear-$monthStart-$dayStart";

        return $timeRange;

    }

    function getYearTotalPrice($AcademicYear, $isOutlay, $status = 1) {

        $YearTotal = 0;

        /*
        try {
            $sql = "SELECT SUM(items_price) Total FROM `cf_items` WHERE `items_outlay` = ? AND (`items_app_time` BETWEEN ? AND ?) AND `items_status` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($isOutlay, $time['start'], $time['end'], $status));
            $result = $query->fetch();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }*/

        //先查出該年份所有Project
        try {
            $projects = $this->listYearProject($AcademicYear);
        } catch (Exception $e) {
            if($e->getCode() === 0)
                return 0;
            else
                throw new Exception("無法讀取project".$e->getMessage());
        }

        //拉出個別project 的 item做總和計算
        foreach ($projects as $project) {
            try {
                $projectTotal = $this->getProjectTotalPrice($project['id'], $isOutlay);
            } catch (Exception $e) {
                throw new Exception("無法計算id=$projectId的支出或收入總額".$e->getMessage());
            }
            $YearTotal += $projectTotal;
        }

        return $YearTotal;
    }

    //這個是前台帳目報表用的，只會列出底下有帳目的活動和計畫
    function listYearProject($AcademicYear) {

        //學年轉換成時間
        $time = $this->transAcademicToDate($AcademicYear);

        //抓回所有project
        try {
            $sql = "SELECT * FROM `cf_project` WHERE (`project_time` BETWEEN ? AND ?);";
            $query = $this->db->prepare($sql);
            $query->execute(array($time['start'], $time['end']));
            $result = $query->fetchAll();
        } catch (Exception $e) {
            throw new Exception("無法讀取project".$e->getMessage());
        }

        //過濾，只留下有帳目的
        foreach ($result as $project) {
            try {
                $sql = "SELECT COUNT(*) AS count FROM `cf_items` WHERE `items_project` = ?;";
                $query = $this->db->prepare($sql);
                $query->execute(array($project->project_id));
                $AppNumber = $query->fetch()->count;
            } catch(Exception $e) {
                throw new Exception("無法辨識帳目".$e->getMessage());
            }

            if($AppNumber > 0) {
                $listProject["$project->project_id"]['id'] = $project->project_id;
                $listProject["$project->project_id"]['name'] = $project->project_name;
            }
        }

        if(isset($listProject))
            return $listProject;
        else
            throw new Exception("本年度目前無任何資料", 0);
    }

    function getProjectTotalPrice($projectId, $isOutlay ,$status = 1) {
        try {
            $sql = "SELECT SUM(items_price) Total FROM `cf_items` WHERE `items_outlay` = ? AND `items_project` = ? AND `items_status` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($isOutlay, $projectId, $status));
            $result = $query->fetch();
        } catch (Exception $e) {
            throw new Exception("無法計算id=$projectId的支出或收入總額".$e->getMessage());
        }

        return $result->Total;
    }

    function listProjectItem($projectId, $isOutlay, $status = 1) {
        try {
            $sql = "SELECT `items_price`, `items_name`, `items_reviewer`, `items_app_time`, `worker_name` FROM `cf_items`, `worker` WHERE `items_reviewer` = `worker_id` AND `items_outlay` = ? AND `items_project` = ? AND `items_status` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($isOutlay, $projectId, $status));
            $result = $query->fetchAll();
        } catch(Exception $e) {
               throw new Exception("無法讀取id=$projectId的帳目內容".$e->getMessage());
        }

        return $result;
    }
}