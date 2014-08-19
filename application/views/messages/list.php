<div id="main">
        <ol class="breadcrumb breadcrumb-arrow SUNFLOWER">
            <li><a href="<?=URL?>"><i class="glyphicon glyphicon-home"></i> 首頁</a></li>
            <li class="active"><span><i class="glyphicon glyphicon-list-alt"></i> 最新資訊</span></li>
        </ol>

        <div class="alert alert-danger alert-dismissable" id="error">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4>Error </h4>
            <p>CODE <span id="errorCode"></span> : <span id="errorMessage"></span></p>
            <p>若您認為此訊息有誤，請透過 <a class="alert-link" href="https://www.facebook.com/messages/147429552025011" traget="_blank">問題聯繫</a> 回報給管理員</p>
            <p><a class="btn btn-danger" href="#" onclick="history.back()">回上一頁</a> <a class="btn btn-link" href="<?php echo URL;?>">Or 回首頁</a></p>
         </div>

        <div id="list">
            <table class="table">
                <tbody id="articleList">
                </tbody>
            </table>
            <div class="text-center">
                <ul class="pagination" id="article-pagination">
                </ul>
            </div>
        </div>

</div>

<script type="text/javascript">
var Pages = 1;
function RenewArticleList(page) {
    $.ajax({
        url: '<?=URL?>Messages/Page/'+page,
        dataType : 'json',
        type : 'post',
        success: function(response) {
            if(typeof(response['errorCode']) == 'undefined') {
                $('#error').hide();
                $('#list').show();
                $('#articleList tr').remove();
                displayArticleList(response);
            } else {
                $('#error').show();
                $('#list').hide();
                $('#errorCode').empty;
                $('#errorMessage').empty;
                $('#errorCode').append(response['errorCode']);
                $('#errorMessage').append(response['errorMessage']);
            }
        }
    });
}

function displayArticleList(data) {

    for(var i = 0;i < data.length;i++) {
        var str = '';
        str += '<tr>'
        str += '<td><a href="<?=URL?>Messages/View/'+data[i]['id']+'">'+data[i]['title']+'</a></td>';
        str += '<td>'+data[i]['time']+'</td>';
        str += '</tr>';
        $('#articleList').append(str);
    }
}

function changePage(page) {
    Pages = page;
    RenewArticleList(page);
    displayPagination(page);
}

function displayPagination(page) {
    $('#article-pagination li').remove();
    str = '';
    if(Pages <= 1) {
        str += '<li class="disabled"><a href="#">&laquo;</a></li>';
    } else {
        str += '<li><a href="#" onclick="changePage('+(Pages-1)+')">&laquo;</a></li>';
    }
    var startPage = 0
    if(page-5 < 0) {
        startPage = 1;
    } else {
        startPage = page-5;
    }
    for(i = startPage;i <= <?=$data['pages']?> && i <= startPage+10;i++) {
        if(i == page) {
            str += '<li class="active"><a href="#">'+i+' <span class="sr-only">(current)</span></a></li>';
        } else {
            str += '<li ><a href="#" onclick="changePage('+i+')">'+i+' </a></li>';
        }

    }
    if(Pages >= <?=$data['pages']?>) {
        str += '<li class="disabled"><a href="#">&raquo;</a></li>';
    } else {
        str += '<li><a href="#" onclick="changePage('+(Pages+1)+')">&raquo;</a></li>';
    }
    $('#article-pagination').append(str);
}
$(document).ready(
    function() {
        RenewArticleList(1);
        displayPagination(1);
        $('#error').hide();
});
</script>