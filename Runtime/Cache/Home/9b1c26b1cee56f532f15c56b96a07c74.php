<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo ($title); ?></title>
    <link rel="bookmark" href="img/favicon.ico" type="image/x-icon" />
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link href="/Home/css/bootstrap.css" rel="stylesheet">
    <link href="/Home/css/font-awesome.min.css" rel="stylesheet">
    <link href="/Home/css/common.css" rel="stylesheet">
    <link href="/Home/css/index.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="/Home/js/html5shiv.min.js"></script>
      <script src="/Home/js/respond.min.js"></script>
    <![endif]-->
    <script src="/Home/js/jquery-1.11.3.min.js"></script>
    <script src="/Home/js/bootstrap.min.js"></script>
  </head>
  <body class="htmlbody">
  	<div class="navfluid">
      <nav class="navbar navbar-fixed-top navbar-inverse mynavbar">
        <div class="container-fluid mybar">
          <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/"><img src="/Home/img/logo.png" alt="" class="img-responsive" style="width:46px;height: 46px;"></a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav" id="navList">
                    
                    <?php if(is_array($parent)): $i = 0; $__LIST__ = $parent;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pvo): $mod = ($i % 2 );++$i; if(($pvo['parent_id'] == 0) and ($pvo['has_child'] == 1)): ?><li class="dropdown">
                        <a href="/Home/Goods/lists/cate/<?php echo ($pvo["id"]); ?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="false" aria-expanded="false"><?php echo ($pvo["cate_name"]); ?></a>
                        <ul class="dropdown-menu">
                          <div class="container">
                            <div class="col-lg-offset-2">
                                <?php if(is_array($child)): $i = 0; $__LIST__ = $child;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cvo): $mod = ($i % 2 );++$i; if(($cvo['parent_id'] == $pvo['id']) and ($cvo['parent_id'] != 0)): ?><li><a href="/Home/Goods/lists/cate/<?php echo ($cvo["id"]); ?>" class="<?php echo ($cvo["cate_pinyin"]); ?>_icon"><?php echo ($cvo["cate_name"]); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                            </div>
                          </div>
                        </ul>
                    </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </ul>
                <ul class="nav navbar-nav navbar-right cart-member">
                    
                    <?php if($loginInfo == null): ?><div class="pull-right">
                        <a href="" class="mycart"><i class="fa fa-shopping-cart"></i>购物车</a>
                        <a href="/Home/Login/login" calss="login">登陆</a>
                        <a href="/Home/Login/register" calss="register">注册</a>
                    </div>
                    <?php else: ?>
                    <div class="pull-right">
                        <a href="" class="mycart">
                            <i class="fa fa-shopping-cart"></i>购物车
                        </a>
                        <a href="" class="cart_num">1</a>
                        <a href="/Home/My/index" calss="login">您好，<?php echo ($loginInfo[1]); ?></a>
                        <a href="/Home/Login/logout" calss="login">退出</a>
                    </div><?php endif; ?>
                </ul>
            </div>
        </div>
        </div>
    </nav>
    </div>
  	
  	<div id="Carousel" data-ride="carousel" class="carousel slide carousel-fade">
		  <!-- Indicators -->
		  <ol class="carousel-indicators">
		    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
		    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
		    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
		  </ol>

		  <!-- Wrapper for slides -->
		  <div class="carousel-inner" role="listbox">
		    <div class="item active">
		      <img src="/Home/img/Bananer1.jpg" alt="Bananer1">
		      <div class="carousel-caption">
		       
		      </div>
		    </div>
		    <div class="item">
		      <img src="/Home/img/Bananer2.jpg" alt="Bananer2">
		      <div class="carousel-caption">
		       
		      </div>
		    </div>
		    <div class="item">
		      <img src="/Home/img/Bananer3.jpg" alt="Bananer3">
		      <div class="carousel-caption">
		       
		      </div>
		    </div>
		    
		  </div>

		  <!-- Controls -->
		  <a class="left carousel-control" href="#Carousel" role="button" data-slide="prev">
		    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		    <span class="sr-only">Previous</span>
		  </a>
		  <a class="right carousel-control" href="#Carousel" role="button" data-slide="next">
		    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		    <span class="sr-only">Next</span>
		  </a>
		</div>

		<div class="jumbotron jumbotron_first" style="background-color: rgb(16,16,16);">
		  <img src="/Home/img/Bananer1.jpg" class="img-responsive center-block" alt="Bananer1">
		</div>

		<div class="jumbotron jumbotron_second" style="background-color: rgb(16,16,16);">
		  <img src="/Home/img/Bananer2.jpg" class="img-responsive center-block" alt="Bananer2">
		</div>
	
		<div class="jumbotron jumbotron_third" style="background-color: rgb(16,16,16);">
		  <img src="/Home/img/Bananer3.jpg" class="img-responsive center-block" alt="Bananer3">
		</div>

    <div class="container-fluid">
      	<div class="row">
	      	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 homepage-section-item position1">
	      		<a href="" class="unit-wrapper">
	      			<div class="unit-text-wrapper">
						<h4 class="unit-header text-center">
							坚固铆钉工艺，彰显风范
						</h4>
						<h5 class="unit-centerall text-center">
							方寸间的舒适，演绎优雅人生
							<br>
							每一处细节的严格，都只为优雅与精致
						</h5>
	      			</div>
	      			<div class="unit-img-wrapper1" id="position1-bg">
						<figure class="unit-image1"></figure>
	      			</div>
	      		</a>
	      	</div>
	      	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 homepage-section-item position2">
				<a href="" class="unit-wrapper">
	      			<div class="unit-text-wrapper">
						<h4 class="unit-header2 text-center">
							百式菜样 · 十八般烹饪法样样精通
						</h4>
						<h5 class="unit-centerall2 text-center">
							强抗重、抗压结合的铆钉工艺
							<br>
							让您在烹饪时期更安全
						</h5>
	      			</div>
	      			<div class="unit-img-wrapper" id="position1-bg">
						<figure class="unit-image2"></figure>
	      			</div>
	      		</a>
	      	</div>
	      	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 homepage-section-item position3">
				<a href="" class="unit-wrapper">
	      			<div class="unit-text-wrapper">
						<h4 class="unit-header3 text-center">
							百式菜样 · 十八般烹饪法样样精通
						</h4>
						<h5 class="unit-centerall3 text-center">
							强抗重、抗压结合的铆钉工艺
							<br>
							让您在烹饪时期更安全
						</h5>
	      			</div>
	      			<div class="unit-img-wrapper3" id="position1-bg">
						<figure class="unit-image3"></figure>
	      			</div>
	      		</a>
	      	</div>
	      	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 homepage-section-item position4">
				<div class="unit-text-wrapper">
					<h4 class="unit-header text-center">
						坚固铆钉工艺，彰显风范
					</h4>
					<h5 class="unit-centerall text-center">
						方寸间的舒适，演绎优雅人生
						<br>
						每一处细节的严格，都只为优雅与精致
					</h5>
	      		</div>
	  			<div class="unit-img-wrapper1" id="position1-bg">
					<figure class="unit-image1"></figure>
	  			</div>
	      	</div>
	    </div>
    </div>
    <footer class="footer">
    <div class="container">
      <div class="row footer-links accordion" id="accordion2">
        <div class="col-lg-2 col-md-2 accordion-group">
          <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
            新手上路<i class="fa fa-angle-down pull-right hidden-lg hidden-md"></i>
            </a>
          </div>
          <div id="collapseOne" class="accordion-body collapse" style="height: 0px; ">
            <div class="accordion-inner">
              <ul>
                <li><a href="">顾客必读</a></li>
                <li><a href="">会员等级折扣</a></li>
                <li><a href="">订单的几种状态</a></li>
                <li><a href="">积分奖励计划</a></li>
                <li><a href="">商品退货保障</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-md-2 accordion-group">
          <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
              购物指南<i class="fa fa-angle-down pull-right hidden-lg hidden-md"></i>
            </a>
          </div>
          <div id="collapseTwo" class="accordion-body collapse" style="height: 0px; ">
            <div class="accordion-inner">
              <ul>
                <li><a href="">非会员购物通道</a></li>
                <li><a href="">体贴的售后服务</a></li>
                <li><a href="">网站使用条款</a></li>
                <li><a href="">网站免责声明</a></li>
                <li><a href="">简单的购物流程</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-md-2 accordion-group">
          <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
              支付/配送方式<i class="fa fa-angle-down pull-right hidden-lg hidden-md"></i>
            </a>
          </div>
          <div id="collapseThree" class="accordion-body collapse" style="height: 0px; ">
            <div class="accordion-inner">
              <ul>
                <li><a href="">支付方式</a></li>
                <li><a href="">配送方式</a></li>
                <li><a href="">订单何时出库</a></li>
                <li><a href="">网上支付小贴士</a></li>
                <li><a href="">关于送货和验货</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-md-2 accordion-group">
          <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFour">
              购物条款<i class="fa fa-angle-down pull-right hidden-lg hidden-md"></i>
            </a>
          </div>
          <div id="collapseFour" class="accordion-body collapse" style="height: 0px; ">
            <div class="accordion-inner">
              <ul>
                <li><a href="">会员注册协议</a></li>
                <li><a href="">隐私保护政策</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-md-2 accordion-group">
          <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFive">
              关注我们<i class="fa fa-angle-down pull-right hidden-lg hidden-md"></i>
            </a>
          </div>
          <div id="collapseFive" class="accordion-body collapse" style="height: 0px; ">
            <div class="accordion-inner">
              <ul>
                <li><a href="">新浪微博</a></li>
                <li><a href="">QQ空间</a></li>
                <li><a href="">官方微信</a></li>
                <li><a href="">最近浏览过的商品</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="row footer-copyright">
        
          <h5 class="text-center">© 2001～2010 All rights reserved</h5>
          <p class="text-center hidden-sm hidden-xs">本商店顾客个人信息将不会被泄漏给其他任何机构和个人</p>
          <p class="text-center hidden-sm hidden-xs">本商店logo和图片都已经申请保护，不经授权不得使用 </p>
          <p class="text-center hidden-sm hidden-xs">有任何购物问题请联系我们在线客服 | 电话：0917-3333333  | 工作时间：周一至周五 8:00－18:00</p>
        
      </div>
    </div>
    </footer>
<!-- Modal-login start -->
    <div class="modal fade" id="ModalLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" id="modal_box">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">账户登录</h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="" id="LoginModal">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user"></i></span>
                                <input type="email" class="form-control" id="Modalusername" placeholder="用户名">
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom: 0">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-key"></i></span>
                                <input type="password" class="form-control" id="Modalpassword" placeholder="密码">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn center-block" id="ModalLoginBtn">登 录</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal-login end -->
    <!-- 弹框 -->
    <script src="/layer/layer.js"></script>
    <script>
    $(document).ready(function(){
      //获取屏幕宽度 手机端等小于992px的隐藏折叠内容，电脑端展开
      var w = document.body.clientWidth;
      if(w<992){
        $(".accordion-body").collapse('hide');
      }else{
        $(".accordion-body").collapse('show');
        $(".accordion-heading>a").attr("data-toggle","");//去掉电脑端折叠效果
      }
      
      //模态框ajax登录
        $("#ModalLoginBtn").on("click",function(){
            var username = $("#Modalusername").val();
            var password = $("#Modalpassword").val();
            if(username==''){
                layer.alert("请输入用户名");
                return false;
            }
            if(password==''){
                layer.alert("请输入用户名");
                return false;
            }
            //登录
            $.ajax({
                url:"/Home/Login/modalLogin",
                type:"post",
                data:{'username':username,'password':password},
                dataType:"json",
                success:function(data){
                    if(data.status=='1'){
                        layer.alert(data.msg);
                        $("#ModalLogin").modal('hide');  //手动关闭模态框
                        window.location.reload();
                    }else if(data.status=='0'){
                        layer.alert(data.msg);
                        return false;
                    }
                },
                error:function(){},
            });
        });
    });
  </script>
  </body>
</html>