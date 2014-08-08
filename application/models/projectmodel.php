<?php
class ProjectModel
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

    function addProject($data) {
        try {
            $sql = "INSERT INTO `cf_project` (project_category, project_name, project_host, project_time) VALUES(?, ?, ?, ?);";
            $query = $this->db->prepare($sql);
            $query->execute(array($data['project_category'], $data['project_name'], $data['project_host'], $data['project_time']));
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        try {
            $sql = "SELECT LAST_INSERT_ID()";
            $query = $this->db->prepare($sql);
            $query->execute();
            $result = $query->fetch();
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $result;
    }

    function updateProject($data) {
        foreach ($data as $project) {
            $param = '';
            $param_val = '';
            if(isset($project['project_name'])) {
                $param = $param.'`project_name` = ?';
                $param_val[] = $project['project_name'];
            }

            if(isset($project['project_status'])) {
                if($param != '')
                    $param = $param. ',';
                $param = $param.'`project_status` = ?';
                $param_val[] = $project['project_status'];
            }

            if(isset($project['project_host'])) {
                if($param != '')
                    $param = $param. ',';
                $param = $param.'`project_host` = ?';
                $param_val[] = $project['project_host'];
            }

            if(isset($project['project_category'])) {
                $param = $param.'`project_category` = ?';
                $param_val[] = $project['project_category'];
            }

            $param_val[] = $project['project_id'];

            try {
                $sql = "UPDATE `cf_project` SET $param WHERE `project_id` = ?;";
                $query = $this->db->prepare($sql);
                $result = $query->execute($param_val);
            } catch(Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        return true;
    }

    function deleteProject($data) {

        //先檢查金流系統中有沒有該筆計畫的帳目
        $deleteList = '';
        $deleteCount = 0;
        $not_delete = '';
        $notDeleteCount = 0;
        foreach($data as $project_id) {
            try {
                $sql = "SELECT COUNT(*) AS count FROM `cf_items` WHERE `items_project` = ?;";
                $query = $this->db->prepare($sql);
                $query->execute(array($project_id));
                $result = $query->fetch();
            } catch(Exception $e) {
                    throw new Exception($e->getMessage());
            }

            if($result->count === '0') {
                $deleteList[]= $project_id;
                $deleteCount++;
            } else {
                $not_delete[] = $project_id;
                $notDeleteCount++;
            }
        }


        //若無則進行刪除
        if($deleteCount > 0) {
            foreach ($deleteList as $deleteItem) {
                try {
                    $sql = "DELETE FROM `cf_project` WHERE `project_id` = ?;";
                    $query = $this->db->prepare($sql);
                    $query->execute(array($deleteItem));
                } catch(Exception $e) {
                        throw new Exception($e->getMessage());
                }
            }
        }


        $execute_result['deleted'] = $deleteCount;
        $execute_result['notDelete'] = $notDeleteCount;
        $execute_result['result'] = true;
        return $execute_result;
    }

    function getProject($status = 0, $key = 0) {
        try {
            if($status === 0)
            {
                $sql = "SELECT * FROM `cf_project`;";
                $query = $this->db->prepare($sql);
                $query->execute();
            } else if ($status === 'active') {
                $sql = "SELECT `project_name` AS name, `project_id` AS id FROM `cf_project` WHERE `project_status` = 'T' AND `project_name` LIKE ?;";
                $query = $this->db->prepare($sql);
                $query->execute(array("$key%"));
            }
            $result = $query->fetchAll();
        } catch(Expection $e) {
            throw new Exception($e->getMessage());
        }
        return $result;
    }

    function getProjectName($id) {
        try {
            $sql = "SELECT `project_name` FROM `cf_project` WHERE `project_id` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($id));
            $result = $query->fetch();
        } catch(Expection $e) {
            throw new Exception($e->getMessage());
        }
        if($result)
            return $result->project_name;
        return false;
    }

    function ProjectIsActive($id) {
        try {
            $sql = "SELECT `project_status` FROM `cf_project` WHERE `project_id` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($id));
            $result = $query->fetch();
        } catch(Expection $e) {
            throw new Exception($e->getMessage());
        }
        if($result->project_status == 'T')
            return true;
        return false;
    }

    function getCategory($id) {
        try {
            $sql = "SELECT `category_name` AS name, `category_color` AS color FROM `cf_project_category` WHERE `category_id` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($id));
            $result = $query->fetch();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        if(!$result)
            throw new Exception("Unclassified");

        return $result;
    }

    function listCategory() {
        try {
            $sql = "SELECT `category_name` AS name, `category_id` AS id FROM `cf_project_category`;";
            $query = $this->db->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $result;
    }

}
?>