<div class="tab-content panel" id="man-content">
    <div class="tab-pane fade active in">
    <h3>工人名單</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>id</th>
                    <th>等級</th>
                    <th>姓名</th>
                    <th>帳號</th>
                    <th>所屬活動/計畫</th>
                    <th>最後登入</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['workerList'] as $workerList) { ?>
                <tr>
                    <td><input class="checkbox" type="checkbox" name="worker-select" value="<?=$workerList->worker_id;?>"></td>
                    <td><?=$workerList->worker_id;?></td>
                    <td><?=$workerList->worker_level;?></td>
                    <td><?=$workerList->worker_name;?></td>
                    <td><?=$workerList->worker_username;?></td>
                    <td><?=$workerList->worker_project;?></td>
                    <td><?=$workerList->worker_lastlogin;?></td>
                    <td><button type="button" class="btn btn-default" id="worker-edit-btn-<?=$workerList->worker_id;?>">編輯</button></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="text-right">
            <button id="worker-add-btn" type="button" class="btn btn-sm btn-primary">新增一個工人</button>
                或是   所有選取的Worker
            <button id="worker-disable-btn" type="button" class="btn btn-sm btn-warning">停權</button>
            <button id="worker-delete-btn" type="button" class="btn btn-sm btn-danger">刪除</button>
        </div>
    </div>
</div>


<div class="modal fade" id="addWorkerModal" tabindex="-1" role="dialog" aria-labelledby="addWorkerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="addWorkerModalLabel">新增工人</h4>
            </div>
            <div class="modal-body">
                <p><input id="add_worker_name" class="form-control" type="text" placeholder="請輸入工人姓名"></p>
                <p><input id="add_worker_username" class="form-control" type="text" placeholder="請輸入工人帳號"></p>
                <p><input id="add_worker_password" class="form-control" type="password" placeholder="請輸入工人密碼"></p>
                <p><input id="add_worker_level" class="form-control" type="number" placeholder="請輸入工人權限等級"></p>
                <div class="alert alert-danger" id="workerAdd-error">
                    <button type="button" class="close" id="close_error_message">×</button>
                    <strong>新增失敗 :</strong><div id='error-message-here'></div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="do-workerAdd" type="button" class="btn btn-primary">新增工人</b`utton>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editWorkerModal" tabindex="-1" role="dialog" aria-labelledby="editWorkerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="editWorkerModalLabel">編輯工人</h4>
            </div>
            <div class="modal-body">
                <input id="edit_worker_id" class="form-control" type="hidden">
                <p>
                    <label for="edit_worker_name" class="control-label">名稱</label>
                    <input id="edit_worker_name" class="form-control" type="text">
                </p>

                <p>
                    <label for="edit_worker_username" class="control-label">帳號</label>
                    <input id="edit_worker_username" class="form-control" type="text" disabled>
                </p>

                <p>
                    <label for="edit_worker_password" class="control-label">密碼</label>
                    <input id="edit_worker_password" class="form-control" type="password">
                </p>

                <p>
                    <label for="edit_worker_level" class="control-label">權限</label>
                    <input id="edit_worker_level" class="form-control" type="number">
                </p>

                <p>
                    <label for="edit_worker_level" class="control-label">所屬計畫/活動</label>
                    <h4 id="workerEdit_project">

                    </h4>
                </p>

                <div class="alert alert-danger" id="workerEdit-error">
                    <button type="button" class="close" id="workerEdit-close_error_message">×</button>
                    <strong>更新失敗 :</strong><div id='workerEdit-error-message-here'></div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="do-workerEdit" type="button" class="btn btn-primary">送出更新</b`utton>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
$(document).ready(
    function() {

        $('#workerEdit-close_error_message').click(
            function() {
                $('#workerEdit-error').hide();
            });
        $('#workerEdit-error').hide();

<?php foreach ($data['workerList'] as $workerList) { ?>
        $('#worker-edit-btn-<?=$workerList->worker_id;?>').click(
            function () {
                $.ajax({
                    url: 'editWorker',
                    dataType: 'json',
                    type: 'post',
                    data: {
                        doing: 'getDetail',
                        userid: '<?=$workerList->worker_id;?>'
                    },
                    success: function(response) {
                        $('#edit_worker_id').attr('value', '<?=$workerList->worker_id;?>');
                        $('#edit_worker_name').attr('value', response['worker_name']);
                        $('#edit_worker_username').attr('value', response['worker_username']);
                        $('#edit_worker_level').attr('value', response['worker_level']);
                        $('#workerEdit_project').empty();

                        console.log(response['worker_project']);
                        if(response['worker_project'] != '') {
                            for (var project in response['worker_project']) {
                                $('#workerEdit_project').append(
                                    '<span class="label label-default">'+response['worker_project'][project]['project_name']+'</span>'
                                    +'<input id="workerEdit_project" name="workerEdit_project" type="hidden" value="'+response['worker_project'][project]['project_id']+'">');
                            }
                        }

                        $('#editWorkerModal').modal('show');
                    }
                });
            });
<?php } ?>

        $('#do-workerEdit').click(
            function() {
                //決定要不要變更密碼
                var passwordChange = '';
                if($('#edit_worker_password').val() == '')
                    passwordChange = false;
                else
                    passwordChange = $.md5($('#edit_worker_password').val());

                $.ajax({
                    url: 'editWorker',
                    dataType: 'json',
                    type: 'post',
                    data: {
                        doing: 'updateWorker',
                        userid: $('#edit_worker_id').val(),
                        name: $('#edit_worker_name').val(),
                        password: passwordChange,
                        level: $('#edit_worker_level').val()
                    },
                    success: function(response) {
                        if(response === 'success')
                            window.location.reload();
                        else {
                            $('#workerEdit-error-message-here').empty();
                            $('#workerEdit-error-message-here').append(response);
                            $('#workerEdit-error').show();
                        }
                    },
                    error: function (response) {
                        console.log('response is not json');
                        console.log(response);
                    }
                });
        });

        $('#close_error_message').click(
            function() {
                $('#workerAdd-error').hide();
            });
        $('#workerAdd-error').hide();

        $('#worker-add-btn').click(
            function () {
                $('#addWorkerModal').modal('show');
            });

        $('#do-workerAdd').click(
            function() {
                $.ajax({
                    url: 'addWorker',
                    dataType: 'json',
                    type: 'post',
                    data: {
                        name: $('#add_worker_name').val(),
                        username: $('#add_worker_username').val(),
                        password: $.md5($('#add_worker_password').val()),
                        level: $('#add_worker_level').val()
                    },
                    success: function(response) {
                        if(response === 'success')
                            window.location.reload();
                        else {
                            $('#error-message-here').empty();
                            $('#error-message-here').append(response);
                            $('#workerAdd-error').show();
                        }
                    },
                    error: function (response) {
                        console.log('response is not json');
                        console.log(response);
                    }
                });
        });

        $('#worker-delete-btn').click(
            function () {
                var selected = new Array();
                $('input[name="worker-select"]:checked').each(function(i) { selected[i] = this.value; });
                $.ajax({
                    url: 'delete',
                    dataType: 'json',
                    type: 'post',
                    data: {
                        target: selected
                    },
                    success: function(response) {
                        alert(response+'已在金流系統申請經費之工人無法被刪除，只能進行停權。');

                        window.location.reload();
                    },
                    error: function (response) {
                        console.log('response is not json');
                        console.log(response);
                    }
                });
            });

        $('#worker-disable-btn').click(
            function () {
                var selected = new Array();
                $('input[name="worker-select"]:checked').each(function(i) { selected[i] = this.value; });
                $.ajax({
                    url: 'disable',
                    dataType: 'json',
                    type: 'post',
                    data: {
                        target: selected
                    },
                    success: function(response) {
                        alert(response+'已在金流系統申請經費之工人無法被刪除，只能進行停權。');

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