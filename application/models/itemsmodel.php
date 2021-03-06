<?php
class ItemsModel
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

    function getItems($project) {
        try {
            $sql = "SELECT * FROM `cf_items` WHERE `items_project` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($project));
            $result = $query->fetchAll();
        } catch(Exception $e) {
               throw new Exception($e->getMessage());
        }

        return $result;
    }

    function updateItems($data) {
        foreach ($data as $item) {
            $param = '';
            $param_val = '';
            if(isset($item['items_name'])) {
                $param = $param.'`items_name` = ?';
                $param_val[] = $item['item_name'];
            }

            if(isset($item['items_status'])) {
                if($param != '')
                    $param = $param. ',';
                $param = $param.'`items_status` = ?';
                $param_val[] = $item['items_status'];
            }

            if(isset($item['items_applicant'])) {
                if($param != '')
                    $param = $param. ',';
                $param = $param.'`items_applicant` = ?';
                $param_val[] = $item['items_applicant'];
            }

            if(isset($item['items_outlay'])) {
                if($param != '')
                    $param = $param. ',';
                $param = $param.'`items_outlay` = ?';
                $param_val[] = $item['items_outlay'];
            }

            if(isset($item['items_price'])) {
                if($param != '')
                    $param = $param. ',';
                $param = $param.'`items_price` = ?';
                $param_val[] = $item['items_price'];
            }

            if(isset($item['items_reviewer'])) {
                if($param != '')
                    $param = $param. ',';
                $param = $param.'`items_reviewer` = ?';
                $param_val[] = $item['items_reviewer'];
            }

            if(isset($item['items_rev_time'])) {
                if($param != '')
                    $param = $param. ',';
                $param = $param.'`items_rev_time` = ?';
                $param_val[] = $item['items_rev_time'];
            }


            $param_val[] = $item['items_id'];

            try {
                $sql = "UPDATE `cf_items` SET $param WHERE `items_id` = ?;";
                $query = $this->db->prepare($sql);
                $result = $query->execute($param_val);
            } catch(Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        return true;
    }

    function userItems($userid) {
        try {
            $sql = "SELECT * FROM `cf_items` WHERE `items_applicant` = ? ORDER BY items_app_time;";
            $query = $this->db->prepare($sql);
            $query->execute(array($userid));
            $result = $query->fetchAll();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        if(count($result) <= 0)
            throw new Exception("沒有申請東西");

        return $result;

    }

    function appItme($data) {
        try {
            $sql = "INSERT INTO `cf_items` (items_project, items_outlay, items_price, items_name, items_applicant, items_app_time) VALUES(?, ?, ?, ?, ?, ?);";
            $query = $this->db->prepare($sql);
            $query->execute(array($data['project'], $data['type'], $data['cost'], $data['name'], $data['applicant'], $data['time']));
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
        return true;
    }
}
?>