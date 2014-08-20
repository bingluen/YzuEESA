<div class="tab-content panel">
        <h3>新增活動</h3>
        <h4>Step 1.先上kktix新增活動</h4>

            <a href="https://kktix.com/dashboard/organizations/yzueesa" target="_blank">進入kktix</a>
        <h4>Step 2.回填到系學會系統</h4>
        <div class="form-group">
            <label class="control-label" for="eventName">活動名稱</label>
            <input tpye="text" class="form-control" id="eventName" placeholder="活動名稱">
        </div>
        <div class="form-group has-feedback" id="path-form">
            <label class="control-label" for="eventPath">活動網址</label>
            <div class="input-group">
                <div class="input-group-addon">http://yzueesa.kktix.cc/events/</div>
                <input type="text" class="form-control" id="eventPath" placeholder="kktix網址">
            </div>
            <label class="control-label" id="path-error-message"></label>
        </div>
        <button type="button" class="btn btn-default" id="preview-btn">抓取預覽</button>
        <h4>step 3.預覽</h4>
        <p>確認資料正確後，再新增到系統中</p>
        <div id="previewEvent" class="panel-body" style="display:none; margin: 30px;" width="70%">
            <div class="form-group">
                <label for="eventTime">活動時間</label>
                <input type="text" class="form-control" id="eventTime" disabled>
            </div>
            <div class="form-group">
                <label for="eventLocation">活動地點</label>
                <input type="text" class="form-control" id="eventLocation" disabled>
            </div>
            <div class="form-group">
                <label for="eventPeople">報名人數 / 活動人數</label>
                <input type="text" class="form-control" id="eventPeople" disabled>
            </div>
            <div class="form-group">
                <label for="eventDescription">活動介紹</label>
                <div id="eventDescription"></div>
            </div>
            <div class="form-group">
                <label for="eventSign">活動報名</label>
                <div id="eventSign"></div>
            </div>
        </div>
        <button type="button" class="btn btn-success" id="send-btn" disabled>新增到系學會網站</button>

        <div class="alert alert-danger" role="alert" id="InternalError" style="display:none;"></div>
</div>

<script>
function goTo() {
    document.location.href='<?=URL?>webMan/Event/EventList';
}


$('#preview-btn').click(function() {
    $('#send-btn').attr('disabled' ,true);
    $('#eventDescription').empty();
    $('#eventSign').empty();
    $('#previewEvent').hide();
    if($('#eventPath').val() == '') {
        $('#path-error-message').empty();
        $('#path-form').removeClass('has-error');
        $('#path-form').removeClass('has-warning');
        $('#path-form').addClass('has-warning');
        $('#path-error-message').append('<span class="glyphicon glyphicon-warning-sign"></span>網址不能為空');
    } else {
        $.ajax({
            url: '<?=URL?>webMan/Event/EventCreate/catchEvent',
            dataType: 'json',
            type: 'post',
            data: {
                url: $('#eventPath').val()
            },
            success: function(response) {
                $('#path-error-message').empty();
                $('#path-form').removeClass('has-error');
                $('#path-form').removeClass('has-warning');
                if(response == false) {
                    $('#path-form').addClass('has-error');
                    $('#path-error-message').append('<span class="glyphicon glyphicon-remove-sign"></span>抓不到活動頁面，請確定已經發布活動');
                } else {
                    $('#previewEvent').show();
                    $('#eventDescription').empty();
                    $('#eventSign').empty();
                    $('#eventTime').attr('value', response['start']+' ~ '+response['end']);
                    $('#eventLocation').attr('value', response['location']);
                    $('#eventPeople').attr('value', response['people']);
                    $('#eventDescription').append(response['description']);
                    $('#eventSign').append('<iframe class="kktix" src="https://kktix.com/tickets_widget?slug='+$('#eventPath').val()+'" frameborder="0" height="600" width="100%" vspace="0" hspace="0" marginheight="5" marginwidth="5" scrolling="auto" allowtransparency="true"></iframe>');
                    $('#send-btn').removeAttr('disabled');
                }
            },
            error: function (response) {
            }
        });
    }
});

$('#send-btn').click(function () {
    $.ajax({
        url: '<?=URL?>webMan/Event/EventCreate/insertToDatabase',
        dataType: 'json',
        type: 'post',
        data: {
            name: $('#eventName').val(),
            url: $('#eventPath').val()
        },
        success: function(response) {
            if(response == 'success') {
                goTo();
            } else {
                $('#InternalError').append('發生錯誤：'+response);
                $('#InternalError').show();
            }
        },
        error: function (response) {
        }
    });
});
</script>