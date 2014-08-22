<div id="main" class="container">
    <ol class="breadcrumb breadcrumb-arrow">
        <li><a href="<?=URL?>"><i class="glyphicon glyphicon-home"></i> 首頁</a></li>
        <li><a href="<?=URL?>Activities/"><i class="glyphicon glyphicon-bullhorn"></i> 學會活動</a></li>
        <li><a href="<?=URL?>Activities/EventList"><i class="glyphicon glyphicon-bullhorn"></i> 活動列表</a></li>
        <li class="active"><span> <?=$data['name']?></span></li>
    </ol>
    <div id="event-menu">
        <div class="list-group">
            <a href="<?=URL?>Activities/" class="list-group-item">學會活動</a>
            <a href="<?=URL?>Activities/EventList" class="list-group-item">活動列表</a>
            <a href="<?=URL?>Activities/" class="list-group-item">活動相簿</a>
        </div>
    </div>
    <div id="event-content">
        <div class="panel">
            <ul id="eventTab" class="nav nav-tabs nav-justified">
                <li class="active"><a href="#info" data-toggle="tab">活動資訊</a></li>
                <li><a href="#ann" data-toggle="tab">活動公告</a></li>
                <li><a href="#sign-up" data-toggle="tab">活動報名</a></li>
            </ul>
            <div id="eventTabContent" class="tab-content">
                <div class="tab-pane fade active in" id="info">
                    <h3 text-align="center"><?=$data['name']?></h3>
                    <p><span class="glyphicon glyphicon-calendar"></span> <?=$data['start']?> ~ <?=$data['end']?>
                        <span>( <a href="<?=$data['iCal']?>">iCal/Outlook</a>, <a href="<?=$data['googleCalendar']?>" target="_blank">Google 日曆</a> )</span></p>
                    <p><span class="glyphicon glyphicon-map-marker"></span> <?=$data['location']?></p>
                    <p><span class="glyphicon glyphicon-user"></span> <?=$data['people']?></p>
                    <?php if($data['img'] != NULL) { ?>
                        <div class="img-cut32 img-cut">
                            <img class="img-rounded" src="<?=$data['img']?>">
                        </div>
                    <?php } ?>
                    <?=$data['description']?>
                </div>
                <div class="tab-pane fade" id="ann">

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
                <div class="tab-pane fade" id="sign-up">
                    <iframe class="kktix" src="https://kktix.com/tickets_widget?slug=<?=$data['url']?>" frameborder="0" width="100%" vspace="0" hspace="0" marginheight="5" marginwidth="5" scrolling="auto" allowtransparency="true">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
var Pages = 1;
function RenewArticleList(page) {
    $.ajax({
        url: '<?=URL?>Activities/getEventMessages/<?=$data["id"]?>/'+page,
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