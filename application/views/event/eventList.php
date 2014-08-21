<div id="main" class="container">
    <ol class="breadcrumb breadcrumb-arrow">
        <li><a href="<?=URL?>"><i class="glyphicon glyphicon-home"></i> 首頁</a></li>
        <li><a href="<?=URL?>Activities/"><i class="glyphicon glyphicon-bullhorn"></i> 學會活動</a></li>
        <li class="active"><span><i class="glyphicon glyphicon-th-list"></i> 活動列表</span></li>
    </ol>
    <div id="event-menu">
        <div class="list-group">
            <a href="<?=URL?>Activities/" class="list-group-item">學會活動</a>
            <a href="<?=URL?>Activities/EventList" class="list-group-item active">活動列表</a>
            <a href="<?=URL?>Activities/" class="list-group-item">活動相簿</a>
        </div>
    </div>
    <div id="event-list">
        <ul class="media-list">
             <?php if(count($data) > 0) {
                foreach ($data as $Event) { ?>
                <li class="media well">
                    <a class="pull-left" href="<?php echo URL."Activities/Event/".$Event['id']; ?>">
                        <img class="media-object img-rounded" src="<?=($Event['img'] == NULL) ? URL.'public/img/EventSystem/null-img.png':$Event['img']?>"></a>
                    <div class="media-body">
                        <h4 class="media-heading"><a href="<?php echo URL."Activities/Event/".$Event['id']; ?>"><?=$Event['name']?></a></h4>
                        <p><span class="glyphicon glyphicon-calendar"></span> <?=$Event['start']?> ~ <?=$Event['end']?>
                            <span>( <a href="<?=$Event['iCal']?>">iCal/Outlook</a>, <a href="<?=$Event['googleCalendar']?>" target="_blank">Google 日曆</a> )</span></p>
                        <p><span class="glyphicon glyphicon-map-marker"></span> <?=$Event['location']?></p>
                        <p><span class="glyphicon glyphicon-user"></span> <?=$Event['people']?></p>
                        <?php
                            //顯示介紹前100字元
                            echo mb_substr(strip_tags($Event['description']), 0, 100, "UTF-8");
                        ?>
                    </div>
                </li>
            <?php } }?>
        </ul>
    </div>

</div>