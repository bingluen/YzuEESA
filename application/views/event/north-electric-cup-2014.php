<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>2014 北區電機院校運動競賽 in 元智大學</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jQuery -->
    <script src="<?php echo URL; ?>public/js/jquery-1.10.2.js"></script>
    <!--<script src="<?php echo URL; ?>public/js/jquery-ui-1.10.4.min.js"></script>-->
    <script src="<?php echo URL; ?>public/js/bootstrap.min.js"></script>
    <!-- our JavaScript -->
    <!-- css -->
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/bootflat.min.css">
    <!--<link rel="stylesheet" href="<?php echo URL; ?>public/css/ui-lightness/jquery-ui-1.10.4.min.css">-->
    <!-- our css -->
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/yzueesa.css">
</head>
<body>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">

    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#header-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>

    <div class="navbar-header">
        <a class="navbar-brand" href="#photoslide" id="bar-brand">2014 北電杯 in 元智</a>
    </div>

    <div class="collapse navbar-collapse" id="header-collapse">
        <ul class="nav navbar-nav">
            <li><a id="bar-index" href="#photoslide">首頁</a></li>
            <li><a id="bar-info" href="">比賽資訊</a></li>
            <li><a id="bar-join" href="">線上報名</a></li>
            <li><a id="bar-trans" href="">交通方式</a></li>
            <li><a id="bar-schedule" href="">比賽賽程</a></li>
            <li><a id="bar-live" href="">即時賽況</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right" id="fblogo">
            <li><a href="https://www.facebook.com/yzueesa" target="_blank"><span class="fblogo"></span></a></li>
        </ul>
    </div>

</div>
<!-- header -->
<div id="photoslide" class="carousel slide" data-ride="carousel">

    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#photoslide" data-slide-to="0" class="active"></li>
        <li data-target="#photoslide" data-slide-to="1"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">

        <div class="item active">
            <img src="<?php echo URL; ?>public/img/">
            <div class="carousel-caption">
                <h1></h1>
                <h4></h4>
            </div>
        </div>

        <div class="item">
            <img src="<?php echo URL; ?>public/img/">
            <div class="carousel-caption">
                <h1></h1>
                <h4></h4>
            </div>
        </div>

    </div>
</div>