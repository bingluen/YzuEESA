<div class="tab-content panel" id="man-content">
    <div class="tab-pane fade active in">
    <h3>分組權限</h3>
    <hr>

        <div class="text-left function-btn">
            <button id="class-add-btn" type="button" class="btn btn-sm btn-primary">新增群組</button>
            <button id="class-disable-btn" type="button" class="btn btn-sm btn-success">更新</button>
            <button id="class-delete-btn" type="button" class="btn btn-sm btn-danger">刪除</button>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Id</th>
                    <th>Level</th>
                    <th>分組名稱</th>
                    <th>Authority</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['classList'] as $classList) { ?>
                <tr>
                    <td><input class="checkbox" type="checkbox" name="worker-select" value="<?=$classList->class_id;?>"></td>
                    <td><?=$classList->class_id;?></td>
                    <td><?=$classList->class_level;?></td>
                    <td><?=$classList->class_name;?></td>
                    <td><?=$classList->calss_authority;?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>
</div>