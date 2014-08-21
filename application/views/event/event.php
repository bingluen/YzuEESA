<div id="main" class="container">
    <ol class="breadcrumb breadcrumb-arrow">
        <li><a href="<?=URL?>"><i class="glyphicon glyphicon-home"></i> 首頁</a></li>
        <li><a href="<?=URL?>Information/"><i class="glyphicon glyphicon-bullhorn"></i> 學會活動</a></li>
    </ol>
    <div id="event-menu">
        <div class="list-group">
            <a href="<?=URL?>Activities/" class="list-group-item active">學會活動</a>
            <a href="<?=URL?>Activities/EventList" class="list-group-item">活動列表</a>
            <a href="<?=URL?>Activities/" class="list-group-item">活動相簿</a>
        </div>
    </div>
    <div id="event-demo">
        <?php if(count($data['fresh']) > 0) {
            foreach ($data['fresh'] as $freshEvent) { ?>
            <div data-slidr="event-<?=$freshEvent['id']?>" class="thumbnail">
            <div class="caption">
                <h3 text-align="center"><?=$freshEvent['name']?></h3>
                <p><span class="glyphicon glyphicon-calendar"></span> <?=$freshEvent['start']?> ~ <?=$freshEvent['end']?>
                    <span>( <a href="<?=$freshEvent['iCal']?>">iCal/Outlook</a>, <a href="<?=$freshEvent['googleCalendar']?>" target="_blank">Google 日曆</a> )</span></p>
                <p><span class="glyphicon glyphicon-map-marker"></span> <?=$freshEvent['location']?></p>
                <p><span class="glyphicon glyphicon-user"></span> <?=$freshEvent['people']?></p>
                <?php if($freshEvent['img'] != NULL) { ?>
                    <div class="img-cut32 img-cut">
                        <img class="img-rounded" src="<?=$freshEvent['img']?>">
                    </div>
                <?php } ?>
                <?=$freshEvent['description']?>
                <iframe class="kktix" src="https://kktix.com/tickets_widget?slug=<?=$freshEvent['url']?>" frameborder="0" height="420" width="100%" vspace="0" hspace="0" marginheight="5" marginwidth="5" scrolling="auto" allowtransparency="true"></iframe>
            </div>
            </div>
        <?php } } else { ?>

            <div data-slidr="event-0" class="thumbnail">
            <div class="caption" text-align="center">
                <h3>現在沒有活動喔～</h3>
            </div>
            </div>
        <?php } ?>
    </div>

</div>

<script>
//slider
    slidr.create('event-demo', {
        breadcrumbs: true,
        controls: 'corner',
        theme: '#222',
        timing: { 'linear': '0.5s ease-in' },
        touch: true,
        transition: 'linear'
    }).start();
</script>