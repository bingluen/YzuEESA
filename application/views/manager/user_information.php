<div class="tab-content panel">

    <div id="man-MainContent">
       <div class="panel panel-info" id="">
            <div class="panel-heading">
                <h4 class="panel-title">使用者資訊</h4>
            </div>

            <table class="table">

                <tr>
                    <td class="man-MainInfo">使用者</td>
                    <td><?php echo $data['name']; ?></td>
                </tr>

                <tr>
                    <td class="man-MainInfo">帳號</td>
                    <td><?php echo $_SESSION['user']; ?></td>
                </tr>

                <tr>
                    <td class="man-MainInfo">登入IP</td>
                    <td><?php echo $_SESSION['user_ip']; ?></td>
                </tr>

                <tr>
                    <td class="man-MainInfo">所屬群組</td>
                    <td><?php echo $data['class']; ?>（Level = <?php echo $_SESSION['level']?>)</td>
                </tr>

                <tr>
                    <td class="man-MainInfo">最後新增</td>
                    <td><?php echo $_SESSION['login_time']; ?></td>
                </tr>

                </table>
        </div>
    </div>


</div>