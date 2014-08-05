<div id="main">
    <div class="container-fluid">
        <ol class="breadcrumb breadcrumb-arrow SUNFLOWER">
            <li><a href="<?=URL?>"><i class="glyphicon glyphicon-home"></i> 首頁</a></li>
            <li class="active"><a href="<?=URL?>Messages/"><i class="glyphicon glyphicon-list-alt"></i> 最新資訊</a></li>
        </ol>
        <?php if(isset($data['errorCode'])) {?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4>Error </h4>
            <p>CODE <?=$data['errorCode']?> : <?=$data['errorMessage']?></p>
            <p>若您認為此訊息有誤，請透過 <a class="alert-link">問題聯繫</a> 回報給管理員</p>
            <p><a class="btn btn-danger" href="#" onclick="history.back()">回上一頁</a> <a class="btn btn-link" href="<?php echo URL;?>">Or 回首頁</a></p>
         </div>
        <?php } else { ?>

        <?php } ?>
    </div>
</div>