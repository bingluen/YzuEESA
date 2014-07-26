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
            $sql = "SELECT COUNT(*) AS count FROM `worker` WHERE `worker_name` = ? OR `worker_username` = ?;";
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
            $sql = "SELECT `worker_id` FROM `worker` WHERE `worker_name` = ? OR `worker_username` = ?;";
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
            $sql = "SELECT `worker_name` FROM `worker` WHERE `worker_id` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($worker));
            $result = $query->fetch();
        } catch(Exception $e) {
               return $e->getMessage();
        }

        if(!$result)
            return 'Null';

        return $result->worker_name;
    }

    function setWorkerProject($worker, $project) {
        //先把工人原本負責的projct拉出來
        try {
            $sql = "SELECT `worker_project` AS auth FROM `worker` WHERE `worker_name` = ? OR `worker_username` = ? OR `worker_id` = ?;";
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
            $sql = "UPDATE `worker` SET `worker_project` = ? WHERE `worker_name` = ? OR `worker_username` = ? OR `worker_id` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($auth, $worker, $worker, $worker));
        } catch(Exception $e) {
               return $e->getMessage();
        }
    }

    function getWorkerList() {
        try {
            $sql = "SELECT `worker_id`, `worker_level`, `worker_name`, `worker_username`, `worker_project`, `worker_lastlogin` FROM `worker`;";
            $query = $this->db->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
        } catch(Expection $e) {
            return $e->getMessage();
        }

        return $result;
    }

    function deleteWorker($data) {

        //先檢查金流系統中有沒有該工人申請的資料
        $deleteList = '';
        $deleteCount = 0;
        $not_delete = '';
        $notDeleteCount = 0;
        foreach($data as $items_id) {
            try {
                $sql = "SELECT COUNT(*) AS count FROM `cf_items` WHERE `items_applicant` = ?;";
                $query = $this->db->prepare($sql);
                $query->execute(array($items_id));
                $result = $query->fetch();
            } catch(Exception $e) {
                    return $e->getMessage();
            }

            if($result->count === '0') {
                $deleteList[]= $items_id;
                $deleteCount++;
            } else {
                $not_delete[] = $items_id;
                $notDeleteCount++;
            }
        }


        //若無則進行刪除
        if($deleteCount > 0) {
            foreach ($deleteList as $deleteItem) {
                try {
                    $sql = "DELETE FROM `worker` WHERE `worker_id` = ?;";
                    $query = $this->db->prepare($sql);
                    $query->execute(array($deleteItem));
                } catch(Exception $e) {
                        return $e->getMessage();
                }
            }
        }

        $execute_result['deleted'] = $deleteCount;
        $execute_result['notDelete'] = $notDeleteCount;
        $execute_result['result'] = true;
        return $execute_result;
    }

    function updateWorker($data, $batch = false) {
        if($batch) {
            foreach ($data as $worker) {
                $param = '';
                $param_val = '';

                if(isset($worker['worker_level'])) {
                    if($param != '')
                        $param = $param.', ';
                    $param = $param.'`worker_level` = ?';
                    $param_val[] = $worker['worker_level'];
                }

                if(isset($worker['worker_name'])) {
                    if($param != '')
                        $param = $param.', ';
                    $param = $param.'`worker_name` = ?';
                    $param_val[] = $worker['worker_name'];
                }

                if(isset($worker['worker_password'])) {
                    if($param != '')
                        $param = $param.', ';
                    $param = $param.'`worker_password` = ?';
                    $param_val[] = $worker['worker_password'];
                }

                if(isset($worker['worker_project'])) {
                    if($param != '')
                        $param = $param.', ';
                    $param = $param.'`worker_project` = ?';
                    $param_val[] = $worker['worker_project'];
                }

                if(isset($worker['worker_lastlogin'])) {
                    if($param != '')
                        $param = $param.', ';
                    $param = $param.'`worker_lastlogin` = ?';
                    $param_val[] = $worker['worker_lastlogin'];
                }

                if(isset($worker['worker_lastIP'])) {
                    if($param != '')
                        $param = $param.', ';
                    $param = $param.'`worker_lastIP` = ?';
                    $param_val[] = $worker['worker_lastIP'];
                }

                $param_val[] = $worker['worker_id'];

                try {
                    $sql = "UPDATE `worker` SET $param WHERE `worker_id` = ?;";
                    $query = $this->db->prepare($sql);
                    $result = $query->execute($param_val);
                } catch(Exception $e) {
                    return $e->getMessage();
                }
            }
        } else {
            $param = '';
            $param_val = '';

            if(isset($data['worker_level'])) {
                if($param != '')
                    $param = $param.', ';
                $param = $param.'`worker_level` = ?';
                $param_val[] = $data['worker_level'];
            }

            if(isset($data['worker_name'])) {
                if($param != '')
                    $param = $param.', ';
                $param = $param.'`worker_name` = ?';
                $param_val[] = $data['worker_name'];
            }

            if(isset($data['worker_password'])) {
                if($param != '')
                    $param = $param.', ';
                $param = $param.'`worker_password` = ?';
                $param_val[] = $data['worker_password'];
            }

            if(isset($data['worker_project'])) {
                if($param != '')
                    $param = $param.', ';
                $param = $param.'`worker_project` = ?';
                $param_val[] = $data['worker_project'];
            }

            if(isset($data['worker_lastlogin'])) {
                if($param != '')
                    $param = $param.', ';
                $param = $param.'`worker_lastlogin` = ?';
                $param_val[] = $data['worker_lastlogin'];
            }

            if(isset($data['worker_lastIP'])) {
                if($param != '')
                    $param = $param.', ';
                $param = $param.'`worker_lastIP` = ?';
                $param_val[] = $data['worker_lastIP'];
            }

            $param_val[] = $data['worker_id'];

            try {
                $sql = "UPDATE `worker` SET $param WHERE `worker_id` = ?;";
                $query = $this->db->prepare($sql);
                $result = $query->execute($param_val);
            } catch(Exception $e) {
                return $e->getMessage();
            }
        }


        return true;
    }

    function addWorker($data) {
        //先檢查帳號有沒有重複
        try {
            $sql = "SELECT `worker_name` AS name FROM `worker` WHERE `worker_username` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($data['worker_username']));
            $result = $query->fetchAll();
        } catch(Exception $e) {
               return $e->getMessage();
        }

        //已經有人用了，回傳資訊
        if(count($result) > 0)
            throw new Exception("工人".$result[0]->name."已經使用了這個帳號，請換一個", 3);

        //新增工人
        try {
            $sql = "INSERT INTO `worker` (worker_level, worker_name, worker_username, worker_password) VALUES(?, ?, ?, ?);";
            $query = $this->db->prepare($sql);
            $query->execute(array($data['worker_level'], $data['worker_name'], $data['worker_username'], $data['worker_password']));
        } catch(Exception $e) {
               return $e->getMessage();
        }

        return true;
    }

    function getWorkerDetail($id) {
        try {
            $sql = "SELECT `worker_level`, `worker_name`, `worker_username`, `worker_project` FROM `worker` WHERE `worker_id` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($id));
            $result = $query->fetch();
        } catch(Expection $e) {
            return $e->getMessage();
        }

        if(count($result) == 0)
            throw new Exception("沒有此工人資料", 4);

        return $result;
    }

    function authUser($authData) {
        //拉出密碼來比對
        try {
            $sql = "SELECT `worker_password`, `worker_id`,`worker_level` FROM `worker` WHERE `worker_username` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($authData['user']));
            $result = $query->fetch();
        } catch (Exception $e) {
            return $e->getMessage();
        }

        if(!$result)
            throw new Exception('帳號不存在', 901);

        if($result->worker_password === $authData['pw']) {
            $authResult['auth'] = true;
            $authResult['userid'] = $result->worker_id;
            $authResult['level'] = $result->worker_level;
            return $authResult;
        } else {
            throw new Exception('帳號或密碼錯誤', 902);
        }

    }
}
?>