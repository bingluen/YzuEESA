<div id="main" class="container">

    <ol class="breadcrumb breadcrumb-arrow">
        <li><a href="<?=URL?>"><i class="glyphicon glyphicon-home"></i> 首頁</a></li>
        <li class="active"><span><i class="glyphicon glyphicon-leaf"></i> 關於系學會</span></li>
    </ol>

    <h3 id="abst">系學會簡介 <small>Student Association Abstractions</small></h2>
    <hr>

    <div class="Content-Text">

        <p>全名—<abbr title="Yuan Ze University Electrical Engineering Student Association">元智大學電機工程學系系學會</abbr>，簡稱—<abbr title="YZUEESA">元智電機系學會</abbr></p>
        <p>組織人數約500人</p>
        <p>總部位於</p>
        <ul>
            <li>32003桃園縣中壢市遠東路135號七館三樓R70310</li>
            <li>R70310, No.135, Yuan-tung Rd., Chungli City 32003, Taiwan</li>
        </ul>

        <p>系學會是由一群熱愛公眾事務的人所組成，在這個地方不限年級也不限班別，大家都是電機系大家庭中的一份子。我們樂於幫助別人，比如辦活動讓學弟妹們玩，或是讓學長姊們有個溫馨的畢業送舊。</p>
        <p>系學會不僅僅是辦活動，開常會，更重要的是能夠讓大家透過這個團體認識到更多人，使得原本互不相識的Ａ、Ｂ兩班，經過一次又一次的活動，最後變得熟識。這是一種難以言喻的力量，因為倘若沒有系學會這樣核心的團體，各個年級，各個班級可能就是單純的各走各的路，但是有了系學會，我們會漸漸發現，這個大學四年中，我們其實過得精彩又豐富。</p>
        <p>電機系學會大致上就各年級的角色制度而言，是以大三同學為主，原因和理由是希望幹部們都經過大二這一整年的磨練與經驗上的累積，在處理會務時，較能夠得心應手。而大二的同學們則主要是各活動的總召群，而由於他們和大一較熟（直屬關係），更可以由大二同學為出發點，連起大一與大三之間的那些線。至於大四，則通常在專心地準備研究所或出國的考試，較少參加學會的活動，但像火鍋大會、系烤等大家難得團圓的活動也常見大四的影子。</p>
        <p>系學會同時也是許多人砥礪自己的好地方，因為透過舉辦活動的實務經驗，我們可以在這些過程中累積很多課堂上學不到的知識。總之，我們相當地有自信且敢這麼說：「加入系學會，可以讓你找到方向！」</p>

    </div>

    <h3 id="core">系學會團隊 <small>Student Association Team</small></h2>

    <div class="panel-group" id="sa-team">

            <div class="panel panel-default">

            <div class="panel-heading">

                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#sa-team" href="#103-team">＃103級</a>
                </h4>

            </div>

            <div id="103-team" class="panel-collapse collapse in panel-group">

                <div class="panel-body">

                    <?php
                    $team = array ('103' =>
                                    array (
                                        'cposition' => '會長',
                                        'eposition' => 'President',
                                        'cname' => '盧兆品',
                                        'ename' => 'Samuel J. Lu Jr.',
                                        'photo' => '103-President.jpg'
                                    ),
                                    array (
                                        'cposition' => '副會長',
                                        'eposition' => 'Vice President',
                                        'cname' => '游縉',
                                        'ename' => 'Jin Yo',
                                        'photo' => '103-Vice-President.jpg'
                                    ),
                                    array (
                                        'cposition' => '執行秘書',
                                        'eposition' => 'Executive Secretary',
                                        'cname' => '蔡松宇',
                                        'ename' => 'Sung Yu Tsai',
                                        'photo' => '103-Executive-Secretary.jpg'
                                    ),
                                    array (
                                        'cposition' => '學務長',
                                        'eposition' => 'Academic Affairs Director',
                                        'cname' => '莊秉倫',
                                        'ename' => 'Ping-Lun Chuang',
                                        'photo' => '103-Academic-Affairs-Director.jpg'
                                    ),
                                    array (
                                        'cposition' => '活動長',
                                        'eposition' => 'Activities Director',
                                        'cname' => '林哲民',
                                        'ename' => 'Che Ming Lin',
                                        'photo' => '103-Activities-Director.jpg'
                                    ),
                                    array (
                                        'cposition' => '公關長',
                                        'eposition' => 'PR Director',
                                        'cname' => '凃宜瑩',
                                        'ename' => 'Yi Ying Tu',
                                        'photo' => '103-Public-Relations-Director.jpg'
                                    ),
                                    array (
                                        'cposition' => '總務長 ',
                                        'eposition' => 'Treasurer',
                                        'cname' => '張軒豪',
                                        'ename' => 'Hsuan Hao Chang',
                                        'photo' => '103-Treasurer.jpg'
                                    ),
                                    array (
                                        'cposition' => '美宣長 ',
                                        'eposition' => 'Art/Design Director',
                                        'cname' => '黃玉茵',
                                        'ename' => 'Christiana Huang',
                                        'photo' => '103-Art_Design-Director.jpg'
                                    ),
                                    array (
                                        'cposition' => '資訊長',
                                        'eposition' => 'Chief Information Officer',
                                        'cname' => '陳奕文',
                                        'ename' => 'Jarvus Chen',
                                        'photo' => '103-Chief-Information-Officer.jpg'
                                    ),
                                    array (
                                        'cposition' => '器材長',
                                        'eposition' => 'Equipment Coordinator',
                                        'cname' => '鄭忠楠',
                                        'ename' => 'Zhong Nan Zheng',
                                        'photo' => '103-Equipment-Coordinator.jpg'
                                    ),
                                    array (
                                        'cposition' => '體育長',
                                        'eposition' => 'Athletics/Activities Director',
                                        'cname' => '張國威',
                                        'ename' => 'Kuo Wei Chang',
                                        'photo' => '103-Athletics_Activities-Director.jpg'
                                    ),
                                    array (
                                        'cposition' => '副活動長 ',
                                        'eposition' => 'Dep. Activities Director',
                                        'cname' => '吳書祐',
                                        'ename' => 'Shu Yu Wu',
                                        'photo' => '103-Deputy-Activities-Director.jpg'
                                    ),
                                    array (
                                        'cposition' => '副公關長 ',
                                        'eposition' => 'Dep. PR Director',
                                        'cname' => '鄧慧惠',
                                        'ename' => 'Hui Hui Teng',
                                        'photo' => '103-Deputy-Public-Relations-Director.jpg'
                                    ),
                                    array (
                                        'cposition' => '副總務長',
                                        'eposition' => 'Dep. Treasurer',
                                        'cname' => '李建勳',
                                        'ename' => 'Chien Hsun Lee',
                                        'photo' => '103-Deputy-Treasurer.jpg'
                                    ),
                                    array (
                                        'cposition' => '副美宣長',
                                        'eposition' => 'Dep. Art/Design Director',
                                        'cname' => '王子謙',
                                        'ename' => 'Tzu Chien Wang',
                                        'photo' => '103-Deputy-Art_Design-Director.jpg'
                                    ),
                                    array (
                                        'cposition' => '副體育長 ',
                                        'eposition' => 'Dep. Athletics/Activities Director',
                                        'cname' => '呂映萱',
                                        'ename' => 'Ying Hsueh Lu',
                                        'photo' => '103-Deputy-Athletics_Activities-Director.jpg'
                                    )
                    );

                    foreach ($team as $member) { ?>

                        <div class="col-xs-6 col-sm-6 col-md-4">

                            <div class="thumbnail">

                                <div class="img-cut-32 img-cut">
                                    <img class="img-rounded" src="<?php echo URL;?>/public/img/about/team_member/<?=$member['photo']?>">
                                </div>

                                <div class="caption text-center">
                                    <h3><?=$member['cposition']?></h3>
                                    <p><?=$member['eposition']?></p>
                                    <p><?=$member['cname']?></p>
                                    <p><small><?=$member['ename']?></small></p>
                                    <p><a href="#" class="btn btn-warning" role="button">聯絡他</a> <a href="#" class="btn btn-default" role="button">？</a></p>
                                </div>

                            </div>
                        </div> <?php

                    } ?>

                </div>
            </div>
        </div>

    </div>
</div>