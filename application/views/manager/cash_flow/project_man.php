<div class="main-content-with-sidebar">
    <h3>所有活動</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>活動名稱</th>
                    <th>狀態</th>
                    <th>總召</th>
                    <th>新增時間</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    <h3>所有計畫</h3>
    <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>計畫名稱</th>
                    <th>狀態</th>
                    <th>負責人</th>
                    <th>新增時間</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['project'] as $project) { ?>
                <tr>
                    <td><input class="checkbox" type="checkbox" name="project-select" value="<?=$project->project_id;?>"></td>
                    <td><?=$project->project_name;?></td>
                    <td><?=($project->project_status === 'T')? '進行中':'已結案';?></td>
                    <td><?=$project->project_host;?></td>
                    <td><?=$project->project_time;?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="text-right">
            所有選取的Project
            <button id="project-doing-btn" type="button" class="btn btn-sm btn-info">設定為進行中</button>
            <button id="project-finish-btn" type="button" class="btn btn-sm btn-warning">設定為已結案</button>
            <button id="project-delete-btn" type="button" class="btn btn-sm btn-danger">刪除</button>
        </div>
</div>
<script>
$(document).ready(
    function() {
        $('#project-doing-btn').click(
            function () {
                var selected = new Array();
                $('input[name="project-select"]:checked').each(function(i) { selected[i] = this.value; });
                $.ajax({
                    url: 'update',
                    dataType: 'json',
                    type: 'post',
                    data: {
                        target: selected,
                        status: 'T'
                    },
                    success: function(response) {
                        window.location.reload();
                    },
                    error: function (response) {
                        console.log('response is not json');
                        console.log(response);
                    }
                });
            });

        $('#project-finish-btn').click(
            function () {
                var selected = new Array();
                $('input[name="project-select"]:checked').each(function(i) { selected[i] = this.value; });
                $.ajax({
                    url: 'update',
                    dataType: 'json',
                    type: 'post',
                    data: {
                        target: selected,
                        status: 'F'
                    },
                    success: function(response) {
                        window.location.reload();
                    },
                    error: function (response) {
                        console.log('response is not json');
                        console.log(response);
                    }
                });
            });

        $('#project-delete-btn').click(
            function () {
                var selected = new Array();
                $('input[name="project-select"]:checked').each(function(i) { selected[i] = this.value; });
                $.ajax({
                    url: 'delete',
                    dataType: 'json',
                    type: 'post',
                    data: {
                        target: selected
                    },
                    success: function(response) {
                        alert(response+'若刪除失敗，表示該計畫下有支出項目。');

                        window.location.reload();
                    },
                    error: function (response) {
                        console.log('response is not json');
                        console.log(response);
                    }
                });
            });
    }
);
</script>
