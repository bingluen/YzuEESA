<?php
class WorkerModel
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
            throw new Exception('沒有這個工人啦！', 1);

        if($result->count > 1)
            throw new Exception("好像有人同名同姓欸？請改用輸入帳號的方式指定", 2);

        return true;
    }

    function getWorkerID($worker) {
        try {
            $sql = "SELECT `worker_id` FROM `cf_worker` WHERE `worker_name` = ? OR `worker_username` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($worker, $worker));
            $result = $query->fetchAll();
        } catch(Exception $e) {
               return $e->getMessage();
        }

        if(count($result) === '0')
            throw new Exception('沒有這個工人啦！', 1);

        if(count($result) > 1)
            throw new Exception("好像有人同名同姓欸？請改用輸入帳號的方式查詢", 2);

        return $result[0]->worker_id;
    }

    function getWorkerName($worker) {
        try {
            $sql = "SELECT `worker_name` FROM `cf_worker` WHERE `worker_id` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($worker));
            $result = $query->fetch();
        } catch(Exception $e) {
               return $e->getMessage();
        }

        return $result->worker_name;
    }

    function setWorkerProject($worker, $project) {
        //先把工人原本的權限拉出來
        try {
            $sql = "SELECT `woker_project` AS auth FROM `cf_worker` WHERE `worker_name` = ? OR `worker_username` = ? OR `worker_id` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($worker, $worker, $worker));
            $result = $query->fetchAll();
        } catch(Exception $e) {
               return $e->getMessage();
        }

        if(count($result) === 0)
            throw new Exception('沒有這個工人啦！', 1);

        if(count($result) > 1)
            throw new Exception("好像有人同名同姓欸？請改用輸入帳號的方式指定", 2);

        $auth = $result[0]->auth;

        //修改權限
        foreach ($project as $auth_key) {
            if($auth != '')
                $auth = $auth. ', ';
            $auth = $auth.$auth_key;
        }

        //回存權限

        try {
            $sql = "UPDATE `cf_worker` SET `woker_project` = ? WHERE `worker_name` = ? OR `worker_username` = ? OR `worker_id` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($auth, $worker, $worker, $worker));
        } catch(Exception $e) {
               return $e->getMessage();
        }
    }
}
?>