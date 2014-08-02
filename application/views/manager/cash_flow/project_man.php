<div class="tab-content panel" id="man-content">
    <div class="tab-pane fade active in">
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
                <button id="project-add-btn" type="button" class="btn btn-sm btn-primary">新增一個計畫</button>
                    或是   所有選取的Project
                <button id="project-doing-btn" type="button" class="btn btn-sm btn-info">設定為進行中</button>
                <button id="project-finish-btn" type="button" class="btn btn-sm btn-warning">設定為已結案</button>
                <button id="project-delete-btn" type="button" class="btn btn-sm btn-danger">刪除</button>
            </div>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">新增計畫</h4>
            </div>
            <div class="modal-body">
                <p><input id="add_project_name" class="form-control" type="text" placeholder="請輸入計畫名稱"></p>
                <p><input id="add_host" class="form-control" type="text" placeholder="請輸負責人"></p>
                <div class="alert alert-danger" id="projectAdd-error">
                    <button type="button" class="close" id="close_error_message">×</button>
                    <strong>新增失敗 :</strong><div id='error-message-here'></div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="do-projectAdd" type="button" class="btn btn-primary">新增計畫</button>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(
    function() {
        $('#close_error_message').click(
            function() {
                $('#projectAdd-error').hide();
            });
        $('#projectAdd-error').hide();

        $('#project-add-btn').click(
            function () {
                $('#myModal').modal('show');
            });

        $('#do-projectAdd').click(
            function() {
                $.ajax({
                    url: '<?=URL?>webMan/CashFlow/Project/insert',
                    dataType: 'json',
                    type: 'post',
                    data: {
                        name: $('#add_project_name').val(),
                        host: $('#add_host').val()
                    },
                    success: function(response) {
                        if(response === 'success')
                            window.location.reload();
                        else {
                            $('#error-message-here').empty();
                            $('#error-message-here').append(response);
                            $('#projectAdd-error').show();
                        }
                    },
                    error: function (response) {
                        console.log('response is not json');
                        console.log(response);
                    }
                });
        });


        $('#project-doing-btn').click(
            function () {
                var selected = new Array();
                $('input[name="project-select"]:checked').each(function(i) { selected[i] = this.value; });
                $.ajax({
                    url: '<?=URL?>webMan/CashFlow/Project/update',
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
                    url: '<?=URL?>webMan/CashFlow/Project/update',
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
                    url: '<?=URL?>webMan/CashFlow/Project/delete',
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
