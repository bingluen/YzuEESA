<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>YzuEESA 元智電機系學會 - 管理後臺</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jQuery -->
    <script src="<?php echo URL; ?>public/js/jquery-1.10.2.js"></script>
    <!--<script src="<?php echo URL; ?>public/js/jquery-ui-1.10.4.min.js"></script>-->
    <script src="<?php echo URL; ?>public/js/bootstrap.min.js"></script>
    <script src="<?php echo URL; ?>public/js/icheck.min.js"></script>
    <script src="<?php echo URL; ?>public/js/jquery-md5.js"></script>
    <script src="<?php echo URL; ?>public/js/jquery.actual.min.js"></script>
    <script src="<?php echo URL; ?>public/js/slidr.min.js"></script>
    <script src="<?php echo URL; ?>public/js/jquery.fs.selecter.min.js"></script>
    <script src="<?php echo URL; ?>public/js/yzueesa.js"></script>
    <!-- our JavaScript -->
    <!-- css -->
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/bootflat.min.css">
    <!--<link rel="stylesheet" href="<?php echo URL; ?>public/css/ui-lightness/jquery-ui-1.10.4.min.css">-->
    <link href="<?php echo URL; ?>public/css/jquery.fs.selecter.css" rel="stylesheet">
    <!-- our css -->
    <link rel="stylesheet" href="<?php echo URL; ?>public/css/yzueesa.css">
</head>
<body>
<?php if(!(isset($data) && $data =='login')) { ?>
<div id="man-Content">
    <div class="">
        <div class="tabbable tabs-left clearfix">
<?php } ?>
<!-- header -->
