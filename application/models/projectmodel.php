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
            $sql = "INSERT INTO `cf_project` (project_name, project_host, project_time) VALUES(?, ?, ?);";
            $query = $this->db->prepare($sql);
            $result = $query->execute(array($data['project_name'], $data['project_host'], $data['project_time']));
        } catch(Exception $e) {
            return $e->getMessage();
        }

        return true;
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

            $param_val[] = $project['project_id'];

            try {
                $sql = "UPDATE `cf_project` SET $param WHERE `project_id` = ?;";
                $query = $this->db->prepare($sql);
                $result = $query->execute($param_val);
            } catch(Exception $e) {
                return $e->getMessage();
            }
        }

        return true;
    }

    function deleteProject($data) {

        //先檢查金流系統中有沒有該筆計畫的帳目
        foreach($data as $project_id) {

        }

        //若無則進行刪除
        try {
            $sql = "DELETE FROM `cf_project` WHERE `project_id` = ?;";
            $query = $this->db->prepare($sql);
            $result = $query->execute($deleteList);
        } catch(Exception $e) {
                return $e->getMessage();
        }

    }

    function getProject() {
        try {
            $sql = "SELECT * FROM `cf_project`;";
            $query = $this->db->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
        } catch(Expection $e) {
            return $e->getMessage();
        }

        return $result;
    }
}
?>