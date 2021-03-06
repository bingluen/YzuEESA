<ul class="panel nav nav-tabs nav-justified"  id="man-sidebar">
    <li <?php if($data == 'home') echo 'class="active"'; ?>><a href="<?php echo URL?>webMan/login/AuthSuccess">管理首頁</a></li>
    <li <?php if($data == 'Messages') echo 'class="active"'; ?>>
        <a href="#" id="messages_tab" class="dropdown-toggle" data-toggle="dropdown">公告系統 <b class="caret"></b></a>
        <ul class="dropdown-menu" role="menu" aria-labelledby="MessagesTabDrop">
            <li><a href="<?php echo URL ?>webMan/MessagesSystem/editor/NewPost" tabindex="-1" data-toggle="messages_tab">發新文章</a></li>
            <li><a href="<?php echo URL ?>webMan/MessagesSystem/PostList" tabindex="-1" data-toggle="messages_tab">管理文章</a></li>
        </ul>
    </li>
    <li <?php if($data == 'Event') echo 'class="active"'; ?>>
        <a href="#" id="Event_tab" class="dropdown-toggle" data-toggle="dropdown">活動系統 <b class="caret"></b></a>
        <ul class="dropdown-menu" role="menu" aria-labelledby="EventTabDrop">
            <li><a href="<?php echo URL ?>webMan/Event" tabindex="-1" data-toggle="Event_tab">系統說明</a></li>
            <li><a href="<?php echo URL ?>webMan/Event/EventList" tabindex="-1" data-toggle="Event_tab">活動列表</a></li>
            <li><a href="<?php echo URL ?>webMan/Event/EventCreate" tabindex="-1" data-toggle="Event_tab">舉辦活動</a></li>

        </ul>
    </li>
    <li <?php if($data == 'CashFlow') echo 'class="active"'; ?>>
        <a href="#" id="cashflow_tab" class="dropdown-toggle" data-toggle="dropdown">金流系統 <b class="caret"></b></a>
        <ul class="dropdown-menu" role="menu" aria-labelledby="CashTabDrop">
            <li><a href="<?php echo URL ?>webMan/CashFlow/Project" tabindex="-1" data-toggle="cashflow_tab">計畫管理</a></li>
            <li><a href="<?php echo URL ?>webMan/CashFlow/Items" tabindex="-1" data-toggle="cashflow_tab">申報審核</a></li>
            <li><a href="<?php echo URL ?>webMan/CashFlow/AppItem" tabindex="-1" data-toggle="cashflow_tab">帳務申報</a></li>
        </ul>
    </li>
    <li <?php if($data == 'Worker') echo 'class="active"'; ?>>
        <a href="#" id="worker_tab" class="dropdown-toggle" data-toggle="dropdown">工人系統 <b class="caret"></b></a>
        <ul class="dropdown-menu" role="menu" aria-labelledby="workerTabDrop">
            <li><a href="<?php echo URL ?>webMan/Worker/Worker" tabindex="-1" data-toggle="worker_tab">工人帳號</a></li>
            <li><a href="<?php echo URL ?>webMan/Worker/Authority" tabindex="-1" data-toggle="worker_tab">權限設定</a></li>
        </ul>
    </li>
    <li><a href="<?php echo URL ?>webMan/login/Logout">登出系統</a></li>
</ul>


<!--
<ul class="panel nav nav-tabs" id="man-sidebar">
    <li <?php if($data == 'home') echo 'class="active"'; ?>><a href="">管理首頁</a></li>
    <li <?php if($data == 'CashFlow') echo 'class="active"'; ?>><a href="">金流系統</a></li>
    <li <?php if($data == 'Worker') echo 'class="active"'; ?>><a href="">工人帳號</a></li>
    <li><a href="">登出系統</a></li>
</ul>

    流動版面廢棄
<ul class="panel nav nav-tabs nav-justified"  id="man-sidebar-max1023">
    <li <?php if($data == 'home') echo 'class="active"'; ?>><a href="">管理首頁</a></li>
    <li <?php if($data == 'CashFlow') echo 'class="active"'; ?>><a href="#" id="cashflow_tab" class="dropdown-toggle" data-toggle="dropdown">金流系統 <b class="caret"></b></a>
        <ul class="dropdown-menu" role="menu" aria-labelledby="myTabDrop1">
            <li><a href="" tabindex="-1" data-toggle="tab">Project</a></li>
            <li><a href="" tabindex="-1" data-toggle="tab">Items</a></li>
        </ul>
    </li>
    <li <?php if($data == 'Worker') echo 'class="active"'; ?>><a href="">工人帳號</a></li>
    <li><a href="">登出系統</a></li>
</ul>
-->