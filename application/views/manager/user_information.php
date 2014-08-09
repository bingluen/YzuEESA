<div class="tab-content panel" id="man-content">

    <div id="man-MainContent">
       <div class="panel panel-info" id="">
            <div class="panel-heading">
                <h4 class="panel-title">使用者資訊</h4>
            </div>
            <!--<p>Hi~ <?=$data['name']?> 你已經登入元智電機系學會網站管理後台，以下是你的身份資料</p>
            <p>登入帳號： <?=$_SESSION['user']?></p>
            <p>登入ip： <?=$_SESSION['user_ip']?></p>
            <p>所屬群組： <?=$data['class']?> （Level = <?=$_SESSION['level']?>）</p>
            <p>最後動作時間：<?=$_SESSION['login_time']?>（超過30分鐘沒有動作，系統將視為登出）</p> -->


            <table class="table">

                <tr>
                    <td class="man-MainInfo">使用者</td>
                    <td><? echo $data['name']; ?></td>
                </tr>

                <tr>
                    <td class="man-MainInfo">帳號</td>
                    <td><? echo $_SESSION['user']; ?></td>
                </tr>

                <tr>
                    <td class="man-MainInfo">登入IP</td>
                    <td><? echo $_SESSION['user_ip']; ?></td>
                </tr>


                <tr>
                    <td class="man-MainInfo">所屬群組</td>
                    <td><? echo $data['class']; ?>（Level = <? echo $_SESSION['level']?>)</td>
                </tr>

                <tr>
                    <td class="man-MainInfo">最後新增</td>
                    <td><? echo $_SESSION['login_time']; ?></td>
                </tr>
                </table>
        </div>
    </div> 


</div>