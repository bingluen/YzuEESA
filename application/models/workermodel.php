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

    private function getIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
          $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
          $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
          $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    function checkWorkerExist($worker) {
        try {
            $sql = "SELECT COUNT(*) AS count FROM `worker` WHERE `worker_name` = ? OR `worker_username` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($worker, $worker));
            $result = $query->fetch();
        } catch(Exception $e) {
               throw new Exception($e->getMessage());
        }

        if($result->count === '0')
            throw new Exception('沒有這個工人啦！', 911);

        if($result->count > 1)
            throw new Exception("好像有人同名同姓欸？請改用輸入帳號的方式指定", 912);

        return true;
    }

    function getWorkerID($worker) {
        try {
            $sql = "SELECT `worker_id` FROM `worker` WHERE `worker_name` = ? OR `worker_username` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($worker, $worker));
            $result = $query->fetchAll();
        } catch(Exception $e) {
               throw new Exception($e->getMessage());
        }

        if(count($result) === '0')
            throw new Exception('沒有這個工人啦！', 911);

        if(count($result) > 1)
            throw new Exception("好像有人同名同姓欸？請改用輸入帳號的方式查詢", 912);

        return $result[0]->worker_id;
    }

    function getWorkerName($worker) {
        try {
            $sql = "SELECT `worker_name` FROM `worker` WHERE `worker_id` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($worker));
            $result = $query->fetch();
        } catch(Exception $e) {
               throw new Exception($e->getMessage());
        }

        if(!$result)
            throw new Exception("帳號已刪除");


        return $result->worker_name;
    }

    function getWorkerList() {
        try {
            $sql = "SELECT `worker_id`, `worker_level`, `worker_name`, `worker_username`, `worker_lastlogin` FROM `worker`;";
            $query = $this->db->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
        } catch(Expection $e) {
            throw new Exception($e->getMessage());
        }

        return $result;
    }

    function searchWorker($key) {
        try {
            $sql = "SELECT `worker_id`, `worker_name` FROM `worker` WHERE `worker_name` LIKE ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array("%$key%"));
            $result = $query->fetchAll();
        } catch(Expection $e) {
            throw new Exception($e->getMessage());
        }
        return $result;
    }

    function deleteWorker($data) {

        $deleteList = '';
        $List = '';
        $deleteCount = 0;
        $not_delete = '';
        $notDeleteCount = 0;
        //檢查是不是SuperAdmin
        foreach($data as $items_id) {
            try {
                $level = $this->getLevel($items_id, 'worker_id');
            } catch(Exception $e) {
                throw new Exception($e->getMessage());
            }
            if($level != 999)
                $List[] = $items_id;
        }

        //先檢查金流系統中有沒有該工人申請的資料
        foreach($List as $items_id) {
            try {
                $sql = "SELECT COUNT(*) AS count FROM `cf_items` WHERE `items_applicant` = ?;";
                $query = $this->db->prepare($sql);
                $query->execute(array($items_id));
                $result = $query->fetch();
            } catch(Exception $e) {
                    throw new Exception($e->getMessage());
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
                        throw new Exception($e->getMessage());
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
                /*
                    權限檢查
                    1.不能修改level比自己大的資料
                    2.不能修改自己的level
                */
                if($worker['worker_id'] === $_SESSION['userid']) {
                    throw new Exception("不能修改自己的Level", 921);
                }

                if(isset($worker['worker_level']) && $worker['worker_level'] != $this->getLevel($worker['worker_id'], 'worker_id') && $this->getLevel($worker['worker_id'], 'worker_id') >= $_SESSION['level'])
                    throw new Exception("只能修改level比自己小的帳號喔", 920);

                $this->updateRow($worker);

            }
        } else {
            /*
                權限檢查
                1.不能修改level比自己大或同level資料
                2.不能修改自己的level
            */
            if($data['worker_id'] === $_SESSION['userid']) {
                throw new Exception("不能修改自己的Level", 921);
            }

            if(isset($data['worker_level']) && $data['worker_level'] != $this->getLevel($data['worker_id'], 'worker_id') && $this->getLevel($data['worker_id'], 'worker_id') >= $_SESSION['level'])
                throw new Exception("只能修改level比自己小的帳號喔", 920);


            $this->updateRow($data);

        }
    }

    function updateRow($data) {
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
            throw new Exception($e->getMessage());
        }
    }

    function addWorker($data) {
        //先檢查帳號有沒有重複
        try {
            $sql = "SELECT `worker_name` AS name FROM `worker` WHERE `worker_username` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($data['worker_username']));
            $result = $query->fetchAll();
        } catch(Exception $e) {
               throw new Exception($e->getMessage());
        }

        //已經有人用了，回傳資訊
        if(count($result) > 0)
            throw new Exception("工人".$result[0]->name."已經使用了這個帳號，請換一個", 913);

        //新增工人
        try {
            $sql = "INSERT INTO `worker` (worker_level, worker_name, worker_username, worker_password) VALUES(?, ?, ?, ?);";
            $query = $this->db->prepare($sql);
            $query->execute(array($data['worker_level'], $data['worker_name'], $data['worker_username'], $data['worker_password']));
        } catch(Exception $e) {
               throw new Exception($e->getMessage());
        }

        return true;
    }

    function getWorkerDetail($id) {
        try {
            $sql = "SELECT `worker_level`, `worker_name`, `worker_username` FROM `worker` WHERE `worker_id` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($id));
            $result = $query->fetch();
        } catch(Expection $e) {
            throw new Exception($e->getMessage());
        }

        if(count($result) == 0)
            throw new Exception("沒有此工人資料", 911);

        return $result;
    }

    function authUser($authData) {
        //拉出密碼來比對
        try {
            $sql = "SELECT `worker_id`, `worker_password`, `worker_level` FROM `worker` WHERE `worker_username` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($authData['user']));
            $result = $query->fetch();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        if(!$result)
            throw new Exception('帳號不存在', 901);

        if($result->worker_password === $authData['pw']) {
            $authResult['auth'] = true;
            $_SESSION['auth'] = 'yes';
            $_SESSION['user'] = $authData['user'];
            $_SESSION['userid'] = $result->worker_id;
            $_SESSION['level'] = $result->worker_level;
            $_SESSION['user_ip'] = $this->getIP();
            $_SESSION['login_time'] = date('Y-m-d H:i:s');

            //寫入登入紀錄
            try {
                $sql = "UPDATE `worker` SET `worker_lastIP` = ? , `worker_lastlogin` = ? WHERE `worker_id` = ?;";
                $query = $this->db->prepare($sql);
                $result = $query->execute(array($_SESSION['user_ip'], $_SESSION['login_time'], $_SESSION['userid']));
            } catch(Exception $e) {
                throw new Exception($e->getMessage());
            }

            return $authResult;
        } else {
            throw new Exception('帳號或密碼錯誤', 902);
        }
    }

    function getLevel($key = 0, $index = 0) {
        if($index === 0 || $key === 0)
            throw new Exception("No key or index be assigned", 990);

        if($index != 'worker_id' && $index != 'worker_name' && $index != 'worker_username')
            throw new Exception("the index value is error", 991);


        try {
            $sql = "SELECT `worker_level` AS level FROM `worker` WHERE `$index` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($key));
            $result = $query->fetchAll();
        } catch(Exception $e) {
               throw new Exception($e->getMessage());
        }

        if(count($result) === 0)
            throw new Exception('沒有這個工人啦！', 992);

        if(count($result) > 1)
            throw new Exception("有多個工人符合條件，請變更key或index", 993);

        return $result[0]->level;
    }


}
?>