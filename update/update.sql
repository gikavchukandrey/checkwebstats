UPDATE {PRE}settings SET value = '2.2.0' where var = 'version';
INSERT IGNORE INTO `{PRE}settings` VALUES('bad_words', 'lesbian,verga,xxx,sex,porn,suck,fuck,cash,vagina,cunt,dick,slut,whore,anal,penis', 'Bad Words', '', 'textarea', '', '', '', 'website', 50);
INSERT IGNORE INTO `{PRE}settings` VALUES('default_lang', 'en', '', '', 'text', '', '', '', 'apperance', 50);
ALTER TABLE `{PRE}sites` ADD `hasAMP` BOOLEAN NOT NULL DEFAULT FALSE AFTER `favicon`;
ALTER TABLE `{PRE}users` ADD `is_demo` BOOLEAN NOT NULL DEFAULT FALSE AFTER `is_admin`;
ALTER TABLE `{PRE}users` ADD `newsletter` BOOLEAN NOT NULL DEFAULT TRUE;
INSERT IGNORE INTO `{PRE}settings` VALUES('slug_contact', 'contact', 'Contact', '', 'text', '', 'required="required"', '', 'slug', 0);
INSERT IGNORE INTO `{PRE}settings` VALUES('slug_last', 'last', 'Last Sites', '', 'text', '', 'required="required"', '', 'slug', 0);
INSERT IGNORE INTO `{PRE}settings` VALUES('slug_top', 'top', 'Top Sites', '', 'text', '', 'required="required"', '', 'slug', 0);
ALTER TABLE `{PRE}sites` ADD `completed` BOOLEAN NOT NULL DEFAULT FALSE;
ALTER TABLE `{PRE}sites` ADD `ip` varchar(250) NOT NULL DEFAULT '' ;
ALTER TABLE `{PRE}sites` ADD `city` varchar(50) NOT NULL DEFAULT '' ;
ALTER TABLE `{PRE}sites` ADD `country` varchar(50) NOT NULL DEFAULT '' ;
ALTER TABLE `{PRE}sites` ADD `region` varchar(50) NOT NULL DEFAULT '' ;
ALTER TABLE `{PRE}sites` ADD `isp` varchar(50) NOT NULL DEFAULT '' ;
ALTER TABLE `{PRE}sites` ADD `charset` varchar(15) NOT NULL DEFAULT '' ;
ALTER TABLE `{PRE}sites` ADD `pagespeed_mobile` int(11) NOT NULL DEFAULT 0 ;
ALTER TABLE `{PRE}sites` ADD `pageAuthority` int(11) NOT NULL DEFAULT 0 ;
ALTER TABLE `{PRE}sites` ADD `mozRank` NUMERIC(10,3) NOT NULL DEFAULT 0 ;
ALTER TABLE `{PRE}settings` CHANGE `options` `options` VARCHAR(500)  CHARACTER SET utf8  COLLATE utf8_general_ci  NOT NULL  DEFAULT '';
INSERT IGNORE INTO `{PRE}settings` VALUES('slug_filter', 'filter', 'Filter List', '', 'text', '', 'required="required"', '', 'slug', 0);
INSERT IGNORE INTO `{PRE}settings` VALUES('slug_subscriptions', 'subscriptions', 'Subscriptions', '', 'text', '', 'required="required"', '', 'slug', 0);
INSERT IGNORE INTO `{PRE}settings` VALUES('slug_historical', 'historical', 'Historical Data', '', 'text', '', 'required="required"', '', 'slug', 0);
INSERT IGNORE INTO `{PRE}settings` VALUES('slug_made_with', 'made_with', 'Made With', '', 'text', '', 'required="required"', '', 'slug', 0);
UPDATE `{PRE}sites` SET `completed` = 1 WHERE score > 0 ;
INSERT IGNORE INTO `{PRE}admin_menus` (`idmenu`, `title`, `idunique`, `target`, `icon`, `idparent`) VALUES (NULL, 'Bulk Sites', 'bulk_sites', 'admin/bulk', 'fa fa-link', '');
INSERT IGNORE INTO `{PRE}admin_menus` (`idmenu`, `title`, `idunique`, `target`, `icon`, `idparent`) VALUES (NULL, 'Sites', 'sites', 'admin/sites', 'fa fa-globe', '');
INSERT IGNORE INTO `{PRE}admin_menus` (`idmenu`, `title`, `idunique`, `target`, `icon`, `idparent`) VALUES (NULL, 'Sitemap', 'sitemap', 'admin/sitemap', 'fa fa-sitemap', '');
INSERT IGNORE INTO `{PRE}admin_menus` (`idmenu`, `title`, `idunique`, `target`, `icon`, `idparent`) VALUES (NULL, 'Cron Jobs', 'cronjobs', 'admin/jobs', 'fa fa-calendar-check-o', '');
INSERT IGNORE INTO `{PRE}settings` VALUES('ua', '', 'CURL User Agent', 'Custom user agent (none for user default)', 'text', '', '', '', 'website', 60);
INSERT IGNORE INTO `{PRE}settings` (`var`, `value`, `label`, `helper`, `type`, `options`, `attr`, `class`, `module`, `order`) VALUES ('only_registered', '0', 'Force register', '', 'select', 'Yes:1|No:0', '', 'select2', 'website', '5');
INSERT IGNORE INTO `{PRE}settings` (`var`, `value`, `label`, `helper`, `type`, `options`, `attr`, `class`, `module`, `order`) VALUES ('guest_block', 'traffic,search_engine,tips,alexa,server,meta,authority,pagespeed,pagespeed_stats', 'Visible for guest', '', 'select-multiple', 'Traffic and Earnings:traffic|Tips:tips|Alexa:alexa|Server Information:server|Meta Tags:meta|Authority:authority|Google Page Speed:pagespeed|Technologies:technologies|Pagespeed Stats:pagespeed_stats', '', 'select2', 'website', '5');
INSERT IGNORE INTO `{PRE}settings` VALUES('domain', '', 'Site Domain', '', 'text', '', 'required="required"', '', 'slug', 0);
INSERT IGNORE INTO `{PRE}settings` VALUES('rebuild_sitemap', '24', '', '', 'text', '', 'required="required"', '', 'sitemap', 0);
INSERT IGNORE INTO `{PRE}settings` VALUES('compress_sitemap', '1', '', '', 'text', '', 'required="required"', '', 'sitemap', 0);
ALTER TABLE `{PRE}sites` ADD `url_real` varchar(50) NOT NULL DEFAULT '' ;
ALTER TABLE `{PRE}sites` ADD `created_on` date;
ALTER TABLE `{PRE}sites` ADD `expires_on` date;
ALTER TABLE `{PRE}sites` ADD `screenshot` varchar(100) NOT NULL DEFAULT 'assets/images/no-picture.jpg' ;
INSERT IGNORE INTO `{PRE}settings` VALUES('api_screenshot', 'http://free.pagepeeker.com/v2/thumbs.php?size=l&url={url}', 'Service Screenshot', 'Your custom service for get screenshot, use {url} param for the current url', 'text', '', 'required="required"', '', 'website', 100);
INSERT IGNORE INTO `{PRE}settings` (`var`, `value`, `label`, `helper`, `type`, `options`, `attr`, `class`, `module`, `order`) VALUES ('download_screenshot', '0', 'Download Screenshot', 'Download screenshot to server (HTTPS Compatibility)', 'select', 'Yes:1|No:0', '', 'select2', 'website', 101);
UPDATE `{PRE}admin_menus` SET `title` = 'Appearance' WHERE  `idunique` = 'apperance';
INSERT IGNORE INTO `{PRE}settings` VALUES('limit_top', '10', 'Limit TOP List', '', 'numeric', '', '', '', 'website', 50);
INSERT IGNORE INTO `{PRE}settings` (`var`, `value`, `label`, `helper`, `type`, `options`, `attr`, `class`, `module`, `order`) VALUES ('show_top_tech', '1', 'Show TOP Technologies (Home Page)', '', 'select', 'Yes:1|No:0', '', 'select2', 'website', '100');
INSERT IGNORE INTO `{PRE}settings` (`var`, `value`, `label`, `helper`, `type`, `options`, `attr`, `class`, `module`, `order`) VALUES ('enable_block', 'traffic,tips,alexa,server,meta,authority,technologies,pagespeed,pagespeed_stats', 'Active Modules', '', 'select-multiple', 'Traffic and Earnings:traffic|Tips:tips|Alexa:alexa|Server Information:server|Meta Tags:meta|Authority:authority|Technologies:technologies|Pagespeed:pagespeed|Pagespeed Stats:pagespeed_stats', '', 'select2', 'website', '5');
INSERT IGNORE INTO `{PRE}settings` (`var`, `value`, `label`, `helper`, `type`, `options`, `attr`, `class`, `module`, `order`) VALUES ('validate_email', '1', 'Validate Email (On Register)', '', 'select', 'Yes:1|No:0', '', 'select2', 'website', '5');
UPDATE `{PRE}settings` SET `options` = 'Traffic and Earnings:traffic|Tips:tips|Alexa:alexa|Server Information:server|Meta Tags:meta|Authority:authority|Technologies:technologies|Pagespeed:pagespeed|Pagespeed Stats:pagespeed_stats|Social:social|Domain Available:domain_available' WHERE `var` = 'enable_block';
UPDATE `{PRE}settings` SET `options` = 'Traffic and Earnings:traffic|Tips:tips|Alexa:alexa|Server Information:server|Meta Tags:meta|Authority:authority|Technologies:technologies|Pagespeed:pagespeed|Pagespeed Stats:pagespeed_stats|Social:social|Domain Available:domain_available' WHERE `var` = 'guest_block';
ALTER TABLE `{PRE}sites` ADD `pagespeed_rules` MEDIUMTEXT;
ALTER TABLE `{PRE}sites` ADD `pagespeed_screenshot_d` MEDIUMTEXT;
ALTER TABLE `{PRE}sites` ADD `pagespeed_screenshot_m` MEDIUMTEXT;
ALTER TABLE `{PRE}sites` ADD `pagespeed_rules_mobile` MEDIUMTEXT;
ALTER TABLE `{PRE}sites` ADD `pagespeed_usability` INT(11);
ALTER TABLE `{PRE}sites` ADD `pagespeed_numberResources` INT(11);
ALTER TABLE `{PRE}sites` ADD `pagespeed_numberHosts` INT(11);
ALTER TABLE `{PRE}sites` ADD `pagespeed_totalRequestBytes` INT(11);
ALTER TABLE `{PRE}sites` ADD `pagespeed_numberStaticResources` INT(11);
ALTER TABLE `{PRE}sites` ADD `pagespeed_htmlResponseBytes` INT(11);
ALTER TABLE `{PRE}sites` ADD `pagespeed_cssResponseBytes` INT(11);
ALTER TABLE `{PRE}sites` ADD `pagespeed_imageResponseBytes` INT(11);
ALTER TABLE `{PRE}sites` ADD `pagespeed_javascriptResponseBytes` INT(11);
ALTER TABLE `{PRE}sites` ADD `pagespeed_otherResponseBytes` INT(11);
ALTER TABLE `{PRE}sites` ADD `pagespeed_numberJsResources` INT(11);
ALTER TABLE `{PRE}sites` ADD `pagespeed_numberCssResources` INT(11);
INSERT IGNORE INTO `{PRE}admin_menus` (`idmenu`, `title`, `idunique`, `target`, `icon`, `idparent`) VALUES(NULL, 'Company Info', 'company', 'admin/settings/company', 'fa fa-info-circle', 'settings');
INSERT IGNORE INTO `{PRE}settings` VALUES('company_about', '', 'About Us', '', 'textarea', '', '', '', 'company', 1);
INSERT IGNORE INTO `{PRE}settings` VALUES('company_name', '', 'Company Name', '', 'text', '', '', '', 'company', 2);
INSERT IGNORE INTO `{PRE}settings` VALUES('company_address', '', 'Address', '', 'text', '', '', '', 'company', 10);
INSERT IGNORE INTO `{PRE}settings` VALUES('company_city_country', '', 'City', '', 'text', '', 'placeholder="Country, City"', '', 'company', 11);
INSERT IGNORE INTO `{PRE}settings` VALUES('company_phone1', '', 'Phone 1', '', 'text', '', '', '', 'company', 20);
INSERT IGNORE INTO `{PRE}settings` VALUES('company_phone2', '', 'Phone 2', '', 'text', '', '', '', 'company', 30);
INSERT IGNORE INTO `{PRE}settings` VALUES('company_email', '', 'Email', '', 'email', '', '', '', 'company', 40);
INSERT IGNORE INTO `{PRE}settings` VALUES('company_facebook', '', 'Facebook', '', 'text', '', '', '', 'company', 40);
INSERT IGNORE INTO `{PRE}settings` VALUES('company_twitter', '', 'Twitter', '', 'text', '', '', '', 'company', 40);
INSERT IGNORE INTO `{PRE}settings` VALUES('company_gplus', '', 'Google +', '', 'text', '', '', '', 'company', 40);
INSERT IGNORE INTO `{PRE}settings` VALUES('company_linkedin', '', 'Linkedin', '', 'text', '', '', '', 'company', 40);
INSERT IGNORE INTO `{PRE}settings` VALUES('company_instagram', '', 'Instagram', '', 'text', '', '', '', 'company', 40);
INSERT IGNORE INTO `{PRE}settings` VALUES('process_limit', '100', '', '', '', '', '', '', 'cronjobs', 10);
INSERT IGNORE INTO `{PRE}settings` VALUES('update_limit', '100', '', '', '', '', '', '', 'cronjobs', 10);
INSERT IGNORE INTO `{PRE}settings` VALUES('process_log', '1', '', '', '', '', '', '', 'cronjobs', 10);
INSERT IGNORE INTO `{PRE}settings` VALUES('secret_bash', '', '', '', '', '', '', '', 'cronjobs', 10);
UPDATE `{PRE}settings` SET value =(SELECT sha1(NOW())) WHERE var='secret_bash' and value = '';
CREATE TABLE IF NOT EXISTS {PRE}logs (
  groupid varchar(10) NOT NULL,
  level varchar(10) NOT NULL,
  dateevent datetime NOT NULL,
  log TEXT NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT IGNORE INTO `{PRE}admin_menus` (`idmenu`, `title`, `idunique`, `target`, `icon`, `idparent`) VALUES(NULL, 'Subscriptions', 'subscriptions', '#', 'fa fa-paypal', '');
INSERT IGNORE INTO `{PRE}admin_menus` (`idmenu`, `title`, `idunique`, `target`, `icon`, `idparent`) VALUES(NULL, 'Settings', 'sub_settings', 'admin/subscriptions/settings', 'fa fa-circle-o', 'subscriptions');
INSERT IGNORE INTO `{PRE}admin_menus` (`idmenu`, `title`, `idunique`, `target`, `icon`, `idparent`) VALUES(NULL, 'Plans & Prices', 'prices', 'admin/subscriptions/prices', 'fa fa-circle-o', 'subscriptions');
INSERT IGNORE INTO `{PRE}admin_menus` (`idmenu`, `title`, `idunique`, `target`, `icon`, `idparent`) VALUES(NULL, 'Logs', 'logs', 'admin/subscriptions/logs', 'fa fa-circle-o', 'subscriptions');
INSERT IGNORE INTO `{PRE}settings` VALUES('paypal_p1_modules', '', '', '', '', '', '', '', '', 10);
INSERT IGNORE INTO `{PRE}settings` VALUES('paypal_p2_modules', '', '', '', '', '', '', '', '', 10);
INSERT IGNORE INTO `{PRE}settings` VALUES('paypal_p3_modules', '', '', '', '', '', '', '', '', 10);
UPDATE `{PRE}settings` SET `options` = (SELECT * FROM (SELECT options FROM {PRE}settings WHERE `var` = 'enable_block') AS temp) WHERE var= 'paypal_p1_modules' ;
UPDATE `{PRE}settings` SET `options` = (SELECT * FROM (SELECT options FROM {PRE}settings WHERE `var` = 'enable_block') AS temp) WHERE var= 'paypal_p2_modules' ;
UPDATE `{PRE}settings` SET `options` = (SELECT * FROM (SELECT options FROM {PRE}settings WHERE `var` = 'enable_block') AS temp) WHERE var= 'paypal_p3_modules' ;
ALTER TABLE `{PRE}users` ADD `plan` int(1)  DEFAULT 1;
ALTER TABLE `{PRE}users` ADD `last_payment` DATETIME NOT NULL;
CREATE TABLE IF NOT EXISTS {PRE}site_history (
  url varchar(100) NOT NULL,
  data MEDIUMTEXT NOT NULL,
  technologies MEDIUMTEXT NOT NULL,
  created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE INDEX url_ix ON {PRE}site_history (url(10));
CREATE TABLE IF NOT EXISTS {PRE}paypal_log
(
 	created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	transaction_subject  varchar(50) NOT NULL,
	payment_date  varchar(50) NOT NULL,
	txn_type  varchar(50) NOT NULL,
	subscr_id  varchar(50) NOT NULL,
	last_name  varchar(50) NOT NULL,
	residence_country  varchar(50) NOT NULL,
	item_name  varchar(50) NOT NULL,
	payment_gross  varchar(50) NOT NULL,
	mc_currency  varchar(50) NOT NULL,
	business  varchar(50) NOT NULL,
	payment_type  varchar(50) NOT NULL,
	protection_eligibility  varchar(50) NOT NULL,
	verify_sign  varchar(50) NOT NULL,
	payer_status  varchar(50) NOT NULL,
	test_ipn  varchar(50) NOT NULL,
	payer_email  varchar(50) NOT NULL,
	txn_id  varchar(50) NOT NULL,
	receiver_email  varchar(50) NOT NULL,
	first_name  varchar(50) NOT NULL,
	payer_id  varchar(50) NOT NULL,
	receiver_id  varchar(50) NOT NULL,
	item_number  varchar(50) NOT NULL,
	payment_status  varchar(50) NOT NULL,
	payment_fee  varchar(50) NOT NULL,
	mc_fee  varchar(50) NOT NULL,
	mc_gross  varchar(50) NOT NULL,
	custom  varchar(100) NOT NULL,
	charset  varchar(50) NOT NULL,
	notify_version  varchar(50) NOT NULL,
	ipn_track_id  varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE {PRE}paypal_log ADD UNIQUE KEY url (txn_id(15));
CREATE TABLE IF NOT EXISTS {PRE}paypal_event
(
	created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	txn_type varchar (25) NOT NULL,
	subscr_id varchar (50) NOT NULL,
	custom  varchar(100) NOT NULL,
	ipn_track_id varchar (25) NOT NULL,
	item_name varchar (50) NOT NULL,
	period3 varchar (50) NOT NULL,
	mc_amount3 varchar (50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
ALTER TABLE `{PRE}sites` ADD `curl_info` TEXT;
ALTER TABLE `{PRE}sites` ADD `dns_record` TEXT;
ALTER TABLE `{PRE}sites` ADD `social` TEXT;
ALTER TABLE `{PRE}sites` ADD `available_domain` TEXT;
INSERT IGNORE INTO `{PRE}settings` (`var`, `value`, `label`, `helper`, `type`, `options`, `attr`, `class`, `module`, `order`) VALUES ('google_screenshot', '1', 'Google Screenshot', '', 'select', 'Yes:1|No:0', '', 'select2', 'website', '5');
INSERT IGNORE INTO `{PRE}settings` VALUES('affiliate_service_domain', 'https://www.namecheap.com/domains/registration/results.aspx?affId=13460&domain={domain}', 'Affiliate Domain Service', 'Your custom service affiliate program, use {domain} param for replace domain', 'text', '', '', '', 'website', 200);
INSERT IGNORE INTO `{PRE}admin_menus` (`idmenu`, `title`, `idunique`, `target`, `icon`, `idparent`) VALUES(NULL, 'Notifications', 'notifications', 'admin/settings/notifications', 'fa fa-circle-o', 'settings');
INSERT IGNORE INTO `{PRE}settings` (`var`, `value`, `label`, `helper`, `type`, `options`, `attr`, `class`, `module`, `order`) VALUES ('email_new_user', '1', 'New User', '', 'select', 'Yes:1|No:0', '', 'select2', 'notifications', '1');
INSERT IGNORE INTO `{PRE}settings` (`var`, `value`, `label`, `helper`, `type`, `options`, `attr`, `class`, `module`, `order`) VALUES ('email_new_site', '1', 'New Site', '', 'select', 'Yes:1|No:0', '', 'select2', 'notifications', '10');
INSERT IGNORE INTO `{PRE}settings` (`var`, `value`, `label`, `helper`, `type`, `options`, `attr`, `class`, `module`, `order`) VALUES ('email_update_site', '0', 'Update Site', '', 'select', 'Yes:1|No:0', '', 'select2', 'notifications', '20');
INSERT IGNORE INTO `{PRE}settings` (`var`, `value`, `label`, `helper`, `type`, `options`, `attr`, `class`, `module`, `order`) VALUES ('save_historical', '1', 'Save historical data', '', 'select', 'Yes:1|No:0', '', 'select2', 'website', '200');
INSERT IGNORE INTO `{PRE}settings` VALUES('background_home', 'assets/images/bg.jpg', '', '', '', '', '', '', 'apperance', 10);
INSERT IGNORE INTO `{PRE}settings` VALUES('background_modal', 'assets/images/bg.jpg', '', '', '', '', '', '', 'apperance', 10);
INSERT IGNORE INTO `{PRE}admin_menus` (`idmenu`, `title`, `idunique`, `target`, `icon`, `idparent`) VALUES (NULL, 'Chrome Plugin', 'chromePlugin', 'admin/chromePlugin', 'fa fa-chrome', '');
INSERT IGNORE INTO `{PRE}settings` VALUES('style_link_color', '#3C8DBC', '', '', '', '', '', '', 'apperance', 10);
INSERT IGNORE INTO `{PRE}settings` VALUES('style_link_sidebar_color', '#333333', '', '', '', '', '', '', 'apperance', 10);
INSERT IGNORE INTO `{PRE}settings` VALUES('style_body_color', '#F3F3F3', '', '', '', '', '', '', 'apperance', 10);
INSERT IGNORE INTO `{PRE}settings` VALUES('style_main_color', '#3C8DBC', '', '', '', '', '', '', 'apperance', 10);
INSERT IGNORE INTO `{PRE}settings` VALUES('style_main_text_color', '#373a3c', '', '', '', '', '', '', 'apperance', 10);
INSERT IGNORE INTO `{PRE}settings` VALUES('style_secondary_text_color', '#818a91', '', '', '', '', '', '', 'apperance', 10);
INSERT IGNORE INTO `{PRE}settings` VALUES('style_secondary_color', '#306F94', '', '', '', '', '', '', 'apperance', 10);
INSERT IGNORE INTO `{PRE}settings` VALUES('style_footer_color', '#333333', '', '', '', '', '', '', 'apperance', 10);
INSERT IGNORE INTO `{PRE}settings` VALUES('style_footer_text_color', "#999", '', '', '', '', '', '', 'apperance', 10);
INSERT IGNORE INTO `{PRE}settings` VALUES('default_font', "Roboto", '', '', '', '', '', '', 'apperance', 10);
INSERT IGNORE INTO `{PRE}settings` VALUES('template_report', "report_score", '', '', '', '', '', '', 'apperance', 10);

