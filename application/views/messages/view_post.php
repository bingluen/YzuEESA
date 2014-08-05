<div id="main">
    <div class="container-fluid">
        <ol class="breadcrumb breadcrumb-arrow SUNFLOWER">
            <li><a href="<?=URL?>"><i class="glyphicon glyphicon-home"></i> 首頁</a></li>
            <li><a href="<?=URL?>Messages/"><i class="glyphicon glyphicon-list-alt"></i> 最新資訊</a></li>
            <li class="active"><span><i class="glyphicon glyphicon-comment"></i> 檢視資訊</span></li>
        </ol>
        <?php if(isset($data['errorCode'])) {?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4>Error </h4>
            <p>CODE <?=$data['errorCode']?> : <?=$data['errorMessage']?></p>
            <p>若您認為此訊息有誤，請透過 <a class="alert-link" href="https://www.facebook.com/messages/147429552025011" traget="_blank">問題聯繫</a> 回報給管理員</p>
            <p><a class="btn btn-danger" href="#" onclick="history.back()">回上一頁</a> <a class="btn btn-link" href="<?php echo URL;?>">Or 回首頁</a></p>
         </div>
        <?php } else { ?>
        <div id="articleTitle"><h3><?=$data['article']->title?></h3></div>
        <hr>
        <div id="articleContent">
            <?=$data['article']->content?>
        </div>
        <div id="articleFooter">
            <p><small><?=$data['article']->author?> 於 <?=$data['article']->time?> 編輯</small></p>
        </div>
        <?php } ?>
    </div>
</div>