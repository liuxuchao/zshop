/*
Navicat MySQL Data Transfer

Source Server         : centos-2
Source Server Version : 50548
Source Host           : 192.168.254.155:3306
Source Database       : zshop

Target Server Type    : MYSQL
Target Server Version : 50548
File Encoding         : 65001

Date: 2018-10-10 00:21:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `zs_activities`
-- ----------------------------
DROP TABLE IF EXISTS `zs_activities`;
CREATE TABLE `zs_activities` (
  `id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT '' COMMENT '活动名称',
  `img_url_ids` varchar(255) DEFAULT NULL,
  `up_limit` int(11) DEFAULT '0' COMMENT '人数上限',
  `theme` varchar(255) DEFAULT '' COMMENT '主题',
  `expenses` decimal(10,2) DEFAULT '0.00' COMMENT '费用',
  `desc` text COMMENT '描述',
  `params` text COMMENT '场次参数，json',
  `startTime` int(11) DEFAULT '0' COMMENT '活动开始时间',
  `endTime` int(11) DEFAULT '0' COMMENT '活动结束时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='活动';

-- ----------------------------
-- Records of zs_activities
-- ----------------------------

-- ----------------------------
-- Table structure for `zs_activities_order`
-- ----------------------------
DROP TABLE IF EXISTS `zs_activities_order`;
CREATE TABLE `zs_activities_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `act_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0' COMMENT '支付状态 1：完成支付；2：未完成；3：取消',
  `pay_type` tinyint(1) DEFAULT '0' COMMENT '支付方式： 1：余额支付；2：微信支付',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='活动订单';

-- ----------------------------
-- Records of zs_activities_order
-- ----------------------------

-- ----------------------------
-- Table structure for `zs_ad`
-- ----------------------------
DROP TABLE IF EXISTS `zs_ad`;
CREATE TABLE `zs_ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT '' COMMENT '广告名称',
  `type_id` int(11) DEFAULT '0' COMMENT '分类ID',
  `postion_desc` varchar(32) DEFAULT '' COMMENT '位置描述',
  `status` tinyint(4) DEFAULT '1' COMMENT '状态  1:正常 2：下架',
  `ad_link` varchar(255) DEFAULT '' COMMENT '链接地址',
  `img_url` varchar(255) DEFAULT '' COMMENT '图片地址',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='广告';

-- ----------------------------
-- Records of zs_ad
-- ----------------------------

-- ----------------------------
-- Table structure for `zs_ad_category`
-- ----------------------------
DROP TABLE IF EXISTS `zs_ad_category`;
CREATE TABLE `zs_ad_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `fid` int(11) DEFAULT '0' COMMENT '父级分类ID',
  `create_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zs_ad_category
-- ----------------------------

-- ----------------------------
-- Table structure for `zs_admin_users`
-- ----------------------------
DROP TABLE IF EXISTS `zs_admin_users`;
CREATE TABLE `zs_admin_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(64) NOT NULL DEFAULT '' COMMENT '登陆账号',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `nickname` char(16) NOT NULL DEFAULT '' COMMENT '昵称',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='管理后台用户，管理员。';

-- ----------------------------
-- Records of zs_admin_users
-- ----------------------------
INSERT INTO `zs_admin_users` VALUES ('2', 'admin', '2e88327de2f97110f6c5f97be61a25b8', 'admin', '1505445740', '0');
INSERT INTO `zs_admin_users` VALUES ('3', 'liuxuchao', 'd85137cca3bebb2b1804aaf61157515b', 'xuchao', '1505455740', '0');
INSERT INTO `zs_admin_users` VALUES ('4', 'liuxuyang', 'd85137cca3bebb2b1804aaf61157515b', 'xuyang', '1505460881', '0');

-- ----------------------------
-- Table structure for `zs_article`
-- ----------------------------
DROP TABLE IF EXISTS `zs_article`;
CREATE TABLE `zs_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '是否显示：1显示；2:隐藏',
  `tag_ids` varchar(64) DEFAULT '' COMMENT '标签组',
  `content` text COMMENT '内容',
  `cate_id` int(11) DEFAULT '0' COMMENT '所属文章id，0:不属于任何文章;',
  `create_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='文章表';

-- ----------------------------
-- Records of zs_article
-- ----------------------------
INSERT INTO `zs_article` VALUES ('1', '去玩儿群翁人', '1', '', '去玩儿群二无若群无&nbsp;', '0', '0000-00-00 00:00:00', null);
INSERT INTO `zs_article` VALUES ('4', '444444', '1', '', '<p>去玩儿群翁人<img src=\"/Uploadfiles/image/20180413/1523582910886082.jpg\" title=\"1523582910886082.jpg\" alt=\"pro-1.jpg\"/>ttttt</p>', '0', '2018-04-13 09:32:51', '0000-00-00 00:00:00');
INSERT INTO `zs_article` VALUES ('5', 'qwerqwer', '1', '', '<p>asdfasdfqwer<img src=\"/Uploadfiles/image/20180418/1524009053700245.jpg\" title=\"1524009053700245.jpg\" alt=\"pro3.jpg\"/>oooooooooooooo</p>', '0', '2018-04-18 07:51:09', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for `zs_article_cate`
-- ----------------------------
DROP TABLE IF EXISTS `zs_article_cate`;
CREATE TABLE `zs_article_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT '0' COMMENT '父ID',
  `description` varchar(255) DEFAULT '' COMMENT '描述',
  `cate_sort` tinyint(4) DEFAULT '0',
  `is_display` tinyint(1) DEFAULT '1' COMMENT '是否显示 1：是 0：不显示',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `has_child` tinyint(1) DEFAULT '0' COMMENT '有无子分类 0=>没有(默认),1=>有',
  `arr_childid` varchar(255) DEFAULT '' COMMENT '子分类id字符串',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='文章分类表';

-- ----------------------------
-- Records of zs_article_cate
-- ----------------------------
INSERT INTO `zs_article_cate` VALUES ('1', '关于我们', '0', '1234123f', '0', '1', '0', '1523571947', '0', '');
INSERT INTO `zs_article_cate` VALUES ('4', '购物指南', '0', '购物指南', '0', '1', '0', null, '0', '');

-- ----------------------------
-- Table structure for `zs_attachment`
-- ----------------------------
DROP TABLE IF EXISTS `zs_attachment`;
CREATE TABLE `zs_attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_type` tinyint(1) DEFAULT '0' COMMENT '文件类型：1：图片；2：视频',
  `file_path` varchar(128) DEFAULT '' COMMENT '文件储存位置',
  `article_id` int(11) DEFAULT '0' COMMENT '所属文章ID',
  `sort_id` tinyint(4) DEFAULT '0' COMMENT '排序，在同一文章中的顺序',
  `create_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='附件表';

-- ----------------------------
-- Records of zs_attachment
-- ----------------------------

-- ----------------------------
-- Table structure for `zs_cart`
-- ----------------------------
DROP TABLE IF EXISTS `zs_cart`;
CREATE TABLE `zs_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0' COMMENT '用户ID',
  `pro_id` int(11) DEFAULT NULL,
  `add_time` int(11) DEFAULT '0' COMMENT '加入时间',
  `plan_num` int(8) DEFAULT '1' COMMENT '购买数量',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态： 1：正常 ；2 删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='购物车';

-- ----------------------------
-- Records of zs_cart
-- ----------------------------

-- ----------------------------
-- Table structure for `zs_category`
-- ----------------------------
DROP TABLE IF EXISTS `zs_category`;
CREATE TABLE `zs_category` (
  `cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) DEFAULT '0' COMMENT '父ID',
  `name` varchar(32) DEFAULT '' COMMENT '分类名称',
  `ename` varchar(32) DEFAULT '' COMMENT '英文名称',
  `cate_no` varchar(16) DEFAULT '' COMMENT '分类编码',
  PRIMARY KEY (`cate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zs_category
-- ----------------------------

-- ----------------------------
-- Table structure for `zs_comments`
-- ----------------------------
DROP TABLE IF EXISTS `zs_comments`;
CREATE TABLE `zs_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0' COMMENT '用户ID',
  `order_id` int(11) DEFAULT '0' COMMENT '订单ID',
  `attitude_score` tinyint(2) DEFAULT NULL,
  `product_score` tinyint(2) DEFAULT NULL,
  `logistics-score` tinyint(2) DEFAULT NULL,
  `content` text COMMENT '评价内容',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品评价表';

-- ----------------------------
-- Records of zs_comments
-- ----------------------------

-- ----------------------------
-- Table structure for `zs_coupons`
-- ----------------------------
DROP TABLE IF EXISTS `zs_coupons`;
CREATE TABLE `zs_coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(11) DEFAULT '' COMMENT '优惠券名称',
  `activity_id` int(11) DEFAULT '0' COMMENT '活动ID',
  `amount` decimal(8,2) DEFAULT '0.00' COMMENT '金额',
  `use_from_time` int(11) DEFAULT '0' COMMENT '优惠券使用的开始时间',
  `use_end_time` int(11) DEFAULT '0' COMMENT '优惠券使用的截止时间',
  `create_time` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0' COMMENT '优惠券使用状态 1：正常  0：禁用',
  `limit_num` int(8) DEFAULT '0' COMMENT '优惠券的可用人数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zs_coupons
-- ----------------------------

-- ----------------------------
-- Table structure for `zs_deliver_user`
-- ----------------------------
DROP TABLE IF EXISTS `zs_deliver_user`;
CREATE TABLE `zs_deliver_user` (
  `id` int(11) NOT NULL DEFAULT '0',
  `work_no` varchar(32) DEFAULT '' COMMENT '工号',
  `true_name` varchar(32) DEFAULT '' COMMENT '真实姓名',
  `password` varchar(32) DEFAULT '',
  `phone` varchar(16) DEFAULT '' COMMENT '电话',
  `icon_url` varchar(128) DEFAULT '' COMMENT '头像地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zs_deliver_user
-- ----------------------------

-- ----------------------------
-- Table structure for `zs_dialog`
-- ----------------------------
DROP TABLE IF EXISTS `zs_dialog`;
CREATE TABLE `zs_dialog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0' COMMENT '用户ID',
  `service_id` int(11) DEFAULT '0' COMMENT '客服ID',
  `type` tinyint(1) DEFAULT '1' COMMENT '类型： 1：用户说；2：客服说',
  `text` varchar(128) DEFAULT '' COMMENT '文本',
  `create_time` int(11) DEFAULT NULL,
  `img_url` varchar(128) DEFAULT '' COMMENT '图片地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客服聊天记录';

-- ----------------------------
-- Records of zs_dialog
-- ----------------------------

-- ----------------------------
-- Table structure for `zs_feedback`
-- ----------------------------
DROP TABLE IF EXISTS `zs_feedback`;
CREATE TABLE `zs_feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `content` text COMMENT '反馈内容',
  `create_time` int(11) DEFAULT '0' COMMENT '提交时间',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态 ： 1：显示；2：不显示；',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='意见反馈';

-- ----------------------------
-- Records of zs_feedback
-- ----------------------------

-- ----------------------------
-- Table structure for `zs_invoice`
-- ----------------------------
DROP TABLE IF EXISTS `zs_invoice`;
CREATE TABLE `zs_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` char(32) DEFAULT NULL,
  `type` tinyint(1) DEFAULT '1' COMMENT '发票分类 1：电子发票；2：纸质发票',
  `email` varchar(64) DEFAULT '' COMMENT '电子发票收件箱',
  `invoice_title` varchar(255) DEFAULT '' COMMENT '发票抬头',
  `taxpayer_number` varchar(255) DEFAULT '' COMMENT '纳税人识别号',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态 1：已发电子邮箱；2：已打印；3:已发快递；0:未使用',
  `useing_time` int(11) DEFAULT '0' COMMENT '使用时间（发票被发送时间）',
  `invoice_type` tinyint(1) DEFAULT '0' COMMENT '纸质发票类型1：普票 ；2：专票',
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `taxpayer_tel` varchar(32) DEFAULT '' COMMENT '纳税人电话',
  `taxpayer_blank_account` varchar(32) DEFAULT '' COMMENT '纳税人银行账号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='发票（订单付款后默认生成数据）';

-- ----------------------------
-- Records of zs_invoice
-- ----------------------------

-- ----------------------------
-- Table structure for `zs_login_log`
-- ----------------------------
DROP TABLE IF EXISTS `zs_login_log`;
CREATE TABLE `zs_login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '登录时间',
  `login_user_id` int(11) DEFAULT NULL,
  `login_client_id` char(16) DEFAULT '' COMMENT '登录IP',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zs_login_log
-- ----------------------------

-- ----------------------------
-- Table structure for `zs_news`
-- ----------------------------
DROP TABLE IF EXISTS `zs_news`;
CREATE TABLE `zs_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catid` int(11) DEFAULT NULL COMMENT '分类ID',
  `title` varchar(128) DEFAULT NULL COMMENT '标题',
  `desc` varchar(255) DEFAULT '' COMMENT '描述',
  `create_time` int(11) DEFAULT NULL,
  `author` int(11) DEFAULT '0' COMMENT '创建人',
  `viewed` int(11) DEFAULT '0' COMMENT '浏览次数',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态： 1：已发布；0：未发布；2：删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zs_news
-- ----------------------------

-- ----------------------------
-- Table structure for `zs_news_category`
-- ----------------------------
DROP TABLE IF EXISTS `zs_news_category`;
CREATE TABLE `zs_news_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(32) DEFAULT NULL,
  `cate_ename` varchar(32) DEFAULT NULL,
  `parent_id` int(11) DEFAULT '0' COMMENT '上级分类ID',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章分类';

-- ----------------------------
-- Records of zs_news_category
-- ----------------------------

-- ----------------------------
-- Table structure for `zs_order`
-- ----------------------------
DROP TABLE IF EXISTS `zs_order`;
CREATE TABLE `zs_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_code` char(32) DEFAULT '' COMMENT '订单编号',
  `order_type` tinyint(2) DEFAULT '0' COMMENT '订单分类 1：商城订单；20：洗衣；30：家政；40：活动；',
  `product_id` int(11) DEFAULT '0' COMMENT '产品ID',
  `service_id` int(11) DEFAULT '0' COMMENT '预约分类ID',
  `customer` varchar(32) DEFAULT '' COMMENT '姓名',
  `phone` int(11) DEFAULT '0' COMMENT '联系方式',
  `services_name` varchar(32) DEFAULT '' COMMENT '服务名称',
  `services_time` varchar(32) DEFAULT '0' COMMENT '服务时间/发货时间',
  `attention` text COMMENT '注意事项',
  `create_time` int(11) DEFAULT '0' COMMENT '订单生成时间',
  `pay_status` tinyint(1) DEFAULT '0' COMMENT '支付状态 1：成功 2：失败；3：未支付',
  `pay_type` tinyint(1) DEFAULT '0' COMMENT '支付方式 1：余额；2：微信；3支付宝：4：其他',
  `pay_serial_number` varchar(32) DEFAULT '' COMMENT '支付流水号',
  `pay_time` int(11) DEFAULT '0' COMMENT '支付时间',
  `coupon_num` int(11) DEFAULT '0' COMMENT '优惠券id',
  `UID` int(11) DEFAULT '0' COMMENT '用户id',
  `totalPrice` decimal(11,2) DEFAULT '0.00' COMMENT '总金额',
  `couponPrice` decimal(11,2) DEFAULT '0.00' COMMENT '优惠券金额',
  `payPrice` decimal(11,2) DEFAULT '0.00' COMMENT '支付金额',
  `buyNum` int(11) DEFAULT '0' COMMENT '购买数量',
  `iUseCoupon` tinyint(1) DEFAULT '1' COMMENT '是否使用优惠券（1=》未使用，2=》已使用）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zs_order
-- ----------------------------
INSERT INTO `zs_order` VALUES ('1', 'sn111111', '1', '18', '0', '', '0', '', '0', null, '0', '0', '0', '', '0', '0', '2', '0.00', '0.00', '0.00', '0', '1');

-- ----------------------------
-- Table structure for `zs_orderrefund`
-- ----------------------------
DROP TABLE IF EXISTS `zs_orderrefund`;
CREATE TABLE `zs_orderrefund` (
  `sOrderNo` varchar(32) NOT NULL COMMENT '订单号',
  `fAmonut` decimal(8,2) DEFAULT NULL COMMENT '申请退款金额',
  `iCreateTime` int(11) DEFAULT NULL COMMENT '申请时间',
  `iStatus` tinyint(4) DEFAULT '0' COMMENT '单子处理状态 -1商家拒绝  1待处理 2已完成',
  `fPayAmonut` decimal(8,2) DEFAULT NULL COMMENT '实退金额',
  `sFlowNo` varchar(32) DEFAULT NULL COMMENT '退款第三方流水号',
  `iOperationDate` int(11) DEFAULT NULL COMMENT '操作时间',
  `iOpreation` int(11) DEFAULT NULL COMMENT '操作人编号',
  PRIMARY KEY (`sOrderNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单退款申请及处理表';

-- ----------------------------
-- Records of zs_orderrefund
-- ----------------------------

-- ----------------------------
-- Table structure for `zs_product`
-- ----------------------------
DROP TABLE IF EXISTS `zs_product`;
CREATE TABLE `zs_product` (
  `pro_id` int(11) NOT NULL AUTO_INCREMENT,
  `list_order` int(11) DEFAULT NULL COMMENT '排序',
  `cate_id` int(11) DEFAULT NULL COMMENT '所属分类ID',
  `product_name` varchar(255) DEFAULT NULL COMMENT '名称',
  `small_title` varchar(255) DEFAULT NULL COMMENT '小标题',
  `status` tinyint(1) DEFAULT '1' COMMENT '是否下架',
  `stock_number` int(11) DEFAULT '0' COMMENT '库存数量',
  `price` decimal(8,2) DEFAULT '0.00' COMMENT '销售价格',
  `market_price` decimal(8,2) DEFAULT NULL COMMENT '市场价格',
  `description` varchar(255) DEFAULT NULL COMMENT '描述',
  `commodity_number` varchar(30) DEFAULT NULL COMMENT '商品编号',
  `attributes` varchar(255) DEFAULT '' COMMENT 'json格式的商品属性',
  `integral` tinyint(8) DEFAULT NULL COMMENT '积分',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `create_ip` varchar(16) DEFAULT NULL COMMENT '创建IP',
  `update_ip` varchar(16) DEFAULT NULL COMMENT '修改IP',
  `contents` mediumtext COMMENT '商品详情',
  `template_style` tinyint(1) DEFAULT NULL COMMENT '前台显示样式 共6种(1:背景通栏居中,2:居中左图右文,3:居中左文右图4居中背景文字左,5:居中背景文字右)',
  `thumb` varchar(255) DEFAULT NULL COMMENT '缩略图',
  `group_img` varchar(255) DEFAULT NULL COMMENT '组图 json格式 { ''url'':''./upd/img'',''url'':''./upd/img2'' }',
  PRIMARY KEY (`pro_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='产品表';

-- ----------------------------
-- Records of zs_product
-- ----------------------------
INSERT INTO `zs_product` VALUES ('18', null, '36', '怡宝矿泉水', '怡宝矿泉水', '1', '2345', '1.45', '2.00', 'asdfasdf', '1234', '\"\"', '1', '1539126453', null, '192.168.254.1', null, '<p>asdfasdfasdf</p>', null, '/Uploadfiles/20181010/5bbd34ad8aa8f.jpg', '');

-- ----------------------------
-- Table structure for `zs_product_attr`
-- ----------------------------
DROP TABLE IF EXISTS `zs_product_attr`;
CREATE TABLE `zs_product_attr` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `cate_id` int(11) DEFAULT NULL COMMENT '分类ID',
  `attr_cn` varchar(64) DEFAULT NULL COMMENT '属性 中文名称',
  `attr_en` varchar(64) DEFAULT NULL COMMENT '属性英文名称',
  `is_sku` tinyint(1) DEFAULT '0' COMMENT '是否为关键属性0：不是关键属性；1：是关键属性',
  `types` tinyint(4) DEFAULT '0' COMMENT '属性类型,默认：0：单行输入框，1：下拉选项，2：单选',
  `unit` varchar(32) DEFAULT NULL COMMENT '属性单位',
  `json_values` text COMMENT '值对应的json格式',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `create_ip` varchar(16) DEFAULT NULL COMMENT '创建ip',
  `update_ip` varchar(16) DEFAULT NULL COMMENT '修改ip',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zs_product_attr
-- ----------------------------
INSERT INTO `zs_product_attr` VALUES ('8', '36', '容量', 'capacity', '0', '0', '0', '', '1539125546', null, '192.168.254.1', null);
INSERT INTO `zs_product_attr` VALUES ('9', '36', '瓶', 'bottle', '0', '1', '0', '340ml,555ml,1000ml', '1539125594', '1539129859', '192.168.254.1', '192.168.254.1');

-- ----------------------------
-- Table structure for `zs_product_cate`
-- ----------------------------
DROP TABLE IF EXISTS `zs_product_cate`;
CREATE TABLE `zs_product_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL COMMENT '父ID',
  `cate_name` varchar(32) NOT NULL COMMENT '分类名称',
  `cate_pinyin` varchar(32) NOT NULL COMMENT '分类拼音',
  `cate_sort` tinyint(4) DEFAULT NULL,
  `create_time` int(11) NOT NULL COMMENT '添加时间',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `description` varchar(255) DEFAULT NULL COMMENT '分类描述',
  `has_child` tinyint(1) NOT NULL DEFAULT '0' COMMENT '有无子分类 0=>没有(默认),1=>有',
  `arr_childid` varchar(255) DEFAULT NULL COMMENT '子分类id数组',
  `ip` varchar(16) DEFAULT NULL COMMENT 'ip',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COMMENT='商品分类表';

-- ----------------------------
-- Records of zs_product_cate
-- ----------------------------
INSERT INTO `zs_product_cate` VALUES ('30', '0', '食品', '', null, '1539125198', null, '食品', '1', '31,32', '192.168.254.1');
INSERT INTO `zs_product_cate` VALUES ('31', '30', '糖果', '', null, '1539125220', null, '糖果', '0', null, '192.168.254.1');
INSERT INTO `zs_product_cate` VALUES ('32', '30', '饮料', '', null, '1539125242', null, '饮料', '1', '36,37,38', '192.168.254.1');
INSERT INTO `zs_product_cate` VALUES ('33', '0', '水果', '', null, '1539125259', null, '水果', '1', '34,35', '192.168.254.1');
INSERT INTO `zs_product_cate` VALUES ('34', '33', '国产水果', '', null, '1539125282', null, '国产水果', '0', null, '192.168.254.1');
INSERT INTO `zs_product_cate` VALUES ('35', '33', '进口水果', '', null, '1539125308', null, '进口水果', '0', null, '192.168.254.1');
INSERT INTO `zs_product_cate` VALUES ('36', '32', '纯净水', '', null, '1539125427', null, '纯净水', '0', null, '192.168.254.1');
INSERT INTO `zs_product_cate` VALUES ('37', '32', '苏打水', '', null, '1539125440', null, '苏打水', '0', null, '192.168.254.1');
INSERT INTO `zs_product_cate` VALUES ('38', '32', '气泡水', '', null, '1539125454', null, '气泡水', '0', null, '192.168.254.1');

-- ----------------------------
-- Table structure for `zs_service_category`
-- ----------------------------
DROP TABLE IF EXISTS `zs_service_category`;
CREATE TABLE `zs_service_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) DEFAULT '1' COMMENT '状态1：正常  2：下架',
  `fid` int(11) DEFAULT NULL,
  `type` tinyint(2) DEFAULT '0' COMMENT '分类 ： 1：洗衣  2：家政',
  `cate_name` varchar(32) DEFAULT NULL,
  `img` varchar(255) DEFAULT '' COMMENT '分类图片',
  `desc` varchar(255) DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='服务分类表';

-- ----------------------------
-- Records of zs_service_category
-- ----------------------------

-- ----------------------------
-- Table structure for `zs_system_config`
-- ----------------------------
DROP TABLE IF EXISTS `zs_system_config`;
CREATE TABLE `zs_system_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(16) NOT NULL COMMENT '配置名称',
  `content` varchar(2048) NOT NULL DEFAULT '' COMMENT '配置详情，json数据',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='UU推荐一些系统配置';

-- ----------------------------
-- Records of zs_system_config
-- ----------------------------

-- ----------------------------
-- Table structure for `zs_user_address`
-- ----------------------------
DROP TABLE IF EXISTS `zs_user_address`;
CREATE TABLE `zs_user_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `receive_man` varchar(32) DEFAULT '' COMMENT '接收人姓名',
  `receive_phone` varchar(32) DEFAULT '' COMMENT '接收人联系方式',
  `community` varchar(128) DEFAULT '' COMMENT '社区',
  `address_detail` varchar(255) DEFAULT '' COMMENT '详细地址',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='收货地址';

-- ----------------------------
-- Records of zs_user_address
-- ----------------------------

-- ----------------------------
-- Table structure for `zs_user_balance`
-- ----------------------------
DROP TABLE IF EXISTS `zs_user_balance`;
CREATE TABLE `zs_user_balance` (
  `id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT NULL,
  `update_time` int(11) DEFAULT '0' COMMENT '修改时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zs_user_balance
-- ----------------------------

-- ----------------------------
-- Table structure for `zs_user_balance_log`
-- ----------------------------
DROP TABLE IF EXISTS `zs_user_balance_log`;
CREATE TABLE `zs_user_balance_log` (
  `id` int(11) DEFAULT NULL,
  `action_type` tinyint(1) DEFAULT '0' COMMENT '动作类型： 1：充值  2：商城消费；3服务消费',
  `number` decimal(10,2) DEFAULT '0.00' COMMENT '操作金额',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `recharge_no` varchar(32) DEFAULT '' COMMENT '充值流水号，消费则为空'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户余额变化日志';

-- ----------------------------
-- Records of zs_user_balance_log
-- ----------------------------

-- ----------------------------
-- Table structure for `zs_user_collection`
-- ----------------------------
DROP TABLE IF EXISTS `zs_user_collection`;
CREATE TABLE `zs_user_collection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) DEFAULT '0' COMMENT '分类 1：商品 ；2：活动 3：家政 4：洗衣',
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT '0' COMMENT '商品id',
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zs_user_collection
-- ----------------------------

-- ----------------------------
-- Table structure for `zs_user_pwd_log`
-- ----------------------------
DROP TABLE IF EXISTS `zs_user_pwd_log`;
CREATE TABLE `zs_user_pwd_log` (
  `id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `log_type` tinyint(1) DEFAULT '1' COMMENT '修改类型 1：初始设置；2：短信验证设置；'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户密码修改日志';

-- ----------------------------
-- Records of zs_user_pwd_log
-- ----------------------------

-- ----------------------------
-- Table structure for `zs_users`
-- ----------------------------
DROP TABLE IF EXISTS `zs_users`;
CREATE TABLE `zs_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(32) DEFAULT '' COMMENT '微信端ID',
  `username` char(32) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '用户登录密码',
  `real_name` char(16) DEFAULT '' COMMENT '用户真实姓名',
  `mobile` bigint(11) unsigned DEFAULT '0' COMMENT '用户登录账号，手机号。',
  `gender` tinyint(1) unsigned DEFAULT '0' COMMENT '性别。1:男；2:女；0:未知。',
  `job` char(16) DEFAULT '' COMMENT '职位',
  `icon_url` char(128) DEFAULT '' COMMENT '用户头像URL',
  `points` int(11) unsigned DEFAULT '0' COMMENT '账号积分',
  `register_type` tinyint(1) DEFAULT '1' COMMENT '注册类型，1：普通，2：分享注册;3：后台添加',
  `create_time` int(11) unsigned DEFAULT '0' COMMENT '数据添加时间，注册时间。',
  `update_time` int(11) DEFAULT '0' COMMENT '数据修改时间。',
  `userType` tinyint(1) DEFAULT '1' COMMENT '类型 0：普通用户  1：送货端用户',
  `userNum` varchar(32) DEFAULT '' COMMENT '工号',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of zs_users
-- ----------------------------
INSERT INTO `zs_users` VALUES ('1', '', 'liuxuyang', '2e88327de2f97110f6c5f97be61a25b8', '', '0', '0', '', '', '0', '1', '1524869792', '0', '1', '');
INSERT INTO `zs_users` VALUES ('2', '', 'jiaxinrq', '2e88327de2f97110f6c5f97be61a25b8', '', '0', '0', '', '', '0', '1', '1524869820', '0', '2', '10000');
