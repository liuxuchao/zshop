-- MySQL dump 10.13  Distrib 5.1.73, for redhat-linux-gnu (x86_64)
--
-- Host: localhost    Database: uu_recommend
-- ------------------------------------------------------
-- Server version	5.7.11-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `uu_admin_users`
--

DROP TABLE IF EXISTS `uu_admin_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_admin_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(64) NOT NULL DEFAULT '' COMMENT '登陆账号',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `nickname` char(16) NOT NULL DEFAULT '' COMMENT '昵称',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理后台用户，管理员。';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_channel`
--

DROP TABLE IF EXISTS `uu_channel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_channel` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '账号状态。1：可用，0：不可用。',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID，uu_users表主键ID。',
  `channel_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '渠道类型ID。1:智联  2：前程',
  `user_name` char(32) NOT NULL DEFAULT '' COMMENT '用户名，会员名，公司名称 ',
  `login_name` char(32) NOT NULL DEFAULT '' COMMENT '登录名，账号。',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码，明文密码。',
  `bind_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '绑定状态，1:绑定；0:解绑定。',
  `original_company_id` char(32) NOT NULL DEFAULT '' COMMENT '原公司ID，在来源网站上的ID。',
  `company_name` char(32) NOT NULL DEFAULT '' COMMENT '公司名称',
  `shortname` char(32) NOT NULL DEFAULT '' COMMENT '公司简称',
  `company_trade` char(255) NOT NULL DEFAULT '' COMMENT '公司行业',
  `company_nature` char(16) NOT NULL DEFAULT '' COMMENT '公司性质，例如：民营，国企。',
  `company_size` char(16) NOT NULL DEFAULT '' COMMENT '公司规模',
  `company_size_from` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '公司规模，人数起点。',
  `company_size_to` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '公司规模，最多人数。',
  `company_address` char(255) NOT NULL DEFAULT '' COMMENT '公司地址',
  `company_description` varchar(10000) NOT NULL DEFAULT '' COMMENT '公司描述',
  `company_website` char(255) NOT NULL DEFAULT '' COMMENT '公司网址',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `channel_type` (`channel_type`),
  KEY `login_name` (`login_name`),
  KEY `account_status` (`account_status`)
) ENGINE=InnoDB AUTO_INCREMENT=183 DEFAULT CHARSET=utf8 COMMENT='渠道账号公司信息';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_channel_action_log`
--

DROP TABLE IF EXISTS `uu_channel_action_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_channel_action_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID，uu_users表主键ID。',
  `channel_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '渠道类型ID。',
  `channel_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '渠道账号ID，uu_channel表主键ID。',
  `action_name` char(16) NOT NULL DEFAULT '' COMMENT '动作名称',
  `action_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '操作结果状态，1:成功；0:失败；',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='渠道账号操作记录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_channel_bind_progress`
--

DROP TABLE IF EXISTS `uu_channel_bind_progress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_channel_bind_progress` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `channel_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '渠道账号类型。1：智联；2：前程。',
  `company_name` char(64) NOT NULL DEFAULT '' COMMENT '公司名称',
  `user_name` char(32) NOT NULL DEFAULT '' COMMENT '用户名，会员名，公司名称',
  `login_name` char(32) NOT NULL DEFAULT '' COMMENT '登录名，账号。',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码，明文密码。',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0：成功（登陆或采集）；1：登陆失败。2：采集职位失败；3：表示获取收件箱失败；4：表示外网采集失败',
  `job_total` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '职位总数',
  `current_job_num` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '当前采集的职位数量',
  `action_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '操作类型。1：登陆；2：采集职位；3：采集公司信息。',
  `is_end` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '动作是否完结。0：未完结，1：已完结。登陆、获取公司信息是一步完成，每次记录都是已完结；职位采集分步骤，最后一步才算完结。',
  `batch` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '批次，区分同一个账号多次绑定解绑时做区分。',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据创建时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`channel_type`,`login_name`,`action_type`),
  KEY `batch` (`batch`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户绑定账号状态';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_channel_company`
--

DROP TABLE IF EXISTS `uu_channel_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_channel_company` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID，uu_users表主键ID。',
  `channel_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '渠道类型ID。1:智联招聘，2：前程无忧',
  `original_company_id` char(32) NOT NULL DEFAULT '' COMMENT '原公司ID，在来源网站上的ID。',
  `company_name` char(32) NOT NULL DEFAULT '' COMMENT '公司名称',
  `shortname` char(32) NOT NULL DEFAULT '0' COMMENT '公司简称',
  `company_trade` char(255) NOT NULL DEFAULT '' COMMENT '公司行业',
  `company_nature` char(16) NOT NULL DEFAULT '' COMMENT '公司性质，例如：民营，国企。',
  `company_size` char(16) NOT NULL DEFAULT '' COMMENT '公司规模',
  `company_size_from` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '公司规模，人数起点。',
  `company_size_to` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '公司规模，最多人数。',
  `company_address` char(255) NOT NULL DEFAULT '' COMMENT '公司地址',
  `company_description` varchar(10000) NOT NULL DEFAULT '' COMMENT '公司描述',
  `company_website` char(255) NOT NULL DEFAULT '' COMMENT '公司网址，公司主页。',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `company_logo` varchar(255) NOT NULL DEFAULT '' COMMENT '公司logo',
  `financing_stage` varchar(255) NOT NULL DEFAULT '' COMMENT '融资阶段',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_2` (`user_id`,`channel_type`,`original_company_id`),
  KEY `user_id` (`user_id`),
  KEY `channel_type` (`channel_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='渠道公司信息，此处只是表结构，数据存放在MongoDB中。';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_channel_institutional`
--

DROP TABLE IF EXISTS `uu_channel_institutional`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_channel_institutional` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `channel_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '渠道类型ID',
  `channel_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '渠道ID，在UU推荐系统中的ID。uu_channel表的主键ID。',
  `name` char(64) NOT NULL DEFAULT '' COMMENT '机构名称',
  `original_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '机构在原网站的ID。',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `channel_id_2` (`channel_id`,`original_id`),
  KEY `channel_id` (`channel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=860 DEFAULT CHARSET=utf8 COMMENT='渠道多机构，目前只有智联是多机构的。';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_channel_jobs`
--

DROP TABLE IF EXISTS `uu_channel_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_channel_jobs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID，uu_users主键ID。',
  `channel_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '渠道类型ID',
  `channel_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '渠道账号ID，uu_channel主键ID。',
  `original_id` char(32) NOT NULL DEFAULT '' COMMENT '原职位ID，职位在来源网站上的ID',
  `institutional_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '机构ID，uu_channel_institutional表的主键ID。',
  `company_id` char(24) NOT NULL DEFAULT '' COMMENT '公司ID，公司信息在mongo中的ID。',
  `original_publish_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '职位在来源网站的发布状态，1：发布中；0：停止发布。',
  `is_recommend` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐简历，0：默认；1：推荐；2:结束推荐',
  `name` char(64) NOT NULL DEFAULT '' COMMENT '职位名称',
  `short_name` char(10) NOT NULL DEFAULT '' COMMENT '职位简称（长度10个字）',
  `job_trade` char(128) NOT NULL DEFAULT '' COMMENT '职位所属的行业、类别',
  `salary` char(16) NOT NULL DEFAULT '' COMMENT '薪资',
  `salary_from` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '薪资范围起点',
  `salary_to` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '薪资范围最高点',
  `work_address` char(255) NOT NULL DEFAULT '' COMMENT '工作地点',
  `work_years` char(16) NOT NULL DEFAULT '' COMMENT '工作年限限制',
  `work_years_from` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '工作年数起点',
  `work_years_to` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '工作年数最高点',
  `degree` char(8) NOT NULL DEFAULT '' COMMENT '最低学历',
  `refresh_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '职位发布时间，时间戳',
  `refresh_end_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '职位发布结束时间',
  `job_description` varchar(10000) NOT NULL DEFAULT '' COMMENT '职位介绍，职位描述。',
  `company_name` char(128) DEFAULT '' COMMENT '公司名称',
  `company_size` char(16) NOT NULL DEFAULT '' COMMENT '企业规模',
  `company_size_from` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '企业规模，人数起点。',
  `company_nature` char(16) NOT NULL DEFAULT '' COMMENT '公司性质',
  `company_trade` char(255) NOT NULL DEFAULT '' COMMENT '公司行业',
  `recommended_time` int(11) NOT NULL DEFAULT '0' COMMENT '设置为推荐的时间',
  `end_recommend_time` int(11) NOT NULL DEFAULT '0' COMMENT '职位结束推荐时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加、创建时间戳',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1为默认,0非默认',
  `work_address_detail` char(128) NOT NULL DEFAULT '' COMMENT '工作地点的详细地址(修改职位信息保存地址)',
  `city` char(20) DEFAULT '' COMMENT '选中地点所在的地级市',
  `district` char(20) DEFAULT '' COMMENT ' 选中地点所在的行政区',
  `latitude` char(20) DEFAULT '' COMMENT '选中地点的纬度',
  `longitude` char(20) DEFAULT '' COMMENT '选中地点的经度',
  `province` char(20) DEFAULT '' COMMENT '选中地点的所在的省',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_2` (`user_id`,`channel_type`,`original_id`,`channel_id`) USING BTREE,
  KEY `user_id` (`user_id`,`channel_id`),
  KEY `channel_id` (`channel_id`),
  KEY `is_recommend` (`is_recommend`),
  KEY `institutional_id` (`institutional_id`),
  KEY `company` (`user_id`,`company_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=33118 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`%`*/ /*!50003 TRIGGER `after_insert_uu_channel_jobs` AFTER INSERT ON `uu_channel_jobs` 
    FOR EACH ROW BEGIN
INSERT INTO uu_channel_jobs_not_indexing 
(
    id,
    user_id,
    channel_type,
    channel_id,
    original_id,
    institutional_id,
    company_id,
    original_publish_status,
    is_recommend,
    NAME,
    short_name,
    job_trade,
    salary,
    salary_from,
    salary_to,
    work_address,
    work_years,
    work_years_from,
    work_years_to,
    degree,
    refresh_time,
    refresh_end_time,
    job_description,
    company_name,
    company_size,
    company_size_from,
    company_nature,
    company_trade,
    recommended_time,
    create_time,
    update_time,
    is_default,
    work_address_detail,
    city,
    district,
    latitude,
    longitude,
    province
) 
VALUES 
(
    new.id,
    new.user_id,
    new.channel_type,
    new.channel_id,
    new.original_id,
    new.institutional_id,
    new.company_id,
    new.original_publish_status,
    new.is_recommend,
    new.name,
    new.short_name,
    new.job_trade,
    new.salary,
    new.salary_from,
    new.salary_to,
    new.work_address,
    new.work_years,
    new.work_years_from,
    new.work_years_to,
    new.degree,
    new.refresh_time,
    new.refresh_end_time,
    new.job_description,
    new.company_name,
    new.company_size,
    new.company_size_from,
    new.company_nature,
    new.company_trade,
    new.recommended_time,
    new.create_time,
    new.update_time,
    new.is_default,
    new.work_address_detail,
    new.city,
    new.district,
    new.latitude,
    new.longitude,
    new.province
);
INSERT INTO uu_channel_jobs_half_baked 
(
    id,
    channel_type,
    original_id,
    STATUS,
    create_time,
    update_time
)
VALUES(
    new.id,
    new.channel_type,
    new.original_id,
    0,
    new.create_time,
    new.update_time
);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `uu_channel_jobs_half_baked`
--

DROP TABLE IF EXISTS `uu_channel_jobs_half_baked`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_channel_jobs_half_baked` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `channel_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '渠道类型ID ',
  `original_id` char(32) NOT NULL DEFAULT '' COMMENT ' 	原职位ID，职位在来源网站上的ID ',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态。0：未做任何操作；1：公司信息和职位信息都已经从采集库中拉取过来；2：加入任务队列；3：拉取职位失败；4：拉取公司信息失败；5：职位信息公司信息填充都失败。',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据添加时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据更新时间',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=33118 DEFAULT CHARSET=utf8 COMMENT='需要完善信息的职位，当用户绑定账号有新增职位时此表会增加数据。此表数据是由触发器插入的。';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_channel_jobs_keywords`
--

DROP TABLE IF EXISTS `uu_channel_jobs_keywords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_channel_jobs_keywords` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `channel_jobs_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '职位ID',
  `keywords` char(128) NOT NULL DEFAULT '' COMMENT '职位标签，关键词。',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_and_job_id` (`user_id`,`channel_jobs_id`,`keywords`) USING BTREE,
  KEY `channel_jobs_id` (`channel_jobs_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='职位关键词（标签），用户在设置职位为‘推荐职位’时会设置职位关键词（标签）。';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_channel_jobs_name`
--

DROP TABLE IF EXISTS `uu_channel_jobs_name`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_channel_jobs_name` (
  `channel_jobs_id` int(10) unsigned NOT NULL COMMENT 'uu_channel_jobs表的主键ID。',
  `name` char(128) NOT NULL DEFAULT '' COMMENT '给职位设置的用于搜索简历的名称',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`channel_jobs_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用于搜索简历的职位名称';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_channel_jobs_not_indexing`
--

DROP TABLE IF EXISTS `uu_channel_jobs_not_indexing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_channel_jobs_not_indexing` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID，uu_users主键ID。',
  `channel_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '渠道类型ID',
  `channel_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '渠道账号ID，uu_channel主键ID。',
  `original_id` char(32) NOT NULL DEFAULT '' COMMENT '原职位ID，职位在来源网站上的ID',
  `institutional_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '机构ID，uu_channel_institutional表的主键ID。',
  `company_id` char(24) NOT NULL DEFAULT '' COMMENT '公司ID，公司信息在mongo中的ID。',
  `original_publish_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '职位在来源网站的发布状态，1：发布中；0：停止发布。',
  `is_recommend` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐简历，0：默认；1：推荐；2:结束推荐',
  `name` char(64) NOT NULL DEFAULT '' COMMENT '职位名称',
  `short_name` char(10) NOT NULL DEFAULT '' COMMENT '职位简称（长度10个字）',
  `job_trade` char(128) NOT NULL DEFAULT '' COMMENT '职位所属的行业、类别',
  `salary` char(16) NOT NULL DEFAULT '' COMMENT '薪资',
  `salary_from` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '薪资范围起点',
  `salary_to` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '薪资范围最高点',
  `work_address` char(255) NOT NULL DEFAULT '' COMMENT '工作地点',
  `work_years` char(16) NOT NULL DEFAULT '' COMMENT '工作年限限制',
  `work_years_from` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '工作年数起点',
  `work_years_to` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '工作年数最高点',
  `degree` char(8) NOT NULL DEFAULT '' COMMENT '最低学历',
  `refresh_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '职位发布时间，时间戳',
  `refresh_end_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '职位结束时间,时间戳',
  `job_description` varchar(2000) NOT NULL DEFAULT '' COMMENT '职位介绍，职位描述。',
  `company_name` char(128) DEFAULT '' COMMENT '公司名称',
  `company_size` char(16) NOT NULL DEFAULT '' COMMENT '企业规模',
  `company_size_from` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '企业规模，人数起点。',
  `company_nature` char(16) NOT NULL DEFAULT '' COMMENT '公司性质',
  `company_trade` char(255) NOT NULL DEFAULT '' COMMENT '公司行业',
  `recommended_time` int(11) NOT NULL DEFAULT '0' COMMENT '设置为推荐的时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加、创建时间戳',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `work_address_detail` char(128) DEFAULT '' COMMENT '工作地点的详细地址(修改职位信息保存地址)',
  `city` char(20) DEFAULT '' COMMENT '选中地点所在的地级市',
  `district` char(20) DEFAULT '' COMMENT '选中地点所在的行政区',
  `latitude` char(20) DEFAULT '' COMMENT '选中地点的纬度',
  `longitude` char(20) DEFAULT '' COMMENT '选中地点的经度',
  `province` char(20) DEFAULT '' COMMENT '选中地点的所在的省',
  `is_default` tinyint(1) DEFAULT '0' COMMENT '1为默认,0非默认',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_2` (`user_id`,`channel_type`,`original_id`,`channel_id`) USING BTREE,
  KEY `user_id` (`user_id`,`channel_id`),
  KEY `channel_id` (`channel_id`),
  KEY `is_recommend` (`is_recommend`),
  KEY `short_name` (`short_name`) USING BTREE,
  KEY `institutional_id` (`institutional_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33118 DEFAULT CHARSET=utf8 COMMENT='没有添加到索引中的职位，用户执行完绑定后，导入的职位会存到这里一份，生成索引后会删除。';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_channel_jobs_tags`
--

DROP TABLE IF EXISTS `uu_channel_jobs_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_channel_jobs_tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `channel_jobs_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '职位ID',
  `tags` char(128) NOT NULL DEFAULT '' COMMENT '职位标签，关键词。',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_and_job_id` (`user_id`,`channel_jobs_id`),
  KEY `user_id` (`user_id`),
  KEY `channel_jobs_id` (`channel_jobs_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='职位关键词（标签），用户在设置职位为‘推荐职位’时会设置职位关键词（标签）。';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_company_tags`
--

DROP TABLE IF EXISTS `uu_company_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_company_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000' COMMENT '用户id',
  `channel_jobs_id` int(11) NOT NULL DEFAULT '0' COMMENT '职位id',
  `tags` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci NOT NULL DEFAULT '' COMMENT '公司标签名',
  `channel_company_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'uu_channel_company的主键',
  `createtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `tags` (`tags`) USING BTREE,
  KEY `jobid` (`channel_jobs_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公司标签';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_dict_area`
--

DROP TABLE IF EXISTS `uu_dict_area`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_dict_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(16) NOT NULL DEFAULT '' COMMENT '地区名称',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父类ID',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '层级，第几级。',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=556 DEFAULT CHARSET=utf8 COMMENT='地区字典';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_dict_area_relation`
--

DROP TABLE IF EXISTS `uu_dict_area_relation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_dict_area_relation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `channel_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '渠道ID',
  `name` char(16) NOT NULL DEFAULT '' COMMENT '地区名称',
  `uu_area_id` int(11) unsigned DEFAULT '0' COMMENT 'uu推荐系统的地区ID',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父类ID',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '层级，第几级。 	',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据添加时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `uu_area_id` (`uu_area_id`)
) ENGINE=InnoDB AUTO_INCREMENT=967 DEFAULT CHARSET=utf8 COMMENT='渠道地区和UU推荐地区对应关系';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_dict_job_relation`
--

DROP TABLE IF EXISTS `uu_dict_job_relation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_dict_job_relation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父类ID',
  `level` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '层级数量',
  `channel_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '渠道类型ID',
  `job_name` char(64) NOT NULL DEFAULT '' COMMENT '渠道职位名称',
  `uu_job_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'UU推荐系统中的职位ID',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `channel_type` (`channel_type`,`job_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4617 DEFAULT CHARSET=utf8 COMMENT='渠道职位和UU推荐系统职位的对应关系';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_dict_trades`
--

DROP TABLE IF EXISTS `uu_dict_trades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_dict_trades` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL DEFAULT '' COMMENT '行业名',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父级id',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_email`
--

DROP TABLE IF EXISTS `uu_email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_email` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'uu_users表的主键ID',
  `email` char(255) NOT NULL DEFAULT '' COMMENT '邮箱账号',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '邮箱密码',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '邮箱账号状态1：可用；0：邮箱账号不可用。2删除',
  `anchor` varchar(128) NOT NULL DEFAULT '' COMMENT '上次拉取锚点',
  `email_channel_id` int(11) unsigned NOT NULL COMMENT '邮箱渠道id',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据创建时间，绑定时间。',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据更新时间',
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否是默认0不是默认1是默认',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`email`) USING BTREE,
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='用户绑定的账号';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_email_channel`
--

DROP TABLE IF EXISTS `uu_email_channel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_email_channel` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '所用邮箱名称比如163邮箱',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '邮箱状态1可用0不可用2删除',
  `suffix` varchar(255) NOT NULL DEFAULT '' COMMENT '邮箱后缀比如@qq.com',
  `domain` varchar(255) DEFAULT '' COMMENT '邮箱地址比如mail.qq.com',
  `createtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后修改时间',
  `sort` tinyint(1) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='邮箱类型';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_email_content`
--

DROP TABLE IF EXISTS `uu_email_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_email_content` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email_id` char(64) NOT NULL DEFAULT '' COMMENT '邮件ID ',
  `content` text NOT NULL COMMENT '邮件内容详情',
  `resume_name` char(32) NOT NULL DEFAULT '' COMMENT '如果是简历邮件可以匹配到姓名，存储，否则为空',
  `resume_phone` int(11) DEFAULT NULL COMMENT '如果是简历邮件可以匹配到电话，存储，否则为空',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间，收取时间。',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_id` (`email_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='邮件内容。这里只展示结构，具体内容存放在MongoDB中';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_email_forward_log`
--

DROP TABLE IF EXISTS `uu_email_forward_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_email_forward_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `email_list_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'uu_email_list表的主键ID 	',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据创建时间。分享时间。',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `email_list_id` (`email_list_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='简历邮件转发记录。';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_email_list`
--

DROP TABLE IF EXISTS `uu_email_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_email_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email_id` char(64) NOT NULL DEFAULT '' COMMENT '邮件ID',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID，uu_users表中的主键ID。',
  `uu_email_id` int(11) NOT NULL,
  `is_read` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否已读。1：已读；0：未读。',
  `email_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '邮件内容类型。1:邮件；2：普通邮件。',
  `is_shared` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否已经分享。0：未分享；1：分享过。',
  `email` char(255) NOT NULL DEFAULT '' COMMENT '邮箱账号，用户绑定的邮箱账号，uu_email的email字段。',
  `subject` char(255) NOT NULL DEFAULT '' COMMENT '邮件标题',
  `preview` char(64) DEFAULT '' COMMENT '邮件的前64个字符',
  `email_from` char(128) NOT NULL DEFAULT '' COMMENT '发件人',
  `email_to` char(255) DEFAULT '' COMMENT '收件人',
  `send_date` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '邮件发送时间戳',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间，收取时间。',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_id` (`email_id`,`user_id`,`uu_email_id`),
  KEY `user_id` (`user_id`),
  KEY `is_read` (`is_read`),
  KEY `uu_email_id` (`uu_email_id`),
  KEY `email_type` (`email_type`)
) ENGINE=InnoDB AUTO_INCREMENT=5414 DEFAULT CHARSET=utf8 COMMENT='用户邮件列表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_goods`
--

DROP TABLE IF EXISTS `uu_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_goods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(32) NOT NULL DEFAULT '' COMMENT '商品名称',
  `u_sum` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'U币数量',
  `price` double(11,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '价格',
  `discount_price` float NOT NULL DEFAULT '0' COMMENT '折后价格',
  `discount` float unsigned NOT NULL DEFAULT '0' COMMENT '折扣数',
  `position` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序规则，按照此字段降序排序。数字越小位置越靠前。',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `position` (`position`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='商品';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_goods_discount`
--

DROP TABLE IF EXISTS `uu_goods_discount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_goods_discount` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `range_from` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'U币数量区间起点',
  `range_to` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'U币数量区间终点',
  `description` char(64) NOT NULL DEFAULT '' COMMENT '描述',
  `discount` float NOT NULL DEFAULT '0' COMMENT '折扣，9.5表示95折。0表示不打折。',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='自定义充值U币数量时的折扣计算方式';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_invite`
--

DROP TABLE IF EXISTS `uu_invite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_invite` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID，uu_users表主键。',
  `channel_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '渠道账号ID，uu_channel主键。',
  `channel_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '渠道类型，1：智联；2:51job；',
  `job_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '职位ID，uu_channel_jobs主键。',
  `resume_id` char(36) NOT NULL DEFAULT '' COMMENT '简历ID',
  `in_mongo_id` varchar(32) DEFAULT '' COMMENT '邀请的简历在mongo中的唯一键',
  `invite_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '邀请状态。0：等待中；1：同意；2：失败。',
  `is_read` int(1) NOT NULL DEFAULT '0' COMMENT '邀请是否被读取（邀请详情是否被打开过）：1：已读，0：未读',
  `search_log_id` int(11) NOT NULL DEFAULT '0' COMMENT ' 通过搜索生成的邀请时的搜索ID',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据添加时间，发出邀请的时间。',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `create_time` (`create_time`),
  KEY `user_id` (`user_id`),
  KEY `update_time` (`update_time`),
  KEY `in_mongo_id` (`in_mongo_id`) USING BTREE,
  KEY `user_id, channel_id, job_id, resume_id` (`user_id`,`job_id`,`resume_id`,`channel_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=502 DEFAULT CHARSET=utf8 COMMENT='HR邀请';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_invite_decline_reason`
--

DROP TABLE IF EXISTS `uu_invite_decline_reason`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_invite_decline_reason` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `invite_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '邀请信息ID，uu_invite表主键ID。',
  `job_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '职位ID，uu_channel_jobs表主键ID。',
  `resume_id` char(36) NOT NULL DEFAULT '' COMMENT '简历ID，求职者ID。',
  `reason_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'uu_reasons_rejection表的id',
  `reason_cn` char(16) NOT NULL DEFAULT '' COMMENT '拒绝理由。',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `invite_id` (`invite_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='求职者拒绝邀请，拒绝理由。';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_invite_detail`
--

DROP TABLE IF EXISTS `uu_invite_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_invite_detail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `invite_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '邀请ID，uu_invite主键ID',
  `who_send` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0 求职者发送的， 1 HR发送的， 2 系统发送的消息 ',
  `from_id` char(36) NOT NULL DEFAULT '' COMMENT '发送信息的用户ID，可能是HR的ID，也可能是求职者简历ID。',
  `to_id` char(36) NOT NULL DEFAULT '' COMMENT '回复信息的用户ID，可能是HR的ID，也可能是求职者简历ID。',
  `job_id` int(11) NOT NULL DEFAULT '0' COMMENT '职位ID，uu_channel_jos表主键ID。',
  `content` char(255) NOT NULL DEFAULT '' COMMENT '通话内容',
  `remark` char(255) NOT NULL DEFAULT '' COMMENT '备注内容。',
  `is_read` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否读过(短信链接是否被点击过) 1：是 0 否',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '沟通信息穿件时间，数据添加时间。',
  `read_time` int(11) NOT NULL DEFAULT '0' COMMENT '求职者第一次查看简历的时间',
  PRIMARY KEY (`id`),
  KEY `invite_id` (`invite_id`,`who_send`) USING BTREE,
  KEY `from_id` (`from_id`,`invite_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=612 DEFAULT CHARSET=utf8 COMMENT='邀请、沟通详情记录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_job_check`
--

DROP TABLE IF EXISTS `uu_job_check`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_job_check` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `channel_job_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '职位在UU推荐项目中的ID。uu_channel_jobs表的主键ID',
  `channel_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '渠道类型ID。1：智联招聘；2：前程无忧。',
  `original_company_id` char(32) NOT NULL DEFAULT '' COMMENT '公司在院网站的ID',
  `original_id` char(32) NOT NULL DEFAULT '' COMMENT '职位在来源网站上的ID',
  `is_run` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否检测过。0：未检测；1：已检测。',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据添加时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据更新时间',
  PRIMARY KEY (`id`),
  KEY `is_exists` (`is_run`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='放在这个表中的职位需要去检测一下是否采集';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_job_connective_words`
--

DROP TABLE IF EXISTS `uu_job_connective_words`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_job_connective_words` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job` char(255) NOT NULL DEFAULT '' COMMENT '关联职位职位',
  `hits` int(11) NOT NULL DEFAULT '0' COMMENT '使用频次',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='职位关联关系词-存储于mongo';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_job_list_page`
--

DROP TABLE IF EXISTS `uu_job_list_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_job_list_page` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `channel_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '渠道ID。1：智联；2：前程无忧。',
  `channel_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '渠道账号绑定信息ID。uu_channel表的主键ID。',
  `is_multi_institutional` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否是多机构账号。0：不是；1：是。',
  `original_institutional_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '机构在来源网站的ID',
  `total_page` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '总页数',
  `page` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '当前页数，当前第几页。',
  `content` varchar(20000) NOT NULL DEFAULT '' COMMENT '职位列表页html内容',
  `parse_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否解析过；0：没有解析，未处理。；1：已经解析，并且解析成功。；2：在任务队列中；3：解析失败；4：存储失败；',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据创建时间，添加时间。',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `original_institutional_id` (`original_institutional_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='职位列表页HTML，从元网站采集的。这只是表结构，数据是存在mongodb中的。';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_job_list_queue_log`
--

DROP TABLE IF EXISTS `uu_job_list_queue_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_job_list_queue_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mongo_id` char(24) NOT NULL DEFAULT '' COMMENT '采集到的职位列表HTML页在mongo集合job_list_page中的id',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态码。1：职位列表为空；2：插入数据库失败；3：其他错误',
  `message` varchar(3000) NOT NULL DEFAULT '' COMMENT '提示消息',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COMMENT='职位列表入库记录。从队列中取出解析好的职位列表入库，记录一些操作异常。';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_job_search_records`
--

DROP TABLE IF EXISTS `uu_job_search_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_job_search_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `search_name` char(200) NOT NULL DEFAULT '' COMMENT '搜索记录',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'uu_users表的id',
  `channel_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '渠道id',
  PRIMARY KEY (`id`),
  KEY `search_name` (`search_name`) USING BTREE,
  KEY `create_time` (`create_time`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=614 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_lexicon_cities`
--

DROP TABLE IF EXISTS `uu_lexicon_cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_lexicon_cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL DEFAULT '10000' COMMENT '城市编号',
  `superior_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级的ID',
  `city_name` char(32) NOT NULL DEFAULT '' COMMENT '省份或者城市名称',
  PRIMARY KEY (`id`),
  KEY `city_id` (`city_id`),
  KEY `superior_id` (`superior_id`)
) ENGINE=InnoDB AUTO_INCREMENT=556 DEFAULT CHARSET=utf8 COMMENT='全国各个省份下的城市';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_lexicon_core_word`
--

DROP TABLE IF EXISTS `uu_lexicon_core_word`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_lexicon_core_word` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL DEFAULT '0' COMMENT '分类ID',
  `word` varchar(32) NOT NULL DEFAULT '' COMMENT '词',
  `word_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '分类：1：核心词，2：副词，3;修饰词',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `sort` tinyint(4) NOT NULL DEFAULT '1' COMMENT '排序（序号小的表示权重高）',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否停止使用，1：可用，2：停用',
  PRIMARY KEY (`id`),
  UNIQUE KEY `word` (`word`),
  KEY `word_type` (`word_type`)
) ENGINE=InnoDB AUTO_INCREMENT=1382 DEFAULT CHARSET=utf8 COMMENT='核心词词库';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_lexicon_job_category`
--

DROP TABLE IF EXISTS `uu_lexicon_job_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_lexicon_job_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) NOT NULL DEFAULT '0' COMMENT '父级id',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '等级（fid=0  为1级）',
  `category_name` varchar(64) NOT NULL DEFAULT '' COMMENT '分类名称',
  `sort` int(4) NOT NULL DEFAULT '0' COMMENT '排序规则（升序排序）',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  `fid_of_str` varchar(12) DEFAULT '000000' COMMENT '分类id的str格式',
  PRIMARY KEY (`id`),
  KEY `fid` (`fid`)
) ENGINE=InnoDB AUTO_INCREMENT=1369 DEFAULT CHARSET=utf8 COMMENT='职位词库的关联分类表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_lexicon_job_description`
--

DROP TABLE IF EXISTS `uu_lexicon_job_description`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_lexicon_job_description` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `word` char(64) NOT NULL DEFAULT '' COMMENT '词，词库中的词。',
  `category_id` int(11) NOT NULL DEFAULT '0' COMMENT '职位分类id',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT ' 	词的状态。0：弃用（删除）；1：使用中； 	',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间 ',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据修改时间 ',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1651 DEFAULT CHARSET=utf8 COMMENT='职位描述词库，ES搜索引擎分词用。';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_lexicon_job_name`
--

DROP TABLE IF EXISTS `uu_lexicon_job_name`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_lexicon_job_name` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` char(64) NOT NULL DEFAULT '' COMMENT '职位名称词',
  `category_id` int(4) NOT NULL DEFAULT '0' COMMENT '分类id',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '词的状态。0：弃用（删除）；1：使用中；',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `word` (`word`,`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3120 DEFAULT CHARSET=utf8 COMMENT='职位名称词库，ES搜索引擎做分词用。';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_nonexistent_jobs`
--

DROP TABLE IF EXISTS `uu_nonexistent_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_nonexistent_jobs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `channel_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '渠道类型ID。1：智联招聘；2：前程无忧。',
  `original_company_id` char(32) NOT NULL DEFAULT '' COMMENT '公司在原网站ID',
  `original_job_id` char(32) NOT NULL DEFAULT '' COMMENT '原职位ID，职位在来源网站上的ID ',
  `is_run` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否已经请求过，是否加入采集队列。',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据修改时间',
  PRIMARY KEY (`id`),
  KEY `is_run` (`is_run`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8 COMMENT='不存在的职位。需要采集详情的职位。';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_order`
--

DROP TABLE IF EXISTS `uu_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `invoice_title_id` int(11) unsigned NOT NULL COMMENT '发票Title id，uu_users_invoice_title表的主键ID。',
  `payment_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '支付方式，1：支付宝；2：微信。',
  `pay_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '支付状态。0：未支付；1：支付成功；2：支付失败。',
  `result_status` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '支付结果码，支付宝9000为支付成功。',
  `trade_status` char(32) NOT NULL DEFAULT '' COMMENT '交易状态，支付宝：WAIT_BUYER_PAY,TRADE_CLOSED,TRADE_SUCCESS,TRADE_FINISHED。',
  `trade_no` char(32) NOT NULL DEFAULT '' COMMENT '订单号',
  `goods_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `goods_number` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品数量',
  `total_amount` double unsigned NOT NULL DEFAULT '0' COMMENT '订单金额',
  `is_invoice` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否开过发票。0：没开过；1：已经开了。',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `trade_no` (`trade_no`) USING BTREE,
  KEY `payment_type` (`payment_type`),
  KEY `user_id` (`user_id`),
  KEY `pay_status` (`pay_status`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COMMENT='订单';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_order_parameter`
--

DROP TABLE IF EXISTS `uu_order_parameter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_order_parameter` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID，uu_order表的主键ID。',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `payment_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '支付方式，1：支付宝；2：微信。',
  `parameter_json` varchar(2000) NOT NULL DEFAULT '' COMMENT '参数数组',
  `parameter_str` varchar(2000) NOT NULL DEFAULT '' COMMENT '参数字符串',
  `sign` varchar(2000) NOT NULL DEFAULT '' COMMENT '签名字符串',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据添加时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='支付参数记录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_payment_feedback_log`
--

DROP TABLE IF EXISTS `uu_payment_feedback_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_payment_feedback_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `payment_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '支付方式，1：支付宝；2：微信。 ',
  `pay_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '支付状态。0：未支付；1：支付成功；2：支付失败。 ',
  `feedback_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '支付结果通知类型。1:同步通知，2:异步通知。',
  `feedback_info` varchar(2000) NOT NULL DEFAULT '' COMMENT '支付平台反馈信息',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据添加时间，支付平台反馈时间。',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='支付平台反馈信息记录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_re_institutional`
--

DROP TABLE IF EXISTS `uu_re_institutional`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_re_institutional` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `re_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '账号重新绑定记录ID，uu_re_log表日志',
  `institutional_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '机构ID，在UU推荐系统中的ID。',
  `name` char(255) NOT NULL DEFAULT '' COMMENT '机构名称',
  `original_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '机构在原网站的ID。',
  `channel_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '渠道类型ID',
  `channel_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '渠道ID，在UU推荐系统中的ID。uu_channel表的主键ID。',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0：未知，无状态；1：重复；2：新增；3：删除。',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据添加时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `original_id` (`channel_id`,`original_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 COMMENT='重新绑定账号时临时存储机构信息，属于一个中转表。';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_re_jobs`
--

DROP TABLE IF EXISTS `uu_re_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_re_jobs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `re_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '重新绑定日志ID',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID，uu_users主键ID。',
  `channel_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '渠道类型ID',
  `channel_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '渠道账号ID，uu_channel主键ID。',
  `original_id` char(32) NOT NULL DEFAULT '' COMMENT '原职位ID，职位在来源网站上的ID',
  `institutional_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '机构ID，uu_channel_institutional表的主键ID。',
  `company_id` char(24) NOT NULL DEFAULT '' COMMENT '公司ID，公司信息在mongo中的ID。',
  `original_publish_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '职位在来源网站的发布状态，1：发布中；0：停止发布。',
  `is_recommend` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐简历，0：默认；1：推荐；2:结束推荐',
  `name` char(64) NOT NULL DEFAULT '' COMMENT '职位名称',
  `short_name` char(8) NOT NULL DEFAULT '' COMMENT '职位简称（长度8个字）',
  `job_trade` char(128) NOT NULL DEFAULT '' COMMENT '职位所属的行业、类别',
  `salary` char(16) NOT NULL DEFAULT '' COMMENT '薪资',
  `salary_from` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '薪资范围起点',
  `salary_to` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '薪资范围最高点',
  `work_address` char(255) NOT NULL DEFAULT '' COMMENT '工作地点',
  `work_years` char(16) NOT NULL DEFAULT '' COMMENT '工作年限限制',
  `work_years_from` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '工作年数起点',
  `work_years_to` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '工作年数最高点',
  `degree` char(8) NOT NULL DEFAULT '' COMMENT '最低学历',
  `refresh_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '职位发布时间，时间戳',
  `refresh_end_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '职位发布结束时间',
  `job_description` varchar(10000) NOT NULL DEFAULT '' COMMENT '职位介绍，职位描述。',
  `company_name` char(128) DEFAULT '' COMMENT '公司名称',
  `company_size` char(16) NOT NULL DEFAULT '' COMMENT '企业规模',
  `company_size_from` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '企业规模，人数起点。',
  `company_nature` char(16) NOT NULL DEFAULT '' COMMENT '公司性质',
  `company_trade` char(255) NOT NULL DEFAULT '' COMMENT '公司行业',
  `recommended_time` int(11) NOT NULL DEFAULT '0' COMMENT '设置为推荐的时间',
  `end_recommend_time` int(11) NOT NULL DEFAULT '0' COMMENT '职位结束推荐时间',
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1为默认,0非默认',
  `work_address_detail` char(128) NOT NULL DEFAULT '' COMMENT '工作地点的详细地址(修改职位信息保存地址)',
  `city` char(20) DEFAULT '' COMMENT '选中地点所在的地级市',
  `district` char(20) DEFAULT '' COMMENT ' 选中地点所在的行政区',
  `latitude` char(20) DEFAULT '' COMMENT '选中地点的纬度',
  `longitude` char(20) DEFAULT '' COMMENT '选中地点的经度',
  `province` char(20) DEFAULT '' COMMENT '选中地点的所在的省',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0：未知，无状态；1：重复；2：新增；3：删除。',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加、创建时间戳',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_2` (`re_id`,`user_id`,`channel_type`,`original_id`,`channel_id`) USING BTREE,
  KEY `user_id` (`user_id`,`channel_id`),
  KEY `channel_id` (`channel_id`),
  KEY `is_recommend` (`is_recommend`),
  KEY `institutional_id` (`institutional_id`),
  KEY `company` (`user_id`,`company_id`) USING BTREE,
  KEY `re_id` (`re_id`)
) ENGINE=InnoDB AUTO_INCREMENT=802 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_re_log`
--

DROP TABLE IF EXISTS `uu_re_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_re_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `channel_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '渠道类型ID ',
  `channel_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '渠道ID，在UU推荐系统中的ID。uu_channel表的主键ID。',
  `original_account` char(255) NOT NULL DEFAULT '' COMMENT '原账号信息，json数据。',
  `new_account` char(255) NOT NULL DEFAULT '' COMMENT '新账号信息，json数据。',
  `new_account_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1:账号、密码有效；2：账号密码无效；3：未知，由于其他原因没有走到验证登陆是否成功的步骤。',
  `bind_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1:重新绑定；2:添加新账号。',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '重新绑定进度状态。0：已开始；1：全部完成；',
  `parse_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:未知，未完成；1：已经完成。',
  `message` char(255) NOT NULL DEFAULT '' COMMENT '提示信息',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1210 DEFAULT CHARSET=utf8 COMMENT='重新绑定日志';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_reasons_rejection`
--

DROP TABLE IF EXISTS `uu_reasons_rejection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_reasons_rejection` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(255) NOT NULL COMMENT '理由名称',
  `category` tinyint(1) unsigned NOT NULL COMMENT '1hr,2求职者',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1正常0停用',
  `create_time` int(11) unsigned NOT NULL COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='拒绝理由';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_recommend_invite_number`
--

DROP TABLE IF EXISTS `uu_recommend_invite_number`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_recommend_invite_number` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `resume_id` char(64) NOT NULL DEFAULT '' COMMENT '简历ID',
  `recommend_number` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '推荐次数',
  `invite_number` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '邀请次数',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间，只存当天零点零分的时间戳。',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据更新时间，存当前系统时间戳。',
  PRIMARY KEY (`id`),
  UNIQUE KEY `resume_id` (`resume_id`,`create_time`),
  KEY `create_time` (`create_time`),
  KEY `recommend_number` (`recommend_number`),
  KEY `invite_number` (`invite_number`)
) ENGINE=InnoDB AUTO_INCREMENT=451 DEFAULT CHARSET=utf8 COMMENT='记录简历每天被推荐次数和被邀请次数';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_recommend_log`
--

DROP TABLE IF EXISTS `uu_recommend_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_recommend_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID，uu_users表的主键ID',
  `channel_job_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT ' 	职位ID，uu_channel_jobs表的主键ID',
  `resume_list_status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '推荐的简历列表状态。1：已读；2：未读；3：新推荐过来的还未到使用时间，不允许使用。',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据创建时间，推荐时间。',
  `result_count` int(11) NOT NULL DEFAULT '0' COMMENT '搜索结果总数',
  `result_num` int(11) NOT NULL DEFAULT '0' COMMENT '搜索返回总数，搜索引擎实际返回的数量。相当于limit指定的数据量也可以理解为翻页时的每页数据量。',
  `unique_result_num` int(11) NOT NULL DEFAULT '0' COMMENT '排除后给用户推荐总数，符合条件的简历数量。',
  PRIMARY KEY (`id`),
  KEY `channel_job_id` (`channel_job_id`),
  KEY `user_id` (`user_id`),
  KEY `create_time` (`create_time`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7692 DEFAULT CHARSET=utf8 COMMENT='职位推荐简历记录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_recommend_resume`
--

DROP TABLE IF EXISTS `uu_recommend_resume`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_recommend_resume` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID，uu_users表的主键ID',
  `operation_user_role` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '操作简历的用户角色，管理员和UU推荐用于都有肯能对简历进行操作，UU推荐用户会选择‘不感兴趣’等操作，后台用户会有人工筛选的一些操作。0：位操作过；1：UU推荐用户；2：后台管理员。',
  `operation_user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '对简历进行操作的用户ID，可能是UU推荐用户，也有可能是后台管理员，根据operation_user_role字段的值来区分。',
  `recommend_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'uu_recommend_log表的主键ID',
  `channel_job_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '职位ID，uu_channel_jobs表的主键ID',
  `resume_id` bigint(12) unsigned NOT NULL DEFAULT '0' COMMENT '简历ID，在巧达系统的ID',
  `person_id` char(64) NOT NULL DEFAULT '' COMMENT '简历id对应的person_id',
  `resume_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户对简历是否感兴趣1：感兴趣，2：不感兴趣，3：简历不合适（审核未通过）。',
  `resume_img` varchar(200) NOT NULL DEFAULT '' COMMENT '简历头像URL',
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '简历中求职者姓名',
  `gender` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别：1=男；2=女。',
  `birthday` int(11) NOT NULL DEFAULT '0' COMMENT '生日，如果是70年以前出生可能是负数的时间戳。',
  `age` tinyint(4) NOT NULL DEFAULT '0' COMMENT '年龄',
  `first_work_start` char(32) NOT NULL DEFAULT '' COMMENT '第一份工作的开始时间',
  `current_area` varchar(64) NOT NULL DEFAULT '' COMMENT '当前居住地',
  `last_job_name` varchar(128) NOT NULL DEFAULT '' COMMENT '最后（最近）一份工作的职位',
  `last_company_name` varchar(255) NOT NULL DEFAULT '' COMMENT '最后（最近）一份工作的公司名称',
  `highest_school_name` varchar(128) NOT NULL DEFAULT '' COMMENT '最高学历毕业院校',
  `highest_specialty` varchar(64) NOT NULL DEFAULT '' COMMENT '最高学历名称',
  `highest_degree` varchar(64) NOT NULL DEFAULT '' COMMENT '最高学历',
  `resume_update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '简历的更新时间',
  `recommend_reason` varchar(128) NOT NULL DEFAULT '' COMMENT '推荐理由',
  `is_read` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户是否查看了简历：0未查看，1：已经查看',
  `is_send_invite` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否发送了邀请。0：未发送；1：发送过了。',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据添加时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据更新时间。操作数据时或者修改数据内容时更新为当前的系统时间。',
  `salary` varchar(64) NOT NULL DEFAULT '' COMMENT '薪资',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_2` (`user_id`,`channel_job_id`,`resume_id`),
  KEY `channel_job_id` (`channel_job_id`),
  KEY `user_id` (`user_id`),
  KEY `resume_id` (`resume_id`),
  KEY `recommend_id` (`recommend_id`),
  KEY `resume_status` (`resume_status`),
  KEY `update_time` (`update_time`),
  KEY `is_send_invite` (`is_send_invite`)
) ENGINE=InnoDB AUTO_INCREMENT=93564 DEFAULT CHARSET=utf8 COMMENT='给职位推荐的简历';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_recommend_statistical`
--

DROP TABLE IF EXISTS `uu_recommend_statistical`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_recommend_statistical` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '向那个用户推的，用户ID',
  `parameter` varchar(128) NOT NULL DEFAULT '' COMMENT '请求的参数',
  `uu_job_id` int(11) NOT NULL DEFAULT '0' COMMENT '推荐的职位在uu推荐库中的ID',
  `result_count` int(11) NOT NULL DEFAULT '0' COMMENT '返回数据总数',
  `resume_id_str` varchar(1200) NOT NULL DEFAULT '' COMMENT '返回的简历id，字符串拼接',
  `call_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '调用推荐的类型：1：设置职位时，2：再来一波时，3：定时推荐时',
  `result_num` int(11) NOT NULL DEFAULT '0' COMMENT '匹配到的数据总数',
  `unique_result_num` int(11) NOT NULL DEFAULT '0' COMMENT '去重后的结果总数',
  `filterIds` varchar(32) NOT NULL DEFAULT '0' COMMENT '过滤的简历id',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  UNIQUE KEY `user_id_job_id` (`user_id`,`uu_job_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='推荐简历时的结果记录-数据存储在mongo';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_resume_forward_log`
--

DROP TABLE IF EXISTS `uu_resume_forward_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_resume_forward_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `job_id` int(11) NOT NULL DEFAULT '0' COMMENT '职位ID',
  `resume_id` int(11) NOT NULL DEFAULT '0' COMMENT '简历ID',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `job_id` (`job_id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8 COMMENT='简历转发记录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_resume_search_log`
--

DROP TABLE IF EXISTS `uu_resume_search_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_resume_search_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `job_id` int(11) NOT NULL DEFAULT '0',
  `total_number` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '搜索结果总数量',
  `view_number` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '查看数量。搜索结果中的简历用户查看了多少。',
  `invite_number` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '邀请数量。搜索结果中的简历用户发出邀请的数量。',
  `parameters` varchar(2000) NOT NULL DEFAULT '' COMMENT 'json 的字符串 存储搜索参数',
  `create_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=643 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_resume_search_read_log`
--

DROP TABLE IF EXISTS `uu_resume_search_read_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_resume_search_read_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `job_id` int(11) NOT NULL DEFAULT '0' COMMENT '职位ID',
  `search_id` int(11) NOT NULL DEFAULT '0' COMMENT '搜索条件ID',
  `resume_id` char(36) NOT NULL DEFAULT '0' COMMENT '简历ID',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间即搜索的简历查看的时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `read_log` (`user_id`,`job_id`,`search_id`,`resume_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8 COMMENT='简历搜索结果查看记录，记录某个用户某个职位下的某个搜索条件查看了某份简历。';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_robot`
--

DROP TABLE IF EXISTS `uu_robot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_robot` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from_user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发送消息的用户ID，可能是管理员，也可能是用户。0表示系统管理员。',
  `to_user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '接收消息的用户ID，可能是管理员也可能是用户。',
  `user_name` char(32) NOT NULL DEFAULT '' COMMENT '发送消息的用户名称',
  `has_read` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否已读，1：已读；0：未读',
  `user_role` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '用户角色，1：系统管理员，2：UU推荐用户。',
  `content_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '内容类型。1：文字，2：图片。',
  `content` char(255) NOT NULL DEFAULT '' COMMENT '聊天内容',
  `create_time` int(11) unsigned DEFAULT '0' COMMENT '发送时间。数据创建时间。',
  PRIMARY KEY (`id`),
  KEY `create_time` (`create_time`),
  KEY `from_user_id` (`from_user_id`),
  KEY `to_user_id` (`to_user_id`),
  KEY `user_role` (`user_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='UU机器人，用户和系统管理员沟通聊天。';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_search_resume_read_log`
--

DROP TABLE IF EXISTS `uu_search_resume_read_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_search_resume_read_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `job_id` int(11) NOT NULL DEFAULT '0' COMMENT '职位ID',
  `search_id` int(11) NOT NULL DEFAULT '0' COMMENT '搜索ID',
  `resume_id` char(36) NOT NULL DEFAULT '0' COMMENT '简历ID',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间即搜索的简历查看的时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `read_log` (`user_id`,`job_id`,`search_id`,`resume_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_system_config`
--

DROP TABLE IF EXISTS `uu_system_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_system_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(16) NOT NULL COMMENT '配置名称',
  `content` varchar(2048) NOT NULL DEFAULT '' COMMENT '配置详情，json数据',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='UU推荐一些系统配置';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_system_message`
--

DROP TABLE IF EXISTS `uu_system_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_system_message` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL COMMENT '文章标题',
  `short_context` varchar(255) NOT NULL COMMENT '文章简介',
  `picture` varchar(128) NOT NULL DEFAULT '0' COMMENT '文章图片',
  `url` varchar(255) NOT NULL DEFAULT '0' COMMENT '文章链接',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `send_time` int(11) NOT NULL COMMENT '发送时间',
  `send_type` int(2) NOT NULL COMMENT '触发方式，1，注册，2，系统定时',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_uninterest_resume`
--

DROP TABLE IF EXISTS `uu_uninterest_resume`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_uninterest_resume` (
  `id` int(11) NOT NULL COMMENT 'uu_recommend_log表的主键ID',
  `resume_id` bigint(12) NOT NULL COMMENT '简历ID，在巧达系统的ID',
  `user_id` int(11) NOT NULL COMMENT '用户ID，uu_users表的主键ID',
  `job_id` int(11) NOT NULL DEFAULT '0' COMMENT '在uu推荐中的职位id',
  `reason` char(32) NOT NULL DEFAULT '' COMMENT '拒绝原因',
  `create_time` int(11) NOT NULL COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户不感兴趣的简历（实际数据存在mongo）';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_unsubscribe_sms`
--

DROP TABLE IF EXISTS `uu_unsubscribe_sms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_unsubscribe_sms` (
  `id` int(11) unsigned NOT NULL,
  `resume_id` char(64) NOT NULL DEFAULT '' COMMENT '简历ID',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='求职者退订短信。';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_users`
--

DROP TABLE IF EXISTS `uu_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户登录账号，手机号。',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '用户登录密码',
  `real_name` char(16) NOT NULL DEFAULT '' COMMENT '用户真实姓名',
  `gender` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别。1:男；2:女；0:未知。',
  `job` char(16) NOT NULL DEFAULT '' COMMENT '职位',
  `icon_url` char(128) NOT NULL DEFAULT '' COMMENT '用户头像URL',
  `channel_id` int(11) NOT NULL DEFAULT '0' COMMENT '使用中的渠道账号-关联uu_channel表主键ID',
  `company_name` char(16) NOT NULL DEFAULT '' COMMENT '用户所在公司名称',
  `shortname` char(32) NOT NULL DEFAULT '' COMMENT '公司简称',
  `company_size` char(32) NOT NULL DEFAULT '' COMMENT '公司规模',
  `company_nature` char(64) NOT NULL DEFAULT '' COMMENT '公司性质',
  `company_trade` char(64) NOT NULL DEFAULT '' COMMENT '所属行业',
  `company_address` char(255) NOT NULL DEFAULT '' COMMENT '公司地址',
  `balance` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '账号余额',
  `register_type` tinyint(1) DEFAULT '1' COMMENT '注册类型，1：普通，2：分享注册',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据添加时间，注册时间。',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据修改时间。',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile` (`mobile`),
  UNIQUE KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COMMENT='用户表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_users_balance_log`
--

DROP TABLE IF EXISTS `uu_users_balance_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_users_balance_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID，uu_users表主键。',
  `action` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '操作，1：增加，2：减少。',
  `action_name` char(18) NOT NULL DEFAULT '' COMMENT '导致余额变化的操作名称，例如：企业认证，分享简历邮箱',
  `sum` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '本次操作金额数量',
  `balance` int(11) NOT NULL COMMENT '操作后的剩余U币额',
  `is_read` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已读（用于查询是否有奖励分享的记录）',
  `remark` char(255) NOT NULL DEFAULT '' COMMENT '备注信息，json数据，记录操作时的数据。',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='余额增减记录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_users_invoice_title`
--

DROP TABLE IF EXISTS `uu_users_invoice_title`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_users_invoice_title` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `title_name` char(32) NOT NULL DEFAULT '' COMMENT '发票title名称',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户发票抬头';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_users_login_log`
--

DROP TABLE IF EXISTS `uu_users_login_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_users_login_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `login_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '登录方式。1:账号密码登录；2:手机号验证码登录；3:首次普通注册登录；4:首次邀请注册登录。5：每日签到。',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID，uu_users表的主键ID。',
  `user_mobile` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户登录手机，登录账号。',
  `device_id` char(64) NOT NULL DEFAULT '' COMMENT '登录时设备ID，用于个推时使用',
  `device_type` char(16) NOT NULL DEFAULT '' COMMENT '设备类型名称',
  `device_version` char(8) NOT NULL DEFAULT '' COMMENT '设备版本',
  `app_version` char(16) NOT NULL DEFAULT '' COMMENT 'APP版本号',
  `ip` bigint(11) NOT NULL DEFAULT '0' COMMENT '用户登录IP，转为10进制后的数字。',
  `login_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '登录时间戳，数据添加时间。',
  `keep_login_days` int(4) NOT NULL DEFAULT '0' COMMENT '连续登录天数',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `user_mobile` (`user_mobile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户登录日志';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_users_login_status`
--

DROP TABLE IF EXISTS `uu_users_login_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_users_login_status` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sys_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '手机设备类型，1：安卓；2：IOS 	',
  `user_id` int(11) unsigned NOT NULL COMMENT '用户ID，uu_users表主键。',
  `login_token` char(32) NOT NULL DEFAULT '' COMMENT '登陆后产生的token',
  `login_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '重新登陆时间',
  `device_id` char(64) NOT NULL DEFAULT '' COMMENT '登录时设备ID，用于个推时使用',
  `device_type` char(16) NOT NULL DEFAULT '' COMMENT '设备类型名称',
  `device_version` char(16) NOT NULL DEFAULT '' COMMENT '设备版本',
  `app_version` char(16) NOT NULL DEFAULT '' COMMENT 'APP版本号',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=532 DEFAULT CHARSET=utf8 COMMENT='用户登陆状态记录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_users_messages_log`
--

DROP TABLE IF EXISTS `uu_users_messages_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_users_messages_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL COMMENT '用户id',
  `message_id` int(10) NOT NULL COMMENT '文章id',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `click_time` int(11) NOT NULL DEFAULT '0' COMMENT '阅读时间',
  `is_read` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否已读，1：未读，2：已读',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE COMMENT '用户id',
  KEY `meg_id` (`message_id`) USING BTREE COMMENT '消息id'
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_users_modify_company_log`
--

DROP TABLE IF EXISTS `uu_users_modify_company_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_users_modify_company_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `channel_id` int(11) NOT NULL DEFAULT '0' COMMENT '账号ID',
  `company_name` char(16) NOT NULL DEFAULT '0' COMMENT '修改后的名称',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='记录用户每个账号下的公司名称修改记录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_users_price_config`
--

DROP TABLE IF EXISTS `uu_users_price_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_users_price_config` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'U币操作类型；1：增加U币；2：扣除U币',
  `name` varchar(32) NOT NULL COMMENT '名称',
  `money` int(11) NOT NULL COMMENT '金额，U币数量。',
  `description` varchar(128) NOT NULL COMMENT '描述',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '修改时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='增加U币和扣除U币的价格配置和操作说明';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_users_push_config`
--

DROP TABLE IF EXISTS `uu_users_push_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_users_push_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `is_bell_vibration` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否响铃震动',
  `is_invite` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否接受邀请',
  `has_agreed_message` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有人同意推送通知',
  `has_refused_message` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否有人拒绝推送通知 0：否；1：是 ',
  `is_push_boot_message` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否接受uu机器人推送消息 0：否 ；1：是',
  `is_preview_sms` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示预览  1：显示 ；0：不显示',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据添加时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `user_id_2` (`user_id`),
  KEY `user_id_3` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COMMENT='用户个推设置表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_users_share_log`
--

DROP TABLE IF EXISTS `uu_users_share_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_users_share_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sns_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '分享的渠道： 1：微信 2：qq 3 :朋友圈 4：qq空间',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '分享人的ID',
  `share_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '分享记录状态：0 ：默认；1：成功；2：失败',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '分享时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `sns_type` (`sns_type`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='分享记录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_users_share_register`
--

DROP TABLE IF EXISTS `uu_users_share_register`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_users_share_register` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shared_user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发送分享的用户ID',
  `share_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分享记录的ID，uu_users_share_log表的主键ID',
  `register_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '看到分享后通过分享（邀请）注册页面注册进来的用户的ID，uu_user表的主键ID',
  `register_user_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '通过邀请注册的用户渠道账号绑定状态，0：默认，1：完成验证',
  `is_reward_login` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '通过分享注册过来的用户是否给过初次登陆奖励。1：给过；0：没给过。',
  `create_time` int(11) NOT NULL COMMENT '创建时间，',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据更新时间',
  PRIMARY KEY (`id`),
  KEY `share_id` (`share_id`),
  KEY `register_user_id` (`register_user_id`) USING BTREE,
  KEY `shared_user_id` (`shared_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='使用邀请注册记录';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `uu_version`
--

DROP TABLE IF EXISTS `uu_version`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uu_version` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `is_publish` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否对外发布。0：不发布；1：发布。',
  `version_code` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '版本号数字',
  `version_name` char(32) NOT NULL DEFAULT '' COMMENT '版本名称，字符串的版本号。',
  `title` char(128) NOT NULL DEFAULT '' COMMENT '版本更新内容标题',
  `content` varchar(2000) NOT NULL DEFAULT '' COMMENT '版本更新内容',
  `is_force` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否强制更新，0:不强制更新;1:强制更新.',
  `android_download_url` char(128) NOT NULL DEFAULT '' COMMENT '安卓安装包下载地址',
  `ios_download_url` char(128) NOT NULL DEFAULT '' COMMENT '苹果安装包下载地址',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间，发布时间。',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `version_code` (`version_code`),
  KEY `is_publish` (`is_publish`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='版本管理，版本更新内容说明。';
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-06  9:50:25
