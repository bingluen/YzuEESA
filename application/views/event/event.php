<div id="main" class="container">
    <ol class="breadcrumb breadcrumb-arrow">
        <li><a href="<?=URL?>"><i class="glyphicon glyphicon-home"></i> 首頁</a></li>
        <li><a href="<?=URL?>Information/"><i class="glyphicon glyphicon-bullhorn"></i> 學會活動</a></li>
    </ol>
    <div id="event-demo">
        <?php foreach ($data['fresh'] as $freshEvent) { ?>
            <div data-slidr="event-<?=$freshEvent['id']?>" class="thumbnail">
            <div class="img-cut32 img-cut">
                <img class="img-rounded" src="<?=$freshEvent['img']?>">
            </div>
            <div class="caption">
                <h3 text-align="center"><?=$freshEvent['name']?></h3>
                <p><span class="glyphicon glyphicon-calendar"></span> <?=$freshEvent['start']?> ~ <?=$freshEvent['end']?>
                    <span>( <a href="<?=$freshEvent['iCal']?>">iCal/Outlook</a>, <a href="<?=$freshEvent['googleCalendar']?>" target="_blank">Google 日曆</a> )</span></p>
                <p><span class="glyphicon glyphicon-map-marker"></span> <?=$freshEvent['location']?></p>
                <p><span class="glyphicon glyphicon-user"></span> <?=$freshEvent['people']?></p>
                <?=$freshEvent['description']?>
                <iframe class="kktix" src="https://kktix.com/tickets_widget?slug=<?=$freshEvent['url']?>" frameborder="0" height="420" width="100%" vspace="0" hspace="0" marginheight="5" marginwidth="5" scrolling="auto" allowtransparency="true"></iframe>
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