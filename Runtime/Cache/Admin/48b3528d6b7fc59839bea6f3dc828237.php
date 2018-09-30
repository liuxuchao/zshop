<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <!--<link rel="shortcut icon" href="img/favicon.png">-->

    <title>管理后台-登陆</title>

    <!-- Bootstrap core CSS -->
    <link href="/Admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Admin/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="/Admin/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="/Admin/css/style.css" rel="stylesheet">
    <link href="/Admin/css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

  <body class="login-body">

    <div class="container">

      <form class="form-signin" action="/Admin/Login/doLogin" method="POST">
        <h2 class="form-signin-heading">登陆</h2>
        <div class="login-wrap">
            <input type="text" name="name" class="form-control" placeholder="账号" autofocus>
            <input type="password" name="password" class="form-control" placeholder="密码">
            <button class="btn btn-lg btn-login btn-block" type="submit">提交</button>
       </form>
        </div>

    </div>
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="/Admin/js/jquery.js"></script>
    <script src="/Admin/js/bootstrap.min.js"></script>
  </body>
</html>