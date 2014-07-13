<div id="Content">
        <div class="sidebar-fixed" id="sidebar">
        <ul class="nav-tab nav nav-pills nav-stacked list-group">
            <li id="sidebar-區塊id"><a href="#區塊id">區塊名稱</a></li>
        </ul>
        </div>
        <div class="main-content-with-sidebar">
            <h3 id="區塊id">區塊名稱 <small>區塊英文名</small></h2>
                <div class="Content-Text">
                    區塊內容
                </div>
            <h3 id="core">系學會團隊 <small>Student Association Team</small></h2>
                <div class="panel-group" id="sa-team">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#sa-team" href="#103-team">
                          ＃N級
                        </a>
                      </h4>
                    </div>
                    <div id="N-team" class="panel-collapse collapse in panel-group">
                      <div class="panel-body">

                            <?php
                                foreach ($team as $member) {
                            ?>
                                <div class="col-xs-6 col-sm-6 col-md-4">
                                  <div class="thumbnail">
                                    <div class="img-cut-32 img-cut"><img class="img-rounded" src="<?php echo URL;?>/public/img/about/team_member/<?=$member['photo']?>"></div>
                                    <div class="caption text-center">
                                      <h3><?=$member['cposition']?></h3>
                                      <p><?=$member['eposition']?></p>
                                      <p><?=$member['cname']?></p>
                                      <p><small><?=$member['ename']?></small></p>
                                      <p><a href="#" class="btn btn-warning" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
                                    </div>
                                  </div>
                                </div>
                            <?php } ?>

                      </div>
                    </div>
                  </div>
                </div>
        </div>
    </div>
<script>
$(document).ready(
    function() {
         $('body').attr('data-spy','scroll');
         $('body').attr('data-target','#sidebar');
    });

$(function () {
    $('body').scrollspy({
            target: '.nav-pills'
        });
    var offsetHeight = 70;
    });
    $('#sidebar-core').click(function () {
        $('html,body').animate({
            scrollTop: $('#core').offset().top-offsetHeight
        }, 1000);
    });
<?php ?>
    $('#sidebar-<?php 區塊ID ?>').click(function () {
        $('html,body').animate({
            scrollTop: $('#abst').offset().top-offsetHeight
        }, 1000);
<?php ?>
});
</script>