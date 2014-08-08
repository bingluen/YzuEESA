<div id="main">
  <div class="container-fluid">
    <div class="panel">
      <ul id="account" class="nav nav-tabs nav-justified">

      </ul>
      <div id="accountContent" class="tab-content">
        <div class="tab-pane fade active in" id="Overview" style="width: 80%; margin-left: 10%;">

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

        </div>

        <div class="tab-pane fade" id="yearDetail" style="width: 80%; margin-left: 10%;">

          <div class="panel panel-default">
            <div class="panel-heading">收入與支出分佈</div>
              <span id="year-Income"></span>
              <span id="year-Expenses"></span>
          </div>

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

function drawLineChart(data, title, container) {
  var options = {
    hAxis: {
      baselineColor: '#7B7B7B'
    },
    height: 350,
    title: title
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
    width: $('#yearDetail').actual( 'innerWidth' ) * 0.5,
    title: title
  };

  var chart = new google.visualization.PieChart(container);
  chart.draw(data, options);
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
      var row = new Array('沒有收入', 100);
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

}

function loadingAnimation() {
  $('#yearDetail').empty();
}
</script>