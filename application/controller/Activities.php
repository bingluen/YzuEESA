<?php
class Activities extends Controller
{
    function index() {
        //loading model
        $EventModel = $this->loadModel('eventmodel');

        //取得今天日期
        $today = time();

        //取得event data
        $events = $EventModel->listEvent();

        $i = 0;
        foreach ($events as $event) {
            $catchData = $EventModel->catchEventDetail($event->url);
            //取得活動結束日
            preg_match('/^[0-9:\x2F :]+/', $catchData['end'], $eventEndDay);
            $endDayTime = strtotime($eventEndDay[0]);
            if($endDayTime >= $today) {
                $data['fresh'][$i]['id'] = $event->id;
                $data['fresh'][$i]['name'] = $event->name;
                //刪除簡介內的活動標誌圖片
                $data['fresh'][$i]['description'] = preg_replace('/[ \n]*<img src=".*" \/>/', ' ', $catchData['description']);
                $data['fresh'][$i]['img'] = $catchData['img'];
                $data['fresh'][$i]['location'] = $catchData['location'];
                $data['fresh'][$i]['people'] = $catchData['people'];
                $data['fresh'][$i]['start'] = $catchData['start'];
                $data['fresh'][$i]['end'] = $catchData['end'];
                $data['fresh'][$i]['url'] = $event->url;
                $data['fresh'][$i]['googleCalendar'] = $catchData['googleCalendar'];
                $data['fresh'][$i]['iCal'] = $catchData['iCal'];
                $i++;
            }
        }
        $this->loadView('_templates/header');
        $this->loadView('event/event', $data);
        $this->loadView('_templates/footer');
    }

    function EventList($page = 0, $limit = 30) {
        //loading model
        $EventModel = $this->loadModel('eventmodel');

        //取得今天日期
        $today = time();

        //取得event data
        $events = $EventModel->listEvent($page, $limit);

        $i = 0;
        foreach ($events as $event) {
            $catchData = $EventModel->catchEventDetail($event->url);
            //取得活動結束日
            preg_match('/^[0-9:\x2F :]+/', $catchData['end'], $eventEndDay);
            $endDayTime = strtotime($eventEndDay[0]);
            if($endDayTime >= $today) {
                $data[$i]['fresh'] = true;
            } else {
                $data[$i]['fresh'] = false;
            }
                $data[$i]['id'] = $event->id;
                $data[$i]['name'] = $event->name;
                //刪除簡介內的活動標誌圖片
                $data[$i]['description'] = preg_replace('/[ \n]*<img src=".*" \/>/', ' ', $catchData['description']);
                $data[$i]['img'] = $catchData['img'];
                $data[$i]['location'] = $catchData['location'];
                $data[$i]['people'] = $catchData['people'];
                $data[$i]['start'] = $catchData['start'];
                $data[$i]['end'] = $catchData['end'];
                $data[$i]['googleCalendar'] = $catchData['googleCalendar'];
                $data[$i]['iCal'] = $catchData['iCal'];
                $i++;
        }
        if($page > 0 || $limit != 30) {
            echo json_encode($data);
            exit;
        }
        $this->loadView('_templates/header');
        $this->loadView('event/eventList', $data);
        $this->loadView('_templates/footer');
    }

    function Event($id) {
        $EventModel = $this->loadModel('eventmodel');

        //撈資料
        $event = $EventModel->getEvent($id);
        $catchData = $EventModel->catchEventDetail($event->url);

        //取得今天日期
        $today = time();

        //取得活動結束日
        preg_match('/^[0-9:\x2F :]+/', $catchData['end'], $eventEndDay);
        $endDayTime = strtotime($eventEndDay[0]);

        if($endDayTime >= $today) {
                $data['fresh'] = true;
            } else {
                $data['fresh'] = false;
            }
                $data['id'] = $event->id;
                $data['name'] = $event->name;
                $data['url'] = $event->url;
                //刪除簡介內的活動標誌圖片
                $data['description'] = preg_replace('/[ \n]*<img src=".*" \/>/', ' ', $catchData['description']);
                $data['img'] = $catchData['img'];
                $data['location'] = $catchData['location'];
                $data['people'] = $catchData['people'];
                $data['start'] = $catchData['start'];
                $data['end'] = $catchData['end'];
                $data['googleCalendar'] = $catchData['googleCalendar'];
                $data['iCal'] = $catchData['iCal'];

        try {
            $data['pages'] = $EventModel->getMessagesPages($id, 30);
        } catch (Exception $e) {
            $data['errorMessage'] = $e->getMessage();
            $data['errorCode'] = $e->getCode();
        }


        $this->loadView('_templates/header');
        $this->loadView('event/viewEvent', $data);
        $this->loadView('_templates/footer');
    }

    function getEventMessages($id , $page = 0) {
        $EventModel = $this->loadModel('eventmodel');
        $Messages = $EventModel->getEventMessages($id, $page - 1);
        echo json_encode($Messages);
        exit;
    }
}


?>