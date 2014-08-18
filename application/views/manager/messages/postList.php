<div class="tab-content panel" id="man-content">

    <div class="tab-pane fade active in">

        <h3>文章列表</h3>
        <hr>

        <!-- <div class="alert alert-warning alert-dismissable" id="Alert-messages">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" id="close-alert">×</button>
            <strong>注意!</strong> 除了特殊設定權限的人員，都只能看到自己發布的文章
        </div> -->

        <div id="postList-Function" class="text-left">
            <button type="button" class="btn btn-sm btn-primary newArticle-btn">新增文章</button>
            <button type="button" class="btn btn-sm btn-info make-public-btn">設定為公開</button>
            <button type="button" class="btn btn-sm btn-warning make-draft-btn">設定為草稿</button>
            <button type="button" class="btn btn-sm btn-danger delete-btn">刪除</button>
        </div>

        <table class="table table-hover">

            <thead>
                <tr>
                    <th></th>
                    <th>狀態</th>
                    <th>文章標題</th>
                    <th>最後編修者</th>
                    <th>最後更新時間</th>
                </tr>
            </thead>

            <tbody id="articleList">
                    <tr></tr>
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
        var url = window.location.toString();
        if(url.indexOf("PostList")!=-1)  {
            var ary=url.split("PostList");
        }
        $('#articleList tr').remove();
        $.ajax({
            url: ary[0]+'PostList/'+page,
            dataType : 'json',
            type : 'post',
            data : {
                pageNumber: page
            },
            success: function(response) {
                displayArticleList(response);
            }
        });
    }

    function displayArticleList(data) {
        var url = window.location.toString();
        if(url.indexOf("PostList")!=-1)  {
            var ary=url.split("PostList");
        }
        for(var i = 0;i < data.length;i++) {
            var str = '';
            str += '<tr>'
            str += '<td><input class="checkbox" type="checkbox" name="article-select" value="'+data[i]['messages_id']+'"></td>';
            if(data[i]['messages_draft'] == '1') {
                str += '<td>草稿</td>';
            } else {
                str += '<td>公開</td>';
            }

            str += '<td><a href="'+ary[0]+'editor/'+data[i]['messages_id']+'">'+data[i]['title']+'</a></td>';
            str += '<td>'+data[i]['messages_author']+'</td>';
            str += '<td>'+data[i]['messages_time']+'</td>';

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

    $('.make-public-btn').click(function () {
        var url = window.location.toString();
        if(url.indexOf("PostList")!=-1)  {
            var ary=url.split("PostList");
        }
        var selected = new Array();
        $('input[name="article-select"]:checked').each(function(i) { selected[i] = this.value; });
        $.ajax({
            url: ary[0]+'public/',
            dataType : 'json',
            type : 'post',
            data : {
                target: selected
            },
            success: function(response) {
                RenewArticleList(Pages);
            }
        });
    });

    $('.make-draft-btn').click(function () {
        var url = window.location.toString();
        if(url.indexOf("PostList")!=-1)  {
            var ary=url.split("PostList");
        }
        var selected = new Array();
        $('input[name="article-select"]:checked').each(function(i) { selected[i] = this.value; });
        $.ajax({
            url: ary[0]+'draft/',
            dataType : 'json',
            type : 'post',
            data : {
                target: selected
            },
            success: function(response) {
                RenewArticleList(Pages);
            }
        });
    });

    $('.delete-btn').click(function () {
        var url = window.location.toString();
        if(url.indexOf("PostList")!=-1)  {
            var ary=url.split("PostList");
        }
        var selected = new Array();
        $('input[name="article-select"]:checked').each(function(i) { selected[i] = this.value; });
        $.ajax({
            url: ary[0]+'delete/',
            dataType : 'json',
            type : 'post',
            data : {
                target: selected
            },
            success: function(response) {
                RenewArticleList(Pages);
            }
        });
    });

    $('.newArticle-btn').click(function () {
        var url = window.location.toString();
        if(url.indexOf("PostList")!=-1)  {
            var ary=url.split("PostList");
        }
        document.location.href=ary[0]+'editor/NewPost';
    });

    $(document).ready(
        function() {
            RenewArticleList(1);
            displayPagination(1);
    });
</script>