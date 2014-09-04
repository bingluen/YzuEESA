<?php
class ClassModel
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

    function listClass() {
        try {
            $sql = "SELECT * FROM `worker_class`;";
            $query = $this->db->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    function checkAuthority($level, $model = 0, $action = false) {
        if($model === 0)
            throw new Exception("model error", 851);

        //level大於900自動通過
        if($level > 900)
            return true;

        //拉回權限表
        try {
            $sql = "SELECT `calss_authority` AS Authority FROM `worker_class` WHERE `class_level` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($level));
            $result = $query->fetch();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        //檢查權限表
        if(!strpos($result->Authority, $model)) {
            if(!$action) {
                echo "
                <meta charset='utf8'>
                <script>
                alert('授權失敗，操作未經授權');
                history.back();
                </script>";
            }
            return false;
        }

        return true;
    }

    function getClassName($level) {
        try {
            $sql = "SELECT `class_name` AS class FROM `worker_class` WHERE `class_level` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($level));
            $result = $query->fetch();
        } catch(Exception $e) {
               throw new Exception($e->getMessage());
        }
        
        if(!$result)
            throw new Exception("this level isn't exists.", 980);

        return $result->class;

    }
}