<style type="text/css">
.deleteMember {
    padding: 0px;
    padding-left: 5px;
    cursor: pointer;
    background: none repeat scroll 0px 0px transparent;
    border: 0px none;
};
</style>
<div class="tab-content panel">
    <div class="tab-pane fade active in">
        <h3>所有計畫 / 活動</h3>
        <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>分類</th>
                        <th>計畫 / 活動名稱</th>
                        <th>狀態</th>
                        <th>負責人 / 總召</th>
                        <th>計畫成員</th>
                        <th>新增時間</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['project'] as $project) { ?>
                    <tr>
                        <td><input class="checkbox" type="checkbox" name="project-select" value="<?=$project->project_id;?>"></td>
                        <td>
                            <?php
                             if($project->project_category != 'Unclassified') { ?>
                            <span class="label" style="font-size:15px; background-color:<?=$project->project_category->color?> !important;">
                                <?=$project->project_category->name;?>
                            </span>
                            <?php } else { ?>
                            <span class="label label-default" style="font-size:15px;">
                                <?=$project->project_category;?>
                            </span>
                            <?php } ?>
                        </td>
                        <td><?=$project->project_name;?></td>
                        <td><?=($project->project_status === 'T')? '進行中':'已結案';?></td>
                        <td><?=$project->project_host;?></td>
                        <td><?php if(count($project->project_member) > 0 ) { foreach ($project->project_member as $member) { echo $member.'<br/>'; } }?></td>
                        <td><?=$project->project_time;?></td>
                        <td><button type="button" class="btn btn-default" onclick="editProject(<?=$project->project_id?>)">編輯</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="text-right">
                <button id="project-add-btn" type="button" class="btn btn-sm btn-primary">新增一個計畫 / 活動</button>
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
                <h4 class="modal-title" id="myModalLabel">新增計畫 / 活動</h4>
            </div>
            <div class="modal-body">
                <p><input id="add_project_name" class="form-control" type="text" placeholder="請輸入計畫名稱"></p>
                <p><input id="add_host" class="form-control" type="text" placeholder="請輸負責人"></p>
                <p>
                    <select name="category" class="form-control">
                        <option value="0">請選擇分類</option>
                        <?php foreach ($data['categoryList'] as $category) { ?>
                        <option value="<?=$category->id?>"><?=$category->name?></option>
                        <?php } ?>
                    </select>
                </p>
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

<div class="modal fade" id="editProject" tabindex="-1" role="dialog" aria-labelledby="editProjectLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="editProjectLabel">編輯計畫 / 活動</h4>
            </div>
            <div class="modal-body">
                <input id="editProjectId" class="form-control" type="hidden">
                <p><input id="editProjectName" class="form-control" type="text" placeholder="請輸入計畫名稱" value="" disabled></p>
                <p><input id="editHost" class="form-control" type="text" placeholder="請輸負責人" value="" disabled></p>
                <p>
                    <select name="editCategory" class="form-control" disabled>
                        <option value="0">請選擇分類</option>
                        <?php foreach ($data['categoryList'] as $category) { ?>
                            <option value="<?=$category->id?>"><?=$category->name?></option>
                        <?php } ?>
                    </select>
                </p>
                    <label for="projectEditMember" class="control-label">成員</label>
                    <div id="projectEditMember" style="font-size:18px;">
                    </div>
                    新增成員（按一下結果中的工人來新增）
                    <input id="searchWorkerKey" class="form-control" type="text" placeholder="輸入工人名稱進行搜尋">
                    <span id="workerSearchResult"></span>
                <p>
                </p>
                <div class="alert alert-danger" id="projectEditError">
                    <button type="button" class="close">×</button>
                    <strong>更新失敗 :</strong><div id='EditErrorMessage'></div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="do-editProject" type="button" class="btn btn-primary">更新計畫</button>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(
    function() {
        $('.close').click(
            function() {
                $('#projectAdd-error').hide();
                $('#projectEditError').hide();
            });
        $('#projectAdd-error').hide();
        $('#projectEditError').hide();

        $('#project-add-btn').click(
            function () {
                $('#myModal').modal('show');
            });

        $('#do-projectAdd').click(
            function() {
                if($('select[name="category"]').val() == 0) {
                    $('#error-message-here').empty();
                    $('#error-message-here').append('請選擇分類');
                    $('#projectAdd-error').show();
                } else {
                    $.ajax({
                        url: '<?=URL?>webMan/CashFlow/Project/insert',
                        dataType: 'json',
                        type: 'post',
                        data: {
                            name: $('#add_project_name').val(),
                            host: $('#add_host').val(),
                            category: $('select[name="category"]').val()
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
                }
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

$('#do-editProject').click(function() {

    var select = new Array();
    $('input[name="projectEditMemberList"]').each(function(i) { select[i] = this.value; });
    var member = ''
    for (var i = 0; i < select.length; i++) {
        if(i != 0) {
            member += ', ';
        }
        member += select[i];
    };
    $.ajax({
        url: '<?=URL?>webMan/CashFlow/Project/updateProjectMember',
        dataType: 'json',
        type: 'post',
        data: {
            target: $('#editProjectId').val(),
            member: member
        },
        success: function(response) {
            window.location.reload();
        },
        error: function (response) {
            console.log('response is not json');
            console.log(response);
        }
    });
})

function editProject(id) {
    $.ajax({
        url: '<?=URL?>webMan/CashFlow/Project/getDetail',
        dataType: 'json',
        type: 'post',
        data: {
            id: id
        },
        success: function(response) {
            //清空
            $('#editProjectId').removeAttr('value');
            $('#editProjectName').removeAttr('value');
            $('#editHost').removeAttr('value');
            $('#editCategory option:selected').removeAttr('selected');
            $('#projectEditMember').empty();
            //填資料
            $('#editProjectId').attr('value', response['project_id']);
            $('#editProjectName').attr('value', response['project_name']);
            $('#editHost').attr('value', response['project_host']);
            $('select[name="editCategory"] > option[value="'+response['project_category']+'"]').attr('selected', 'selected');
            displayWorker(response['project_member']);
            $('#editProject').modal('show');
        }
    });
}




function displayWorker(workers) {
    if(workers != '') {
        for (var worker in workers) {
            var str = '';
            str += '<div style="display: inline-block;" class="label label-default" id="';
            str += workers[worker]['id'];
            str += '">';
            str += workers[worker]['name'];
            str += '<button type="button" class="deleteMember" onclick="deleteMember(';
            str += workers[worker]['id'];
            str += ')">&times;</button>';
            str += '<input id="projectEditMemberList" name="projectEditMemberList" type="hidden" value="';
            str += workers[worker]['id'];
            str += '"></div>';
            $('#projectEditMember').append(str);
        }
    }
}

function deleteMember(Member) {
    $('div#'+Member).remove();
}

function addMember(id, name) {
    $('#workerResult-'+id).remove();
    var str = '';
    str += '<div style="display: inline-block;" class="label label-default" id="';
    str += id;
    str += '">';
    str += name;
    str += '<button type="button" class="deleteMember" onclick="deleteMember(';
    str += id;
    str += ')">&times;</button>';
    str += '<input id="projectEditMemberList" name="projectEditMemberList" type="hidden" value="';
    str += id;
    str += '"></div>';
    $('#projectEditMember').append(str);
}

function displayResult(searchResult) {
    var select = new Array();
    $('input[name="projectEditMemberList"]').each(function(i) { select[i] = this.value; });
    str = '';
    for(var item in searchResult) {
        var isAuth = false;
        for(var worker in select) {
            if(searchResult[item]['worker_id'] == select[worker]) {
                isAuth = true;
                break;
            }
        }
        if(!isAuth) {
            str += '<button id="workerResult-'+searchResult[item]['worker_id']+'" type="button" class="btn btn-primary" onclick="addMember(';
            str += searchResult[item]['worker_id'];
            str += ', \'';
            str += searchResult[item]['worker_name'];
            str += '\')">';
            str += searchResult[item]['worker_name'];
            str += '</button>';
        }
    }
    if(str == '')
        str += '沒有符合條件的工人';
    $('#workerSearchResult').append(str);
}

$('#searchWorkerKey').keyup(
    function() {
        $('#workerSearchResult').empty();
        if($('#searchWorkerKey').val() != '') {
            $.ajax({
                url: '<?=URL?>webMan/Worker/Worker/searchWorker',
                dataType: 'json',
                type: 'post',
                data: {
                    key: $('#searchWorkerKey').val()
                },
                success: function(response) {
                    displayResult(response);
                }
            });
        }
    });

</script>
