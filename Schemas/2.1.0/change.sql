[2017-05-31]
ALTER TABLE `uu_recommend`.`uu_channel_jobs` ADD COLUMN `sync_status` TINYINT(1) DEFAULT -1 NOT NULL COMMENT '重新绑定默认-1,如果只为失效此字段为0,正常为1' AFTER `cannel_default_time`; 

[2017-06-02]
ALTER TABLE `uu_channel_jobs` ADD INDEX(`is_fill`);


[2017-06-03]

#关于发送邀请时候的邮件中的短连接
ALTER TABLE `uu_invite_detail`
ADD COLUMN `read_by_email`  tinyint(1) NULL DEFAULT 0 COMMENT '0:默认（未使用邮件打开），1：已经在邮件中打开' AFTER `read_time`;

ALTER TABLE `uu_invite_detail`
ADD COLUMN `from_email`  varchar(64) NULL DEFAULT '' COMMENT '发送邮件的邮箱账号' AFTER `read_by_email`;

ALTER TABLE `uu_invite_detail`
ADD COLUMN `to_email`  varchar(64) NULL DEFAULT '' COMMENT '接收邮件的邮箱账号' AFTER `from_email`;



[2017-06-07]
#首页banner数据表创建

DROP TABLE IF EXISTS `uu_index_banner`;
CREATE TABLE `uu_index_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link_url` varchar(128) DEFAULT '' COMMENT '链接地址',
  `img_url` varchar(255) DEFAULT '' COMMENT '图片地址',
  `is_display` tinyint(1) DEFAULT '0' COMMENT '是否显示 1:显示 0 ：不显示',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

[2017-06-08]
ALTER TABLE `uu_index_banner`
ADD COLUMN `sort`  tinyint(4) NULL DEFAULT 0 COMMENT '排序id 默认0 按照 id升序排序' AFTER `is_display`;

