<div class="tab-content panel" id="man-content">
    <div id="man-MainContent">
        <div class="alert alert-warning alert-dismissable" id="Alert-messages">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" id="close-alert">×</button>
            <strong>注意!</strong> 若編輯超過30分鐘，系統自動登出，文章會發送失敗。
        </div>
        <div class="form-group">
            <label for="title">文章標題</label>
            <input type="text" class="form-control" id="title" placeholder="Title" value="<?php
            if($data)
                echo $data['title'];
            ?>">
        </div>
        <textarea class="form-control" id="PostContent" style="width:100%">
        <?php
            if($data)
                echo $data['content'];
        ?>
        </textarea>
        <?php if($data) { ?>
        <input type="hidden" id="post_id" value="<?=$data['post_id']?>">
        <?php } ?>
        <p class="text-center" style="margin-top: 30px;">
            <button type="button" class="btn btn-primary" id="post-btn">發   布</button>
        </p>
    </div>
</div>

<script type="text/javascript" src="<?=URL?>public/js/tinymce/tinymce.min.js"></script>
<script>
$('#close-alert').click(function() {
    $('#Alert-messages').hide();
});
tinymce.init({
    selector: "textarea#PostContent",
    theme: "modern",
    height: 300,
    language : 'zh_TW',
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons paste textcolor"
   ],
   content_css: "<?=URL?>public/css/bootflat.css",
   toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
   style_formats: [
        {title: 'Bold text', inline: 'b'},
        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
        {title: 'Example 1', inline: 'span', classes: 'example1'},
        {title: 'Example 2', inline: 'span', classes: 'example2'},
        {title: 'Table styles'},
        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
    ]
 });

function goTo() {
    var url = window.location.toString();
    if(url.indexOf("editor/")!=-1)  {
        var ary=url.split("editor/");
    }
    document.location.href=ary[0]+'PostList';
}

<?php if($data) { ?>
$('#post-btn').click(function() {
    var url = window.location.toString();
    if(url.indexOf("editor/")!=-1)  {
        var ary=url.split("editor/");
    }
    $.ajax({
        url: ary[0]+'post/update',
        dataType: 'json',
        type: 'post',
        data: {
            title: $('#title').val(),
            content: tinyMCE.activeEditor.getContent(),
            id: $('#post_id').val()
        },
        success: function(response) {
            if(response == 'success')
                alert('文章已更新');
                goTo();
        },
        error: function (response) {
            console.log('response is not json');
            console.log(response);
        }
    });
});
<?php } else { ?>
$('#post-btn').click(function() {
    var url = window.location.toString();
    if(url.indexOf("editor/")!=-1)  {
        var ary=url.split("editor/");
    }
    $.ajax({
        url: ary[0]+'post/new',
        dataType: 'json',
        type: 'post',
        data: {
            title: $('#title').val(),
            content: tinyMCE.activeEditor.getContent(),
        },
        success: function(response) {
            alert('文章已發布');
            goTo();
        },
        error: function (response) {
            console.log('response is not json');
            console.log(response);
        }
    });
});
<?php } ?>
</script>

