<div class="tab-content panel">
    <div class="tab-pane fade active in">
        <h3>申請審核</h3>
        <?php
            if(sizeof($data['project']) == 0) { ?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            沒有申請資料
        </div>
        <?php } ?>
    <?php
    foreach ($data['project'] as $project) { ?>
            <h4>
                ＃<?=$project->project_name; ?><small class="text-right">計畫負責人：<?=$project->project_host; ?></small>
            </h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>類型</th>
                        <th>項目</th>
                        <th>金額</th>
                        <th>申請人</th>
                        <th>狀態</th>
                        <th>審核人</th>
                        <th>申請時間</th>
                        <th>核准時間</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($data['items'][$project->project_id] as $item) {
                    ?>
                    <tr>                                <td><input class="checkbox" type="checkbox" name="items-<?=$item->items_project; ?>-select" value="<?=$item->items_id;?>"></td>
                        <td><?=($item->items_outlay === 'T') ? '<span class="label label-warning">支出</span>':'<span class="label label-info">收入</span>';?></td>
                        <td><?=$item->items_name;?></td>
                        <td><?=$item->items_price;?></td>
                        <td><?=$item->items_applicant;?></td>
                        <td><?=($item->items_status === '0') ? '<span class="label label-default">尚未審核</span>':(($item->items_status === '1')? '<span class="label label-success">已核准</span>':'<span class="label label-danger">不核准</span>');?></td>
                        <td><?=($item->items_reviewer === NULL) ? '--' : $item->items_reviewer;?></td>
                        <td><?=$item->items_app_time;?></td>
                        <td><?=($item->items_status === '0') ? '--':$item->items_rev_time;?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="text-right">
                    所有選取的申請項目
                    <button id="items-<?=$project->project_id; ?>-pass-btn" type="button" class="btn btn-sm btn-success">通過</button>
                    <button id="items-<?=$project->project_id; ?>-notpass-btn" type="button" class="btn btn-sm btn-danger">不通過</button>
            </div>
    <?php
     } ?>
    </div>
</div>

<script type="text/javascript">
$(document).ready(
    function() {
        <?php
            foreach ($data['project'] as $project) {
        ?>
        $('#items-<?=$project->project_id; ?>-pass-btn').click(
            function () {
                var selected = new Array();
                $('input[name="items-<?=$project->project_id; ?>-select"]:checked').each(function(i) { selected[i] = this.value; });
                $.ajax({
                    url: '<?=URL?>webMan/CashFlow/Items/pass',
                    dataType: 'json',
                    type: 'post',
                    data: {
                        target: selected,
                        status: '1'
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

        $('#items-<?=$project->project_id; ?>-notpass-btn').click(
            function () {
                var selected = new Array();
                $('input[name="items-<?=$project->project_id; ?>-select"]:checked').each(function(i) { selected[i] = this.value; });
                $.ajax({
                    url: '<?=URL?>webMan/CashFlow/Items/pass',
                    dataType: 'json',
                    type: 'post',
                    data: {
                        target: selected,
                        status: '2',
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
        <?php
        } ?>
    }
);
</script>