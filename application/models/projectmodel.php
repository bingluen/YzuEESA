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
            try {
                $sql = "UPDATE `cf_project` SET `project_name` = ?, `project_status` = ?, `project_host` = ? WHERE `project_id` = ?;";
                $query = $this->db->prepare($sql);
                $result = $query->excute(array($project['project_name'], $project['project_status'], $project['project_host'], $project['project_id']));
            } catch(Exception $e) {
                return $e->getMessage();
            }
        }

        return true;
    }

    function getProject() {
        try {
            $sql = "SELECT * FROM `cf_project`"
            $query = $this->db->prepare($sql);
            $result = $query->excute();
        } catch(Expection $e) {
            return $e->getMessage();
        }

        return $result
    }
}
?>