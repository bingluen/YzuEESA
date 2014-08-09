<style type="text/css">
.google-visualization-table-table {
  font-size: 14px !important;
}
</style>


<div id="main">
  <div class="container-fluid">

    <ol class="breadcrumb breadcrumb-arrow SUNFLOWER">
      <li><a href="<?=URL?>"><i class="glyphicon glyphicon-home"></i> 首頁</a></li>
      <li><a href="<?=URL?>Information/"><i class="glyphicon glyphicon-info-sign"></i> 公開資訊</a></li>
      <li class="active"><span><i class="glyphicon glyphicon-usd"></i> 財務透明</span></li>
    </ol>


    <div class="panel">
      <ul id="account" class="nav nav-tabs nav-justified">

      </ul>
      <div id="accountContent" class="tab-content">
        <div class="tab-pane fade active in" id="Overview" style="width: 90%; margin-left: 5%;">

          <div class="panel panel-default">
            <div class="panel-heading">各年度結餘</div>
            <table class="table">
              <thead>
                <tr>
                  <th>年度</th>
                  <th>總支出</th>
                  <th>總收入</th>
                  <th>結餘</th>
                </tr>
              </thead>
              <tbody id="Balance">
              </tbody>
            </table>
          </div>

          <div class="panel panel-default">
            <div class="panel-heading">歷年變化圖</div>
            <div id="BalanceChangeOverYear"></div>
          </div>

          <div id="projectData"></div>

        </div>

        <div class="tab-pane fade" id="yearDetail" style="width: 90%; margin-left: 5%;">

          <div class="panel panel-default">
            <div class="panel-heading">收入與支出分佈</div>
              <div class="text-center row">
              <div class="col-md-6" id="year-Income" style="display: inline-block;"></div>
              <div class="col-md-6" id="year-Expenses" style="display: inline-block;"></div>
            </div>
          </div>

          <div id="projectDetail"></div>

          <div id="loadingAnimation" style="hight:500px; display:none">
            <div class="progress progress-striped active">
              <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                <span class="sr-only">20% Complete</span>
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<script type="text/javascript">

google.load("visualization", "1", {packages:["corechart"]});
google.load('visualization', '1', {packages:['table']});

function drawLineChart(data, title, container) {
  var options = {
    hAxis: {
      baselineColor: '#7B7B7B'
    },
    height: 450,
    title: title,
    fontSize: 18
  };

  var chart = new google.visualization.LineChart(container);
  chart.draw(data, options);
}


function drawPieChart(data, title, container) {
  var options = {
    hAxis: {
      baselineColor: '#7B7B7B'
    },
    height: 350,
    width: 400,
    title: title,
    chartArea: {
      width: 300,
      height: 300
    },
    fontSize: 14
  };

  var chart = new google.visualization.PieChart(container);
  chart.draw(data, options);
}

function drawTable(data, position) {
  var table = new google.visualization.Table(position);
  var options = {
    showRowNumber: true,
    fontsize: 18,
    width: $( '.projectIncome' ).actual( 'innerWidth' )
  };
  table.draw(data, options);
}

$(document).ready(
  function() {
    prepareTab();
    overview();
});

function prepareTab() {
  str = '<li class="active"><a href="#Overview" data-toggle="tab">總覽</a></li>';
  $.ajax({
    url: '<?=URL?>Information/Account/listYear',
    dataType: 'json',
    type: 'post',
    success: function(response) {
      for(var i in response) {
        str += '<li><a href="#yearDetail" data-toggle="tab" onclick="yearDetail('+response[i]+')">'+response[i]+' 學年</a></li>';
      }
      $('#account').append(str);
    }
  });
}

function overview() {
  $.ajax({
    url: '<?=URL?>Information/Account/Overview',
    dataType: 'json',
    type: 'post',
    success: function(response) {
      if(response === 'No Data'){
        var str = '';
        str += '<tr>';
        str += '<td colspan="4">';
        str += '沒有資料';
        str += '</td>';
        str += '</tr>';
        $('#Balance tr').remove();
        $('#Balance').append(str);
      } else {
        //回填表格
        $('#Balance').empty();
        var TotalIncome = 0;
        var TotalExpenses = 0;
        for(var i in response) {
          var str = '';
          TotalIncome += eval(response[i]['income']);
          TotalExpenses += eval(response[i]['expenditure']);
          str += '<tr>';
          str += '<td>'+response[i]['year']+'年度</td>';
          str += '<td>'+response[i]['expenditure']+'</td>';
          str += '<td>'+response[i]['income']+'</td>';
          str += '<td>'+(response[i]['income'] - response[i]['expenditure'])+'</td>';
          str += '</tr>';
          $('#Balance').append(str);
        }

        var str = '';
        str += '<tr>';
        str += '<td>歷年總和</td>';
        str += '<td>'+TotalExpenses+'</td>';
        str += '<td>'+TotalIncome+'</td>';
        str += '<td>'+(TotalIncome - TotalExpenses)+'</td>';
        str += '</tr>';
        $('#Balance').append(str);


        //準備畫圖
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Year');
        data.addColumn('number', 'Income');
        data.addColumn('number', 'Expenses');
        data.addColumn('number', 'Balance');
        for (var i = 0 ; i < response.length ; i++) {
          var row = new Array(response[i]['year']+'年度', eval(response[i]['income']), eval(response[i]['expenditure']), eval(response[i]['income'] - response[i]['expenditure']));
          data.addRow(row);
        }

        var title = '';

        google.setOnLoadCallback(drawLineChart(data, title, document.getElementById('BalanceChangeOverYear')));
      }
    },
    error: function (response) {
    }
  });
}

function yearDetail(year) {
  $.ajax({
    url: '<?=URL?>Information/Account/yearDetail',
    dataType: 'json',
    type: 'post',
    data: {
      year: year
    },
    success: function(response) {
      displayYearData(response);
    }
  });
}

function displayYearData(RawData) {
  //畫面清空
  $('#year-Income').empty(); //年度收入圓餅圖
  $('#year-Expenses').empty();
  $('#projectDetail').empty();

  //先畫收入與支出的圓餅圖

    //收入
    var TotalIncome = new google.visualization.DataTable();
    TotalIncome.addColumn('string', 'Project / Active Name');
    TotalIncome.addColumn('number', 'Income');
    var isAllZero = true
    for (var i in RawData['income']) {
      var row = new Array(RawData['projectList'][i]['name'], eval(RawData['income'][i]));
      if(eval(RawData['income'][i]) != 0)
        isAllZero = false;
      TotalIncome.addRow(row);
    }

    if(isAllZero) {
      var row = new Array('沒有收入', 1);
      TotalIncome.addRow(row);
    }

    google.setOnLoadCallback(drawPieChart(TotalIncome, '', document.getElementById('year-Income')));


    //支出
    var TotalExpenses = new google.visualization.DataTable();
    TotalExpenses.addColumn('string', 'Project / Active Name');
    TotalExpenses.addColumn('number', 'Expenses');
    var isAllZero = true
    for (var i in RawData['expenses']) {
      var row = new Array(RawData['projectList'][i]['name'], eval(RawData['expenses'][i]));
      if(eval(RawData['expenses'][i]) != 0)
        isAllZero = false;
      TotalExpenses.addRow(row);
    }

    if(isAllZero) {
      var row = new Array('沒有支出', 100);
      TotalExpenses.addRow(row);
    }

    google.setOnLoadCallback(drawPieChart(TotalExpenses, '', document.getElementById('year-Expenses')));

    IncomeStr = '<p class="text-center">收入 '+RawData['TotalIncome']+'</p>';
    $('#year-Income').append(IncomeStr);
    ExpensesStr = '<p class="text-center">支出 '+RawData['TotalExpenses']+'</p>';
    $('#year-Expenses').append(ExpensesStr);


  //做出各個計畫的表格
  for (var i in RawData['itemList']) {
    //整理資料 先畫出 收入表
    var  projectDataIncomeTable = new google.visualization.DataTable();
    projectDataIncomeTable.addColumn('string', 'Item Name');
    projectDataIncomeTable.addColumn('number', 'Price');
    projectDataIncomeTable.addColumn('string', 'Time');
    projectDataIncomeTable.addColumn('string', 'Reviewer')
    for(var j in RawData['itemList'][i]['income']) {
      var row = new Array(RawData['itemList'][i]['income'][j]['items_name'],
        eval(RawData['itemList'][i]['income'][j]['items_price']),
        RawData['itemList'][i]['income'][j]['items_app_time'],
        RawData['itemList'][i]['income'][j]['worker_name']);
      projectDataIncomeTable.addRow(row);
    }

    var  projectDataExpensesTable = new google.visualization.DataTable();
    projectDataExpensesTable.addColumn('string', 'Item Name');
    projectDataExpensesTable.addColumn('number', 'Price');
    projectDataExpensesTable.addColumn('string', 'Time');
    projectDataExpensesTable.addColumn('string', 'Reviewer')
    for(var j in RawData['itemList'][i]['expenses']) {
      var row = new Array(RawData['itemList'][i]['expenses'][j]['items_name'],
        eval(RawData['itemList'][i]['expenses'][j]['items_price']),
        RawData['itemList'][i]['expenses'][j]['items_app_time'],
        RawData['itemList'][i]['expenses'][j]['worker_name']);
      projectDataExpensesTable.addRow(row);
    }


    generateProjectTable(projectDataIncomeTable, projectDataExpensesTable, RawData['projectList'][i]['name'], RawData['projectList'][i]['id']);


  };

}

function generateProjectTable(IncomeData, ExpensesData, projectName, projectId) {
  str = '';
  str += '<div class="panel panel-default">';

  str += '<div class="panel-heading">'+projectName+'</div>';

  str += '<div class="row" style="padding:30px  ;  ">';

  str += '<div class="col-md-6">';
  str += '<div class="panel panel-default">';
  str += '<div class="panel-heading projectIncome">收入表</div>';
  str += '<span id="projectDetail-'+projectId+'-income"></span>';
  str += '</div>'
  str += '</div>'

  str += '<div class="col-md-6">';
  str += '<div class="panel panel-default">';
  str += '<div class="panel-heading">支出表</div>';
  str += '<span id="projectDetail-'+projectId+'-expenses"></span>';
  str += '</div>'
  str += '</div>'

  str += '</div>'
  str += '</div>';
  $('#projectDetail').append(str);

  if(IncomeData['tf'].length > 0)
    google.setOnLoadCallback(drawTable(IncomeData, document.getElementById('projectDetail-'+projectId+'-income')));
  else {
    str = '<p class="text-center" style="margin:30px;">沒有收入</p>';
    $('#projectDetail-'+projectId+'-income').append(str);
  }


  if(ExpensesData['tf'].length > 0)
    google.setOnLoadCallback(drawTable(ExpensesData, document.getElementById('projectDetail-'+projectId+'-expenses')));
  else {
    str = '<p class="text-center" style="margin:30px;">沒有支出</p>';
    $('#projectDetail-'+projectId+'-expenses').append(str);
  }

  //$('.google-visualization-table-table').addClass('table');
  //$('.google-visualization-table-table').attr('style', '');

}

function loadingAnimation() {
  $('#yearDetail').empty();
}
</script>