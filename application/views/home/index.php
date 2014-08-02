<div id="main">
    <div class="container-fluid">
        <div class="row">
            <!-- 公告區 -->
            <div class="col-sm-6">
                <h4>最新消息</h4>
                <hr>
                <ul>
                    <?php foreach ($data['messages'] as $messages) { ?>
                    <li><p><span class="label label-default"><?=date('Y-m-d', strtotime($messages->time))?></span>   <a href="<?php echo URL;?>Messages/View/<?=$messages->id?>"><?=$messages->title?></a></p></li>
                    <?php } ?>
                    <div class="text-right"><a href="<?php echo URL;?>messages/">More..</a></div>
                </ul>
                <h4>活動資訊</h4>
                <hr>
                <ul>
                    <li></li>
                </ul>
            </div>
        </div>
    </div>
</div>