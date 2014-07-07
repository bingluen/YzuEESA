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
<body data-spy="scroll" data-target=".navbar">
<div class="navbar navbar-default navbar-fixed-top" role="navigation">

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
            <li><a id="bar-info" href="#info">比賽資訊</a></li>
            <li><a id="bar-trans" href="#trans">交通方式</a></li>
            <li><a id="bar-join" href="#join">線上報名</a></li>
            <li><a id="bar-schedule" href="#schedule">比賽賽程</a></li>
            <li><a id="bar-live" href="#live">即時賽況</a></li>
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
            <img src="<?php echo URL; ?>public/img/test/1.png">
            <div class="carousel-caption">
                <h1></h1>
                <h4></h4>
            </div>
        </div>

        <div class="item">
            <img src="<?php echo URL; ?>public/img/test/2.png">
            <div class="carousel-caption">
                <h1></h1>
                <h4></h4>
            </div>
        </div>

    </div>
</div>

<div id="Content">
    <div id="EventMain">
            <div id="info">
                <br><br><br>
                <h3 class="eventContentTitle">比賽資訊</h2>
                    <hr>
                    <div class="Event-Content-Text">
                        <p>test</p>
                    </div>
            </div>
            <div id="trans">
                <br><br><br>
                <h3 class="eventContentTitle">交通方式</h2>
                    <hr>
                    <div class="Event-Content-Text">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m10!1m3!1d3616.8790575477515!2d121.26443342208597!3d24.970229141700823!2m1!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x34681f5490d43fcd%3A0x186eb5a7e52b332b!2z5YWD5pm65aSn5a24!5e0!3m2!1szh-TW!2s!4v1403949325039" width="600" height="450" frameborder="0" style="border:0"></iframe>
                        <p>test</p>
                    </div>
            </div>
            <div id="join">
                <br><br><br>
                <h3 class="eventContentTitle">線上報名</h2>
                    <hr>
                    <div class="Event-Content-Text">
                        <p>test</p>
                    </div>
            </div>
            <div id="schedule">
                <br><br><br>
                <h3 class="eventContentTitle">比賽賽程</h2>
                    <hr>
                    <div class="Event-Content-Text">
                        <p>test</p>
                    </div>
            </div>
            <div id="live">
                <br><br><br>
                <h3 class="eventContentTitle">即時賽況</h2>
                    <hr>
                    <div class="Event-Content-Text">
                        <p>test</p>
                    </div>
            </div>
    </div>
</div>
<div class="footer text-center">
    主辦單位：元智大學電機工程學系103級系學會<br>
    協辦單位：
</div>


<script>
    $(function () {
        var offsetHeight = 70;
        $('#photoslide').carousel();
        $('body').scrollspy({
            target: '.navbar'
        });

        $('#bar-brand').click(function () {
            $('html,body').animate({
                scrollTop: $('#photoslide').offset().top
            }, 1000);
        });
        $('#bar-index').click(function () {
            $('html,body').animate({
                scrollTop: $('#photoslide').offset().top
            }, 1000);
        });
        $('#bar-info').click(function () {
            $('html,body').animate({
                scrollTop: $('#info').offset().top
            }, 1000);
        });
        $('#bar-trans').click(function () {
            $('html,body').animate({
                scrollTop: $('#trans').offset().top
            }, 1000);
        });
        $('#bar-schedule').click(function () {
            $('html,body').animate({
                scrollTop: $('#schedule').offset().top
            }, 1000);
        });
        $('#bar-join').click(function () {
            $('html,body').animate({
                scrollTop: $('#join').offset().top
            }, 1000);
        });
        $('#bar-live').click(function () {
            $('html,body').animate({
                scrollTop: $('#live').offset().top
            }, 1000);
        });
        $(document).ready(function () {
            $('.carousel').hide().fadeIn(800);
        });
    });
</script>