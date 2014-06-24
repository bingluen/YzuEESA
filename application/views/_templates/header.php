<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>YzuEESA 元智電機系學會</title>
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
        <a class="navbar-brand" href="#photoslide" id="bar-brand">YzuEESA 元智電機系學會</a>
    </div>

    <div class="collapse navbar-collapse" id="header-collapse">
        <ul class="nav navbar-nav">
            <li><a href="<?php echo URL; ?>">首頁</a></li>
            <li><a href="<?php echo URL; ?>about/">關於學會</a></li>
            <li><a href="">學會活動</a></li>
            <li><a href="">精彩回顧</a></li>
            <li><a href="<?php echo URL; ?>istudy/">iStudy Project</a></li>
            <li><a href="">公開資訊</a></li>
            <li><a href="https://www.facebook.com/messages/147429552025011" target="_blank">問題聯繫</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right" id="fblogo">
            <li><a href="https://www.facebook.com/yzueesa" target="_blank"><span class="fblogo"></span></a></li>
        </ul>
    </div>
</div>
<div id="photoslide" class="carousel slide" data-ride="carousel">

    <!-- Indicators -->
    <ol class="carousel-indicators">
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner ">
        <div class="item active">
            <img src="<?php echo URL; ?>public/img/test/banner.png">
        </div>
</div>
<!-- header -->