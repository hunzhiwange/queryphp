INSERT INTO `admin_menu` (`id`, `pid`, `title`, `url`, `icon`, `menu_type`, `sort`, `status`, `rule_id`, `module`, `menu`) VALUES('52','0','管理','','','1','0','1','59','Administrative','');
INSERT INTO `admin_menu` (`id`, `pid`, `title`, `url`, `icon`, `menu_type`, `sort`, `status`, `rule_id`, `module`, `menu`) VALUES('53','52','系统配置','','','1','0','1','61','Administrative','');
INSERT INTO `admin_menu` (`id`, `pid`, `title`, `url`, `icon`, `menu_type`, `sort`, `status`, `rule_id`, `module`, `menu`) VALUES('54','53','菜单管理','/admin/menu/list','','1','0','1','21','Administrative','menu');
INSERT INTO `admin_menu` (`id`, `pid`, `title`, `url`, `icon`, `menu_type`, `sort`, `status`, `rule_id`, `module`, `menu`) VALUES('55','53','系统参数','/admin/config/add','','1','0','1','29','Administrative','systemConfig');
INSERT INTO `admin_menu` (`id`, `pid`, `title`, `url`, `icon`, `menu_type`, `sort`, `status`, `rule_id`, `module`, `menu`) VALUES('56','53','权限规则','/admin/rule/list','','1','0','1','13','Administrative','rule');
INSERT INTO `admin_menu` (`id`, `pid`, `title`, `url`, `icon`, `menu_type`, `sort`, `status`, `rule_id`, `module`, `menu`) VALUES('57','52','组织架构','','','1','0','1','63','Administrative','');
INSERT INTO `admin_menu` (`id`, `pid`, `title`, `url`, `icon`, `menu_type`, `sort`, `status`, `rule_id`, `module`, `menu`) VALUES('58','57','岗位管理','/admin/position/list','','1','0','1','31','Administrative','position');
INSERT INTO `admin_menu` (`id`, `pid`, `title`, `url`, `icon`, `menu_type`, `sort`, `status`, `rule_id`, `module`, `menu`) VALUES('59','57','部门管理','/admin/structures/list','','1','0','1','39','Administrative','structures');
INSERT INTO `admin_menu` (`id`, `pid`, `title`, `url`, `icon`, `menu_type`, `sort`, `status`, `rule_id`, `module`, `menu`) VALUES('60','57','用户组管理','/admin/groups/list','','1','0','1','47','Administrative','groups');
INSERT INTO `admin_menu` (`id`, `pid`, `title`, `url`, `icon`, `menu_type`, `sort`, `status`, `rule_id`, `module`, `menu`) VALUES('61','52','账户管理','','','1','0','1','62','Administrative','');
INSERT INTO `admin_menu` (`id`, `pid`, `title`, `url`, `icon`, `menu_type`, `sort`, `status`, `rule_id`, `module`, `menu`) VALUES('62','61','账户列表','/admin/users/list','','1','0','1','55','Administrative','users');
INSERT INTO `admin_menu` (`id`, `pid`, `title`, `url`, `icon`, `menu_type`, `sort`, `status`, `rule_id`, `module`, `menu`) VALUES('65','61','test vue','/admin/users/test','','2','0','1','61','Administrative','uses');
