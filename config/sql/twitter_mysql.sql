-- SVN FILE: $Id$
--
-- BaserCMS Twitterプラグイン インストール SQL（MySQL）
--
-- BaserCMS :  Based Website Development Project <http://basercms.net>
-- Copyright 2008 - 2010, Catchup, Inc.
--								9-5 nagao 3-chome, fukuoka-shi
--								fukuoka, Japan 814-0123
--
-- @copyright		Copyright 2008 - 2010, Catchup, Inc.
-- @link			http://basercms.net BaserCMS Project
-- @version			$Revision$
-- @modifiedby		$LastChangedBy$
-- @lastmodified	$Date$
-- @license			http://basercms.net/license/index.html


SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- テーブルの構造 `bc__twitter_configs`
--

CREATE TABLE IF NOT EXISTS `bc__twitter_configs` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `value` text collate utf8_unicode_ci,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- テーブルのデータをダンプしています `bc__twitter_configs`
--

INSERT INTO `bc__twitter_configs` (`name`, `value`, `created`, `modified`) VALUES
('consumer_key','Ms83i4onvRtIpuiCRCCa7A', NOW(), NOW()),
('consumer_secret','91r0eu3uMQDQkBPzEPTcPQZqjIZR37QiCuCdFbwE', NOW(), NOW()),
('access_token_key',NULL, NOW(), NOW()),
('access_token_secret',NULL, NOW(), NOW()),
('username', NULL, NOW(), NOW()),
('view_num','3', NOW(), NOW()),
('tweet_settings','a:1:{i:0;a:7:{s:2:\"id\";i:1;s:4:\"name\";s:15:\"ブログ記事\";s:6:\"plugin\";s:4:\"blog\";s:10:\"controller\";s:10:\"blog_posts\";s:6:\"action\";s:10:\"admin_edit\";s:15:\"status_template\";s:4:\"blog\";s:6:\"status\";s:1:\"1\";}}', NOW(), NOW());