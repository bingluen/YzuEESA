<div id="main" class="container">
    <ol class="breadcrumb breadcrumb-arrow">
        <li><a href="<?=URL?>"><i class="glyphicon glyphicon-home"></i> 首頁</a></li>
        <li><a href="<?=URL?>Activities/"><i class="glyphicon glyphicon-bullhorn"></i> 學會活動</a></li>
        <li><a href="<?=URL?>Activities/EventList"><i class="glyphicon glyphicon-bullhorn"></i> 活動列表</a></li>
        <li class="active"><span> <?=$data['name']?></span></li>
    </ol>
    <div id="event-menu">
        <div class="list-group">
            <a href="<?=URL?>Activities/" class="list-group-item">學會活動</a>
            <a href="<?=URL?>Activities/EventList" class="list-group-item">活動列表</a>
            <a href="<?=URL?>Activities/" class="list-group-item">活動相簿</a>
        </div>
    </div>
    <div id="event-content">
        <div class="panel">
            <ul id="eventTab" class="nav nav-tabs nav-justified">
                <li class="active"><a href="#info" data-toggle="tab">活動資訊</a></li>
                <li><a href="#ann" data-toggle="tab">活動公告</a></li>
                <li><a href="#sign-up" data-toggle="tab">活動報名</a></li>
            </ul>
            <div id="eventTabContent" class="tab-content">
                <div class="tab-pane fade active in" id="info">
                    <h3 text-align="center"><?=$data['name']?></h3>
                    <p><span class="glyphicon glyphicon-calendar"></span> <?=$data['start']?> ~ <?=$data['end']?>
                        <span>( <a href="<?=$data['iCal']?>">iCal/Outlook</a>, <a href="<?=$data['googleCalendar']?>" target="_blank">Google 日曆</a> )</span></p>
                    <p><span class="glyphicon glyphicon-map-marker"></span> <?=$data['location']?></p>
                    <p><span class="glyphicon glyphicon-user"></span> <?=$data['people']?></p>
                    <?php if($data['img'] != NULL) { ?>
                        <div class="img-cut32 img-cut">
                            <img class="img-rounded" src="<?=$data['img']?>">
                        </div>
                    <?php } ?>
                    <?=$data['description']?>
                </div>
                <div class="tab-pane fade" id="ann">

                </div>
                <div class="tab-pane fade" id="sign-up">
                    <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone...</p>
                </div>
            </div>
        </div>
    </div>

</div>