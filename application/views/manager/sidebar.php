<ul class="panel nav nav-tabs nav-justified"  id="man-sidebar">
    <li <?php if($data == 'home') echo 'class="active"'; ?>><a href="">管理首頁</a></li>
    <li <?php if($data == 'CashFlow') echo 'class="active"'; ?>><a href="#" id="cashflow_tab" class="dropdown-toggle" data-toggle="dropdown">金流系統 <b class="caret"></b></a>
        <ul class="dropdown-menu" role="menu" aria-labelledby="myTabDrop1">
            <li><a href="<?php echo URL ?>webMan/CashFlow/Project" tabindex="-1" data-toggle="cashflow_tab">Project</a></li>
            <li><a href="<?php echo URL ?>webMan/CashFlow/Items" tabindex="-1" data-toggle="cashflow_tab">Items</a></li>
        </ul>
    </li>
    <li <?php if($data == 'Worker') echo 'class="active"'; ?>><a href="<?php echo URL ?>webMan/CashFlow/Worker">工人帳號</a></li>
    <li><a href="">登出系統</a></li>
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