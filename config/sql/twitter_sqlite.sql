-- SVN FILE: $Id$
--
-- BaserCMS Twitterプラグイン インストール SQL（SQLite）
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

--
-- テーブルの構造 "bc__twitter_configs"
--

CREATE TABLE bc__twitter_configs (
  "id" integer NOT NULL PRIMARY KEY,
  "name" text default NULL,
  "value" text default NULL,
  "created" text default NULL,
  "modified" text default NULL
);

--
-- テーブルのデータをダンプしています "bc__twitter_configs"
--

INSERT INTO bc__twitter_configs (name, value, created, modified) VALUES
('consumer_key','Ms83i4onvRtIpuiCRCCa7A', datetime('now', 'localtime'), datetime('now', 'localtime'));
INSERT INTO bc__twitter_configs (name, value, created, modified) VALUES
('consumer_secret','91r0eu3uMQDQkBPzEPTcPQZqjIZR37QiCuCdFbwE', datetime('now', 'localtime'), datetime('now', 'localtime'));
INSERT INTO bc__twitter_configs (name, value, created, modified) VALUES
('access_token_key',NULL, datetime('now', 'localtime'), datetime('now', 'localtime'));
INSERT INTO bc__twitter_configs (name, value, created, modified) VALUES
('access_token_secret',NULL, datetime('now', 'localtime'), datetime('now', 'localtime'));
INSERT INTO bc__twitter_configs (name, value, created, modified) VALUES
('username', NULL, datetime('now', 'localtime'), datetime('now', 'localtime'));
INSERT INTO bc__twitter_configs (name, value, created, modified) VALUES
('view_num','3', datetime('now', 'localtime'), datetime('now', 'localtime'));
INSERT INTO bc__twitter_configs (name, value, created, modified) VALUES
('tweet_settings','a:1:{i:0;a:7:{s:2:"id";i:1;s:4:"name";s:15:"ブログ記事";s:6:"plugin";s:4:"blog";s:10:"controller";s:10:"blog_posts";s:6:"action";s:10:"admin_edit";s:15:"status_template";s:4:"blog";s:6:"status";s:1:"1";}}', datetime('now', 'localtime'), datetime('now', 'localtime'));