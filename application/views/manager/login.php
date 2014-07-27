<div class="" id="login-page">
    <div class="panel panel-default" id="login-form">
        <div class="panel-heading">管理系統登入</div>
        <div class="panel-body">
            <?php if(isset($msg) && $msg != 0) { ?>
            <div class="alert alert-danger" id="auth-error">
                <strong>授權失敗 :</strong><?=$msg?>
            </div>
            <?php } ?>
            <div class="form-group">
                <label for="username">登入帳號</label>
                <input type="text" class="form-control" id="username" placeholder="input your username">
            </div>

            <div class="form-group">
                <label for="password">登入密碼</label>
                <input type="password" class="form-control" id="password" placeholder="input your password">
            </div>
            <div class="alert alert-danger" id="login-error">
                <button type="button" class="close" id="close_error_message">×</button>
                <strong>登入失敗 :</strong><span id='error-message-here'></span>
            </div>
            <div class="alert alert-success" id="login-success">
                <button type="button" class="close" id="close_success_message">×</button>
                <strong>登入成功!</strong>
            </div>
            <div class="text-left"><button id="doLogin" class="btn btn-defaul">登入</button></div>
        </div>
    </div>
</div>
<script>
function goTo() {
    var url = window.location.toString();
    if(url.indexOf("login/")!=-1)  {
        var ary=url.split("login/");
    }
    document.location.href=ary[0]+'login/AuthSuccess';
}
$(document).ready(
    function() {
        $('#close_error_message').click(
            function() {
                $('#login-error').hide();
            });
        $('#login-error').hide();

        $('#close_success_message').click(
            function() {
                $('#login-success').hide();
            });
        $('#login-success').hide();

        $('#doLogin').click(
            function () {
                var url = window.location.toString();
                if(url.indexOf("login/")!=-1)  {
                    var ary=url.split("login/");
                }
                $.ajax({
                    url: ary[0]+'login/Auth',
                    dataType: 'json',
                    type: 'post',
                    data: {
                        username: $('#username').val(),
                        password: $.md5($('#password').val())
                    },
                    success: function(response) {
                        if(response == 'success') {
                            setTimeout("goTo()", 5000);
                            $('#login-success').show();
                        } else {
                            $('#error-message-here').empty();
                            $('#error-message-here').append(response);
                            $('#login-error').show();
                        }
                    },
                    error: function (response) {
                        console.log('response is not json');
                    }
                });
            });
    });
</script>