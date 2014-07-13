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

    function checkWorkerExist($worker) {
        try {
            $sql = "SELECT COUNT(*) AS count FROM `cf_worker` WHERE `worker_name` = ? OR `worker_username` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($worker, $worker));
            $result = $query->fetch();
        } catch(Exception $e) {
               return $e->getMessage();
        }

        if($result->count === '0')
            return false;

        return true;
    }

    function setWorkerProject($woker, $project) {
        //先把工人原本的權限拉出來
        try {
            $sql = "SELECT `woker_project` AS auth FROM `cf_worker` WHERE `worker_name` = ? OR `worker_username` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($worker, $worker));
            $result = $query->fetchAll();
        } catch(Exception $e) {
               return $e->getMessage();
        }

        if(count($result->auth) === '0')
            throw new Exception('沒有這個工人啦！')

        if(count($result->auth) > 1)
            throw new Exception("好像有人同名同姓欸？請改用輸入帳號的方式指定");

        $auth = $result->auth;

        //修改權限
        foreach ($project as $auth_key) {
            if($auth != '')
                $auth = $auth. ', ';
            $auth = $auth.$auth_key;
        }

        //回存權限
    }
}
?>