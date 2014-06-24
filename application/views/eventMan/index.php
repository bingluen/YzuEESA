<?php
@session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>系學會活動管理頁</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jQuery -->
    <script src="<?php echo URL; ?>public/js/jquery-1.10.2.js"></script>
    <!--<script src="<?php echo URL; ?>public/js/jquery-ui-1.10.4.min.js"></script>-->
    <script src="<?php echo URL; ?>public/js/bootstrap.min.js"></script>
    <script src="<?php echo URL; ?>public/js/jquery-md5.js"></script>
    <!-- our JavaScript -->
    <!-- css -->
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/bootflat.min.css">
    <!--<link rel="stylesheet" href="<?php echo URL; ?>public/css/ui-lightness/jquery-ui-1.10.4.min.css">-->
    <!-- our css -->
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/yzueesa.css">
</head>
<body>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">管理系統登入</h4>
          </div>
          <div class="modal-body">
              <p><input id="account" class="form-control" type="text" placeholder="請輸入管理員帳號"></p>
              <p><input id="password" class="form-control" type="password" placeholder="請輸入管理員密碼"></p>
              <div class="alert alert-danger" id="login-error">
              <button type="button" class="close" id="close_error_message">×</button>
              <strong>登入失敗!</strong> 請確認帳號或密碼正確性.
              </div>
          </div>
          <div class="modal-footer">
            <button id="do-login" type="button" class="btn btn-primary">登入系統</button>
          </div>
        </div>
      </div>
    </div>

    <div id="page-content">
    </div>
    <script>
        $(document).ready(
            function() {
                $('#close_error_message').click(
                    function() {
                        $('#login-error').hide();
                    });
                $('#login-error').hide();
                $('#myModal').modal('show');
                $('#do-login').click(
                    function() {
                        var url = window.location.toString();
                        var eventName = "";
                        if(url.indexOf("event/")!=-1){
                             var ary=url.split("event/");
                             eventName = ary[1].split("/");
                        }
                        $.ajax({
                            url: ary[0]+'login/event/'+eventName,
                            dataType: 'json',
                            type: 'post',
                            data: {
                                account: $('#account').val(),
                                password: $.md5($('#password').val())
                            },
                            success: function(response) {
                                $('#page_content').append(response);
                                $('#myModal').modal('hide');
                                $('#page-content').append(response);
                            },
                            error: function(response) {
                                $('#login-error').show();
                            }
                        });
                    }
                );
            }
        );
    </script>
</body>