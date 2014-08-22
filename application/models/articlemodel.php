<?php
class ArticleModel
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

    function post($data) {
        try {
            $sql = "INSERT INTO `messages` (messages_title, messages_content, messages_author, messages_time, messages_draft, messages_type, messages_eventid) VALUES(?, ?, ?, ?, ?, ?, ?);";
            $query = $this->db->prepare($sql);
            $query->execute(array($data['title'], htmlspecialchars($data['content']), $data['author'], $data['time'], $data['draft'], $data['type'], $data['eventid']));
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }

        return true;
    }

    function updatePost($data) {
        try {
            $sql = "UPDATE `messages` SET `messages_title` = ?, `messages_content` = ?, `messages_author` = ?, `messages_time` = ?, `messages_draft` = ?, `messages_type` = ?, `messages_eventid` = ? WHERE `messages_id` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($data['title'], htmlspecialchars($data['content']), $data['author'], $data['time'], $data['draft'], $data['type'], $data['eventid'], $data['post_id']));
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return true;
    }

    function getPost($id) {
        try {
            $sql = "SELECT `messages_title` AS title, `messages_content` AS content FROM `messages` WHERE `messages_id` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($id));
            $result = $query->fetch();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        $result->content = html_entity_decode($result->content);
        return $result;
    }

    function listPost($page = 0, $limit = 15, $type = 0, $position = 0, $level = 0, $user = 0) {
        try {

            if($position == 0 ) { // 0 = 前台
                $sql = "SELECT `messages_id` AS id, `messages_title` AS title, `messages_time` AS time FROM `messages` WHERE `messages_draft` = '0' AND `messages_type` = '$type' ORDER BY `messages_time` DESC LIMIT $page, $limit;";
            } else if($position == 1) { // 1 = 後台
                if($level > 900)
                    $sql = "SELECT `messages_id`, `messages_draft`, `messages_title` AS title, `messages_time`, `messages_author`, `messages_type` FROM `messages` ORDER BY `messages_time` DESC LIMIT $page, $limit;";
                else
                    $sql = "SELECT `messages_id`, `messages_draft`, `messages_title` AS title, `messages_time`, `messages_author`, `messages_type` FROM `messages` WHERE `messages_author` = '$user' ORDER BY `messages_time` DESC LIMIT $page, $limit;";
            }
            $query = $this->db->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $result;
    }

    function deletePost($list) {
        foreach ($list as $id) {
            try {
                $sql = "DELETE FROM `messages` WHERE `messages_id` = ?;";
                $query = $this->db->prepare($sql);
                $query->execute(array($id));
            } catch(Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
        return true;
    }

    function publicPost($list) {
        foreach ($list as $id) {
            try {
                $sql = "UPDATE `messages` SET `messages_draft` = ? WHERE `messages_id` = ?;";
                $query = $this->db->prepare($sql);
                $query->execute(array(0, $id));
            } catch(Exception $e) {
                throw new Exception($e->getMessage());
            }
            return true;
        }
    }

    function draftPost($list) {
        foreach ($list as $id) {
            try {
                $sql = "UPDATE `messages` SET `messages_draft` = ? WHERE `messages_id` = ?;";
                $query = $this->db->prepare($sql);
                $query->execute(array(1, $id));
            } catch(Exception $e) {
                throw new Exception($e->getMessage());
            }
            return true;
        }
    }

    function getPages($dpp) {
        try {
            $sql = "SELECT (COUNT(*) DIV $dpp) AS pages, (COUNT(*) MOD $dpp) AS mode  FROM `messages`;";
            $query = $this->db->prepare($sql);
            $query->execute();
            $result = $query->fetch();
            if($result->mode > 0)
                return $result->pages+1;
            else
                return $result->pages;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    function viewPost($id) {
        try {
            $sql = "SELECT `messages_title` AS title, `messages_content` AS content, `messages_author` AS author, `messages_time` AS time FROM `messages` WHERE `messages_id` = ?";
            $query = $this->db->prepare($sql);
            $query->execute(array($id));
            $result = $query->fetch();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        if(!$result) {
            throw new Exception("文章不存在或已經被刪除。", 801);
        }

        $result->content = html_entity_decode($result->content);

        return $result;
    }

    function getAuthor($id) {
        try {
            $sql = "SELECT `messages_author` FROM `messages` WHERE `messages_id` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($id));
            $result = $query->fetch();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return $result->messages_author;
    }
}