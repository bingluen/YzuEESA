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
                    <td><?=$worerList->worker_id;?></td>
                    <td><?=$worerList->worker_level;?></td>
                    <td><?=$worerList->worker_name;?></td>
                    <td><?=$worerList->worker_username;?></td>
                    <td><?=$worerList->woker_project;?></td>
                    <td><?=$worerList->worker_lastlogin;?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
</div>