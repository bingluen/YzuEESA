<div class="tab-content panel" id="man-content">
    <div class="tab-pane fade active in">
        <h3>我提出的申項目</h3>
        <?php if(!isset($data['message'])) { ?>
        <table class="table">
            <thead>
                <tr>
                    <th>類型</th>
                    <th>項目</th>
                    <th>金額</th>
                    <th>狀態</th>
                    <th>審核人</th>
                    <th>申請時間</th>
                    <th>核准時間</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($data['appItems'] as $item) {
                ?>
                <tr>
                    <td><?=($item->items_outlay === 'T') ? '<span class="label label-warning">支出</span>':'<span class="label label-info">收入</span>';?></td>
                    <td><?=$item->items_name;?></td>
                    <td><?=$item->items_price;?></td>
                    <td><?=($item->items_status === '0') ? '<span class="label label-default">尚未審核</span>':(($item->items_status === '1')? '<span class="label label-success">已核准</span>':'<span class="label label-danger">不核准</span>');?></td>
                    <td><?=($item->items_reviewer === NULL) ? '--' : $item->items_reviewer;?></td>
                    <td><?=$item->items_app_time;?></td>
                    <td><?=($item->items_status === '0') ? '--':$item->items_rev_time;?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } else { ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?=$data['message']?>
        </div>
        <?php } ?>

        <h3>帳務申報</h3>
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th>類型</th>
                    <th>項目</th>
                    <th>金額</th>
                </tr>
            </thead>
            <tbody id ="appFrom">
                <tr>
                    <td>
                        <select name="type" class="form-control">
                            <option value="0">請選擇</option>
                            <option value="T">支出</option>
                            <option value="F">收入</option>
                        </select>
                    </td>
                    <td><input type="text" name="name" class="form-control" placeholder="輸入品項名稱和數量 ex. 硬碟 x 3"></td>
                    <td><input type="number" name="cost" class="form-control" placeholder="輸入本項目總金額 ex. 7800"></td>
                </tr>
            </tbody>
        </table>
        <div class="text-right">
            <button id="newRow-btn" type="button" class="btn btn-sm btn-default">增加一行</button>
            <button id="sendCheck-btn" type="button" class="btn btn-sm btn-info">進行申請</button>
        </div>
    </div>
</div>

<div class="modal fade" id="appItemModal" tabindex="-1" role="dialog" aria-labelledby="appItemModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">請選擇帳目所屬的Project/活動</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-warning alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong>注意!</strong> 一旦送出申請後就無法撤回，若選擇錯誤的Project/活動，審核時會直接否決，需要再次重新申請並選擇正確的Project/活動. 任何有欄位空白的資料申請不會被送出
        </div>
        <select id="project" class="form-control">
            <option value="0">請選擇</option>
            <?php foreach ($data['project'] as $project) { ?>
                <option value="<?=$project['key']?>"><?=$project['name']?></option>
            <?php } ?>
        </select>
        <div class="alert alert-danger alert-dismissable" id="error-message">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong>申請失敗 :</strong><div id='error-message-here'></div>
            </div>
      </div>
      <div class="modal-footer">
        <button id="send-btn" type="button" class="btn btn-primary">送出申請</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
$(document).ready(
    function() {
        $('#error-message').hide();
});
$('#newRow-btn').click(function () {
    var str = '';
    str += '<tr>';
    str += '<td>';
    str += '<select name="type" class="form-control">';
    str += '<option value="0">請選擇</option>';
    str += '<option value="T">支出</option>';
    str += '<option value="F">收入</option>';
    str += '</select>';
    str += '</td>';
    str += '<td><input type="text" name="name" class="form-control" placeholder="輸入品項名稱和數量 ex. 硬碟 x 3"></td>';
    str += '<td><input type="number" name="cost" class="form-control" placeholder="輸入本項目總金額 ex. 7800"></td>';
    str += '</tr>';
    $('#appFrom').append(str);
});

$('#sendCheck-btn').click(function() {
    $('#appItemModal').modal('show')
});

$('#send-btn').click(function() {
    //先抓全部的值
    var type = new Array();
    $('select[name="type"]').each(function(i) {
        if(this.value != 0)
            type[i] = this.value;
    });
    var name = new Array();
    $('input[name="name"]').each(function(i) {
            name[i] = this.value;
    });
    var cost = new Array();
    $('input[name="cost"]').each(function(i) {
            cost[i] = this.value;
    });

    //把有空白的資料都刪掉
    var typeData = new Array();
    var nameData = new Array();
    var costData = new Array();
    var j = 0
    for (var i = type.length - 1; i >= 0; i--) {
        if(type[i] != '' && name[i] != '' && cost[i] != '') {
            typeData[j] = type[i];
            nameData[j] = name[i];
            costData[j] = cost[i];
            j++;
        }
    };

    if($('#project').val() == 0) {
        $('#error-message-here').empty();
        $('#error-message-here').append('要選擇計畫喔～');
        $('#error-message').show();


    } else {
        //ajax送資料
        $.ajax({
            url: '<?=URL?>webMan/CashFlow/AppItem/sendApp',
            dataType: 'json',
            type: 'post',
            data: {
                type: typeData,
                name: nameData,
                cost: costData,
                project: $('#project').val()
            },
            success: function(response) {
                if(response === 'success')
                    window.location.reload();
                else {
                    $('#error-message-here').empty();
                    $('#error-message-here').append(response);
                    $('#error-message').show();
                }
            },
            error: function (response) {
                console.log('response is not json');
                console.log(response);
            }
        });
    }

});
</script>