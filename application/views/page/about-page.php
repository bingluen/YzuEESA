    <div id="Content">
        <div class="sidebar-fixed" id="sidebar">
        <ul class="nav-tab nav nav-pills nav-stacked list-group">
            <li id="sidebar-abst" data-offset="70px"><a href="#abst">簡介</a></li>
            <li id="sidebar-core" data-offset="70px"><a href="#core">團隊</a></li>
        </ul>
        </div>
        <div class="main-content-with-sidebar">
            <h3 id="abst">系學會簡介 <small>Student Association Abstractions</small></h2>
            <h3 id="core">系學會團隊 <small>Student Association Team</small></h2>
                <div class="panel-group" id="sa-team">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#sa-team" href="#103-team">
                          ＃103級
                        </a>
                      </h4>
                    </div>
                    <div id="103-team" class="panel-collapse collapse in panel-group">
                      <div class="panel-body">

                            <?php
                                $team = array('103' =>
                                        array(
                                            'cposition' => '會長',
                                            'eposition' => 'President',
                                            'cname' => '盧兆品',
                                            'ename' => 'Samuel J. Lu Jr.',
                                            'photo' => '103-President.jpg'
                                        ),
                                        array(
                                            'cposition' => '副會長',
                                            'eposition' => 'Vice President',
                                            'cname' => '游縉',
                                            'ename' => 'Jin Yo',
                                            'photo' => '103-Vice-President.jpg'
                                        ),
                                        array(
                                            'cposition' => '執行秘書',
                                            'eposition' => 'Executive Secretary',
                                            'cname' => '蔡松宇',
                                            'ename' => 'Sung Yu Tsai',
                                            'photo' => '103-Executive-Secretary.jpg'
                                        ),
                                        array(
                                            'cposition' => '活動長',
                                            'eposition' => 'Activities Director',
                                            'cname' => '林哲民',
                                            'ename' => 'Che Ming Lin',
                                            'photo' => '103-Activities-Director.jpg'
                                        ),
                                        array(
                                            'cposition' => '副活動長 ',
                                            'eposition' => 'Dep. Activities Director',
                                            'cname' => '吳書祐',
                                            'ename' => 'Shu Yu Wu',
                                            'photo' => '103-Deputy-Activities-Director.jpg'
                                        ),
                                        array(
                                            'cposition' => '公關長',
                                            'eposition' => 'PR Director',
                                            'cname' => '凃宜瑩',
                                            'ename' => 'Yi Ying Tu',
                                            'photo' => '103-Public-Relations-Director.jpg'
                                        ),
                                        array(
                                            'cposition' => '副公關長 ',
                                            'eposition' => 'Dep. PR Director',
                                            'cname' => '鄧慧惠',
                                            'ename' => 'Hui Hui Teng',
                                            'photo' => '103-Deputy-Public-Relations-Director.jpg'
                                        ),
                                        array(
                                            'cposition' => '總務長 ',
                                            'eposition' => 'Treasurer',
                                            'cname' => '張軒豪',
                                            'ename' => 'Hsuan Hao Chang',
                                            'photo' => '103-Treasurer.jpg'
                                        ),
                                        array(
                                            'cposition' => '副總務長',
                                            'eposition' => 'Dep. Treasurer',
                                            'cname' => '李建勳',
                                            'ename' => 'Chien Hsun Lee',
                                            'photo' => '103-Deputy-Treasurer.jpg'
                                        ),
                                        array(
                                            'cposition' => '美宣長 ',
                                            'eposition' => 'Art/Design Director',
                                            'cname' => '黃玉茵',
                                            'ename' => 'Christiana Huang',
                                            'photo' => '103-Art_Design-Director.jpg'
                                        ),
                                        array(
                                            'cposition' => '副美宣長',
                                            'eposition' => 'Dep. Art/Design Director',
                                            'cname' => '王子謙',
                                            'ename' => 'Tzu Chien Wang',
                                            'photo' => '103-Deputy-Art_Design-Director.jpg'
                                        ),
                                        array(
                                            'cposition' => '資訊長',
                                            'eposition' => 'Chief Information Officer',
                                            'cname' => '陳奕文',
                                            'ename' => 'Jarvus Chen',
                                            'photo' => '103-Chief-Information-Officer.jpg'
                                        ),
                                        array(
                                            'cposition' => '器材長',
                                            'eposition' => 'Equipment Coordinator',
                                            'cname' => '鄭忠楠',
                                            'ename' => 'Zhong Nan Zheng',
                                            'photo' => '103-Equipment-Coordinator.jpg'
                                        ),
                                        array(
                                            'cposition' => '體育長',
                                            'eposition' => 'Athletics/Activities Director',
                                            'cname' => '張國威',
                                            'ename' => 'Kuo Wei Chang',
                                            'photo' => '103-Athletics_Activities-Director.jpg'
                                        ),
                                        array(
                                            'cposition' => '副體育長 ',
                                            'eposition' => 'Dep. Athletics/Activities Director',
                                            'cname' => '呂映萱',
                                            'ename' => 'Ying Hsueh Lu',
                                            'photo' => '103-Deputy-Athletics_Activities-Director.jpg'
                                        ),
                                        array(
                                            'cposition' => '學務長',
                                            'eposition' => 'Academic Affairs Director',
                                            'cname' => '莊秉倫',
                                            'ename' => 'Ping-Lun Chuang',
                                            'photo' => '103-Academic-Affairs-Director.jpg'
                                        )
                                    );
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
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#sa-team" href="#102-team">
                          ＃102級
                        </a>
                      </h4>
                    </div>
                    <div id="102-team" class="panel-collapse collapse">
                      <div class="panel-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#sa-team" href="#101-team">
                          ＃101級
                        </a>
                      </h4>
                    </div>
                    <div id="101-team" class="panel-collapse collapse">
                      <div class="panel-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
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
    $('#sidebar-abst').click(function () {
        $('html,body').animate({
            scrollTop: $('#abst').offset().top-offsetHeight
        }, 1000);
    });
    $('#sidebar-core').click(function () {
        $('html,body').animate({
            scrollTop: $('#core').offset().top-offsetHeight
        }, 1000);
    });

});
</script>