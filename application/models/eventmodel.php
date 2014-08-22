<?php
class EventModel
{
    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    function catchEventDetail($url) {
        $content = '';
        $host = 'http://yzueesa.kktix.cc/events/'.$url;
        $connect = curl_init();
        $option = array(
            CURLOPT_URL => $host,
            CURLOPT_HEADER => 0,
            CURLOPT_REFERER => $host,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
            );
        curl_setopt_array($connect, $option);
        $content = curl_exec($connect);
        curl_close($connect);

        if(preg_match('/404 Page Not Found/', $content)) {
            return false;
        } else {
            //catch Time
            preg_match_all('/class="timezoneSuffix">(.*)<\/span> ~ /', $content, $catch);
            $data['start'] = $catch['1']['0'];
            preg_match_all('/~ <span class="timezoneSuffix">(.*)<\/span> /', $content, $catch);
            $data['end'] = $catch['1']['0'];

            //catch Location
            preg_match_all('/class="fa fa-map-marker"><\/i>(.*)<\/span>/', $content, $catch);
            $data['location'] = $catch['1']['0'];

            //catch the number of participants
            preg_match_all('/class="fa fa-male"><\/i>\x0A[ ]+(.*)/', $content, $catch);
            $data['people'] = $catch['1']['0'];

            //catch ima of description
            preg_match_all('/<div class="description">[ \n]+<img src="(.*)"/', $content, $catch);
            if(isset($catch['1']['0']))
                $data['img'] = $catch['1']['0'];
            else
                //$data['img'] = URL.'public/img/EventSystem/null-img.png';
                $data['img'] = NULL;

            //catch time calendar
            preg_match_all('/, <a href="(.*)" target="_blank">Google/', $content, $catch);
            $data['googleCalendar'] = $catch['1']['0'];
            preg_match_all('/<a href="(.*)">iCal/', $content, $catch);
            $data['iCal'] = $catch['1']['0'];

            //catch event description text
            //preg_match_all('/<div class="description">((.|\n)*)<\/div>/', $content, $catch);
            $Needle['start'] = strpos($content, '<div class="description">') + 25;
            $Needle['end'] = strpos($content, '</div>', $Needle['start']);
            $data['description'] = substr($content, $Needle['start'], $Needle['end']-$Needle['start']);

            return $data;
        }
    }

    function addEvent($data) {
        try {
            $sql = "INSERT INTO `event_list` (event_name, event_path, event_host) VALUES(?, ?, ?);";
            $query = $this->db->prepare($sql);
            $result = $query->execute(array($data['name'], $data['path'], $data['host']));
        } catch(Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    function listEvent($page = 0, $limit = 5, $position = 0, $level = 0, $user = 0) {
        try {
            if($position == 0) {
                $sql = "SELECT `event_id` AS id, `event_name` AS name, `event_path` AS url, `event_host` AS host FROM `event_list` ORDER BY `event_id` DESC LIMIT $page, $limit;";
            } else {
                if($level > 900) {
                    $sql = "SELECT `event_id` AS id, `event_name` AS name, `event_path` AS url, `event_host` AS host FROM `event_list` ORDER BY `event_id` DESC LIMIT $page, $limit;";
                } else {
                    $sql = "SELECT `event_id` AS id, `event_name` AS name, `event_path` AS url, `event_host` AS host FROM `event_list` WHERE `event_host` = '$user' ORDER BY `event_id` DESC LIMIT $page, $limit;";
                }
            }
            $query = $this->db->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }

    function getEvent($id) {
        try {
            $sql = "SELECT `event_id` AS id, `event_name` AS name, `event_path` AS url, `event_host` AS host FROM `event_list` WHERE `event_id` = ?";
            $query = $this->db->prepare($sql);
            $query->execute(array($id));
            $result = $query->fetch();
            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    function getEventList() {
        try {
            $sql = "SELECT `event_id` AS id, `event_name` AS name FROM `event_list` ORDER BY `event_id`";
            $query = $this->db->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    function getEventMessages($id, $page = 0, $limit = 30) {
        try {
            $sql = "SELECT `messages_id` AS id, `messages_title` AS title, `messages_time` AS time FROM `messages` WHERE `messages_draft` = '0' AND `messages_type` = '1' AND `messages_eventid` = ? ORDER BY `messages_time` DESC LIMIT $page, $limit;";
            $query = $this->db->prepare($sql);
            $query->execute(array($id));
            $result = $query->fetchAll();
            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    function getMessagesPages($dpp, $eventid) {
        try {
            $sql = "SELECT (COUNT(*) DIV $dpp) AS pages, (COUNT(*) MOD $dpp) AS mode  FROM `messages` WHERE `messages_eventid` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($eventid));
            $result = $query->fetch();
            if($result->mode > 0)
                return $result->pages+1;
            else
                return $result->pages;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    function getEventMessageContent($id) {
        try {
            $sql = "SELECT `messages_title` AS title, `messages_content` AS content, `messages_author` AS author, `messages_time` AS time FROM `messages` WHERE `messages_id` = ?;";
            $query = $this->db->prepare($sql);
            $query->execute(array($id));
            $result = $query->fetch();
            $result->content = html_entity_decode($result->content);
            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
?>