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
        $j = 0;
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
            } else {
                $data['expired'][$j]['id'] = $event->id;
                $data['expired'][$j]['name'] = $event->name;
                //刪除簡介內的活動標誌圖片

                $data['expired'][$j]['description'] = preg_replace('/[ \n]*<img src=".*" \/>/', ' ', $catchData['description']);
                $dataa['expired'][$j]['img'] = $catchData['img'];
                $data['expired'][$j]['location'] = $catchData['location'];
                $data['expired'][$j]['people'] = $catchData['people'];
                $data['expired'][$j]['start'] = $catchData['start'];
                $data['expired'][$j]['end'] = $catchData['end'];
                $data['expired'][$i]['url'] = $event->url;
                $data['expired'][$i]['googleCalendar'] = $catchData['googleCalendar'];
                $data['expired'][$i]['iCal'] = $catchData['iCal'];
                $j++;
            }
        }
        $this->loadView('_templates/header');
        $this->loadView('event/event', $data);
        $this->loadView('_templates/footer');
    }
}


?>