
<div class="main-content-with-sidebar">
    <h3>工人名單</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>等級</th>
                    <th>姓名</th>
                    <th>帳號</th>
                    <th>所屬活動/計畫</th>
                    <th>最後登入</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['workerList'] as $workerList) { ?>
                <tr>
                    <td></td>
                    <td><?=$workerList->worker_level;?></td>
                    <td><?=$workerList->worker_name;?></td>
                    <td><?=$workerList->worker_username;?></td>
                    <td><?=$workerList->woker_project;?></td>
                    <td><?=$workerList->worker_lastlogin;?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
</div>