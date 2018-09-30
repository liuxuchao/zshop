<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>Zshop商城-管理-用户列表-第<?php echo ($currentPage); ?>页</title>
    <!-- Bootstrap core CSS -->
    <link href="/Admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Admin/css/bootstrap-reset.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="/Admin/css/style.css" rel="stylesheet">
    <link href="/Admin/css/style-responsive.css" rel="stylesheet" />

    
    <link href="/Admin/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="/Admin/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
    <link rel="stylesheet" href="/Admin/css/owl.carousel.css" type="text/css">
    
    <link href="/Admin/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="/Admin/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
    <link rel="stylesheet" href="/Admin/css/owl.carousel.css" type="text/css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="/Admin/js/html5shiv.js"></script>
      <script src="/Admin/js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
  <?php if(!empty($displayType) and 2 == $displayType ): ?><div class="container"><?php endif; ?>
  <section id="container" >

    <header class="header white-bg">
    <?php if(!empty($displayType) and 2 == $displayType ): ?><div class="container"><?php endif; ?>
            <div class="sidebar-toggle-box">
                <div data-original-title="Toggle Navigation" data-placement="right" class="icon-reorder tooltips"></div>
            </div>
            <!--logo start-->
            <a href="index.html" class="logo">Zshop<span> 后台管理中心</span></a>
            <!--logo end-->
            <div class="nav notify-row" id="top_menu">

            </div>
            <div class="top-nav ">
                <!--search & user info start-->
                <ul class="nav pull-right top-menu">
                    <li>
                        <input type="text" class="form-control search" placeholder="Search">
                    </li>
                    <li>
                        <a href="/" target="_blank">前台首页</a>
                    </li>
                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="username"><?php echo ($_SESSION['admin_user']['nickname']); ?></span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
                            <li><a href="/Admin/Admin/changepwd"><i class=" icon-suitcase"></i>修改密码</a></li>
                            <li><a href="#"><i class="icon-cog"></i>切换显示宽度</a></li>
                            <li><a href="/Admin/Login/logout"><i class="icon-key"></i>退出</a></li>
                        </ul>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
                <!--search & user info end-->
            </div>
        <?php if(!empty($displayType) and 2 == $displayType ): ?></div><?php endif; ?>
</header>

          <!--sidebar start-->
      <aside>
        <div id="sidebar"  class="nav-collapse ">
          <!-- sidebar menu start-->
          <ul class="sidebar-menu  dcjq-parent-li" id="nav-accordion">
            <li>
              <a href="/Admin/Index" <?php if('Index' == $controllerName): ?>class="active dcjq-parent"<?php endif; ?>>
                <i class="icon-dashboard"></i>
                <span>主面板</span>
              </a>
            </li>
          <li class="sub-menu  dcjq-parent-li">
                <a href="javascript:;" <?php if('Users' == $controllerName): ?>class="active dcjq-parent"<?php endif; ?>>
                 <i class="icon-user"></i>
                 <span>用户管理</span>
               </a>
            <ul class="sub  dcjq-parent-li">
             <li <?php if('index' == $actionName and 'Users' == $controllerName): ?>class="active"<?php endif; ?>><a href="/Admin/Users/index" >用户列表</a></li>
           </ul>
         </li>
         <li class="sub-menu  dcjq-parent-li">
                <a href="javascript:;" <?php if('Order' == $controllerName or 'UsersBalanceLog' == $controllerName): ?>class="active dcjq-parent"<?php endif; ?>>
                 <i class="icon-user"></i>
                 <span>订单管理</span>
               </a>
            <ul class="sub  dcjq-parent-li">
             <li <?php if('index' == $actionName and 'Users' == $controllerName): ?>class="active"<?php endif; ?>><a href="/Admin/Users/index" >商城订单列表</a></li>
             <li <?php if('index' == $actionName and 'Users' == $controllerName): ?>class="active"<?php endif; ?>><a href="/Admin/Users/index" >服务订单列表</a></li>
             <li <?php if('index' == $actionName and 'Users' == $controllerName): ?>class="active"<?php endif; ?>><a href="/Admin/Users/index" >活动订单列表</a></li>
           </ul>
         </li>
        
		<li class="sub-menu  dcjq-parent-li">
          <a href="javascript:;" <?php if('Product' == $controllerName or 'ProductCate' == $controllerName): ?>class="active dcjq-parent"<?php endif; ?>>
            <i class="icon-btc"></i>
            <span>商品服务活动管理</span>
          </a>
          <ul class="sub">
            <li <?php if('Product' == $controllerName): ?>class="active"<?php endif; ?>><a href="/Admin/Product">商品列表</a></li>
            <li <?php if('ProductCate' == $controllerName): ?>class="active"<?php endif; ?>><a href="/Admin/ProductCate" >商品分类</a></li>
            <li <?php if('ProductCate' == $controllerName): ?>class="active"<?php endif; ?>><a href="/Admin/ProductCate" >服务分类</a></li>
            <li <?php if('ProductCate' == $controllerName): ?>class="active"<?php endif; ?>><a href="/Admin/ProductCate" >服务列表</a></li>
            <li <?php if('ProductCate' == $controllerName): ?>class="active"<?php endif; ?>><a href="/Admin/ProductCate" >活动分类</a></li>
            <li <?php if('ProductCate' == $controllerName): ?>class="active"<?php endif; ?>><a href="/Admin/ProductCate" >活动列表</a></li>
          </ul>
        </li>
		<li class="sub-menu  dcjq-parent-li">
          <a href="javascript:;" <?php if('Product' == $controllerName or 'ProductCate' == $controllerName): ?>class="active dcjq-parent"<?php endif; ?>>
            <i class="icon-btc"></i>
            <span>其他管理</span>
          </a>
          <ul class="sub">
            <li <?php if('Product' == $controllerName): ?>class="active"<?php endif; ?>><a href="/Admin/Product">广告列表</a></li>
            <li <?php if('ProductCate' == $controllerName): ?>class="active"<?php endif; ?>><a href="/Admin/ProductCate" >优惠券列表</a></li>
            <li <?php if('ProductCate' == $controllerName): ?>class="active"<?php endif; ?>><a href="/Admin/ProductCate" >发票列表</a></li>
          </ul>
        </li>
	<li class="sub-menu  dcjq-parent-li">
          <a href="javascript:;" <?php if('Article' == $controllerName or 'ArticleCate' == $controllerName): ?>class="active dcjq-parent"<?php endif; ?>>
            <i class="icon-btc"></i>
            <span>文章管理</span>
          </a>
          <ul class="sub">
            <li <?php if('index' == $actionName and 'Article' == $controllerName): ?>class="active"<?php endif; ?>>
				<a href="/Admin/Article/index">文章列表</a></li>
            <li <?php if('ArticleCate' == $actionName and 'Article' == $controllerName): ?>class="active"<?php endif; ?>>
				<a href="/Admin/ArticleCate/index" >文章分类</a></li>
          </ul>
        </li>
        <li><a href="/Admin/Source" <?php if('Source' == $controllerName): ?>class="active dcjq-parent"<?php endif; ?>> <i class="icon-dashboard"></i><span>附件管理</span></a></li>
         <li class="sub-menu">
          <a href="javascript:;" <?php if('SmsLog' == $controllerName or 'LoginLog' == $controllerName or 'RecommendStatistical' == $controllerName or 'ResumeSearchLog' == $controllerName): ?>class="active dcjq-parent"<?php endif; ?>>
            <i class=" icon-pencil"></i>
            <span>日志</span>
          </a>
          <ul class="sub">
            <li <?php if('index' == $actionName and 'SmsLog' == $controllerName): ?>class="active"<?php endif; ?>><a href="/Admin/SmsLog/index">短信发送日志</a></li>
            <li <?php if('index' == $actionName and 'LoginLog' == $controllerName): ?>class="active"<?php endif; ?>><a href="/Admin/LoginLog/index">登陆日志</a></li>
            <li <?php if('index' == $actionName and 'RecommendStatistical' == $controllerName): ?>class="active"<?php endif; ?>><a href="/Admin/RecommendStatistical/index">支付请求日志</a></li>
          </ul>
        </li>
        <li class="sub-menu  dcjq-parent-li" >
                <a href="javascript:;"  <?php if('Admin' == $controllerName or 'Role' == $controllerName): ?>class="active dcjq-parent"<?php endif; ?>>
                <i class="icon-laptop"></i>
                <span>后台管理</span>
                </a>
                <ul class="sub">
                  <li <?php if('Admin' == $controllerName and 'index' == $actionName): ?>class="active"<?php endif; ?>><a href="/Admin/Admin" >管理员列表</a></li>
                  <li <?php if('Role' == $controllerName and 'index' == $actionName): ?>class="active"<?php endif; ?>><a href="/Admin/Role">角色管理</a></li>
                </ul>
            </li>
        <li class="sub-menu  dcjq-parent-li" >
            <a href="javascript:;"  <?php if('Auth' == $controllerName): ?>class="active dcjq-parent"<?php endif; ?>>
            <i class="icon-laptop"></i>
            <span>权限管理</span>
            </a>
            <ul class="sub">
              <li <?php if('index' == $actionName and 'Auth' == $controllerName): ?>class="active"<?php endif; ?>><a href="/Admin/Auth/index" >权限组列表</a></li>
              <li <?php if('ruleIndex' == $actionName and 'Auth' == $controllerName): ?>class="active"<?php endif; ?>><a href="/Admin/Auth/ruleIndex">权限规则列表</a></li>
            </ul>
        </li>
	<li class="sub-menu  dcjq-parent-li" >
             <a href="javascript:;"  <?php if('Version' == $controllerName): ?>class="active dcjq-parent"<?php endif; ?>>
              <i class="icon-flag-alt"></i>
              <span>系统设置</span>
            </a>
            <ul class="sub">
              <li <?php if('add' == $actionName): ?>class="active"<?php endif; ?>><a href="/Admin/Version/add">基本设置</a></li>
              <li <?php if('add' == $actionName): ?>class="active"<?php endif; ?>><a href="/Admin/Version/add">字典管理</a></li>
            </ul>
          </li>
      </ul>
      <!-- sidebar menu end-->
    </div>
  </aside>
      
      <!--main content start-->
      <section id="main-content" style="min-height:1000px;">
        
      <section class="wrapper">
              <div class="row">
                  <div class="col-lg-12">
                      <!--breadcrumbs start -->
                      <ul class="breadcrumb">
                          <li><a href="/Admin/Index"><i class="icon-home"></i> 主面板</a></li>
                          <li><a href="/Admin/Users">用户管理</a></li>
                          <li class="active">用户列表</li>
                      </ul>
                      <!--breadcrumbs end -->
                  </div>
              </div>
              <!-- page start-->
              <div class="row">
                  <div class="col-lg-12">
                      <div class="col-sm-12" style="padding-left:0px;padding-right:0px;">
                      <section class="panel">
                          <header class="panel-heading">
                              用户列表
                          </header>
                          <div class="panel-body">
                              <form class="form-horizontal" role="form" id="search" method="post" action="/Admin/Users/index" >
                              <div class="col-md-6 alltimesof">
                                  <button type="button" class='btn timesof <?php if(today == $param['date']): ?>btn-primary<?php endif; ?>'>今天</button>
                                  <button type="button" class='btn timesof <?php if(yesterday == $param['date']): ?>btn-primary<?php endif; ?>'>昨天</button>
                                  <button type="button" class='btn timesof <?php if(week == $param['date']): ?>btn-primary<?php endif; ?>'>本周</button>
                                  <button type="button" class='btn timesof <?php if(month == $param['date']): ?>btn-primary<?php endif; ?>'>本月</button>
                                  <button type="button" class='btn timesof <?php if(all == $param['date']): ?>btn-primary<?php endif; ?>'>全部</button>
                                  </div>
                                  <div class="col-md-6">
                                          <div class="input-group input-large" data-date="2016/07/28" data-date-format="yyyy/mm/dd">
                                         
                                            <input type="text" class="form-control dpd1" value="<?php echo (date('m/d/Y',$param["srtime"])); ?>" name="srtime">
                                            <span class="input-group-addon">To</span>
                                            <input type="text" class="form-control dpd2" value="<?php echo (date('m/d/Y',$param["ertime"])); ?>" name="ertime">
                                        </div>
                                          <span class="help-block">注册时间查询</span>
                                      </div>
                                      <div class="col-md-3">
                                      <div class="form-group">
                                          <input type="text" name="mobile" class="form-control" id="phone" value="<?php echo ($param["mobile"]); ?>" placeholder="输入手机号搜索">
                                      </div>
                                      </div>
                                      <div class="col-md-9">
                                        <button  id="btn_search" class="btn btn-info">搜索</button>
                                        <input type="hidden" id="search_type" name="search_type">
                                        <button  id="btn_search_share" class="btn btn-info">搜索推荐人</button>
                                      </div>
                              </form>
                          </div>
                                  
                      </section>

                    </div>


                  </div>
              </div>
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <table class="table table-striped table-advance table-hover">
                              <thead>
                              <tr>
                                  <th><i class="icon-phone"></i>手机</th>
                                  <th><i class="icon-user"></i>用户名</th>
                                  <th><i class="icon-bullhorn"></i>验证渠道</th>
                                  <th><i class="icon-bullhorn"></i>招聘邮箱</th>
                                  <th><i class="icon-bullhorn"></i>推荐好友</th>
                                  <th><i class="icon-bullhorn"></i>推荐人</th>
                                  <th><i class="icon-jpy"></i>蛙币余额</th>
                                  <th><i class="icon-time"></i>注册时间</th>
                                  <th><i class="icon-time"></i>最近登录</th>
                                  <th>重置密码</th>
                                  <th>操作</th>
                              </tr>
                              </thead>
                              <tbody>
                              <?php if(!empty($userList) and is_array($userList)): if(is_array($userList)): $i = 0; $__LIST__ = $userList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$user): $mod = ($i % 2 );++$i;?><tr>
                                  <td><a href="#"><?php echo ($user["mobile"]); ?></a></td>
                                  <td class="hidden-phone"><?php echo ($user["name"]); ?></td>
                                  <td class="hidden-phone">
                                    <?php if(is_array($user["channelList"])): $i = 0; $__LIST__ = $user["channelList"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$channel): $mod = ($i % 2 );++$i; echo ($channel["channel_type"]); ?>: <?php echo ($channel["login_name"]); ?>
                                        <br><?php endforeach; endif; else: echo "" ;endif; ?>
                                  </td>
                                  <td class="hidden-phone"> - </td>
                                  <td class="hidden-phone">
                                  <span class="badge bg-success"><?php echo ($user["sharebindcount"]); ?></span>
                                    /<?php echo ($user["shareallcount"]); ?></td>
                                  <td class="hidden-phone"><?php echo ($user["shared_user_mobile"]); ?></td>
                                  <td class="hidden-phone"><?php echo ($user["balance"]); ?></td>
                                  <td class="hidden-phone"><?php echo (date('Y-m-d H:i',$user["create_time"])); ?></td>
                                  <td class="hidden-phone"><?php echo (date('Y-m-d H:i',$user["login_time"])); ?></td>
                                  <td>
                                  <a href="/Admin/Users/resetPwd/userId/<?php echo ($user["id"]); ?>" alt="重置密码" ><button class="btn btn-success btn-xs"><i class="icon-ok"></i></button></a>
                                  </td>
                                  <td>
                                    <a  class="btn btn-xs btn-warning myModal2" href="/Admin/UsersBalanceLog/balanceLog/user_id/<?php echo ($user["user_id"]); ?>">蛙币收支</a>
                                    <a class="btn btn-primary btn-xs" href="/Admin/Users/updates/userId/<?php echo ($user["user_id"]); ?>">修改信息</a>
                                    <a  class="btn btn-xs btn-warning myModal2" data-toggle="modal" href="#myModal2" value="<?php echo ($user["user_id"]); ?>">删除</a>
                                    <div class="btn-group">
                                      <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-xs btn-info" type="button">更多 <span class="caret"></span></button>
                                      <ul role="menu" class="dropdown-menu">
                                          <li><a href="#">短信发送日志</a></li>
                                          <li><a href="#">登陆日志</a></li>
                                          <li><a href="#">分享记录</a></li>
<!--                                          <li class="divider"></li>
                                          <li><a href="#"></a></li>-->
                                      </ul>
                                    </div>
                                  </td>
                              </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                              <?php else: ?>
                              
                              <tr><td colspan="5">没有数据</td></tr><?php endif; ?>
                              </tbody>
                          </table>
                      </section>
                  </div>
                  <div class="col-lg-6"><div class="dataTables_info" id="editable-sample_info">共 <?php echo ($count); ?> 条记录，当前显示 第 <?php echo ($currentPage); ?> 页</div></div>
                  <div class="col-lg-6"><?php echo ($page); ?></div>
              </div>
              <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">对话框</h4>
                                    </div>
                                    <div class="modal-body">

                                        确定删除此记录

                                    </div>
                                    <div class="modal-footer">
                                        <button data-dismiss="modal" class="btn btn-default" type="button">关闭</button>
                                        <button class="btn btn-warning" id="confirmvalue" value="" type="button"> 确认</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">提示消息</h4>
                                    </div>
                                    <div class="modal-body" id="reback_message">

                                    </div>
                                </div>
                            </div>
                        </div>
              <!-- page end-->
       </section>

      </section>
      <!--main content end-->
            <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              2018 &copy;Tihold
              <a href="#" class="go-top">
                  <i class="icon-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->

  </section>
  <?php if(!empty($displayType) and 2 == $displayType ): ?></div><?php endif; ?>
    <script src="/Admin/js/jquery.js"></script>
    <script src="/Admin/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="/Admin/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="/Admin/js/jquery.scrollTo.min.js"></script>
    <script src="/Admin/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="/Admin/js/respond.min.js" ></script>
    <script src="/Admin/js/jquery.tagsinput.js" ></script>

    <!--common script for all pages-->
    <script type="text/javascript" src="/Admin/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
   <script src="/Admin/js/calendar.js"></script>
    <script src="/Admin/js/common-scripts.js"></script>
    <!-- <script src="/Admin/js/form-component.js"></script> -->
   <script src="/Admin/js/advanced-form-components.js"></script>
   
      <script src="/Admin/js/advanced-form-components.js"></script>
      <script type="text/javascript" src="/Admin/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

          //confirm start
            $(".myModal2").click(function(){
                var uid = $(this).attr("value");
                $("#confirmvalue").attr("value",$(this).attr("value"));
            });
            $("#confirmvalue").click(function(){
              $("#myModal2").css('display','none'); 
              $("#myModal2").removeClass("in"); 
              $("body").removeClass("modal-open");
                var userId = $(this).attr("value");
                  $.post("/Admin/Users/doDelete",{userId:userId},function(data,textStatus, jqXHR){
                    if (data) {
                        $("#reback_message").text("删除成功");
                        $("body").removeClass("modal-open");
                        $("#myModal3").addClass("in"); 
                        $("#myModal3").css('display','block'); 
                    }else{
                        $("#reback_message").text("删除失败");
                        $("body").removeClass("modal-open");
                        $("#myModal3").addClass("in"); 
                        $("#myModal3").css('display','block'); 
                    }
                    setTimeout(function (){
                        $("#myModal3").removeClass("in"); 
                        $("#myModal3").css('display','none'); 
                        $("body").removeClass("modal-open");
                        $(".modal-backdrop").removeClass("in");
                     }, 2000);
                    window.location.reload();
                  });
            });
            //confirm end
            
            $(".timesof").click(function(){
              var dates = new Array();
              dates[0] = 'today';
              dates[1] = 'yesterday';
              dates[2] = 'week';
              dates[3] = 'month';
              dates[4] = 'all';
              var  values = $(this).index();
              date = dates[values];

              $("#value_timesof").val(values+1);
              $(".timesof").removeClass("btn-primary");
              $(this).addClass("btn-primary");
              window.location.href="/admin/Users/index/date/"+date;

            });
            $("#phone").change(function(){
              if (!$("#phone").val().match(/^(1(3[0-9]|4[57]|5[0-35-9]|7[01678]|8[0-9])+\d{8})$/)){
                $("#phone").val("");
              } 
            });
            $("#btn_search").click(function(){
              $("#search_type").val('');
              $("#search").submit();
            });
            $("#btn_search_share").click(function(){
              $("#search_type").val('shared');
              $("#search").submit();
            });
        });
      </script>
    
  </body>
</html>