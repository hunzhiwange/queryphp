/*
 Navicat Premium Data Transfer

 Source Server         : mysql57
 Source Server Type    : MySQL
 Source Server Version : 50742 (5.7.42)
 Source Host           : 127.0.0.1:3306
 Source Schema         : api_ql_data1

 Target Server Type    : MySQL
 Target Server Version : 50742 (5.7.42)
 File Encoding         : 65001

 Date: 23/11/2023 14:56:06
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for base_brand
-- ----------------------------
DROP TABLE IF EXISTS `base_brand`;
CREATE TABLE `base_brand` (
  `brand_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `status` enum('T','F') NOT NULL DEFAULT 'T' COMMENT '状态',
  `order_num` bigint(20) unsigned NOT NULL DEFAULT '500' COMMENT '排序 DESC',
  `brand_num` varchar(30) NOT NULL DEFAULT '' COMMENT '编号',
  `brand_name` varchar(30) NOT NULL DEFAULT '' COMMENT '名称',
  `brand_logo` varchar(130) NOT NULL DEFAULT '' COMMENT 'LOGO',
  `brand_about` text COMMENT '介绍',
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `brand_letter` varchar(30) NOT NULL DEFAULT '' COMMENT '品牌首字母',
  `seo_keywords` varchar(30) NOT NULL DEFAULT '' COMMENT 'SEO关键字',
  PRIMARY KEY (`brand_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='商品品牌';

-- ----------------------------
-- Records of base_brand
-- ----------------------------
BEGIN;
INSERT INTO `base_brand` (`brand_id`, `company_id`, `status`, `order_num`, `brand_num`, `brand_name`, `brand_logo`, `brand_about`, `update_date`, `create_date`, `brand_letter`, `seo_keywords`) VALUES (1, 0, 'T', 500, '', 'hello2', 'world', NULL, '2023-10-30 03:43:57', '2023-10-30 03:37:05', 'WAXQG', '');
COMMIT;

-- ----------------------------
-- Table structure for client_star_discount
-- ----------------------------
DROP TABLE IF EXISTS `client_star_discount`;
CREATE TABLE `client_star_discount` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `client_no` varchar(30) NOT NULL DEFAULT '' COMMENT '客户编号',
  `year` char(4) NOT NULL DEFAULT '0000' COMMENT '年度',
  `discount_start` date NOT NULL DEFAULT '1000-01-01' COMMENT '折扣开始时间',
  `discount_end` date NOT NULL DEFAULT '9999-01-01' COMMENT '折扣结束时间',
  `current_std_level` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '当前标准星级',
  `current_month` int(2) unsigned NOT NULL DEFAULT '1' COMMENT '当前月份',
  `current_level` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '当月综合星级',
  `current_discount` decimal(21,6) unsigned NOT NULL DEFAULT '1.000000' COMMENT '当月综合折扣',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用 0=否;1=是;',
  `remark` varchar(90) NOT NULL DEFAULT '' COMMENT '备注',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客户星级折扣';

-- ----------------------------
-- Records of client_star_discount
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for client_stock
-- ----------------------------
DROP TABLE IF EXISTS `client_stock`;
CREATE TABLE `client_stock` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `client_no` varchar(30) NOT NULL DEFAULT '' COMMENT '客户编号',
  `doc_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '单据类型',
  `warehouse_no` varchar(30) NOT NULL DEFAULT '' COMMENT '仓库编号',
  `is_main` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为主仓 0=否;1=是;',
  `status` tinyint(20) unsigned NOT NULL DEFAULT '1' COMMENT '启用状态 0=否;1=是;',
  `sort` bigint(20) unsigned NOT NULL DEFAULT '50000' COMMENT '排序 DESC',
  `distance` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '客户与仓库之间的距离',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客户与单据类型仓库关联表';

-- ----------------------------
-- Records of client_stock
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for client_stock1
-- ----------------------------
DROP TABLE IF EXISTS `client_stock1`;
CREATE TABLE `client_stock1` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `client_no` varchar(30) NOT NULL DEFAULT '' COMMENT '客户编号',
  `doc_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '单据类型',
  `warehouse_no` varchar(30) NOT NULL DEFAULT '' COMMENT '仓库编号',
  `is_main` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为主仓 0=否;1=是;',
  `status` tinyint(20) unsigned NOT NULL DEFAULT '1' COMMENT '启用状态 0=否;1=是;',
  `sort` bigint(20) unsigned NOT NULL DEFAULT '50000' COMMENT '排序 DESC',
  `distance` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '客户与仓库之间的距离',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客户与单据类型仓库关联表';

-- ----------------------------
-- Records of client_stock1
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for client_stock2
-- ----------------------------
DROP TABLE IF EXISTS `client_stock2`;
CREATE TABLE `client_stock2` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `client_no` varchar(30) NOT NULL DEFAULT '' COMMENT '客户编号',
  `doc_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '单据类型',
  `warehouse_no` varchar(30) NOT NULL DEFAULT '' COMMENT '仓库编号',
  `is_main` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为主仓 0=否;1=是;',
  `status` tinyint(20) unsigned NOT NULL DEFAULT '1' COMMENT '启用状态 0=否;1=是;',
  `sort` bigint(20) unsigned NOT NULL DEFAULT '50000' COMMENT '排序 DESC',
  `distance` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '客户与仓库之间的距离',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客户与单据类型仓库关联表';

-- ----------------------------
-- Records of client_stock2
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for doc
-- ----------------------------
DROP TABLE IF EXISTS `doc`;
CREATE TABLE `doc` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `client_no` varchar(30) NOT NULL DEFAULT '' COMMENT '客户编号',
  `order_no` varchar(30) NOT NULL DEFAULT '' COMMENT '订单编号',
  `doc_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '单据类型',
  `doc_sub_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '子单据类型',
  `source` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '单据来源',
  `status` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '单据状态',
  `status_step` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '单据状态进度',
  `pay_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '付款状态',
  `audit_status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '审核状态 1=待审核;2=已审核;3=已取消;',
  `warehouse_no` varchar(30) NOT NULL DEFAULT '' COMMENT '下单仓库编号',
  `ship_type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '送货方式',
  `ship_date` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '交货时间',
  `invoice_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '开票 1=不开票;2=普通发票;3=增值发票;',
  `invoice_tax` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '税点 取值范围为0-1',
  `source_device` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '来源设备  0=pc;1=IOS;2=安卓;3=微信;4=小程序;',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `internal_remark` varchar(100) NOT NULL DEFAULT '' COMMENT '内部备注',
  `payment_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '支付方式 0=预付;1=现付;2=后付;',
  `product_total_amount` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '订单金额',
  `freight_amount` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '运费',
  `settlement_total_amount` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '结算金额 用户实际支付金额',
  `product_type_count` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '订单含商品种类数量',
  `product_number_total` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '单据数量统计',
  `amount_paid` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '已付款金额',
  `special_total_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '申请金额',
  `special_favorable_amount` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '特批优惠',
  `invoice_total_amount` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '税费',
  `deduction_amount` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '扣款金额',
  `amount_paid_version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户已支付金额乐观锁',
  `market_amount_total` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '下单单位市场价格合计',
  `is_staff_order` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否为员工代客下单 0=否;1=是;',
  `consignee` varchar(30) NOT NULL DEFAULT '' COMMENT '收货单位',
  `consignee_contact` varchar(30) NOT NULL DEFAULT '' COMMENT '联系人',
  `consignee_phone` varchar(30) NOT NULL DEFAULT '' COMMENT '联系方式',
  `consignee_address` varchar(50) NOT NULL DEFAULT '' COMMENT '收货地址',
  `deduction_no` varchar(50) NOT NULL DEFAULT '' COMMENT '扣款单号',
  `last_status_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '状态最后更新时间',
  `transfer_from_order_no` varchar(30) NOT NULL DEFAULT '' COMMENT '转店来源客户订单编号',
  `transfer_to_order_no` varchar(30) NOT NULL DEFAULT '' COMMENT '转店目标客户订单编号',
  `import_task_id` varchar(20) NOT NULL DEFAULT '' COMMENT '导入任务编号',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `create_account_name` varchar(30) NOT NULL DEFAULT '' COMMENT '创建人名字',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  `data_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型 0=热数据;1=温数据;2=冷数据;',
  `data_process` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型处理进度 0=待处理;1=处理成功;2=处理失败;',
  `data_customer` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型消费者 0=未设置;大于0=具体消费者;',
  `data_retry` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型消费重试次数',
  `is_closed` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '交易是否关闭 0=否;1=是;',
  `relation_doc_no` varchar(30) NOT NULL DEFAULT '' COMMENT '关联单据',
  `out_storage_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '已出库数量',
  `shipped_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '已发货数量',
  `received_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '已收货数量',
  `real_received_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '实际已收货数量 生鲜缩水等',
  `to_warehouse_no` varchar(30) NOT NULL DEFAULT '' COMMENT '目标仓库编号',
  `client_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '客户ID',
  `warehouse_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '仓库ID',
  `staff_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '经办人',
  `staff_no` varchar(64) NOT NULL DEFAULT '' COMMENT '经办人编号',
  `to_warehouse_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '目标仓库ID',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_client_no` (`client_no`,`company_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=89719549133459457 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='单据';

-- ----------------------------
-- Records of doc
-- ----------------------------
BEGIN;
INSERT INTO `doc` (`id`, `platform_id`, `company_id`, `client_no`, `order_no`, `doc_type`, `doc_sub_type`, `source`, `status`, `status_step`, `pay_status`, `audit_status`, `warehouse_no`, `ship_type`, `ship_date`, `invoice_type`, `invoice_tax`, `source_device`, `remark`, `internal_remark`, `payment_type`, `product_total_amount`, `freight_amount`, `settlement_total_amount`, `product_type_count`, `product_number_total`, `amount_paid`, `special_total_price`, `special_favorable_amount`, `invoice_total_amount`, `deduction_amount`, `amount_paid_version`, `market_amount_total`, `is_staff_order`, `consignee`, `consignee_contact`, `consignee_phone`, `consignee_address`, `deduction_no`, `last_status_time`, `transfer_from_order_no`, `transfer_to_order_no`, `import_task_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`, `is_closed`, `relation_doc_no`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `to_warehouse_no`, `client_id`, `warehouse_id`, `staff_id`, `staff_no`, `to_warehouse_id`) VALUES (71523294179889152, 100000, 100100, '', 'RK2023091900001', 6, 30, 0, 42, 1, 0, 2, 'chengdu', 0, '2023-09-19 08:48:02', 0, 0.000000, 0, '', '', 0, 2000.000000, 0.000000, 2000.000000, 4, 4.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 1, 0.000000, 1, '', '', '', '', '', '2023-09-19 08:48:14', '', '', '', '2023-09-19 00:48:02', '2023-09-19 00:48:14', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0, 0, '', 0.000000, 0.000000, 0.000000, 0.000000, '', 0, 52739595116351489, 4145731162214400, 'user', 0);
INSERT INTO `doc` (`id`, `platform_id`, `company_id`, `client_no`, `order_no`, `doc_type`, `doc_sub_type`, `source`, `status`, `status_step`, `pay_status`, `audit_status`, `warehouse_no`, `ship_type`, `ship_date`, `invoice_type`, `invoice_tax`, `source_device`, `remark`, `internal_remark`, `payment_type`, `product_total_amount`, `freight_amount`, `settlement_total_amount`, `product_type_count`, `product_number_total`, `amount_paid`, `special_total_price`, `special_favorable_amount`, `invoice_total_amount`, `deduction_amount`, `amount_paid_version`, `market_amount_total`, `is_staff_order`, `consignee`, `consignee_contact`, `consignee_phone`, `consignee_address`, `deduction_no`, `last_status_time`, `transfer_from_order_no`, `transfer_to_order_no`, `import_task_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`, `is_closed`, `relation_doc_no`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `to_warehouse_no`, `client_id`, `warehouse_id`, `staff_id`, `staff_no`, `to_warehouse_id`) VALUES (74832852809814016, 100000, 100100, '2005444', 'XH2023092800001', 1, 0, 0, 12, 1, 0, 2, 'chengdu', 0, '2023-09-28 11:59:02', 0, 0.000000, 0, '', '', 0, 1600.000000, 0.000000, 1600.000000, 4, 4.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 1, 0.000000, 1, '', '', '', '', '', '2023-11-08 09:22:42', '', '', '', '2023-09-28 03:59:02', '2023-11-08 01:22:42', 0, 4145731145437184, 'admin', 4145731145437184, 8, 0, 0, 0, 0, 0, '', 2.000000, 2.000000, 0.000000, 0.000000, '', 4145731174797314, 52739595116351489, 4145731162214400, 'user', 0);
INSERT INTO `doc` (`id`, `platform_id`, `company_id`, `client_no`, `order_no`, `doc_type`, `doc_sub_type`, `source`, `status`, `status_step`, `pay_status`, `audit_status`, `warehouse_no`, `ship_type`, `ship_date`, `invoice_type`, `invoice_tax`, `source_device`, `remark`, `internal_remark`, `payment_type`, `product_total_amount`, `freight_amount`, `settlement_total_amount`, `product_type_count`, `product_number_total`, `amount_paid`, `special_total_price`, `special_favorable_amount`, `invoice_total_amount`, `deduction_amount`, `amount_paid_version`, `market_amount_total`, `is_staff_order`, `consignee`, `consignee_contact`, `consignee_phone`, `consignee_address`, `deduction_no`, `last_status_time`, `transfer_from_order_no`, `transfer_to_order_no`, `import_task_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`, `is_closed`, `relation_doc_no`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `to_warehouse_no`, `client_id`, `warehouse_id`, `staff_id`, `staff_no`, `to_warehouse_id`) VALUES (78811260350763008, 100000, 100100, '', 'RK2023100900001', 6, 30, 0, 41, 1, 0, 2, 'CD01', 0, '2023-10-09 11:27:48', 0, 0.000000, 0, '', '', 0, 26250.000000, 0.000000, 26250.000000, 3, 52.500000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 1, 0.000000, 1, '', '', '', '', '', '2023-10-09 03:27:48', '', '', '', '2023-10-09 03:27:48', '2023-10-09 03:27:48', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0, 0, '', 0.000000, 0.000000, 0.000000, 0.000000, '', 0, 52739428627648512, 0, '9005355', 0);
INSERT INTO `doc` (`id`, `platform_id`, `company_id`, `client_no`, `order_no`, `doc_type`, `doc_sub_type`, `source`, `status`, `status_step`, `pay_status`, `audit_status`, `warehouse_no`, `ship_type`, `ship_date`, `invoice_type`, `invoice_tax`, `source_device`, `remark`, `internal_remark`, `payment_type`, `product_total_amount`, `freight_amount`, `settlement_total_amount`, `product_type_count`, `product_number_total`, `amount_paid`, `special_total_price`, `special_favorable_amount`, `invoice_total_amount`, `deduction_amount`, `amount_paid_version`, `market_amount_total`, `is_staff_order`, `consignee`, `consignee_contact`, `consignee_phone`, `consignee_address`, `deduction_no`, `last_status_time`, `transfer_from_order_no`, `transfer_to_order_no`, `import_task_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`, `is_closed`, `relation_doc_no`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `to_warehouse_no`, `client_id`, `warehouse_id`, `staff_id`, `staff_no`, `to_warehouse_id`) VALUES (78811260740833280, 100000, 100100, '', 'RK2023100900002', 6, 30, 0, 41, 1, 0, 2, 'CD02', 0, '2023-10-09 11:27:48', 0, 0.000000, 0, '', '', 0, 3000.000000, 0.000000, 3000.000000, 1, 6.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 1, 0.000000, 1, '', '', '', '', '', '2023-10-09 03:27:48', '', '', '', '2023-10-09 03:27:48', '2023-10-09 03:27:48', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0, 0, '', 0.000000, 0.000000, 0.000000, 0.000000, '', 0, 52739482901942272, 0, '9005355', 0);
INSERT INTO `doc` (`id`, `platform_id`, `company_id`, `client_no`, `order_no`, `doc_type`, `doc_sub_type`, `source`, `status`, `status_step`, `pay_status`, `audit_status`, `warehouse_no`, `ship_type`, `ship_date`, `invoice_type`, `invoice_tax`, `source_device`, `remark`, `internal_remark`, `payment_type`, `product_total_amount`, `freight_amount`, `settlement_total_amount`, `product_type_count`, `product_number_total`, `amount_paid`, `special_total_price`, `special_favorable_amount`, `invoice_total_amount`, `deduction_amount`, `amount_paid_version`, `market_amount_total`, `is_staff_order`, `consignee`, `consignee_contact`, `consignee_phone`, `consignee_address`, `deduction_no`, `last_status_time`, `transfer_from_order_no`, `transfer_to_order_no`, `import_task_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`, `is_closed`, `relation_doc_no`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `to_warehouse_no`, `client_id`, `warehouse_id`, `staff_id`, `staff_no`, `to_warehouse_id`) VALUES (78811260984102912, 100000, 100100, '', 'RK2023100900003', 6, 30, 0, 41, 1, 0, 2, 'CD03', 0, '2023-10-09 11:27:48', 0, 0.000000, 0, '', '', 0, 32500.000000, 0.000000, 32500.000000, 2, 65.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 1, 0.000000, 1, '', '', '', '', '', '2023-10-09 03:27:48', '', '', '', '2023-10-09 03:27:48', '2023-10-09 03:27:48', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0, 0, '', 0.000000, 0.000000, 0.000000, 0.000000, '', 0, 52739539395022848, 0, '8002032', 0);
INSERT INTO `doc` (`id`, `platform_id`, `company_id`, `client_no`, `order_no`, `doc_type`, `doc_sub_type`, `source`, `status`, `status_step`, `pay_status`, `audit_status`, `warehouse_no`, `ship_type`, `ship_date`, `invoice_type`, `invoice_tax`, `source_device`, `remark`, `internal_remark`, `payment_type`, `product_total_amount`, `freight_amount`, `settlement_total_amount`, `product_type_count`, `product_number_total`, `amount_paid`, `special_total_price`, `special_favorable_amount`, `invoice_total_amount`, `deduction_amount`, `amount_paid_version`, `market_amount_total`, `is_staff_order`, `consignee`, `consignee_contact`, `consignee_phone`, `consignee_address`, `deduction_no`, `last_status_time`, `transfer_from_order_no`, `transfer_to_order_no`, `import_task_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`, `is_closed`, `relation_doc_no`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `to_warehouse_no`, `client_id`, `warehouse_id`, `staff_id`, `staff_no`, `to_warehouse_id`) VALUES (78811362029080576, 100000, 100100, '', 'RK2023100900004', 6, 30, 0, 41, 1, 0, 2, 'CD01', 0, '2023-10-09 11:28:12', 0, 0.000000, 0, '', '', 0, 26250.000000, 0.000000, 26250.000000, 3, 52.500000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 1, 0.000000, 1, '', '', '', '', '', '2023-10-09 03:28:12', '', '', '', '2023-10-09 03:28:12', '2023-10-09 03:28:12', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0, 0, '', 0.000000, 0.000000, 0.000000, 0.000000, '', 0, 52739428627648512, 0, '9005355', 0);
INSERT INTO `doc` (`id`, `platform_id`, `company_id`, `client_no`, `order_no`, `doc_type`, `doc_sub_type`, `source`, `status`, `status_step`, `pay_status`, `audit_status`, `warehouse_no`, `ship_type`, `ship_date`, `invoice_type`, `invoice_tax`, `source_device`, `remark`, `internal_remark`, `payment_type`, `product_total_amount`, `freight_amount`, `settlement_total_amount`, `product_type_count`, `product_number_total`, `amount_paid`, `special_total_price`, `special_favorable_amount`, `invoice_total_amount`, `deduction_amount`, `amount_paid_version`, `market_amount_total`, `is_staff_order`, `consignee`, `consignee_contact`, `consignee_phone`, `consignee_address`, `deduction_no`, `last_status_time`, `transfer_from_order_no`, `transfer_to_order_no`, `import_task_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`, `is_closed`, `relation_doc_no`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `to_warehouse_no`, `client_id`, `warehouse_id`, `staff_id`, `staff_no`, `to_warehouse_id`) VALUES (78811362293321728, 100000, 100100, '', 'RK2023100900005', 6, 30, 0, 41, 1, 0, 2, 'CD02', 0, '2023-10-09 11:28:13', 0, 0.000000, 0, '', '', 0, 3000.000000, 0.000000, 3000.000000, 1, 6.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 1, 0.000000, 1, '', '', '', '', '', '2023-10-09 03:28:13', '', '', '', '2023-10-09 03:28:13', '2023-10-09 03:28:13', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0, 0, '', 0.000000, 0.000000, 0.000000, 0.000000, '', 0, 52739482901942272, 0, '9005355', 0);
INSERT INTO `doc` (`id`, `platform_id`, `company_id`, `client_no`, `order_no`, `doc_type`, `doc_sub_type`, `source`, `status`, `status_step`, `pay_status`, `audit_status`, `warehouse_no`, `ship_type`, `ship_date`, `invoice_type`, `invoice_tax`, `source_device`, `remark`, `internal_remark`, `payment_type`, `product_total_amount`, `freight_amount`, `settlement_total_amount`, `product_type_count`, `product_number_total`, `amount_paid`, `special_total_price`, `special_favorable_amount`, `invoice_total_amount`, `deduction_amount`, `amount_paid_version`, `market_amount_total`, `is_staff_order`, `consignee`, `consignee_contact`, `consignee_phone`, `consignee_address`, `deduction_no`, `last_status_time`, `transfer_from_order_no`, `transfer_to_order_no`, `import_task_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`, `is_closed`, `relation_doc_no`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `to_warehouse_no`, `client_id`, `warehouse_id`, `staff_id`, `staff_no`, `to_warehouse_id`) VALUES (78811362461093888, 100000, 100100, '', 'RK2023100900006', 6, 30, 0, 42, 1, 0, 2, 'CD03', 0, '2023-10-09 11:28:13', 0, 0.000000, 0, '', '', 0, 32500.000000, 0.000000, 32500.000000, 2, 65.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 1, 0.000000, 1, '', '', '', '', '', '2023-10-18 10:05:03', '', '', '', '2023-10-09 03:28:13', '2023-10-18 02:05:03', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0, 0, '', 0.000000, 0.000000, 0.000000, 0.000000, '', 0, 52739539395022848, 0, '8002032', 0);
INSERT INTO `doc` (`id`, `platform_id`, `company_id`, `client_no`, `order_no`, `doc_type`, `doc_sub_type`, `source`, `status`, `status_step`, `pay_status`, `audit_status`, `warehouse_no`, `ship_type`, `ship_date`, `invoice_type`, `invoice_tax`, `source_device`, `remark`, `internal_remark`, `payment_type`, `product_total_amount`, `freight_amount`, `settlement_total_amount`, `product_type_count`, `product_number_total`, `amount_paid`, `special_total_price`, `special_favorable_amount`, `invoice_total_amount`, `deduction_amount`, `amount_paid_version`, `market_amount_total`, `is_staff_order`, `consignee`, `consignee_contact`, `consignee_phone`, `consignee_address`, `deduction_no`, `last_status_time`, `transfer_from_order_no`, `transfer_to_order_no`, `import_task_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`, `is_closed`, `relation_doc_no`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `to_warehouse_no`, `client_id`, `warehouse_id`, `staff_id`, `staff_no`, `to_warehouse_id`) VALUES (82045195197222912, 100000, 100100, '2005444', 'CK2023101800001', 7, 44, 0, 35, 1, 0, 2, 'chengdu', 0, '2023-10-18 09:38:18', 0, 0.000000, 0, '', '', 0, 1400.000000, 0.000000, 1400.000000, 4, 3.500000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 1, 0.000000, 1, '', '', '', '', '', '2023-10-18 10:06:07', '', '', '', '2023-10-18 01:38:18', '2023-10-18 02:06:07', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0, 0, 'XH2023092800001', 0.000000, 0.000000, 0.000000, 0.000000, '', 4145731174797314, 52739595116351489, 0, '', 0);
INSERT INTO `doc` (`id`, `platform_id`, `company_id`, `client_no`, `order_no`, `doc_type`, `doc_sub_type`, `source`, `status`, `status_step`, `pay_status`, `audit_status`, `warehouse_no`, `ship_type`, `ship_date`, `invoice_type`, `invoice_tax`, `source_device`, `remark`, `internal_remark`, `payment_type`, `product_total_amount`, `freight_amount`, `settlement_total_amount`, `product_type_count`, `product_number_total`, `amount_paid`, `special_total_price`, `special_favorable_amount`, `invoice_total_amount`, `deduction_amount`, `amount_paid_version`, `market_amount_total`, `is_staff_order`, `consignee`, `consignee_contact`, `consignee_phone`, `consignee_address`, `deduction_no`, `last_status_time`, `transfer_from_order_no`, `transfer_to_order_no`, `import_task_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`, `is_closed`, `relation_doc_no`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `to_warehouse_no`, `client_id`, `warehouse_id`, `staff_id`, `staff_no`, `to_warehouse_id`) VALUES (82052193590579200, 100000, 100100, '', 'RK2023101800001', 6, 36, 0, 42, 1, 0, 2, 'chengdu', 0, '2023-10-18 10:06:07', 0, 0.000000, 0, '', '', 0, 1750.000000, 0.000000, 1750.000000, 4, 3.500000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 1, 0.000000, 1, '', '', '', '', '', '2023-10-18 02:06:07', '', '', '', '2023-10-18 02:06:07', '2023-10-18 02:06:07', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0, 0, 'CK2023101800001', 0.000000, 0.000000, 0.000000, 0.000000, '', 0, 52739595116351489, 4145731145437184, 'admin', 0);
INSERT INTO `doc` (`id`, `platform_id`, `company_id`, `client_no`, `order_no`, `doc_type`, `doc_sub_type`, `source`, `status`, `status_step`, `pay_status`, `audit_status`, `warehouse_no`, `ship_type`, `ship_date`, `invoice_type`, `invoice_tax`, `source_device`, `remark`, `internal_remark`, `payment_type`, `product_total_amount`, `freight_amount`, `settlement_total_amount`, `product_type_count`, `product_number_total`, `amount_paid`, `special_total_price`, `special_favorable_amount`, `invoice_total_amount`, `deduction_amount`, `amount_paid_version`, `market_amount_total`, `is_staff_order`, `consignee`, `consignee_contact`, `consignee_phone`, `consignee_address`, `deduction_no`, `last_status_time`, `transfer_from_order_no`, `transfer_to_order_no`, `import_task_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`, `is_closed`, `relation_doc_no`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `to_warehouse_no`, `client_id`, `warehouse_id`, `staff_id`, `staff_no`, `to_warehouse_id`) VALUES (82805972480954368, 100000, 100100, '2005444', 'XH2023102000002', 1, 0, 0, 1, 1, 0, 2, 'CD03', 0, '2023-10-20 12:01:22', 0, 0.000000, 0, '', '', 0, 400.000000, 0.000000, 400.000000, 1, 1.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 1, 0.000000, 1, '', '', '', '', '', '2023-10-20 12:05:06', '', '', '', '2023-10-20 04:01:22', '2023-10-20 04:05:06', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0, 1, '', 0.000000, 0.000000, 0.000000, 0.000000, '', 4145731174797314, 52739539395022848, 4145731162214400, 'user', 0);
INSERT INTO `doc` (`id`, `platform_id`, `company_id`, `client_no`, `order_no`, `doc_type`, `doc_sub_type`, `source`, `status`, `status_step`, `pay_status`, `audit_status`, `warehouse_no`, `ship_type`, `ship_date`, `invoice_type`, `invoice_tax`, `source_device`, `remark`, `internal_remark`, `payment_type`, `product_total_amount`, `freight_amount`, `settlement_total_amount`, `product_type_count`, `product_number_total`, `amount_paid`, `special_total_price`, `special_favorable_amount`, `invoice_total_amount`, `deduction_amount`, `amount_paid_version`, `market_amount_total`, `is_staff_order`, `consignee`, `consignee_contact`, `consignee_phone`, `consignee_address`, `deduction_no`, `last_status_time`, `transfer_from_order_no`, `transfer_to_order_no`, `import_task_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`, `is_closed`, `relation_doc_no`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `to_warehouse_no`, `client_id`, `warehouse_id`, `staff_id`, `staff_no`, `to_warehouse_id`) VALUES (82807297738412032, 100000, 100100, '2002032', 'QH2023102000001', 3, 0, 0, 7, 1, 0, 2, 'CD03', 0, '2023-10-20 12:06:38', 0, 0.000000, 0, '', '', 0, 400.000000, 0.000000, 400.000000, 1, 1.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 1, 0.000000, 1, '', '', '', '', '', '2023-10-20 12:08:15', '', '', '', '2023-10-20 04:06:38', '2023-10-20 04:08:15', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0, 0, '', 0.000000, 0.000000, 0.000000, 0.000000, '', 4145731174797313, 52739539395022848, 4145731145437184, 'admin', 0);
INSERT INTO `doc` (`id`, `platform_id`, `company_id`, `client_no`, `order_no`, `doc_type`, `doc_sub_type`, `source`, `status`, `status_step`, `pay_status`, `audit_status`, `warehouse_no`, `ship_type`, `ship_date`, `invoice_type`, `invoice_tax`, `source_device`, `remark`, `internal_remark`, `payment_type`, `product_total_amount`, `freight_amount`, `settlement_total_amount`, `product_type_count`, `product_number_total`, `amount_paid`, `special_total_price`, `special_favorable_amount`, `invoice_total_amount`, `deduction_amount`, `amount_paid_version`, `market_amount_total`, `is_staff_order`, `consignee`, `consignee_contact`, `consignee_phone`, `consignee_address`, `deduction_no`, `last_status_time`, `transfer_from_order_no`, `transfer_to_order_no`, `import_task_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`, `is_closed`, `relation_doc_no`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `to_warehouse_no`, `client_id`, `warehouse_id`, `staff_id`, `staff_no`, `to_warehouse_id`) VALUES (88924786704650240, 100000, 100100, '2005444', 'CK2023110600001', 7, 44, 0, 33, 1, 0, 2, 'chengdu', 0, '2023-11-06 09:15:21', 0, 0.000000, 0, '', '', 0, 400.000000, 0.000000, 400.000000, 2, 2.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 1, 0.000000, 1, '', '', '', '', '', '2023-11-06 01:15:21', '', '', '', '2023-11-06 01:15:21', '2023-11-06 01:15:21', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0, 0, 'XH2023092800001', 0.000000, 0.000000, 0.000000, 0.000000, '', 4145731174797314, 52739595116351489, 0, '', 0);
INSERT INTO `doc` (`id`, `platform_id`, `company_id`, `client_no`, `order_no`, `doc_type`, `doc_sub_type`, `source`, `status`, `status_step`, `pay_status`, `audit_status`, `warehouse_no`, `ship_type`, `ship_date`, `invoice_type`, `invoice_tax`, `source_device`, `remark`, `internal_remark`, `payment_type`, `product_total_amount`, `freight_amount`, `settlement_total_amount`, `product_type_count`, `product_number_total`, `amount_paid`, `special_total_price`, `special_favorable_amount`, `invoice_total_amount`, `deduction_amount`, `amount_paid_version`, `market_amount_total`, `is_staff_order`, `consignee`, `consignee_contact`, `consignee_phone`, `consignee_address`, `deduction_no`, `last_status_time`, `transfer_from_order_no`, `transfer_to_order_no`, `import_task_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`, `is_closed`, `relation_doc_no`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `to_warehouse_no`, `client_id`, `warehouse_id`, `staff_id`, `staff_no`, `to_warehouse_id`) VALUES (89650021347233792, 100000, 100100, '', 'RK2023110800001', 6, 30, 0, 42, 1, 0, 2, 'chengdu', 0, '2023-11-08 09:17:10', 0, 0.000000, 0, '', '', 0, 1500.000000, 0.000000, 1500.000000, 9, 9.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 1, 0.000000, 1, '', '', '', '', '', '2023-11-08 09:17:18', '', '', '', '2023-11-08 01:17:10', '2023-11-08 01:17:18', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0, 0, '', 0.000000, 0.000000, 0.000000, 0.000000, '', 0, 52739595116351489, 4145731145437184, 'admin', 0);
INSERT INTO `doc` (`id`, `platform_id`, `company_id`, `client_no`, `order_no`, `doc_type`, `doc_sub_type`, `source`, `status`, `status_step`, `pay_status`, `audit_status`, `warehouse_no`, `ship_type`, `ship_date`, `invoice_type`, `invoice_tax`, `source_device`, `remark`, `internal_remark`, `payment_type`, `product_total_amount`, `freight_amount`, `settlement_total_amount`, `product_type_count`, `product_number_total`, `amount_paid`, `special_total_price`, `special_favorable_amount`, `invoice_total_amount`, `deduction_amount`, `amount_paid_version`, `market_amount_total`, `is_staff_order`, `consignee`, `consignee_contact`, `consignee_phone`, `consignee_address`, `deduction_no`, `last_status_time`, `transfer_from_order_no`, `transfer_to_order_no`, `import_task_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`, `is_closed`, `relation_doc_no`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `to_warehouse_no`, `client_id`, `warehouse_id`, `staff_id`, `staff_no`, `to_warehouse_id`) VALUES (89651354905219072, 100000, 100100, '2005444', 'CK2023110800001', 7, 44, 0, 35, 1, 0, 2, 'chengdu', 0, '2023-11-08 09:22:28', 0, 0.000000, 0, '', '', 0, 800.000000, 0.000000, 800.000000, 2, 2.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 1, 0.000000, 1, '', '', '', '', '', '2023-11-08 09:22:42', '', '', '', '2023-11-08 01:22:28', '2023-11-08 01:22:42', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0, 0, 'XH2023092800001', 0.000000, 0.000000, 0.000000, 0.000000, '', 4145731174797314, 52739595116351489, 0, '', 0);
INSERT INTO `doc` (`id`, `platform_id`, `company_id`, `client_no`, `order_no`, `doc_type`, `doc_sub_type`, `source`, `status`, `status_step`, `pay_status`, `audit_status`, `warehouse_no`, `ship_type`, `ship_date`, `invoice_type`, `invoice_tax`, `source_device`, `remark`, `internal_remark`, `payment_type`, `product_total_amount`, `freight_amount`, `settlement_total_amount`, `product_type_count`, `product_number_total`, `amount_paid`, `special_total_price`, `special_favorable_amount`, `invoice_total_amount`, `deduction_amount`, `amount_paid_version`, `market_amount_total`, `is_staff_order`, `consignee`, `consignee_contact`, `consignee_phone`, `consignee_address`, `deduction_no`, `last_status_time`, `transfer_from_order_no`, `transfer_to_order_no`, `import_task_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`, `is_closed`, `relation_doc_no`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `to_warehouse_no`, `client_id`, `warehouse_id`, `staff_id`, `staff_no`, `to_warehouse_id`) VALUES (89651413872939008, 100000, 100100, '', 'RK2023110800002', 6, 36, 0, 42, 1, 0, 2, 'chengdu', 0, '2023-11-08 09:22:42', 0, 0.000000, 0, '', '', 0, 1000.000000, 0.000000, 1000.000000, 2, 2.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 1, 0.000000, 1, '', '', '', '', '', '2023-11-08 01:22:42', '', '', '', '2023-11-08 01:22:42', '2023-11-08 01:22:42', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0, 0, 'CK2023110800001', 0.000000, 0.000000, 0.000000, 0.000000, '', 0, 52739595116351489, 4145731145437184, 'admin', 0);
INSERT INTO `doc` (`id`, `platform_id`, `company_id`, `client_no`, `order_no`, `doc_type`, `doc_sub_type`, `source`, `status`, `status_step`, `pay_status`, `audit_status`, `warehouse_no`, `ship_type`, `ship_date`, `invoice_type`, `invoice_tax`, `source_device`, `remark`, `internal_remark`, `payment_type`, `product_total_amount`, `freight_amount`, `settlement_total_amount`, `product_type_count`, `product_number_total`, `amount_paid`, `special_total_price`, `special_favorable_amount`, `invoice_total_amount`, `deduction_amount`, `amount_paid_version`, `market_amount_total`, `is_staff_order`, `consignee`, `consignee_contact`, `consignee_phone`, `consignee_address`, `deduction_no`, `last_status_time`, `transfer_from_order_no`, `transfer_to_order_no`, `import_task_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`, `is_closed`, `relation_doc_no`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `to_warehouse_no`, `client_id`, `warehouse_id`, `staff_id`, `staff_no`, `to_warehouse_id`) VALUES (89719364189818880, 100000, 100100, '2005444', 'XH2023110800001', 1, 0, 0, 17, 1, 0, 2, 'chengdu', 0, '2023-11-08 13:52:43', 0, 0.000000, 0, '', '', 0, 400.000000, 0.000000, 400.000000, 7, 7.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 1, 0.000000, 1, '', '', '', '', '', '2023-11-08 13:53:27', '', '', '', '2023-11-08 05:52:43', '2023-11-08 05:53:27', 0, 4145731145437184, 'admin', 4145731145437184, 1, 0, 0, 0, 0, 0, '', 7.000000, 7.000000, 7.000000, 7.000000, '', 4145731174797314, 52739595116351489, 4145731162214400, 'user', 0);
INSERT INTO `doc` (`id`, `platform_id`, `company_id`, `client_no`, `order_no`, `doc_type`, `doc_sub_type`, `source`, `status`, `status_step`, `pay_status`, `audit_status`, `warehouse_no`, `ship_type`, `ship_date`, `invoice_type`, `invoice_tax`, `source_device`, `remark`, `internal_remark`, `payment_type`, `product_total_amount`, `freight_amount`, `settlement_total_amount`, `product_type_count`, `product_number_total`, `amount_paid`, `special_total_price`, `special_favorable_amount`, `invoice_total_amount`, `deduction_amount`, `amount_paid_version`, `market_amount_total`, `is_staff_order`, `consignee`, `consignee_contact`, `consignee_phone`, `consignee_address`, `deduction_no`, `last_status_time`, `transfer_from_order_no`, `transfer_to_order_no`, `import_task_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`, `is_closed`, `relation_doc_no`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `to_warehouse_no`, `client_id`, `warehouse_id`, `staff_id`, `staff_no`, `to_warehouse_id`) VALUES (89719364663775232, 100000, 100100, '2005444', 'XH2023110800002', 1, 0, 0, 6, 1, 0, 2, 'CD03', 0, '2023-11-08 13:52:43', 0, 0.000000, 0, '', '', 0, 800.000000, 0.000000, 800.000000, 2, 2.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 1, 0.000000, 1, '', '', '', '', '', '2023-11-08 05:52:43', '', '', '', '2023-11-08 05:52:43', '2023-11-08 05:52:43', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0, 0, '', 0.000000, 0.000000, 0.000000, 0.000000, '', 4145731174797314, 52739539395022848, 4145731162214400, 'user', 0);
INSERT INTO `doc` (`id`, `platform_id`, `company_id`, `client_no`, `order_no`, `doc_type`, `doc_sub_type`, `source`, `status`, `status_step`, `pay_status`, `audit_status`, `warehouse_no`, `ship_type`, `ship_date`, `invoice_type`, `invoice_tax`, `source_device`, `remark`, `internal_remark`, `payment_type`, `product_total_amount`, `freight_amount`, `settlement_total_amount`, `product_type_count`, `product_number_total`, `amount_paid`, `special_total_price`, `special_favorable_amount`, `invoice_total_amount`, `deduction_amount`, `amount_paid_version`, `market_amount_total`, `is_staff_order`, `consignee`, `consignee_contact`, `consignee_phone`, `consignee_address`, `deduction_no`, `last_status_time`, `transfer_from_order_no`, `transfer_to_order_no`, `import_task_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`, `is_closed`, `relation_doc_no`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `to_warehouse_no`, `client_id`, `warehouse_id`, `staff_id`, `staff_no`, `to_warehouse_id`) VALUES (89719549133459456, 100000, 100100, '2005444', 'CK2023110800002', 7, 44, 0, 34, 1, 0, 2, 'chengdu', 0, '2023-11-08 13:53:27', 0, 0.000000, 0, '', '', 0, 400.000000, 0.000000, 400.000000, 7, 7.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 1, 0.000000, 1, '', '', '', '', '', '2023-11-08 05:53:27', '', '', '', '2023-11-08 05:53:27', '2023-11-08 05:53:27', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0, 0, 'XH2023110800001', 0.000000, 0.000000, 0.000000, 0.000000, '', 4145731174797314, 52739595116351489, 0, '', 0);
COMMIT;

-- ----------------------------
-- Table structure for doc1
-- ----------------------------
DROP TABLE IF EXISTS `doc1`;
CREATE TABLE `doc1` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `client_no` varchar(30) NOT NULL DEFAULT '' COMMENT '客户编号',
  `order_no` varchar(30) NOT NULL DEFAULT '' COMMENT '订单编号',
  `doc_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '单据类型',
  `doc_sub_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '子单据类型',
  `source` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '单据来源',
  `status` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '单据状态',
  `status_step` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '单据状态进度',
  `pay_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '付款状态',
  `audit_status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '审核状态 1=待审核;2=已审核;3=已取消;',
  `warehouse_no` varchar(30) NOT NULL DEFAULT '' COMMENT '下单仓库编号',
  `ship_type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '送货方式',
  `ship_date` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '交货时间',
  `invoice_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '开票 1=不开票;2=普通发票;3=增值发票;',
  `invoice_tax` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '税点 取值范围为0-1',
  `source_device` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '来源设备  0=pc;1=IOS;2=安卓;3=微信;4=小程序;',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `internal_remark` varchar(100) NOT NULL DEFAULT '' COMMENT '内部备注',
  `payment_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '支付方式 0=预付;1=现付;2=后付;',
  `product_total_amount` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '订单金额',
  `freight_amount` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '运费',
  `settlement_total_amount` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '结算金额 用户实际支付金额',
  `product_type_count` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '订单含商品种类数量',
  `product_number_total` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '单据数量统计',
  `amount_paid` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '已付款金额',
  `special_total_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '申请金额',
  `special_favorable_amount` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '特批优惠',
  `invoice_total_amount` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '税费',
  `deduction_amount` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '扣款金额',
  `amount_paid_version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户已支付金额乐观锁',
  `market_amount_total` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '下单单位市场价格合计',
  `is_staff_order` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否为员工代客下单 0=否;1=是;',
  `consignee` varchar(30) NOT NULL DEFAULT '' COMMENT '收货单位',
  `consignee_contact` varchar(30) NOT NULL DEFAULT '' COMMENT '联系人',
  `consignee_phone` varchar(30) NOT NULL DEFAULT '' COMMENT '联系方式',
  `consignee_address` varchar(50) NOT NULL DEFAULT '' COMMENT '收货地址',
  `deduction_no` varchar(50) NOT NULL DEFAULT '' COMMENT '扣款单号',
  `last_status_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '状态最后更新时间',
  `transfer_from_order_no` varchar(30) NOT NULL DEFAULT '' COMMENT '转店来源客户订单编号',
  `transfer_to_order_no` varchar(30) NOT NULL DEFAULT '' COMMENT '转店目标客户订单编号',
  `import_task_id` varchar(20) NOT NULL DEFAULT '' COMMENT '导入任务编号',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `create_account_name` varchar(30) NOT NULL DEFAULT '' COMMENT '创建人名字',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  `data_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型 0=热数据;1=温数据;2=冷数据;',
  `data_process` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型处理进度 0=待处理;1=处理成功;2=处理失败;',
  `data_customer` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型消费者 0=未设置;大于0=具体消费者;',
  `data_retry` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型消费重试次数',
  `is_closed` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '交易是否关闭 0=否;1=是;',
  `relation_doc_no` varchar(30) NOT NULL DEFAULT '' COMMENT '关联单据',
  `out_storage_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '已出库数量',
  `shipped_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '已发货数量',
  `received_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '已收货数量',
  `real_received_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '实际已收货数量 生鲜缩水等',
  `to_warehouse_no` varchar(30) NOT NULL DEFAULT '' COMMENT '目标仓库编号',
  `client_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '客户ID',
  `warehouse_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '仓库ID',
  `staff_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '经办人',
  `staff_no` varchar(64) NOT NULL DEFAULT '' COMMENT '经办人编号',
  `to_warehouse_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '目标仓库ID',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_client_no` (`client_no`,`company_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='单据';

-- ----------------------------
-- Records of doc1
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for doc2
-- ----------------------------
DROP TABLE IF EXISTS `doc2`;
CREATE TABLE `doc2` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `client_no` varchar(30) NOT NULL DEFAULT '' COMMENT '客户编号',
  `order_no` varchar(30) NOT NULL DEFAULT '' COMMENT '订单编号',
  `doc_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '单据类型',
  `doc_sub_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '子单据类型',
  `source` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '单据来源',
  `status` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '单据状态',
  `status_step` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '单据状态进度',
  `pay_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '付款状态',
  `audit_status` tinyint(1) unsigned NOT NULL DEFAULT '2' COMMENT '审核状态 1=待审核;2=已审核;3=已取消;',
  `warehouse_no` varchar(30) NOT NULL DEFAULT '' COMMENT '下单仓库编号',
  `ship_type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '送货方式',
  `ship_date` datetime DEFAULT CURRENT_TIMESTAMP COMMENT '交货时间',
  `invoice_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '开票 1=不开票;2=普通发票;3=增值发票;',
  `invoice_tax` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '税点 取值范围为0-1',
  `source_device` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '来源设备  0=pc;1=IOS;2=安卓;3=微信;4=小程序;',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `internal_remark` varchar(100) NOT NULL DEFAULT '' COMMENT '内部备注',
  `payment_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '支付方式 0=预付;1=现付;2=后付;',
  `product_total_amount` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '订单金额',
  `freight_amount` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '运费',
  `settlement_total_amount` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '结算金额 用户实际支付金额',
  `product_type_count` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '订单含商品种类数量',
  `product_number_total` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '单据数量统计',
  `amount_paid` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '已付款金额',
  `special_total_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '申请金额',
  `special_favorable_amount` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '特批优惠',
  `invoice_total_amount` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '税费',
  `deduction_amount` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '扣款金额',
  `amount_paid_version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户已支付金额乐观锁',
  `market_amount_total` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '下单单位市场价格合计',
  `is_staff_order` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否为员工代客下单 0=否;1=是;',
  `consignee` varchar(30) NOT NULL DEFAULT '' COMMENT '收货单位',
  `consignee_contact` varchar(30) NOT NULL DEFAULT '' COMMENT '联系人',
  `consignee_phone` varchar(30) NOT NULL DEFAULT '' COMMENT '联系方式',
  `consignee_address` varchar(50) NOT NULL DEFAULT '' COMMENT '收货地址',
  `deduction_no` varchar(50) NOT NULL DEFAULT '' COMMENT '扣款单号',
  `last_status_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '状态最后更新时间',
  `transfer_from_order_no` varchar(30) NOT NULL DEFAULT '' COMMENT '转店来源客户订单编号',
  `transfer_to_order_no` varchar(30) NOT NULL DEFAULT '' COMMENT '转店目标客户订单编号',
  `import_task_id` varchar(20) NOT NULL DEFAULT '' COMMENT '导入任务编号',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `create_account_name` varchar(30) NOT NULL DEFAULT '' COMMENT '创建人名字',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  `data_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型 0=热数据;1=温数据;2=冷数据;',
  `data_process` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型处理进度 0=待处理;1=处理成功;2=处理失败;',
  `data_customer` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型消费者 0=未设置;大于0=具体消费者;',
  `data_retry` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型消费重试次数',
  `is_closed` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '交易是否关闭 0=否;1=是;',
  `relation_doc_no` varchar(30) NOT NULL DEFAULT '' COMMENT '关联单据',
  `out_storage_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '已出库数量',
  `shipped_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '已发货数量',
  `received_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '已收货数量',
  `real_received_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '实际已收货数量 生鲜缩水等',
  `to_warehouse_no` varchar(30) NOT NULL DEFAULT '' COMMENT '目标仓库编号',
  `client_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '客户ID',
  `warehouse_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '仓库ID',
  `staff_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '经办人',
  `staff_no` varchar(64) NOT NULL DEFAULT '' COMMENT '经办人编号',
  `to_warehouse_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '目标仓库ID',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_client_no` (`client_no`,`company_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='单据';

-- ----------------------------
-- Records of doc2
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for doc_item
-- ----------------------------
DROP TABLE IF EXISTS `doc_item`;
CREATE TABLE `doc_item` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `client_no` varchar(30) NOT NULL DEFAULT '' COMMENT '客户ID',
  `doc_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '单据类型',
  `doc_sub_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '子单据类型',
  `order_no` varchar(30) NOT NULL DEFAULT '0' COMMENT '订单编号',
  `sub_order_no` varchar(30) NOT NULL DEFAULT '' COMMENT '子订单',
  `status` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '单据状态',
  `spu_no` varchar(30) NOT NULL DEFAULT '' COMMENT 'SPU编号',
  `sku_no` varchar(30) NOT NULL DEFAULT '' COMMENT 'SKU编号',
  `settlement_amount` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '结算金额 客户实际支付金额，退款使用',
  `small_unit_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '小单位订购数量',
  `small_unit_purchase_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '小单位成交价',
  `order_unit` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '订购单位 1=小单位;2=中单位;3=大单位;',
  `order_unit_name` varchar(20) NOT NULL DEFAULT '' COMMENT '订购单位名字',
  `order_unit_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '订购单位数量',
  `order_ratio` decimal(21,6) NOT NULL DEFAULT '1.000000' COMMENT '订购换算关系',
  `order_unit_purchase_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '订购单位成交价',
  `is_gift` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为赠品 0=否;1=是;',
  `promotion_id` varchar(30) NOT NULL DEFAULT '' COMMENT '促销活动ID',
  `promotion_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '促销活动类型 0=普通商品;1=商品特价;2=商品买赠;3=团购活动;4=满立惠;5=套餐;6=满赠优惠券;7=组合商品;',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `out_storage_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '已出库数量',
  `shipped_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '已发货数量',
  `received_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '已收货数量',
  `real_received_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '实际已收货数量 生鲜缩水等',
  `warehouse_no` varchar(30) NOT NULL DEFAULT '' COMMENT '仓库编号',
  `product_discount` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '产品折扣率 取值范围为0-1',
  `client_discount` decimal(18,0) unsigned NOT NULL DEFAULT '0' COMMENT '客户折扣率 取值范围为0-1',
  `inventory_lock_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否锁定库存 0=否;1=是;',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  `small_unit` varchar(20) NOT NULL DEFAULT '' COMMENT '小单位',
  `medium_unit` varchar(20) NOT NULL DEFAULT '' COMMENT '中单位',
  `medium_ratio` decimal(21,6) unsigned NOT NULL DEFAULT '1.000000' COMMENT '中单位换算关系',
  `large_unit` varchar(20) NOT NULL DEFAULT '' COMMENT '大单位',
  `large_ratio` decimal(21,6) unsigned NOT NULL DEFAULT '1.000000' COMMENT '大单位换算关系',
  `product_snapshot_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '产品快照ID',
  `product_title` varchar(50) NOT NULL DEFAULT '' COMMENT '商品名字',
  `data_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型 0=热数据;1=温数据;2=冷数据;',
  `data_process` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型处理进度 0=待处理;1=处理成功;2=处理失败;',
  `data_customer` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型消费者 0=未设置;大于0=具体消费者;',
  `data_retry` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型消费重试次数',
  `relation_doc_no` varchar(30) NOT NULL DEFAULT '' COMMENT '关联单据',
  `relation_doc_item_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '关联单据明细',
  `to_warehouse_no` varchar(30) NOT NULL DEFAULT '' COMMENT '目标仓库编号',
  `product_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '产品ID',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `un_idx` (`platform_id`,`company_id`,`order_no`,`sku_no`,`is_gift`,`promotion_id`,`warehouse_no`,`order_unit`) USING BTREE COMMENT '单据明细',
  KEY `idx_platform_company` (`platform_id`,`company_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=89719549355757569 DEFAULT CHARSET=utf8 COMMENT='单据明细';

-- ----------------------------
-- Records of doc_item
-- ----------------------------
BEGIN;
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (71523294305718272, 100000, 100100, '', 6, 30, 'RK2023091900001', '', 42, 'BB6110', '1130000117119', 500.000000, 1.000000, 500.000000, 1, '件', 1.000000, 1.000000, 500.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-09-19 00:48:02', '2023-09-19 00:48:14', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣 ', 0, 0, 0, 0, '', 0, '', 52739064654336000);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (71523294397992960, 100000, 100100, '', 6, 30, 'RK2023091900001', '', 42, 'BB6110', '1130000117116', 500.000000, 1.000000, 500.000000, 1, '件', 1.000000, 1.000000, 500.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-09-19 00:48:02', '2023-09-19 00:48:14', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣 ', 0, 0, 0, 0, '', 0, '', 52739064255877120);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (71523294431547392, 100000, 100100, '', 6, 30, 'RK2023091900001', '', 42, 'BB6110', '1130000117117', 500.000000, 1.000000, 500.000000, 1, '件', 1.000000, 1.000000, 500.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-09-19 00:48:02', '2023-09-19 00:48:14', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣 ', 0, 0, 0, 0, '', 0, '', 52739064411066368);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (71523294465101824, 100000, 100100, '', 6, 30, 'RK2023091900001', '', 42, 'BB6110', '1130000117118', 500.000000, 1.000000, 500.000000, 1, '件', 1.000000, 1.000000, 500.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-09-19 00:48:02', '2023-09-19 00:48:14', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣 ', 0, 0, 0, 0, '', 0, '', 52739064524312576);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (74832853027917824, 100000, 100100, '2005444', 1, 0, 'XH2023092800001', '', 12, 'BB6110', '1130000117119', 400.000000, 1.000000, 400.000000, 1, '件', 1.000000, 1.000000, 400.000000, 0, '0', 0, '', 1.000000, 1.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-09-28 03:59:02', '2023-11-08 01:22:42', 0, 4145731145437184, 4145731145437184, 5, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣-热销款', 0, 0, 0, 0, '', 0, '', 52739064654336000);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (74832853082443776, 100000, 100100, '2005444', 1, 0, 'XH2023092800001', '', 12, 'BB6110', '1130000117118', 400.000000, 1.000000, 400.000000, 1, '件', 1.000000, 1.000000, 400.000000, 0, '0', 0, '', 1.000000, 1.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-09-28 03:59:02', '2023-11-08 01:22:42', 0, 4145731145437184, 4145731145437184, 5, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣', 0, 0, 0, 0, '', 0, '', 52739064524312576);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (74832853107609600, 100000, 100100, '2005444', 1, 0, 'XH2023092800001', '', 12, 'BB6110', '1130000117116', 400.000000, 1.000000, 400.000000, 1, '件', 1.000000, 1.000000, 400.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-09-28 03:59:02', '2023-11-08 01:22:42', 0, 4145731145437184, 4145731145437184, 7, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣 ', 0, 0, 0, 0, '', 0, '', 52739064255877120);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (74832853132775424, 100000, 100100, '2005444', 1, 0, 'XH2023092800001', '', 12, 'BB6110', '1130000117117', 400.000000, 1.000000, 400.000000, 1, '件', 1.000000, 1.000000, 400.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-09-28 03:59:02', '2023-11-08 01:22:42', 0, 4145731145437184, 4145731145437184, 7, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣', 0, 0, 0, 0, '', 0, '', 52739064411066368);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (78811260430454784, 100000, 100100, '', 6, 30, 'RK2023100900001', '', 41, 'BB6110', '1130000117116', 2750.000000, 5.500000, 500.000000, 1, '件', 5.500000, 1.000000, 500.000000, 0, '0', 0, '加急发货', 0.000000, 0.000000, 0.000000, 0.000000, 'CD01', 1.000000, 1, 1, '2023-10-09 03:27:48', '2023-10-09 03:27:48', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣 ', 0, 0, 0, 0, '', 0, '', 52739064255877120);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (78811260468203520, 100000, 100100, '', 6, 30, 'RK2023100900001', '', 41, 'BB6110', '1130000117116', 20000.000000, 40.000000, 500.000000, 2, '箱', 8.000000, 5.000000, 2500.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'CD01', 1.000000, 1, 1, '2023-10-09 03:27:48', '2023-10-09 03:27:48', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣 ', 0, 0, 0, 0, '', 0, '', 52739064255877120);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (78811260510146560, 100000, 100100, '', 6, 30, 'RK2023100900001', '', 41, 'BB6110', '1130000117117', 3500.000000, 7.000000, 500.000000, 1, '件', 7.000000, 1.000000, 500.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'CD01', 1.000000, 1, 1, '2023-10-09 03:27:48', '2023-10-09 03:27:48', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣', 0, 0, 0, 0, '', 0, '', 52739064411066368);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (78811260786970624, 100000, 100100, '', 6, 30, 'RK2023100900002', '', 41, 'BB6110', '1130000117117', 3000.000000, 6.000000, 500.000000, 1, '件', 6.000000, 1.000000, 500.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'CD02', 1.000000, 1, 1, '2023-10-09 03:27:48', '2023-10-09 03:27:48', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣', 0, 0, 0, 0, '', 0, '', 52739064411066368);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (78811261017657344, 100000, 100100, '', 6, 30, 'RK2023100900003', '', 41, 'BB6110', '1130000117116', 7500.000000, 15.000000, 500.000000, 2, '箱', 3.000000, 5.000000, 2500.000000, 0, '0', 0, '紧急商品', 0.000000, 0.000000, 0.000000, 0.000000, 'CD03', 1.000000, 1, 1, '2023-10-09 03:27:48', '2023-10-09 03:27:48', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣 ', 0, 0, 0, 0, '', 0, '', 52739064255877120);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (78811261051211776, 100000, 100100, '', 6, 30, 'RK2023100900003', '', 41, 'BB6110', '1130000117117', 25000.000000, 50.000000, 500.000000, 3, '包', 5.000000, 10.000000, 5000.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'CD03', 1.000000, 1, 1, '2023-10-09 03:27:48', '2023-10-09 03:27:48', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣', 0, 0, 0, 0, '', 0, '', 52739064411066368);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (78811362066829312, 100000, 100100, '', 6, 30, 'RK2023100900004', '', 41, 'BB6110', '1130000117116', 2750.000000, 5.500000, 500.000000, 1, '件', 5.500000, 1.000000, 500.000000, 0, '0', 0, '加急发货', 0.000000, 0.000000, 0.000000, 0.000000, 'CD01', 1.000000, 1, 1, '2023-10-09 03:28:12', '2023-10-09 03:28:12', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣 ', 0, 0, 0, 0, '', 0, '', 52739064255877120);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (78811362104578048, 100000, 100100, '', 6, 30, 'RK2023100900004', '', 41, 'BB6110', '1130000117116', 20000.000000, 40.000000, 500.000000, 2, '箱', 8.000000, 5.000000, 2500.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'CD01', 1.000000, 1, 1, '2023-10-09 03:28:12', '2023-10-09 03:28:12', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣 ', 0, 0, 0, 0, '', 0, '', 52739064255877120);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (78811362133938176, 100000, 100100, '', 6, 30, 'RK2023100900004', '', 41, 'BB6110', '1130000117117', 3500.000000, 7.000000, 500.000000, 1, '件', 7.000000, 1.000000, 500.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'CD01', 1.000000, 1, 1, '2023-10-09 03:28:12', '2023-10-09 03:28:12', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣', 0, 0, 0, 0, '', 0, '', 52739064411066368);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (78811362331070464, 100000, 100100, '', 6, 30, 'RK2023100900005', '', 41, 'BB6110', '1130000117117', 3000.000000, 6.000000, 500.000000, 1, '件', 6.000000, 1.000000, 500.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'CD02', 1.000000, 1, 1, '2023-10-09 03:28:13', '2023-10-09 03:28:13', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣', 0, 0, 0, 0, '', 0, '', 52739064411066368);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (78811362507231232, 100000, 100100, '', 6, 30, 'RK2023100900006', '', 42, 'BB6110', '1130000117116', 7500.000000, 15.000000, 500.000000, 2, '箱', 3.000000, 5.000000, 2500.000000, 0, '0', 0, '紧急商品', 0.000000, 0.000000, 0.000000, 0.000000, 'CD03', 1.000000, 1, 1, '2023-10-09 03:28:13', '2023-10-18 02:05:03', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣 ', 0, 0, 0, 0, '', 0, '', 52739064255877120);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (78811362553368576, 100000, 100100, '', 6, 30, 'RK2023100900006', '', 42, 'BB6110', '1130000117117', 25000.000000, 50.000000, 500.000000, 3, '包', 5.000000, 10.000000, 5000.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'CD03', 1.000000, 1, 1, '2023-10-09 03:28:13', '2023-10-18 02:05:03', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣', 0, 0, 0, 0, '', 0, '', 52739064411066368);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (82045195268526080, 100000, 100100, '2005444', 7, 44, 'CK2023101800001', '', 35, 'BB6110', '1130000117117', 200.000000, 0.500000, 400.000000, 1, '件', 0.500000, 1.000000, 400.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-10-18 01:38:18', '2023-10-18 02:06:07', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣', 0, 0, 0, 0, 'XH2023092800001', 74832853132775424, '', 52739064411066368);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (82045195306274816, 100000, 100100, '2005444', 7, 44, 'CK2023101800001', '', 35, 'BB6110', '1130000117116', 400.000000, 1.000000, 400.000000, 1, '件', 1.000000, 1.000000, 400.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-10-18 01:38:18', '2023-10-18 02:06:07', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣 ', 0, 0, 0, 0, 'XH2023092800001', 74832853107609600, '', 52739064255877120);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (82045195335634944, 100000, 100100, '2005444', 7, 44, 'CK2023101800001', '', 35, 'BB6110', '1130000117118', 400.000000, 1.000000, 400.000000, 1, '件', 1.000000, 1.000000, 400.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-10-18 01:38:18', '2023-10-18 02:06:07', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣', 0, 0, 0, 0, 'XH2023092800001', 74832853082443776, '', 52739064524312576);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (82045195364995072, 100000, 100100, '2005444', 7, 44, 'CK2023101800001', '', 35, 'BB6110', '1130000117119', 400.000000, 1.000000, 400.000000, 1, '件', 1.000000, 1.000000, 400.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-10-18 01:38:18', '2023-10-18 02:06:07', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣-热销款', 0, 0, 0, 0, 'XH2023092800001', 74832853027917824, '', 52739064654336000);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (82052193674465280, 100000, 100100, '', 6, 36, 'RK2023101800001', '', 42, 'BB6110', '1130000117116', 500.000000, 1.000000, 500.000000, 1, '件', 1.000000, 1.000000, 500.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-10-18 02:06:07', '2023-10-18 02:06:07', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣 ', 0, 0, 0, 0, 'CK2023101800001', 82045195306274816, '', 52739064255877120);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (82052193741574144, 100000, 100100, '', 6, 36, 'RK2023101800001', '', 42, 'BB6110', '1130000117117', 250.000000, 0.500000, 500.000000, 1, '件', 0.500000, 1.000000, 500.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-10-18 02:06:07', '2023-10-18 02:06:07', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣', 0, 0, 0, 0, 'CK2023101800001', 82045195268526080, '', 52739064411066368);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (82052193808683008, 100000, 100100, '', 6, 36, 'RK2023101800001', '', 42, 'BB6110', '1130000117118', 500.000000, 1.000000, 500.000000, 1, '件', 1.000000, 1.000000, 500.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-10-18 02:06:07', '2023-10-18 02:06:07', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣', 0, 0, 0, 0, 'CK2023101800001', 82045195335634944, '', 52739064524312576);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (82052193875791872, 100000, 100100, '', 6, 36, 'RK2023101800001', '', 42, 'BB6110', '1130000117119', 500.000000, 1.000000, 500.000000, 1, '件', 1.000000, 1.000000, 500.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-10-18 02:06:07', '2023-10-18 02:06:07', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣-热销款', 0, 0, 0, 0, 'CK2023101800001', 82045195364995072, '', 52739064654336000);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (82805972539674624, 100000, 100100, '2005444', 1, 0, 'XH2023102000002', '', 1, 'BB6110', '1130000117117', 400.000000, 1.000000, 400.000000, 1, '件', 1.000000, 1.000000, 400.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'CD03', 1.000000, 1, 1, '2023-10-20 04:01:22', '2023-10-20 04:05:06', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣', 0, 0, 0, 0, '', 0, '', 52739064411066368);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (82807297763577856, 100000, 100100, '2002032', 3, 0, 'QH2023102000001', '', 7, 'BB6110', '1130000117116', 400.000000, 1.000000, 400.000000, 1, '件', 1.000000, 1.000000, 400.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'CD03', 1.000000, 1, 1, '2023-10-20 04:06:38', '2023-10-20 04:08:15', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣 ', 0, 0, 0, 0, '', 0, '', 52739064255877120);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (88924786746593280, 100000, 100100, '2005444', 7, 44, 'CK2023110600001', '', 33, 'BB6110', '1130000117118', 400.000000, 1.000000, 400.000000, 1, '件', 1.000000, 1.000000, 400.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-11-06 01:15:21', '2023-11-06 01:15:21', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣', 0, 0, 0, 0, 'XH2023092800001', 74832853082443776, '', 52739064524312576);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (88924786788536320, 100000, 100100, '2005444', 7, 44, 'CK2023110600001', '', 33, 'BB6110', '1130000117119', 0.000000, 1.000000, 0.000000, 1, '件', 1.000000, 1.000000, 0.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-11-06 01:15:21', '2023-11-06 01:15:21', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣-热销款', 0, 0, 0, 0, 'XH2023092800001', 74832853027917824, '', 52739064654336000);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (89650021456285696, 100000, 100100, '', 6, 30, 'RK2023110800001', '', 42, 'CSM123456', 'CSM1234564', 0.000000, 1.000000, 0.000000, 1, '克', 1.000000, 1.000000, 0.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-11-08 01:17:10', '2023-11-08 01:17:18', 0, 4145731145437184, 4145731145437184, 0, '克', '', 1.000000, '', 1.000000, 0, '测试多规格', 0, 0, 0, 0, '', 0, '', 89377222460313600);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (89650021573726208, 100000, 100100, '', 6, 30, 'RK2023110800001', '', 42, 'BB6110', '1130000117116', 500.000000, 1.000000, 500.000000, 1, '件', 1.000000, 1.000000, 500.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-11-08 01:17:10', '2023-11-08 01:17:18', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣 ', 0, 0, 0, 0, '', 0, '', 52739064255877120);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (89650021615669248, 100000, 100100, '', 6, 30, 'RK2023110800001', '', 42, 'BB6110', '1130000117117', 500.000000, 1.000000, 500.000000, 1, '件', 1.000000, 1.000000, 500.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-11-08 01:17:10', '2023-11-08 01:17:18', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣', 0, 0, 0, 0, '', 0, '', 52739064411066368);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (89650021649223680, 100000, 100100, '', 6, 30, 'RK2023110800001', '', 42, 'BB6110', '1130000117118', 500.000000, 1.000000, 500.000000, 1, '件', 1.000000, 1.000000, 500.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-11-08 01:17:10', '2023-11-08 01:17:18', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣', 0, 0, 0, 0, '', 0, '', 52739064524312576);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (89650021682778112, 100000, 100100, '', 6, 30, 'RK2023110800001', '', 42, 'BB6110', '1130000117119', 0.000000, 1.000000, 0.000000, 1, '件', 1.000000, 1.000000, 0.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-11-08 01:17:10', '2023-11-08 01:17:18', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣-热销款', 0, 0, 0, 0, '', 0, '', 52739064654336000);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (89650021728915456, 100000, 100100, '', 6, 30, 'RK2023110800001', '', 42, 'CS123456', 'CS123456789', 0.000000, 1.000000, 0.000000, 1, '束', 1.000000, 1.000000, 0.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-11-08 01:17:10', '2023-11-08 01:17:18', 0, 4145731145437184, 4145731145437184, 0, '束', '', 1.000000, '', 1.000000, 0, '测试商品', 0, 0, 0, 0, '', 0, '', 89376926845767680);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (89650021762469888, 100000, 100100, '', 6, 30, 'RK2023110800001', '', 42, 'CSM123456', 'CSM1234561', 0.000000, 1.000000, 0.000000, 1, '克', 1.000000, 1.000000, 0.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-11-08 01:17:10', '2023-11-08 01:17:18', 0, 4145731145437184, 4145731145437184, 0, '克', '', 1.000000, '', 1.000000, 0, '测试多规格', 0, 0, 0, 0, '', 0, '', 89377221780836352);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (89650021804412928, 100000, 100100, '', 6, 30, 'RK2023110800001', '', 42, 'CSM123456', 'CSM1234562', 0.000000, 1.000000, 0.000000, 1, '克', 1.000000, 1.000000, 0.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-11-08 01:17:10', '2023-11-08 01:17:18', 0, 4145731145437184, 4145731145437184, 0, '克', '', 1.000000, '', 1.000000, 0, '测试多规格', 0, 0, 0, 0, '', 0, '', 89377222007328768);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (89650021846355968, 100000, 100100, '', 6, 30, 'RK2023110800001', '', 42, 'CSM123456', 'CSM1234563', 0.000000, 1.000000, 0.000000, 1, '克', 1.000000, 1.000000, 0.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-11-08 01:17:10', '2023-11-08 01:17:18', 0, 4145731145437184, 4145731145437184, 0, '克', '', 1.000000, '', 1.000000, 0, '测试多规格爆款', 0, 0, 0, 0, '', 0, '', 89377222208655360);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (89651354938773504, 100000, 100100, '2005444', 7, 44, 'CK2023110800001', '', 35, 'BB6110', '1130000117117', 400.000000, 1.000000, 400.000000, 1, '件', 1.000000, 1.000000, 400.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-11-08 01:22:28', '2023-11-08 01:22:42', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣', 0, 0, 0, 0, 'XH2023092800001', 74832853132775424, '', 52739064411066368);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (89651354972327936, 100000, 100100, '2005444', 7, 44, 'CK2023110800001', '', 35, 'BB6110', '1130000117116', 400.000000, 1.000000, 400.000000, 1, '件', 1.000000, 1.000000, 400.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-11-08 01:22:28', '2023-11-08 01:22:42', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣 ', 0, 0, 0, 0, 'XH2023092800001', 74832853107609600, '', 52739064255877120);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (89651413910687744, 100000, 100100, '', 6, 36, 'RK2023110800002', '', 42, 'BB6110', '1130000117116', 500.000000, 1.000000, 500.000000, 1, '件', 1.000000, 1.000000, 500.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-11-08 01:22:42', '2023-11-08 01:22:42', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣 ', 0, 0, 0, 0, 'CK2023110800001', 89651354972327936, '', 52739064255877120);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (89651413952630784, 100000, 100100, '', 6, 36, 'RK2023110800002', '', 42, 'BB6110', '1130000117117', 500.000000, 1.000000, 500.000000, 1, '件', 1.000000, 1.000000, 500.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-11-08 01:22:42', '2023-11-08 01:22:42', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣', 0, 0, 0, 0, 'CK2023110800001', 89651354938773504, '', 52739064411066368);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (89719364235956224, 100000, 100100, '2005444', 1, 0, 'XH2023110800001', '', 17, 'CSM123456', 'CSM1234563', 0.000000, 1.000000, 0.000000, 1, '克', 1.000000, 1.000000, 0.000000, 0, '0', 0, '', 1.000000, 1.000000, 1.000000, 1.000000, 'chengdu', 1.000000, 1, 1, '2023-11-08 05:52:43', '2023-11-08 05:53:27', 0, 4145731145437184, 4145731145437184, 1, '克', '', 1.000000, '', 1.000000, 0, '测试多规格爆款', 0, 0, 0, 0, '', 0, '', 89377222208655360);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (89719364265316352, 100000, 100100, '2005444', 1, 0, 'XH2023110800001', '', 17, 'CSM123456', 'CSM1234564', 0.000000, 1.000000, 0.000000, 1, '克', 1.000000, 1.000000, 0.000000, 0, '0', 0, '', 1.000000, 1.000000, 1.000000, 1.000000, 'chengdu', 1.000000, 1, 1, '2023-11-08 05:52:43', '2023-11-08 05:53:27', 0, 4145731145437184, 4145731145437184, 1, '克', '', 1.000000, '', 1.000000, 0, '测试多规格', 0, 0, 0, 0, '', 0, '', 89377222460313600);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (89719364290482176, 100000, 100100, '2005444', 1, 0, 'XH2023110800001', '', 17, 'BB6110', '1130000117118', 400.000000, 1.000000, 400.000000, 1, '件', 1.000000, 1.000000, 400.000000, 0, '0', 0, '', 1.000000, 1.000000, 1.000000, 1.000000, 'chengdu', 1.000000, 1, 1, '2023-11-08 05:52:43', '2023-11-08 05:53:27', 0, 4145731145437184, 4145731145437184, 1, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣', 0, 0, 0, 0, '', 0, '', 52739064524312576);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (89719364324036608, 100000, 100100, '2005444', 1, 0, 'XH2023110800001', '', 17, 'BB6110', '1130000117119', 0.000000, 1.000000, 0.000000, 1, '件', 1.000000, 1.000000, 0.000000, 0, '0', 0, '', 1.000000, 1.000000, 1.000000, 1.000000, 'chengdu', 1.000000, 1, 1, '2023-11-08 05:52:43', '2023-11-08 05:53:27', 0, 4145731145437184, 4145731145437184, 1, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣-热销款', 0, 0, 0, 0, '', 0, '', 52739064654336000);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (89719364349202432, 100000, 100100, '2005444', 1, 0, 'XH2023110800001', '', 17, 'CS123456', 'CS123456789', 0.000000, 1.000000, 0.000000, 1, '束', 1.000000, 1.000000, 0.000000, 0, '0', 0, '', 1.000000, 1.000000, 1.000000, 1.000000, 'chengdu', 1.000000, 1, 1, '2023-11-08 05:52:43', '2023-11-08 05:53:27', 0, 4145731145437184, 4145731145437184, 1, '束', '', 1.000000, '', 1.000000, 0, '测试商品', 0, 0, 0, 0, '', 0, '', 89376926845767680);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (89719364378562560, 100000, 100100, '2005444', 1, 0, 'XH2023110800001', '', 17, 'CSM123456', 'CSM1234561', 0.000000, 1.000000, 0.000000, 1, '克', 1.000000, 1.000000, 0.000000, 0, '0', 0, '', 1.000000, 1.000000, 1.000000, 1.000000, 'chengdu', 1.000000, 1, 1, '2023-11-08 05:52:43', '2023-11-08 05:53:27', 0, 4145731145437184, 4145731145437184, 1, '克', '', 1.000000, '', 1.000000, 0, '测试多规格', 0, 0, 0, 0, '', 0, '', 89377221780836352);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (89719364407922688, 100000, 100100, '2005444', 1, 0, 'XH2023110800001', '', 17, 'CSM123456', 'CSM1234562', 0.000000, 1.000000, 0.000000, 1, '克', 1.000000, 1.000000, 0.000000, 0, '0', 0, '', 1.000000, 1.000000, 1.000000, 1.000000, 'chengdu', 1.000000, 1, 1, '2023-11-08 05:52:43', '2023-11-08 05:53:27', 0, 4145731145437184, 4145731145437184, 1, '克', '', 1.000000, '', 1.000000, 0, '测试多规格', 0, 0, 0, 0, '', 0, '', 89377222007328768);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (89719364693135360, 100000, 100100, '2005444', 1, 0, 'XH2023110800002', '', 6, 'BB6110', '1130000117116', 400.000000, 1.000000, 400.000000, 1, '件', 1.000000, 1.000000, 400.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'CD03', 1.000000, 1, 1, '2023-11-08 05:52:43', '2023-11-08 05:52:43', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣 ', 0, 0, 0, 0, '', 0, '', 52739064255877120);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (89719364722495488, 100000, 100100, '2005444', 1, 0, 'XH2023110800002', '', 6, 'BB6110', '1130000117117', 400.000000, 1.000000, 400.000000, 1, '件', 1.000000, 1.000000, 400.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'CD03', 1.000000, 1, 1, '2023-11-08 05:52:43', '2023-11-08 05:52:43', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣', 0, 0, 0, 0, '', 0, '', 52739064411066368);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (89719549167013888, 100000, 100100, '2005444', 7, 44, 'CK2023110800002', '', 34, 'CSM123456', 'CSM1234562', 0.000000, 1.000000, 0.000000, 1, '克', 1.000000, 1.000000, 0.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-11-08 05:53:27', '2023-11-08 05:53:27', 0, 4145731145437184, 4145731145437184, 0, '克', '', 1.000000, '', 1.000000, 0, '测试多规格', 0, 0, 0, 0, 'XH2023110800001', 89719364407922688, '', 89377222007328768);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (89719549196374016, 100000, 100100, '2005444', 7, 44, 'CK2023110800002', '', 34, 'CSM123456', 'CSM1234561', 0.000000, 1.000000, 0.000000, 1, '克', 1.000000, 1.000000, 0.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-11-08 05:53:27', '2023-11-08 05:53:27', 0, 4145731145437184, 4145731145437184, 0, '克', '', 1.000000, '', 1.000000, 0, '测试多规格', 0, 0, 0, 0, 'XH2023110800001', 89719364378562560, '', 89377221780836352);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (89719549229928448, 100000, 100100, '2005444', 7, 44, 'CK2023110800002', '', 34, 'CS123456', 'CS123456789', 0.000000, 1.000000, 0.000000, 1, '束', 1.000000, 1.000000, 0.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-11-08 05:53:27', '2023-11-08 05:53:27', 0, 4145731145437184, 4145731145437184, 0, '束', '', 1.000000, '', 1.000000, 0, '测试商品', 0, 0, 0, 0, 'XH2023110800001', 89719364349202432, '', 89376926845767680);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (89719549255094272, 100000, 100100, '2005444', 7, 44, 'CK2023110800002', '', 34, 'BB6110', '1130000117119', 0.000000, 1.000000, 0.000000, 1, '件', 1.000000, 1.000000, 0.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-11-08 05:53:27', '2023-11-08 05:53:27', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣-热销款', 0, 0, 0, 0, 'XH2023110800001', 89719364324036608, '', 52739064654336000);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (89719549292843008, 100000, 100100, '2005444', 7, 44, 'CK2023110800002', '', 34, 'BB6110', '1130000117118', 400.000000, 1.000000, 400.000000, 1, '件', 1.000000, 1.000000, 400.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-11-08 05:53:27', '2023-11-08 05:53:27', 0, 4145731145437184, 4145731145437184, 0, '件', '箱', 5.000000, '包', 10.000000, 0, '缤纷派内衣', 0, 0, 0, 0, 'XH2023110800001', 89719364290482176, '', 52739064524312576);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (89719549322203136, 100000, 100100, '2005444', 7, 44, 'CK2023110800002', '', 34, 'CSM123456', 'CSM1234564', 0.000000, 1.000000, 0.000000, 1, '克', 1.000000, 1.000000, 0.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-11-08 05:53:27', '2023-11-08 05:53:27', 0, 4145731145437184, 4145731145437184, 0, '克', '', 1.000000, '', 1.000000, 0, '测试多规格', 0, 0, 0, 0, 'XH2023110800001', 89719364265316352, '', 89377222460313600);
INSERT INTO `doc_item` (`id`, `platform_id`, `company_id`, `client_no`, `doc_type`, `doc_sub_type`, `order_no`, `sub_order_no`, `status`, `spu_no`, `sku_no`, `settlement_amount`, `small_unit_number`, `small_unit_purchase_price`, `order_unit`, `order_unit_name`, `order_unit_number`, `order_ratio`, `order_unit_purchase_price`, `is_gift`, `promotion_id`, `promotion_type`, `remark`, `out_storage_number`, `shipped_number`, `received_number`, `real_received_number`, `warehouse_no`, `product_discount`, `client_discount`, `inventory_lock_status`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `product_snapshot_id`, `product_title`, `data_type`, `data_process`, `data_customer`, `data_retry`, `relation_doc_no`, `relation_doc_item_id`, `to_warehouse_no`, `product_id`) VALUES (89719549355757568, 100000, 100100, '2005444', 7, 44, 'CK2023110800002', '', 34, 'CSM123456', 'CSM1234563', 0.000000, 1.000000, 0.000000, 1, '克', 1.000000, 1.000000, 0.000000, 0, '0', 0, '', 0.000000, 0.000000, 0.000000, 0.000000, 'chengdu', 1.000000, 1, 1, '2023-11-08 05:53:27', '2023-11-08 05:53:27', 0, 4145731145437184, 4145731145437184, 0, '克', '', 1.000000, '', 1.000000, 0, '测试多规格爆款', 0, 0, 0, 0, 'XH2023110800001', 89719364235956224, '', 89377222208655360);
COMMIT;

-- ----------------------------
-- Table structure for doc_item1
-- ----------------------------
DROP TABLE IF EXISTS `doc_item1`;
CREATE TABLE `doc_item1` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `client_no` varchar(30) NOT NULL DEFAULT '' COMMENT '客户ID',
  `doc_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '单据类型',
  `doc_sub_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '子单据类型',
  `order_no` varchar(30) NOT NULL DEFAULT '0' COMMENT '订单编号',
  `sub_order_no` varchar(30) NOT NULL DEFAULT '' COMMENT '子订单',
  `status` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '单据状态',
  `spu_no` varchar(30) NOT NULL DEFAULT '' COMMENT 'SPU编号',
  `sku_no` varchar(30) NOT NULL DEFAULT '' COMMENT 'SKU编号',
  `settlement_amount` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '结算金额 客户实际支付金额，退款使用',
  `small_unit_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '小单位订购数量',
  `small_unit_purchase_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '小单位成交价',
  `order_unit` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '订购单位 1=小单位;2=中单位;3=大单位;',
  `order_unit_name` varchar(20) NOT NULL DEFAULT '' COMMENT '订购单位名字',
  `order_unit_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '订购单位数量',
  `order_ratio` decimal(21,6) NOT NULL DEFAULT '1.000000' COMMENT '订购换算关系',
  `order_unit_purchase_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '订购单位成交价',
  `is_gift` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为赠品 0=否;1=是;',
  `promotion_id` varchar(30) NOT NULL DEFAULT '' COMMENT '促销活动ID',
  `promotion_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '促销活动类型 0=普通商品;1=商品特价;2=商品买赠;3=团购活动;4=满立惠;5=套餐;6=满赠优惠券;7=组合商品;',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `out_storage_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '已出库数量',
  `shipped_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '已发货数量',
  `received_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '已收货数量',
  `real_received_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '实际已收货数量 生鲜缩水等',
  `warehouse_no` varchar(30) NOT NULL DEFAULT '' COMMENT '仓库编号',
  `product_discount` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '产品折扣率 取值范围为0-1',
  `client_discount` decimal(18,0) unsigned NOT NULL DEFAULT '0' COMMENT '客户折扣率 取值范围为0-1',
  `inventory_lock_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否锁定库存 0=否;1=是;',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  `small_unit` varchar(20) NOT NULL DEFAULT '' COMMENT '小单位',
  `medium_unit` varchar(20) NOT NULL DEFAULT '' COMMENT '中单位',
  `medium_ratio` decimal(21,6) unsigned NOT NULL DEFAULT '1.000000' COMMENT '中单位换算关系',
  `large_unit` varchar(20) NOT NULL DEFAULT '' COMMENT '大单位',
  `large_ratio` decimal(21,6) unsigned NOT NULL DEFAULT '1.000000' COMMENT '大单位换算关系',
  `product_snapshot_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '产品快照ID',
  `product_title` varchar(50) NOT NULL DEFAULT '' COMMENT '商品名字',
  `data_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型 0=热数据;1=温数据;2=冷数据;',
  `data_process` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型处理进度 0=待处理;1=处理成功;2=处理失败;',
  `data_customer` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型消费者 0=未设置;大于0=具体消费者;',
  `data_retry` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型消费重试次数',
  `relation_doc_no` varchar(30) NOT NULL DEFAULT '' COMMENT '关联单据',
  `relation_doc_item_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '关联单据明细',
  `to_warehouse_no` varchar(30) NOT NULL DEFAULT '' COMMENT '目标仓库编号',
  `product_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '产品ID',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `un_idx` (`platform_id`,`company_id`,`order_no`,`sku_no`,`is_gift`,`promotion_id`,`warehouse_no`,`order_unit`) USING BTREE COMMENT '单据明细',
  KEY `idx_platform_company` (`platform_id`,`company_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='单据明细';

-- ----------------------------
-- Records of doc_item1
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for doc_item2
-- ----------------------------
DROP TABLE IF EXISTS `doc_item2`;
CREATE TABLE `doc_item2` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `client_no` varchar(30) NOT NULL DEFAULT '' COMMENT '客户ID',
  `doc_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '单据类型',
  `doc_sub_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '子单据类型',
  `order_no` varchar(30) NOT NULL DEFAULT '0' COMMENT '订单编号',
  `sub_order_no` varchar(30) NOT NULL DEFAULT '' COMMENT '子订单',
  `status` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '单据状态',
  `spu_no` varchar(30) NOT NULL DEFAULT '' COMMENT 'SPU编号',
  `sku_no` varchar(30) NOT NULL DEFAULT '' COMMENT 'SKU编号',
  `settlement_amount` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '结算金额 客户实际支付金额，退款使用',
  `small_unit_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '小单位订购数量',
  `small_unit_purchase_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '小单位成交价',
  `order_unit` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '订购单位 1=小单位;2=中单位;3=大单位;',
  `order_unit_name` varchar(20) NOT NULL DEFAULT '' COMMENT '订购单位名字',
  `order_unit_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '订购单位数量',
  `order_ratio` decimal(21,6) NOT NULL DEFAULT '1.000000' COMMENT '订购换算关系',
  `order_unit_purchase_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '订购单位成交价',
  `is_gift` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为赠品 0=否;1=是;',
  `promotion_id` varchar(30) NOT NULL DEFAULT '' COMMENT '促销活动ID',
  `promotion_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '促销活动类型 0=普通商品;1=商品特价;2=商品买赠;3=团购活动;4=满立惠;5=套餐;6=满赠优惠券;7=组合商品;',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `out_storage_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '已出库数量',
  `shipped_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '已发货数量',
  `received_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '已收货数量',
  `real_received_number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '实际已收货数量 生鲜缩水等',
  `warehouse_no` varchar(30) NOT NULL DEFAULT '' COMMENT '仓库编号',
  `product_discount` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '产品折扣率 取值范围为0-1',
  `client_discount` decimal(18,0) unsigned NOT NULL DEFAULT '0' COMMENT '客户折扣率 取值范围为0-1',
  `inventory_lock_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否锁定库存 0=否;1=是;',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  `small_unit` varchar(20) NOT NULL DEFAULT '' COMMENT '小单位',
  `medium_unit` varchar(20) NOT NULL DEFAULT '' COMMENT '中单位',
  `medium_ratio` decimal(21,6) unsigned NOT NULL DEFAULT '1.000000' COMMENT '中单位换算关系',
  `large_unit` varchar(20) NOT NULL DEFAULT '' COMMENT '大单位',
  `large_ratio` decimal(21,6) unsigned NOT NULL DEFAULT '1.000000' COMMENT '大单位换算关系',
  `product_snapshot_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '产品快照ID',
  `product_title` varchar(50) NOT NULL DEFAULT '' COMMENT '商品名字',
  `data_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型 0=热数据;1=温数据;2=冷数据;',
  `data_process` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型处理进度 0=待处理;1=处理成功;2=处理失败;',
  `data_customer` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型消费者 0=未设置;大于0=具体消费者;',
  `data_retry` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型消费重试次数',
  `relation_doc_no` varchar(30) NOT NULL DEFAULT '' COMMENT '关联单据',
  `relation_doc_item_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '关联单据明细',
  `to_warehouse_no` varchar(30) NOT NULL DEFAULT '' COMMENT '目标仓库编号',
  `product_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '产品ID',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `un_idx` (`platform_id`,`company_id`,`order_no`,`sku_no`,`is_gift`,`promotion_id`,`warehouse_no`,`order_unit`) USING BTREE COMMENT '单据明细',
  KEY `idx_platform_company` (`platform_id`,`company_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='单据明细';

-- ----------------------------
-- Records of doc_item2
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for doc_log_track
-- ----------------------------
DROP TABLE IF EXISTS `doc_log_track`;
CREATE TABLE `doc_log_track` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `order_no` varchar(30) NOT NULL DEFAULT '' COMMENT '订单',
  `sub_order_no` varchar(30) NOT NULL DEFAULT '' COMMENT '子订单ID',
  `operation` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作类型',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '操作说明',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `create_account_name` varchar(30) NOT NULL DEFAULT '' COMMENT '创建人名字',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  `data_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型 0=热数据;1=温数据;2=冷数据;',
  `data_process` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型处理进度 0=待处理;1=处理成功;2=处理失败;',
  `data_customer` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型消费者 0=未设置;大于0=具体消费者;',
  `data_retry` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型消费重试次数',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `orders_FK` (`order_no`,`company_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=89719549796159489 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='单据日志跟踪';

-- ----------------------------
-- Records of doc_log_track
-- ----------------------------
BEGIN;
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (71523294494461952, 100000, 100100, 'RK2023091900001', '', 41, '创建并提交单据', '2023-09-19 00:48:02', '2023-09-19 00:48:02', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (71523344029192192, 100000, 100100, 'RK2023091900001', '', 42, '入库单审核通过', '2023-09-19 00:48:14', '2023-09-19 00:48:14', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (74832853157941248, 100000, 100100, 'XH2023092800001', '', 6, '创建并提交单据', '2023-09-28 03:59:02', '2023-09-28 03:59:02', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (78811260568866816, 100000, 100100, 'RK2023100900001', '', 41, '创建并提交单据', '2023-10-09 03:27:48', '2023-10-09 03:27:48', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (78811260824719360, 100000, 100100, 'RK2023100900002', '', 41, '创建并提交单据', '2023-10-09 03:27:48', '2023-10-09 03:27:48', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (78811261080571904, 100000, 100100, 'RK2023100900003', '', 41, '创建并提交单据', '2023-10-09 03:27:48', '2023-10-09 03:27:48', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (78811362171686912, 100000, 100100, 'RK2023100900004', '', 41, '创建并提交单据', '2023-10-09 03:28:12', '2023-10-09 03:28:12', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (78811362364624896, 100000, 100100, 'RK2023100900005', '', 41, '创建并提交单据', '2023-10-09 03:28:13', '2023-10-09 03:28:13', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (78811362586923008, 100000, 100100, 'RK2023100900006', '', 41, '创建并提交单据', '2023-10-09 03:28:13', '2023-10-09 03:28:13', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (78866522998706176, 100000, 100100, 'XH2023092800001', '', 7, '订单审核通过', '2023-10-09 07:07:24', '2023-10-09 07:07:24', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (78866534499487744, 100000, 100100, 'XH2023092800001', '', 8, '订单财务审核通过', '2023-10-09 07:07:27', '2023-10-09 07:07:27', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (78866548525240320, 100000, 100100, 'XH2023092800001', '', 9, '订单信用检查通过', '2023-10-09 07:07:30', '2023-10-09 07:07:30', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (78866557178089472, 100000, 100100, 'XH2023092800001', '', 10, '订单库存定位', '2023-10-09 07:07:32', '2023-10-09 07:07:32', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (78866567684820992, 100000, 100100, 'XH2023092800001', '', 11, '订单拣货完成', '2023-10-09 07:07:35', '2023-10-09 07:07:35', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (82045195390160896, 100000, 100100, 'CK2023101800001', '', 34, '创建并提交单据，关联单据：XH2023092800001', '2023-10-18 01:38:18', '2023-10-18 01:38:18', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (82045195415326720, 100000, 100100, 'XH2023092800001', '', 1700010, '创建并提交单据，关联单据：CK2023101800001', '2023-10-18 01:38:18', '2023-10-18 01:38:18', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (82045195738288128, 100000, 100100, 'XH2023092800001', '', 12, '出库发货触发订单状态变更', '2023-10-18 01:38:18', '2023-10-18 01:38:18', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (82051925452918784, 100000, 100100, 'RK2023100900006', '', 42, '入库单审核通过', '2023-10-18 02:05:03', '2023-10-18 02:05:03', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (82052164272394240, 100000, 100100, 'CK2023101800001', '', 320000, '撤销收货，关联单据: XH2023092800001', '2023-10-18 02:06:00', '2023-10-18 02:06:00', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (82052164322725888, 100000, 100100, 'XH2023092800001', '', 150009, '撤销收货，关联单据: CK2023101800001', '2023-10-18 02:06:00', '2023-10-18 02:06:00', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (82052180915392512, 100000, 100100, 'CK2023101800001', '', 310000, '撤销已发货，关联单据: XH2023092800001', '2023-10-18 02:06:04', '2023-10-18 02:06:04', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (82052180961529856, 100000, 100100, 'XH2023092800001', '', 1700011, '撤销已发货，关联单据: CK2023101800001', '2023-10-18 02:06:04', '2023-10-18 02:06:04', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (82052192143544320, 100000, 100100, 'CK2023101800001', '', 34, '取消出库，关联单据: XH2023092800001', '2023-10-18 02:06:07', '2023-10-18 02:06:07', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (82052192172904448, 100000, 100100, 'XH2023092800001', '', 150008, '取消出库，关联单据: CK2023101800001', '2023-10-18 02:06:07', '2023-10-18 02:06:07', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (82052192609112064, 100000, 100100, 'XH2023092800001', '', 130003, '出库发货触发订单状态变更', '2023-10-18 02:06:07', '2023-10-18 02:06:07', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (82052193942900736, 100000, 100100, 'RK2023101800001', '', 42, '创建并提交单据，关联单据：CK2023101800001', '2023-10-18 02:06:07', '2023-10-18 02:06:07', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (82052194005815296, 100000, 100100, 'CK2023101800001', '', 150010, '创建并提交单据，关联单据：RK2023101800001', '2023-10-18 02:06:07', '2023-10-18 02:06:07', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (82805972577423360, 100000, 100100, 'XH2023102000002', '', 6, '创建并提交单据', '2023-10-20 04:01:22', '2023-10-20 04:01:22', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (82806000385658880, 100000, 100100, 'XH2023102000002', '', 7, '订单审核通过', '2023-10-20 04:01:28', '2023-10-20 04:01:28', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (82806910813868032, 100000, 100100, 'XH2023102000002', '', 1, '财务审核不通过', '2023-10-20 04:05:06', '2023-10-20 04:05:06', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (82807297792937984, 100000, 100100, 'QH2023102000001', '', 6, '创建并提交单据', '2023-10-20 04:06:38', '2023-10-20 04:06:38', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (82807706871795712, 100000, 100100, 'QH2023102000001', '', 7, '订单审核通过', '2023-10-20 04:08:15', '2023-10-20 04:08:15', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (88924786822090752, 100000, 100100, 'CK2023110600001', '', 33, '创建并提交单据，关联单据：XH2023092800001', '2023-11-06 01:15:21', '2023-11-06 01:15:21', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (88924786851450880, 100000, 100100, 'XH2023092800001', '', 150007, '创建并提交单据，关联单据：CK2023110600001', '2023-11-06 01:15:21', '2023-11-06 01:15:21', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (88924787124080640, 100000, 100100, 'XH2023092800001', '', 12, '出库发货触发订单状态变更', '2023-11-06 01:15:21', '2023-11-06 01:15:21', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (89650021892493312, 100000, 100100, 'RK2023110800001', '', 41, '创建并提交单据', '2023-11-08 01:17:10', '2023-11-08 01:17:10', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (89650053400104960, 100000, 100100, 'RK2023110800001', '', 42, '入库单审核通过', '2023-11-08 01:17:18', '2023-11-08 01:17:18', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (89651355047825408, 100000, 100100, 'CK2023110800001', '', 33, '创建并提交单据，关联单据：XH2023092800001', '2023-11-08 01:22:28', '2023-11-08 01:22:28', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (89651355077185536, 100000, 100100, 'XH2023092800001', '', 150007, '创建并提交单据，关联单据：CK2023110800001', '2023-11-08 01:22:28', '2023-11-08 01:22:28', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (89651355345620992, 100000, 100100, 'XH2023092800001', '', 150001, '出库发货触发订单状态变更', '2023-11-08 01:22:28', '2023-11-08 01:22:28', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (89651400635715584, 100000, 100100, 'CK2023110800001', '', 310000, '撤销已发货，关联单据: XH2023092800001', '2023-11-08 01:22:39', '2023-11-08 01:22:39', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (89651400660881408, 100000, 100100, 'XH2023092800001', '', 1700011, '撤销已发货，关联单据: CK2023110800001', '2023-11-08 01:22:39', '2023-11-08 01:22:39', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (89651400874790912, 100000, 100100, 'XH2023092800001', '', 150003, '出库发货触发订单状态变更', '2023-11-08 01:22:39', '2023-11-08 01:22:39', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (89651413310902272, 100000, 100100, 'CK2023110800001', '', 34, '取消出库，关联单据: XH2023092800001', '2023-11-08 01:22:42', '2023-11-08 01:22:42', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (89651413344456704, 100000, 100100, 'XH2023092800001', '', 150008, '取消出库，关联单据: CK2023110800001', '2023-11-08 01:22:42', '2023-11-08 01:22:42', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (89651413566754816, 100000, 100100, 'XH2023092800001', '', 140002, '出库发货触发订单状态变更', '2023-11-08 01:22:42', '2023-11-08 01:22:42', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (89651413986185216, 100000, 100100, 'RK2023110800002', '', 42, '创建并提交单据，关联单据：CK2023110800001', '2023-11-08 01:22:42', '2023-11-08 01:22:42', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (89651414007156736, 100000, 100100, 'CK2023110800001', '', 150010, '创建并提交单据，关联单据：RK2023110800002', '2023-11-08 01:22:42', '2023-11-08 01:22:42', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (89719364441477120, 100000, 100100, 'XH2023110800001', '', 6, '创建并提交单据', '2023-11-08 05:52:43', '2023-11-08 05:52:43', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (89719364751855616, 100000, 100100, 'XH2023110800002', '', 6, '创建并提交单据', '2023-11-08 05:52:43', '2023-11-08 05:52:43', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (89719480384622592, 100000, 100100, 'XH2023110800001', '', 7, '订单审核通过', '2023-11-08 05:53:11', '2023-11-08 05:53:11', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (89719494909497344, 100000, 100100, 'XH2023110800001', '', 8, '订单财务审核通过', '2023-11-08 05:53:14', '2023-11-08 05:53:14', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (89719506326392832, 100000, 100100, 'XH2023110800001', '', 9, '订单信用检查通过', '2023-11-08 05:53:17', '2023-11-08 05:53:17', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (89719514769526784, 100000, 100100, 'XH2023110800001', '', 10, '订单库存定位', '2023-11-08 05:53:19', '2023-11-08 05:53:19', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (89719522495434752, 100000, 100100, 'XH2023110800001', '', 11, '订单拣货完成', '2023-11-08 05:53:21', '2023-11-08 05:53:21', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (89719549380923392, 100000, 100100, 'CK2023110800002', '', 34, '创建并提交单据，关联单据：XH2023110800001', '2023-11-08 05:53:27', '2023-11-08 05:53:27', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (89719549418672128, 100000, 100100, 'XH2023110800001', '', 1700010, '创建并提交单据，关联单据：CK2023110800002', '2023-11-08 05:53:27', '2023-11-08 05:53:27', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
INSERT INTO `doc_log_track` (`id`, `platform_id`, `company_id`, `order_no`, `sub_order_no`, `operation`, `remark`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `data_type`, `data_process`, `data_customer`, `data_retry`) VALUES (89719549796159488, 100000, 100100, 'XH2023110800001', '', 170004, '出库发货触发订单状态变更', '2023-11-08 05:53:27', '2023-11-08 05:53:27', 0, 4145731145437184, 'admin', 4145731145437184, 0, 0, 0, 0, 0);
COMMIT;

-- ----------------------------
-- Table structure for doc_log_track1
-- ----------------------------
DROP TABLE IF EXISTS `doc_log_track1`;
CREATE TABLE `doc_log_track1` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `order_no` varchar(30) NOT NULL DEFAULT '' COMMENT '订单',
  `sub_order_no` varchar(30) NOT NULL DEFAULT '' COMMENT '子订单ID',
  `operation` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作类型',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '操作说明',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `create_account_name` varchar(30) NOT NULL DEFAULT '' COMMENT '创建人名字',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  `data_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型 0=热数据;1=温数据;2=冷数据;',
  `data_process` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型处理进度 0=待处理;1=处理成功;2=处理失败;',
  `data_customer` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型消费者 0=未设置;大于0=具体消费者;',
  `data_retry` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型消费重试次数',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `orders_FK` (`order_no`,`company_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='单据日志跟踪';

-- ----------------------------
-- Records of doc_log_track1
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for doc_log_track2
-- ----------------------------
DROP TABLE IF EXISTS `doc_log_track2`;
CREATE TABLE `doc_log_track2` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `order_no` varchar(30) NOT NULL DEFAULT '' COMMENT '订单',
  `sub_order_no` varchar(30) NOT NULL DEFAULT '' COMMENT '子订单ID',
  `operation` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作类型',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '操作说明',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `create_account_name` varchar(30) NOT NULL DEFAULT '' COMMENT '创建人名字',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  `data_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型 0=热数据;1=温数据;2=冷数据;',
  `data_process` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型处理进度 0=待处理;1=处理成功;2=处理失败;',
  `data_customer` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型消费者 0=未设置;大于0=具体消费者;',
  `data_retry` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '数据类型消费重试次数',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `orders_FK` (`order_no`,`company_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='单据日志跟踪';

-- ----------------------------
-- Records of doc_log_track2
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for job
-- ----------------------------
DROP TABLE IF EXISTS `job`;
CREATE TABLE `job` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `name` varchar(200) NOT NULL DEFAULT '' COMMENT '任务名称',
  `total` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '总条数',
  `success` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '成功条数',
  `fail` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '失败条数',
  `type` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '类型',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  `process` tinyint(3) NOT NULL DEFAULT '0' COMMENT '处理进度 0=待处理;1=处理成功;2=处理失败;',
  `error` varchar(255) NOT NULL DEFAULT '' COMMENT '错误消息',
  `customer` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '消费者',
  `retry` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '重试次数',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_platform_company` (`platform_id`,`company_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=78811361655787521 DEFAULT CHARSET=utf8 COMMENT='任务管理';

-- ----------------------------
-- Records of job
-- ----------------------------
BEGIN;
INSERT INTO `job` (`id`, `platform_id`, `company_id`, `name`, `total`, `success`, `fail`, `type`, `create_at`, `delete_at`, `create_account`, `version`, `process`, `error`, `customer`, `retry`) VALUES (78811259511902208, 100000, 100100, 'in-storage.csv', 8, 6, 0, 20230427215654, '2023-10-09 03:27:48', 0, 4145731145437184, 0, 1, '', 0, 0);
INSERT INTO `job` (`id`, `platform_id`, `company_id`, `name`, `total`, `success`, `fail`, `type`, `create_at`, `delete_at`, `create_account`, `version`, `process`, `error`, `customer`, `retry`) VALUES (78811361655787520, 100000, 100100, 'in-storage.csv', 8, 6, 0, 20230427215654, '2023-10-09 03:28:12', 0, 4145731145437184, 0, 1, '', 0, 0);
COMMIT;

-- ----------------------------
-- Table structure for job_content
-- ----------------------------
DROP TABLE IF EXISTS `job_content`;
CREATE TABLE `job_content` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `content` mediumtext NOT NULL COMMENT '内容',
  `job_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '任务ID',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_platform_company` (`platform_id`,`company_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=78811361735479297 DEFAULT CHARSET=utf8 COMMENT='任务管理内容';

-- ----------------------------
-- Records of job_content
-- ----------------------------
BEGIN;
INSERT INTO `job_content` (`id`, `platform_id`, `company_id`, `content`, `job_id`, `create_at`, `delete_at`, `create_account`, `version`) VALUES (78811259591593984, 100000, 100100, '[{\"staff_no\":\"\",\"sku_no\":\"\",\"warehouse_no\":\"\",\"unit_number\":\"\",\"unit\":\"小单位;中单位;大单位\",\"remark\":\"\"},{\"staff_no\":\"经办人编号\",\"sku_no\":\"产品规格编码\",\"warehouse_no\":\"仓库编号\",\"unit_number\":\"入库数量\",\"unit\":\"入库单位\",\"remark\":\"入库备注\"},{\"staff_no\":\"9005355\",\"sku_no\":\"1130000117116\",\"warehouse_no\":\"CD01\",\"unit_number\":\"5.5\",\"unit\":\"小单位\",\"remark\":\"加急发货\"},{\"staff_no\":\"9005355\",\"sku_no\":\"1130000117116\",\"warehouse_no\":\"CD01\",\"unit_number\":\"8\",\"unit\":\"中单位\",\"remark\":\"\"},{\"staff_no\":\"9005355\",\"sku_no\":\"1130000117117\",\"warehouse_no\":\"CD01\",\"unit_number\":\"7\",\"unit\":\"小单位\",\"remark\":\"\"},{\"staff_no\":\"9005355\",\"sku_no\":\"1130000117117\",\"warehouse_no\":\"CD02\",\"unit_number\":\"6\",\"unit\":\"小单位\",\"remark\":\"\"},{\"staff_no\":\"8002032\",\"sku_no\":\"1130000117116\",\"warehouse_no\":\"CD03\",\"unit_number\":\"3\",\"unit\":\"中单位\",\"remark\":\"紧急商品\"},{\"staff_no\":\"8002032\",\"sku_no\":\"1130000117117\",\"warehouse_no\":\"CD03\",\"unit_number\":\"5\",\"unit\":\"大单位\",\"remark\":\"\"}]', 78811259511902208, '2023-10-09 03:27:48', 0, 4145731145437184, 0);
INSERT INTO `job_content` (`id`, `platform_id`, `company_id`, `content`, `job_id`, `create_at`, `delete_at`, `create_account`, `version`) VALUES (78811361672564736, 100000, 100100, '[{\"staff_no\":\"\",\"sku_no\":\"\",\"warehouse_no\":\"\",\"unit_number\":\"\",\"unit\":\"小单位;中单位;大单位\",\"remark\":\"\"},{\"staff_no\":\"经办人编号\",\"sku_no\":\"产品规格编码\",\"warehouse_no\":\"仓库编号\",\"unit_number\":\"入库数量\",\"unit\":\"入库单位\",\"remark\":\"入库备注\"},{\"staff_no\":\"9005355\",\"sku_no\":\"1130000117116\",\"warehouse_no\":\"CD01\",\"unit_number\":\"5.5\",\"unit\":\"小单位\",\"remark\":\"加急发货\"},{\"staff_no\":\"9005355\",\"sku_no\":\"1130000117116\",\"warehouse_no\":\"CD01\",\"unit_number\":\"8\",\"unit\":\"中单位\",\"remark\":\"\"},{\"staff_no\":\"9005355\",\"sku_no\":\"1130000117117\",\"warehouse_no\":\"CD01\",\"unit_number\":\"7\",\"unit\":\"小单位\",\"remark\":\"\"},{\"staff_no\":\"9005355\",\"sku_no\":\"1130000117117\",\"warehouse_no\":\"CD02\",\"unit_number\":\"6\",\"unit\":\"小单位\",\"remark\":\"\"},{\"staff_no\":\"8002032\",\"sku_no\":\"1130000117116\",\"warehouse_no\":\"CD03\",\"unit_number\":\"3\",\"unit\":\"中单位\",\"remark\":\"紧急商品\"},{\"staff_no\":\"8002032\",\"sku_no\":\"1130000117117\",\"warehouse_no\":\"CD03\",\"unit_number\":\"5\",\"unit\":\"大单位\",\"remark\":\"\"}]', 78811259511902208, '2023-10-09 03:28:12', 0, 4145731145437184, 0);
INSERT INTO `job_content` (`id`, `platform_id`, `company_id`, `content`, `job_id`, `create_at`, `delete_at`, `create_account`, `version`) VALUES (78811361735479296, 100000, 100100, '[{\"staff_no\":\"\",\"sku_no\":\"\",\"warehouse_no\":\"\",\"unit_number\":\"\",\"unit\":\"小单位;中单位;大单位\",\"remark\":\"\"},{\"staff_no\":\"经办人编号\",\"sku_no\":\"产品规格编码\",\"warehouse_no\":\"仓库编号\",\"unit_number\":\"入库数量\",\"unit\":\"入库单位\",\"remark\":\"入库备注\"},{\"staff_no\":\"9005355\",\"sku_no\":\"1130000117116\",\"warehouse_no\":\"CD01\",\"unit_number\":\"5.5\",\"unit\":\"小单位\",\"remark\":\"加急发货\"},{\"staff_no\":\"9005355\",\"sku_no\":\"1130000117116\",\"warehouse_no\":\"CD01\",\"unit_number\":\"8\",\"unit\":\"中单位\",\"remark\":\"\"},{\"staff_no\":\"9005355\",\"sku_no\":\"1130000117117\",\"warehouse_no\":\"CD01\",\"unit_number\":\"7\",\"unit\":\"小单位\",\"remark\":\"\"},{\"staff_no\":\"9005355\",\"sku_no\":\"1130000117117\",\"warehouse_no\":\"CD02\",\"unit_number\":\"6\",\"unit\":\"小单位\",\"remark\":\"\"},{\"staff_no\":\"8002032\",\"sku_no\":\"1130000117116\",\"warehouse_no\":\"CD03\",\"unit_number\":\"3\",\"unit\":\"中单位\",\"remark\":\"紧急商品\"},{\"staff_no\":\"8002032\",\"sku_no\":\"1130000117117\",\"warehouse_no\":\"CD03\",\"unit_number\":\"5\",\"unit\":\"大单位\",\"remark\":\"\"}]', 78811361655787520, '2023-10-09 03:28:12', 0, 4145731145437184, 0);
COMMIT;

-- ----------------------------
-- Table structure for phinx_log
-- ----------------------------
DROP TABLE IF EXISTS `phinx_log`;
CREATE TABLE `phinx_log` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of phinx_log
-- ----------------------------
BEGIN;
INSERT INTO `phinx_log` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES (20230217145516, 'BaseBrand', '2023-09-15 11:08:58', '2023-09-15 11:08:58', 0);
INSERT INTO `phinx_log` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES (20230218123718, 'ProductSpec', '2023-09-15 11:08:58', '2023-09-15 11:08:58', 0);
INSERT INTO `phinx_log` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES (20230218171033, 'ProductSpecGroup', '2023-09-15 11:08:58', '2023-09-15 11:08:58', 0);
INSERT INTO `phinx_log` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES (20230219113541, 'ProductBrand', '2023-09-15 11:08:58', '2023-09-15 11:08:58', 0);
INSERT INTO `phinx_log` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES (20230220124658, 'ProductCategory', '2023-09-15 11:08:58', '2023-09-15 11:08:59', 0);
INSERT INTO `phinx_log` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES (20230307060152, 'Product', '2023-09-15 11:08:59', '2023-09-15 11:08:59', 0);
INSERT INTO `phinx_log` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES (20230307060223, 'ProductContent', '2023-09-15 11:08:59', '2023-09-15 11:08:59', 0);
INSERT INTO `phinx_log` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES (20230307060228, 'ProductExtend', '2023-09-15 11:08:59', '2023-09-15 11:09:00', 0);
INSERT INTO `phinx_log` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES (20230310090017, 'Warehouse', '2023-09-15 11:09:00', '2023-09-15 11:09:00', 0);
INSERT INTO `phinx_log` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES (20230310095625, 'Stock', '2023-09-15 11:09:00', '2023-09-15 11:09:00', 0);
INSERT INTO `phinx_log` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES (20230312112628, 'StockLog', '2023-09-15 11:09:00', '2023-09-15 11:09:00', 0);
INSERT INTO `phinx_log` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES (20230314153503, 'ClientStock', '2023-09-15 11:09:00', '2023-09-15 11:09:00', 0);
INSERT INTO `phinx_log` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES (20230315154659, 'ProductSnapshot', '2023-09-15 11:09:00', '2023-09-15 11:09:01', 0);
INSERT INTO `phinx_log` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES (20230315160043, 'DocItem', '2023-09-15 11:09:01', '2023-09-15 11:09:01', 0);
INSERT INTO `phinx_log` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES (20230316153205, 'Doc', '2023-09-15 11:09:01', '2023-09-15 11:09:01', 0);
INSERT INTO `phinx_log` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES (20230316160905, 'DocLogTrack', '2023-09-15 11:09:01', '2023-09-15 11:09:02', 0);
INSERT INTO `phinx_log` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES (20230320170228, 'ClientStarDiscount', '2023-09-15 11:09:02', '2023-09-15 11:09:02', 0);
INSERT INTO `phinx_log` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES (20230412170014, 'SearchPlan', '2023-09-15 11:09:02', '2023-09-15 11:09:02', 0);
INSERT INTO `phinx_log` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES (20230424075646, 'ProductUnit', '2023-09-15 11:09:02', '2023-09-15 11:09:02', 0);
INSERT INTO `phinx_log` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES (20230427134303, 'Job', '2023-09-15 11:09:02', '2023-09-15 11:09:02', 0);
INSERT INTO `phinx_log` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES (20230427134306, 'JobContent', '2023-09-15 11:09:02', '2023-09-15 11:09:02', 0);
INSERT INTO `phinx_log` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES (20230622011850, 'PrintTemplate', '2023-09-15 11:09:02', '2023-09-15 11:09:02', 0);
INSERT INTO `phinx_log` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES (20230622011900, 'PrintTemplateContent', '2023-09-15 11:09:02', '2023-09-15 11:09:02', 0);
INSERT INTO `phinx_log` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES (20230624032114, 'ProductTemplate', '2023-09-15 11:09:02', '2023-09-15 11:09:02', 0);
COMMIT;

-- ----------------------------
-- Table structure for print_template
-- ----------------------------
DROP TABLE IF EXISTS `print_template`;
CREATE TABLE `print_template` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '模板名称',
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为默认模板 0=否;1=是;',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '模板类型',
  `remark` varchar(50) NOT NULL DEFAULT '' COMMENT '备注',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_platform_company` (`platform_id`,`company_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=39455683602681857 DEFAULT CHARSET=utf8 COMMENT='打印模板';

-- ----------------------------
-- Records of print_template
-- ----------------------------
BEGIN;
INSERT INTO `print_template` (`id`, `platform_id`, `company_id`, `name`, `is_default`, `type`, `remark`, `create_at`, `delete_at`, `create_account`, `version`) VALUES (39455653869260800, 100000, 100100, '默认模板', 1, 0, '', '2023-06-22 13:03:13', 0, 4145731145437184, 0);
INSERT INTO `print_template` (`id`, `platform_id`, `company_id`, `name`, `is_default`, `type`, `remark`, `create_at`, `delete_at`, `create_account`, `version`) VALUES (39455683602681856, 100000, 100100, '小票模板', 0, 0, '', '2023-06-22 13:03:20', 0, 4145731145437184, 0);
COMMIT;

-- ----------------------------
-- Table structure for print_template_content
-- ----------------------------
DROP TABLE IF EXISTS `print_template_content`;
CREATE TABLE `print_template_content` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `template_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '任务ID',
  `content` text NOT NULL COMMENT '内容',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_platform_company` (`platform_id`,`company_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=39455813210869761 DEFAULT CHARSET=utf8 COMMENT='打印模板内容';

-- ----------------------------
-- Records of print_template_content
-- ----------------------------
BEGIN;
INSERT INTO `print_template_content` (`id`, `platform_id`, `company_id`, `template_id`, `content`, `create_at`, `delete_at`, `create_account`, `version`) VALUES (39455801265491968, 100000, 100100, 39455653869260800, '{\"panels\":[{\"index\":0,\"name\":1,\"height\":296.6,\"width\":210,\"paperHeader\":0,\"paperFooter\":840.7559055118112,\"printElements\":[{\"options\":{\"left\":241.5,\"top\":28.5,\"height\":17,\"width\":120,\"testData\":\"订货单\",\"fontSize\":16.5,\"fontWeight\":\"700\",\"textAlign\":\"center\",\"hideTitle\":true,\"title\":\"订货单\",\"right\":361.5,\"bottom\":45.5,\"vCenter\":301.5,\"hCenter\":37,\"coordinateSync\":false,\"widthHeightSync\":false,\"qrCodeLevel\":0},\"printElementType\":{\"title\":\"单据表头\",\"type\":\"text\"}},{\"options\":{\"left\":214.5,\"top\":67.5,\"height\":16,\"width\":168,\"field\":\"client_no\",\"testData\":\"9005355\",\"fontSize\":6.75,\"fontWeight\":\"700\",\"textContentVerticalAlign\":\"middle\",\"title\":\"客户编号\",\"coordinateSync\":false,\"widthHeightSync\":false,\"qrCodeLevel\":0,\"right\":382.5,\"bottom\":82.75,\"vCenter\":298.5,\"hCenter\":74.75},\"printElementType\":{\"title\":\"客户编号\",\"type\":\"text\"}},{\"options\":{\"left\":403.5,\"top\":67.5,\"height\":16,\"width\":171,\"field\":\"user.phone\",\"fontSize\":6.75,\"fontWeight\":\"700\",\"textContentVerticalAlign\":\"middle\",\"title\":\"联系电话\",\"coordinateSync\":false,\"widthHeightSync\":false,\"qrCodeLevel\":0},\"printElementType\":{\"title\":\"联系电话\",\"type\":\"text\"}},{\"options\":{\"left\":16.5,\"top\":67.5,\"height\":16,\"width\":175.5,\"field\":\"order_no\",\"testData\":\"QP2023051600006\",\"fontSize\":6.75,\"fontWeight\":\"700\",\"textAlign\":\"left\",\"textContentVerticalAlign\":\"middle\",\"title\":\"订单编号\",\"right\":189,\"bottom\":82.75,\"vCenter\":101.25,\"hCenter\":74.75},\"printElementType\":{\"title\":\"订单编号\",\"type\":\"text\"}},{\"options\":{\"left\":214.5,\"top\":94.5,\"height\":16,\"width\":360,\"field\":\"user.address\",\"testData\":\"四川省成都市青羊区全家\",\"fontSize\":6.75,\"fontWeight\":\"700\",\"textContentVerticalAlign\":\"middle\",\"title\":\"收货地址\",\"coordinateSync\":false,\"widthHeightSync\":false,\"qrCodeLevel\":0,\"right\":519.75,\"bottom\":112,\"vCenter\":363.75,\"hCenter\":104},\"printElementType\":{\"title\":\"收货地址\",\"type\":\"text\"}},{\"options\":{\"left\":15,\"top\":94.5,\"height\":16,\"width\":177,\"field\":\"user.contact\",\"testData\":\"刘先生\",\"fontSize\":6.75,\"fontWeight\":\"700\",\"textContentVerticalAlign\":\"middle\",\"title\":\"联系人\",\"coordinateSync\":false,\"widthHeightSync\":false,\"qrCodeLevel\":0,\"right\":179.5,\"bottom\":109.75,\"vCenter\":114.5,\"hCenter\":101.75},\"printElementType\":{\"title\":\"联系人\",\"type\":\"text\"}},{\"options\":{\"left\":16.5,\"top\":124.5,\"height\":54,\"width\":556.5,\"tableFooterRepeat\":\"last\",\"field\":\"table\",\"tableHeaderRepeat\":\"first\",\"fields\":[{\"text\":\"商品\",\"field\":\"product_title\"},{\"text\":\"商品编号\",\"field\":\"spu_no\"},{\"text\":\"规格编号\",\"field\":\"sku_no\"},{\"text\":\"规格\",\"field\":\"product.sku_title\"},{\"text\":\"单位\",\"field\":\"order_unit_name\"},{\"text\":\"数量\",\"field\":\"order_unit_number\"},{\"text\":\"单价\",\"field\":\"order_unit_purchase_price\"},{\"text\":\"金额\",\"field\":\"settlement_amount\"},{\"text\":\"备注\",\"field\":\"remark\"}],\"coordinateSync\":false,\"widthHeightSync\":false,\"columns\":[[{\"width\":79.5,\"title\":\"商品\",\"field\":\"product_title\",\"checked\":true,\"columnId\":\"product_title\",\"fixed\":false,\"rowspan\":1,\"colspan\":1,\"align\":\"center\"},{\"width\":79.5,\"title\":\"规格编号\",\"field\":\"sku_no\",\"checked\":true,\"columnId\":\"sku_no\",\"fixed\":false,\"rowspan\":1,\"colspan\":1,\"align\":\"center\"},{\"width\":79.5,\"title\":\"规格\",\"field\":\"product.sku_title\",\"checked\":true,\"columnId\":\"product.sku_title\",\"fixed\":false,\"rowspan\":1,\"colspan\":1,\"align\":\"center\"},{\"width\":79.5,\"title\":\"单位\",\"field\":\"order_unit_name\",\"checked\":true,\"columnId\":\"order_unit_name\",\"fixed\":false,\"rowspan\":1,\"colspan\":1,\"align\":\"center\"},{\"width\":79.5,\"title\":\"数量\",\"field\":\"order_unit_number\",\"checked\":true,\"columnId\":\"order_unit_number\",\"fixed\":false,\"rowspan\":1,\"colspan\":1,\"align\":\"right\",\"halign\":\"right\",\"tableQRCodeLevel\":0,\"tableSummaryTitle\":true,\"tableSummary\":\"sum\",\"tableSummaryAlign\":\"right\"},{\"width\":79.5,\"title\":\"单价\",\"field\":\"order_unit_purchase_price\",\"checked\":true,\"columnId\":\"order_unit_purchase_price\",\"fixed\":false,\"rowspan\":1,\"colspan\":1,\"align\":\"right\",\"halign\":\"right\",\"tableQRCodeLevel\":0,\"tableSummaryTitle\":true,\"tableSummary\":\"sum\",\"tableSummaryAlign\":\"right\"},{\"width\":79.5,\"title\":\"金额\",\"field\":\"settlement_amount\",\"checked\":true,\"columnId\":\"settlement_amount\",\"fixed\":false,\"rowspan\":1,\"colspan\":1,\"align\":\"right\",\"halign\":\"right\",\"tableQRCodeLevel\":0,\"tableSummaryTitle\":true,\"tableSummary\":\"sum\",\"tableSummaryAlign\":\"right\"},{\"width\":150,\"title\":\"商品编号\",\"field\":\"spu_no\",\"checked\":false,\"columnId\":\"spu_no\",\"fixed\":false,\"rowspan\":1,\"colspan\":1,\"align\":\"center\"},{\"width\":150,\"title\":\"备注\",\"field\":\"remark\",\"checked\":false,\"columnId\":\"remark\",\"fixed\":false,\"rowspan\":1,\"colspan\":1,\"align\":\"center\"}]]},\"printElementType\":{\"title\":\"订单数据\",\"type\":\"table\",\"editable\":true,\"columnDisplayEditable\":true,\"columnDisplayIndexEditable\":true,\"columnTitleEditable\":true,\"columnResizable\":true,\"columnAlignEditable\":true,\"isEnableEditField\":true,\"isEnableContextMenu\":true,\"isEnableInsertRow\":true,\"isEnableDeleteRow\":true,\"isEnableInsertColumn\":true,\"isEnableDeleteColumn\":true,\"isEnableMergeCell\":true}},{\"options\":{\"left\":433.5,\"top\":189,\"height\":16,\"width\":139.5,\"field\":\"frameworkPrintDate\",\"testData\":\"2023-05-15 22:05:19\",\"fontSize\":6.75,\"fontWeight\":\"700\",\"textContentVerticalAlign\":\"middle\",\"title\":\"打印时间\",\"right\":572.25,\"bottom\":204.25,\"vCenter\":502.5,\"hCenter\":196.25,\"coordinateSync\":false,\"widthHeightSync\":false,\"qrCodeLevel\":0,\"textAlign\":\"right\"},\"printElementType\":{\"title\":\"打印时间\",\"type\":\"text\"}},{\"options\":{\"left\":15,\"top\":189,\"height\":16,\"width\":177,\"field\":\"create_account_name\",\"testData\":\"刘先生\",\"fontSize\":6.75,\"fontWeight\":\"700\",\"textAlign\":\"left\",\"textContentVerticalAlign\":\"middle\",\"title\":\"制单人\",\"right\":135.75,\"bottom\":213.25,\"vCenter\":75.75,\"hCenter\":205.25},\"printElementType\":{\"title\":\"制单人\",\"type\":\"text\"}}],\"paperNumberLeft\":577.5,\"paperNumberTop\":-39,\"paperNumberDisabled\":true,\"scale\":1,\"watermarkOptions\":{\"content\":\"\",\"fillStyle\":\"rgba(163, 44, 44, 1)\",\"fontSize\":\"65px\",\"rotate\":78,\"width\":308,\"height\":107,\"timestamp\":false,\"format\":\"YYYY-MM-DD HH:mm\"}}]}', '2023-06-22 10:17:02', 0, 4145731145437184, 0);
INSERT INTO `print_template_content` (`id`, `platform_id`, `company_id`, `template_id`, `content`, `create_at`, `delete_at`, `create_account`, `version`) VALUES (39455813210869760, 100000, 100100, 39455683602681856, '{\"panels\":[{\"index\":0,\"name\":1,\"height\":400,\"width\":112,\"paperHeader\":0,\"paperFooter\":1133.8582677165355,\"printElements\":[{\"options\":{\"left\":96,\"top\":19.5,\"height\":17,\"width\":120,\"fontSize\":16.5,\"fontWeight\":\"700\",\"textAlign\":\"center\",\"hideTitle\":true,\"title\":\"订货单\",\"right\":215.25,\"bottom\":35.75,\"vCenter\":155.25,\"hCenter\":27.25,\"coordinateSync\":false,\"widthHeightSync\":false,\"qrCodeLevel\":0},\"printElementType\":{\"title\":\"单据表头\",\"type\":\"text\"}},{\"options\":{\"left\":19.5,\"top\":51,\"height\":9,\"width\":274.5,\"right\":294,\"bottom\":60,\"vCenter\":156.75,\"hCenter\":55.5,\"coordinateSync\":false,\"widthHeightSync\":false,\"borderStyle\":\"dashed\"},\"printElementType\":{\"title\":\"横线\",\"type\":\"hline\"}},{\"options\":{\"left\":19.5,\"top\":60,\"height\":16,\"width\":274.5,\"field\":\"client_no\",\"testData\":\"2002045\",\"fontSize\":6.75,\"fontWeight\":\"700\",\"textAlign\":\"left\",\"textContentVerticalAlign\":\"middle\",\"title\":\"客户编号\",\"right\":141.75,\"bottom\":78.25,\"vCenter\":81.75,\"hCenter\":70.25},\"printElementType\":{\"title\":\"客户编号\",\"type\":\"text\"}},{\"options\":{\"left\":19.5,\"top\":84,\"height\":16,\"width\":274.5,\"field\":\"user.contact\",\"testData\":\"刘先生\",\"fontSize\":6.75,\"fontWeight\":\"700\",\"textAlign\":\"left\",\"textContentVerticalAlign\":\"middle\",\"title\":\"联系人\",\"right\":138.75,\"bottom\":99.25,\"vCenter\":78.75,\"hCenter\":91.25},\"printElementType\":{\"title\":\"联系人\",\"type\":\"text\"}},{\"options\":{\"left\":19.5,\"top\":111,\"height\":16,\"width\":274.5,\"field\":\"create_account_name\",\"testData\":\"刘先生\",\"fontSize\":6.75,\"fontWeight\":\"700\",\"textAlign\":\"left\",\"textContentVerticalAlign\":\"middle\",\"title\":\"制单人\",\"right\":138.75,\"bottom\":127,\"vCenter\":78.75,\"hCenter\":119},\"printElementType\":{\"title\":\"制单人\",\"type\":\"text\"}},{\"options\":{\"left\":19.5,\"top\":135,\"height\":16,\"width\":274.5,\"field\":\"order_no\",\"testData\":\"QP2023051600006\",\"fontSize\":6.75,\"fontWeight\":\"700\",\"textAlign\":\"left\",\"textContentVerticalAlign\":\"middle\",\"title\":\"订单编号\",\"right\":139.5,\"bottom\":157,\"vCenter\":79.5,\"hCenter\":149},\"printElementType\":{\"title\":\"订单编号\",\"type\":\"text\"}},{\"options\":{\"left\":18,\"top\":159,\"height\":16,\"width\":276,\"field\":\"create_at\",\"testData\":\"2023-05-15 22:05:19\",\"fontSize\":6.75,\"fontWeight\":\"700\",\"textAlign\":\"left\",\"textContentVerticalAlign\":\"middle\",\"title\":\"下单时间\",\"right\":291,\"bottom\":174.25,\"vCenter\":153,\"hCenter\":166.25},\"printElementType\":{\"title\":\"下单时间\",\"type\":\"text\"}},{\"options\":{\"left\":18,\"top\":183,\"height\":9,\"width\":274.5,\"right\":289.5,\"bottom\":191.25,\"vCenter\":152.25,\"hCenter\":186.75,\"coordinateSync\":false,\"widthHeightSync\":false,\"borderStyle\":\"dashed\"},\"printElementType\":{\"title\":\"横线\",\"type\":\"hline\"}},{\"options\":{\"left\":18,\"top\":192,\"height\":16,\"width\":273,\"field\":\"user.contact\",\"testData\":\"刘先生\",\"fontSize\":6.75,\"fontWeight\":\"700\",\"textAlign\":\"left\",\"textContentVerticalAlign\":\"middle\",\"title\":\"联系人\",\"right\":138,\"bottom\":211,\"vCenter\":78,\"hCenter\":203},\"printElementType\":{\"title\":\"联系人\",\"type\":\"text\"}},{\"options\":{\"left\":18,\"top\":217.5,\"height\":16,\"width\":274.5,\"field\":\"user.phone\",\"testData\":\"\",\"fontSize\":6.75,\"fontWeight\":\"700\",\"textAlign\":\"left\",\"textContentVerticalAlign\":\"middle\",\"title\":\"联系电话\",\"right\":289.5,\"bottom\":232.75,\"vCenter\":152.25,\"hCenter\":224.75},\"printElementType\":{\"title\":\"联系电话\",\"type\":\"text\"}},{\"options\":{\"left\":18,\"top\":244.5,\"height\":16.5,\"width\":273,\"field\":\"user.address\",\"testData\":\"四川省成都市青羊区全家\",\"fontSize\":6.75,\"fontWeight\":\"700\",\"textAlign\":\"left\",\"textContentVerticalAlign\":\"middle\",\"title\":\"收货地址\",\"right\":138.75,\"bottom\":260.5,\"vCenter\":78.75,\"hCenter\":252.5},\"printElementType\":{\"title\":\"收货地址\",\"type\":\"text\"}},{\"options\":{\"left\":16.5,\"top\":268.5,\"height\":9,\"width\":274.5,\"right\":292.74609375,\"bottom\":277.74609375,\"vCenter\":155.49609375,\"hCenter\":273.24609375,\"coordinateSync\":false,\"widthHeightSync\":false,\"borderStyle\":\"dashed\"},\"printElementType\":{\"title\":\"横线\",\"type\":\"hline\"}},{\"options\":{\"left\":16.5,\"top\":277.5,\"height\":52.5,\"width\":274.5,\"tableFooterRepeat\":\"last\",\"field\":\"table\",\"tableHeaderRepeat\":\"first\",\"fields\":[{\"text\":\"商品\",\"field\":\"product_title\"},{\"text\":\"商品编号\",\"field\":\"spu_no\"},{\"text\":\"规格编号\",\"field\":\"sku_no\"},{\"text\":\"规格\",\"field\":\"product.sku_title\"},{\"text\":\"单位\",\"field\":\"order_unit_name\"},{\"text\":\"数量\",\"field\":\"order_unit_number\"},{\"text\":\"单价\",\"field\":\"order_unit_purchase_price\"},{\"text\":\"金额\",\"field\":\"settlement_amount\"},{\"text\":\"备注\",\"field\":\"remark\"}],\"coordinateSync\":false,\"widthHeightSync\":false,\"tableBodyRowBorder\":\"noBorder\",\"tableBorder\":\"noBorder\",\"tableHeaderBorder\":\"noBorder\",\"tableHeaderCellBorder\":\"noBorder\",\"tableHeaderBackground\":\"#ffffff\",\"tableBodyCellBorder\":\"noBorder\",\"tableFooterBorder\":\"noBorder\",\"tableFooterCellBorder\":\"noBorder\",\"right\":291,\"bottom\":331.5,\"vCenter\":153.75,\"hCenter\":305.25,\"columns\":[[{\"width\":68.625,\"title\":\"商品\",\"field\":\"product_title\",\"checked\":true,\"columnId\":\"product_title\",\"fixed\":false,\"rowspan\":1,\"colspan\":1,\"align\":\"left\",\"halign\":\"left\",\"tableQRCodeLevel\":0,\"tableSummaryTitle\":true,\"tableSummary\":\"\"},{\"width\":69.375,\"title\":\"单价\",\"field\":\"order_unit_purchase_price\",\"checked\":true,\"columnId\":\"order_unit_purchase_price\",\"fixed\":false,\"rowspan\":1,\"colspan\":1,\"align\":\"right\",\"halign\":\"right\",\"tableQRCodeLevel\":0,\"tableSummaryTitle\":true,\"tableSummary\":\"\"},{\"width\":67.875,\"title\":\"数量\",\"field\":\"order_unit_number\",\"checked\":true,\"columnId\":\"order_unit_number\",\"fixed\":false,\"rowspan\":1,\"colspan\":1,\"align\":\"right\",\"halign\":\"right\",\"tableQRCodeLevel\":0,\"tableSummaryTitle\":true,\"tableSummary\":\"sum\"},{\"width\":68.625,\"title\":\"金额\",\"field\":\"settlement_amount\",\"checked\":true,\"columnId\":\"settlement_amount\",\"fixed\":false,\"rowspan\":1,\"colspan\":1,\"align\":\"right\",\"halign\":\"right\",\"tableQRCodeLevel\":0,\"tableSummaryTitle\":true,\"tableSummary\":\"sum\"},{\"width\":150,\"title\":\"商品编号\",\"field\":\"spu_no\",\"checked\":false,\"columnId\":\"spu_no\",\"fixed\":false,\"rowspan\":1,\"colspan\":1,\"align\":\"center\"},{\"width\":150,\"title\":\"规格编号\",\"field\":\"sku_no\",\"checked\":false,\"columnId\":\"sku_no\",\"fixed\":false,\"rowspan\":1,\"colspan\":1,\"align\":\"center\"},{\"width\":150,\"title\":\"规格\",\"field\":\"product.sku_title\",\"checked\":false,\"columnId\":\"product.sku_title\",\"fixed\":false,\"rowspan\":1,\"colspan\":1,\"align\":\"center\"},{\"width\":150,\"title\":\"单位\",\"field\":\"order_unit_name\",\"checked\":false,\"columnId\":\"order_unit_name\",\"fixed\":false,\"rowspan\":1,\"colspan\":1,\"align\":\"center\"},{\"width\":150,\"title\":\"备注\",\"field\":\"remark\",\"checked\":false,\"columnId\":\"remark\",\"fixed\":false,\"rowspan\":1,\"colspan\":1,\"align\":\"center\"}]]},\"printElementType\":{\"title\":\"订单数据\",\"type\":\"table\",\"editable\":true,\"columnDisplayEditable\":true,\"columnDisplayIndexEditable\":true,\"columnTitleEditable\":true,\"columnResizable\":true,\"columnAlignEditable\":true,\"isEnableEditField\":true,\"isEnableContextMenu\":true,\"isEnableInsertRow\":true,\"isEnableDeleteRow\":true,\"isEnableInsertColumn\":true,\"isEnableDeleteColumn\":true,\"isEnableMergeCell\":true}},{\"options\":{\"left\":16.5,\"top\":352.5,\"height\":9,\"width\":274.5,\"right\":291.99609375,\"bottom\":361.74609375,\"vCenter\":154.74609375,\"hCenter\":357.24609375,\"coordinateSync\":false,\"widthHeightSync\":false,\"borderStyle\":\"dashed\"},\"printElementType\":{\"title\":\"横线\",\"type\":\"hline\"}},{\"options\":{\"left\":88.5,\"top\":361.5,\"height\":9.75,\"width\":123,\"title\":\"****欢迎再次下单****\",\"right\":211.5,\"bottom\":374.25,\"vCenter\":150,\"hCenter\":369.375,\"coordinateSync\":false,\"widthHeightSync\":false,\"fontSize\":12,\"fontWeight\":\"bolder\",\"qrCodeLevel\":0},\"printElementType\":{\"title\":\"文本\",\"type\":\"text\"}}],\"paperNumberLeft\":310,\"paperNumberTop\":819,\"watermarkOptions\":{}}]}', '2023-06-22 10:16:39', 0, 4145731145437184, 0);
COMMIT;

-- ----------------------------
-- Table structure for product
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `spu_no` varchar(30) NOT NULL DEFAULT '' COMMENT '产品编号',
  `sku_no` varchar(30) NOT NULL DEFAULT '' COMMENT '规格编号',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '商品标题',
  `sub_title` varchar(50) NOT NULL DEFAULT '' COMMENT '副标题',
  `sku_title` varchar(100) NOT NULL DEFAULT '' COMMENT '规格标题',
  `color` varchar(30) NOT NULL DEFAULT '' COMMENT '颜色 机身颜色 深空黑色,暗紫色,景色',
  `size` varchar(30) NOT NULL DEFAULT '' COMMENT '尺码 存储容量 8G+128G,12G+256G,12G+512G',
  `spec1` varchar(20) NOT NULL DEFAULT '' COMMENT '第一种规格 网络类型 4G全网通,5G全网通',
  `spec2` varchar(20) NOT NULL DEFAULT '' COMMENT '第二种规格 版本类型 中国大陆',
  `spec3` varchar(20) NOT NULL DEFAULT '' COMMENT '第三种规格 官方标配,快充套装,耳机套餐',
  `images` varchar(250) NOT NULL DEFAULT '' COMMENT '商品主图',
  `saleable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否上架 0=下架;1=上架;',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '商品状态 0=正常;1=停采;2=淘汰;3=停售;',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `attr1` varchar(20) NOT NULL DEFAULT '' COMMENT '第一种属性',
  `attr2` varchar(20) NOT NULL DEFAULT '' COMMENT '第二种属性',
  `attr3` varchar(20) NOT NULL DEFAULT '' COMMENT '第三种属性',
  `attr4` varchar(20) NOT NULL DEFAULT '' COMMENT '第四种属性',
  `attr5` varchar(20) NOT NULL DEFAULT '' COMMENT '第五种属性',
  `attr6` varchar(20) NOT NULL DEFAULT '' COMMENT '第六种属性',
  `attr7` varchar(20) NOT NULL DEFAULT '' COMMENT '第七种属性',
  `attr8` varchar(20) NOT NULL DEFAULT '' COMMENT '第八种属性',
  `attr9` varchar(20) NOT NULL DEFAULT '' COMMENT '第九种属性',
  `attr10` varchar(20) NOT NULL DEFAULT '' COMMENT '第十种属性',
  `attr11` varchar(20) NOT NULL DEFAULT '' COMMENT '第十一种属性',
  `attr12` varchar(20) NOT NULL DEFAULT '' COMMENT '第十二种属性',
  `attr13` varchar(20) NOT NULL DEFAULT '' COMMENT '第十三种属性',
  `attr14` varchar(20) NOT NULL DEFAULT '' COMMENT '第十四种属性',
  `attr15` varchar(20) NOT NULL DEFAULT '' COMMENT '第十五种属性',
  `sort` bigint(20) unsigned NOT NULL DEFAULT '50000' COMMENT '排序 DESC',
  `free_freight` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否包邮 0=不包邮;1=包邮;',
  `small_unit` varchar(10) NOT NULL DEFAULT '' COMMENT '小单位',
  `medium_unit` varchar(10) NOT NULL DEFAULT '' COMMENT '中单位',
  `medium_ratio` decimal(21,6) unsigned NOT NULL DEFAULT '1.000000' COMMENT '中单位换算关系',
  `large_unit` varchar(10) NOT NULL DEFAULT '' COMMENT '大单位',
  `large_ratio` decimal(21,6) unsigned NOT NULL DEFAULT '1.000000' COMMENT '大单位换算关系',
  `sales_unit` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '销售单位 1=小单位;2=中单位;3=大单位;',
  `base_unit_min_order` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '最低起订小单位数量 单位为小单位',
  `keyword` varchar(20) NOT NULL DEFAULT '' COMMENT '搜索关键词 空格分隔',
  `is_subsidiary` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为辅料商品 0=普通商品;1=辅料商品;',
  `shelf_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '商品上架时间',
  `product_model` varchar(30) NOT NULL DEFAULT '' COMMENT '商品型号',
  `location_no` varchar(30) NOT NULL DEFAULT '' COMMENT '货位号',
  `small_barcode` varchar(20) NOT NULL DEFAULT '' COMMENT '小单位条形码',
  `medium_barcode` varchar(20) NOT NULL DEFAULT '' COMMENT '中单位条形码',
  `large_barcode` varchar(20) NOT NULL DEFAULT '' COMMENT '大单位条形码',
  `small_sales_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '小单位销售价格 又名配送价',
  `small_purchase_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '小单位进货价格 又名成本价',
  `small_market_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '小单位市场价格 又名全国统一零售价',
  `small_min_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '小单位最低价格 销售价低于此价格不能下单',
  `small_max_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '小单位最高价格 销售价高于此价格不能下单',
  `medium_sales_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '中单位销售价格 又名配送价',
  `medium_purchase_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '中单位进货价格 又名成本价',
  `medium_market_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '中单位市场价格 又名全国统一零售价',
  `medium_min_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '中单位最低价格 销售价低于此价格不能下单',
  `medium_max_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '中单位最高价格 销售价高于此价格不能下单',
  `large_sales_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '大单位销售价格 又名配送价',
  `large_purchase_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '大单位进货价格 又名成本价',
  `large_market_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '大单位市场价格 又名全国统一零售价',
  `large_min_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '大单位最低价格 销售价低于此价格不能下单',
  `large_max_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '大单位最高价格 销售价高于此价格不能下单',
  `is_spu` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为主商品 0=否;1=是;',
  `is_new` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为新品 0=否;1=是;',
  `is_hot` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为热销商品 0=否;1=是;',
  `is_special` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为特价商品 商品折扣 0=普通商品;1=特价商品;',
  `discount` decimal(21,6) unsigned NOT NULL DEFAULT '1.000000' COMMENT '折扣率 取值范围为0-1',
  `discount_start` date NOT NULL DEFAULT '1000-01-01' COMMENT '折扣开始时间',
  `discount_end` date NOT NULL DEFAULT '9999-01-01' COMMENT '折扣结束时间',
  `is_pre_sale` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为预售商品 0=否;1=是;',
  `is_client_star_discount` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否参与客户星级折扣 0=否;1=是;',
  `auto_shelf_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '自动上架时间',
  `auto_off_shelf_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '自动下架时间',
  `estimated_arrival_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '预计到货时间',
  `snapshot_version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '快照版本号',
  `brand_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商品品牌',
  `category_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商品分类',
  `category_level1` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商品一级分类',
  `category_level2` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商品二级分类',
  `supplier_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '供应商',
  `template_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '规格模板',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_sku_no` (`platform_id`,`company_id`,`sku_no`) USING BTREE COMMENT '规格编号',
  UNIQUE KEY `uniq_spec` (`platform_id`,`company_id`,`spu_no`,`color`,`size`,`spec1`,`spec2`,`spec3`) USING BTREE COMMENT '规格',
  KEY `key_spu_no` (`spu_no`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=89377222460313601 DEFAULT CHARSET=utf8 COMMENT='产品表SKU';

-- ----------------------------
-- Records of product
-- ----------------------------
BEGIN;
INSERT INTO `product` (`id`, `platform_id`, `company_id`, `spu_no`, `sku_no`, `title`, `sub_title`, `sku_title`, `color`, `size`, `spec1`, `spec2`, `spec3`, `images`, `saleable`, `status`, `create_at`, `update_at`, `delete_at`, `version`, `create_account`, `update_account`, `attr1`, `attr2`, `attr3`, `attr4`, `attr5`, `attr6`, `attr7`, `attr8`, `attr9`, `attr10`, `attr11`, `attr12`, `attr13`, `attr14`, `attr15`, `sort`, `free_freight`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `sales_unit`, `base_unit_min_order`, `keyword`, `is_subsidiary`, `shelf_time`, `product_model`, `location_no`, `small_barcode`, `medium_barcode`, `large_barcode`, `small_sales_price`, `small_purchase_price`, `small_market_price`, `small_min_price`, `small_max_price`, `medium_sales_price`, `medium_purchase_price`, `medium_market_price`, `medium_min_price`, `medium_max_price`, `large_sales_price`, `large_purchase_price`, `large_market_price`, `large_min_price`, `large_max_price`, `is_spu`, `is_new`, `is_hot`, `is_special`, `discount`, `discount_start`, `discount_end`, `is_pre_sale`, `is_client_star_discount`, `auto_shelf_time`, `auto_off_shelf_time`, `estimated_arrival_time`, `snapshot_version`, `brand_id`, `category_id`, `category_level1`, `category_level2`, `supplier_id`, `template_id`) VALUES (52739064255877120, 100000, 100100, 'BB6110', '1130000117116', '缤纷派内衣 ', '相当舒适', '红色 M C', 'red', 'm', 'c', '', '', '', 1, 0, '2023-07-29 04:46:12', '2023-07-29 04:46:12', 0, 0, 4145731145437184, 4145731145437184, 'J4', '1', 'G7青春版（全网通）', '', '', '', '', '', '', '', '', '', '', '', '', 50000, 0, '件', '箱', 5.000000, '包', 10.000000, 1, 0.000000, '', 0, '2023-07-29 12:46:12', '', '', '', '', '', 500.000000, 0.000000, 0.000000, 0.000000, 0.000000, 2500.000000, 0.000000, 0.000000, 0.000000, 0.000000, 5000.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0, 0, 0, 0, 1.000000, '1000-01-01', '9999-01-01', 0, 1, '2023-07-29 12:46:12', '2023-07-29 12:46:12', '2023-07-29 12:46:12', 0, 0, 40021888721883136, 40021167695859712, 40021442565378048, 0, 0);
INSERT INTO `product` (`id`, `platform_id`, `company_id`, `spu_no`, `sku_no`, `title`, `sub_title`, `sku_title`, `color`, `size`, `spec1`, `spec2`, `spec3`, `images`, `saleable`, `status`, `create_at`, `update_at`, `delete_at`, `version`, `create_account`, `update_account`, `attr1`, `attr2`, `attr3`, `attr4`, `attr5`, `attr6`, `attr7`, `attr8`, `attr9`, `attr10`, `attr11`, `attr12`, `attr13`, `attr14`, `attr15`, `sort`, `free_freight`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `sales_unit`, `base_unit_min_order`, `keyword`, `is_subsidiary`, `shelf_time`, `product_model`, `location_no`, `small_barcode`, `medium_barcode`, `large_barcode`, `small_sales_price`, `small_purchase_price`, `small_market_price`, `small_min_price`, `small_max_price`, `medium_sales_price`, `medium_purchase_price`, `medium_market_price`, `medium_min_price`, `medium_max_price`, `large_sales_price`, `large_purchase_price`, `large_market_price`, `large_min_price`, `large_max_price`, `is_spu`, `is_new`, `is_hot`, `is_special`, `discount`, `discount_start`, `discount_end`, `is_pre_sale`, `is_client_star_discount`, `auto_shelf_time`, `auto_off_shelf_time`, `estimated_arrival_time`, `snapshot_version`, `brand_id`, `category_id`, `category_level1`, `category_level2`, `supplier_id`, `template_id`) VALUES (52739064411066368, 100000, 100100, 'BB6110', '1130000117117', '缤纷派内衣', '相当舒适', '黑色 M D', 'black', 'm', 'd', '', '', 'product/100100/b8ccd99e-193c-5930-8af9-58572cbc985f.jpg', 1, 0, '2023-07-29 04:46:12', '2023-09-19 00:56:03', 0, 0, 4145731145437184, 4145731145437184, 'J2', '2', 'G7青春版（电信）', '', '', '', '', '', '', '', '', '', '', '', '', 50000, 0, '件', '箱', 5.000000, '包', 10.000000, 1, 0.000000, '', 0, '2023-07-29 12:46:12', '', '', '', '', '', 500.000000, 0.000000, 0.000000, 0.000000, 0.000000, 2500.000000, 0.000000, 0.000000, 0.000000, 0.000000, 5000.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0, 0, 0, 0, 1.000000, '1000-01-01', '9999-01-01', 0, 1, '2023-07-29 12:46:12', '2023-07-29 12:46:12', '2023-07-29 12:46:12', 0, 0, 40021888721883136, 40021167695859712, 40021442565378048, 0, 0);
INSERT INTO `product` (`id`, `platform_id`, `company_id`, `spu_no`, `sku_no`, `title`, `sub_title`, `sku_title`, `color`, `size`, `spec1`, `spec2`, `spec3`, `images`, `saleable`, `status`, `create_at`, `update_at`, `delete_at`, `version`, `create_account`, `update_account`, `attr1`, `attr2`, `attr3`, `attr4`, `attr5`, `attr6`, `attr7`, `attr8`, `attr9`, `attr10`, `attr11`, `attr12`, `attr13`, `attr14`, `attr15`, `sort`, `free_freight`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `sales_unit`, `base_unit_min_order`, `keyword`, `is_subsidiary`, `shelf_time`, `product_model`, `location_no`, `small_barcode`, `medium_barcode`, `large_barcode`, `small_sales_price`, `small_purchase_price`, `small_market_price`, `small_min_price`, `small_max_price`, `medium_sales_price`, `medium_purchase_price`, `medium_market_price`, `medium_min_price`, `medium_max_price`, `large_sales_price`, `large_purchase_price`, `large_market_price`, `large_min_price`, `large_max_price`, `is_spu`, `is_new`, `is_hot`, `is_special`, `discount`, `discount_start`, `discount_end`, `is_pre_sale`, `is_client_star_discount`, `auto_shelf_time`, `auto_off_shelf_time`, `estimated_arrival_time`, `snapshot_version`, `brand_id`, `category_id`, `category_level1`, `category_level2`, `supplier_id`, `template_id`) VALUES (52739064524312576, 100000, 100100, 'BB6110', '1130000117118', '缤纷派内衣', '相当舒适', '红色 XL D', 'red', 'xl', 'd', '', '', 'product/100100/044d41c3-6423-51ba-98f4-0d5636bcf552.jpg', 1, 0, '2023-07-29 04:46:12', '2023-09-19 00:55:49', 0, 0, 4145731145437184, 4145731145437184, 'J3', '2', 'G7青春版（网通）', '', '', '', '', '', '', '', '', '', '', '', '', 50000, 0, '件', '箱', 5.000000, '包', 10.000000, 1, 0.000000, '', 0, '2023-07-29 12:46:12', '', '', '', '', '', 500.000000, 0.000000, 0.000000, 0.000000, 0.000000, 2500.000000, 0.000000, 0.000000, 0.000000, 0.000000, 5000.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0, 0, 0, 0, 1.000000, '1000-01-01', '9999-01-01', 0, 1, '2023-07-29 12:46:12', '2023-07-29 12:46:12', '2023-07-29 12:46:12', 0, 0, 40021888721883136, 40021167695859712, 40021442565378048, 0, 0);
INSERT INTO `product` (`id`, `platform_id`, `company_id`, `spu_no`, `sku_no`, `title`, `sub_title`, `sku_title`, `color`, `size`, `spec1`, `spec2`, `spec3`, `images`, `saleable`, `status`, `create_at`, `update_at`, `delete_at`, `version`, `create_account`, `update_account`, `attr1`, `attr2`, `attr3`, `attr4`, `attr5`, `attr6`, `attr7`, `attr8`, `attr9`, `attr10`, `attr11`, `attr12`, `attr13`, `attr14`, `attr15`, `sort`, `free_freight`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `sales_unit`, `base_unit_min_order`, `keyword`, `is_subsidiary`, `shelf_time`, `product_model`, `location_no`, `small_barcode`, `medium_barcode`, `large_barcode`, `small_sales_price`, `small_purchase_price`, `small_market_price`, `small_min_price`, `small_max_price`, `medium_sales_price`, `medium_purchase_price`, `medium_market_price`, `medium_min_price`, `medium_max_price`, `large_sales_price`, `large_purchase_price`, `large_market_price`, `large_min_price`, `large_max_price`, `is_spu`, `is_new`, `is_hot`, `is_special`, `discount`, `discount_start`, `discount_end`, `is_pre_sale`, `is_client_star_discount`, `auto_shelf_time`, `auto_off_shelf_time`, `estimated_arrival_time`, `snapshot_version`, `brand_id`, `category_id`, `category_level1`, `category_level2`, `supplier_id`, `template_id`) VALUES (52739064654336000, 100000, 100100, 'BB6110', '1130000117119', '缤纷派内衣-热销款', '相当舒适', '红色 M D', 'red', 'm', 'd', '', '', 'product/100100/11be79c0-b283-5336-b4d9-451e5fa9b9ea.jpg', 1, 0, '2023-07-29 04:46:12', '2023-10-20 07:41:55', 0, 0, 4145731145437184, 4145731145437184, 'J1', '2', 'G7青春版（联通）', '', '', '', '', '', '', '', '', '', '', '', '', 50000, 0, '件', '箱', 5.000000, '包', 10.000000, 1, 0.000000, '', 0, '2023-07-29 12:46:12', '', '', '', '', '', 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0, 0, 0, 0, 1.000000, '1000-01-01', '9999-01-01', 0, 1, '2023-07-29 12:46:12', '2023-07-29 12:46:12', '2023-07-29 12:46:12', 0, 0, 40021888721883136, 40021167695859712, 40021442565378048, 0, 0);
INSERT INTO `product` (`id`, `platform_id`, `company_id`, `spu_no`, `sku_no`, `title`, `sub_title`, `sku_title`, `color`, `size`, `spec1`, `spec2`, `spec3`, `images`, `saleable`, `status`, `create_at`, `update_at`, `delete_at`, `version`, `create_account`, `update_account`, `attr1`, `attr2`, `attr3`, `attr4`, `attr5`, `attr6`, `attr7`, `attr8`, `attr9`, `attr10`, `attr11`, `attr12`, `attr13`, `attr14`, `attr15`, `sort`, `free_freight`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `sales_unit`, `base_unit_min_order`, `keyword`, `is_subsidiary`, `shelf_time`, `product_model`, `location_no`, `small_barcode`, `medium_barcode`, `large_barcode`, `small_sales_price`, `small_purchase_price`, `small_market_price`, `small_min_price`, `small_max_price`, `medium_sales_price`, `medium_purchase_price`, `medium_market_price`, `medium_min_price`, `medium_max_price`, `large_sales_price`, `large_purchase_price`, `large_market_price`, `large_min_price`, `large_max_price`, `is_spu`, `is_new`, `is_hot`, `is_special`, `discount`, `discount_start`, `discount_end`, `is_pre_sale`, `is_client_star_discount`, `auto_shelf_time`, `auto_off_shelf_time`, `estimated_arrival_time`, `snapshot_version`, `brand_id`, `category_id`, `category_level1`, `category_level2`, `supplier_id`, `template_id`) VALUES (89376926845767680, 100000, 100100, 'CS123456', 'CS123456789', '测试商品', '', '', '', '', '', '', '', '', 1, 0, '2023-11-07 07:11:59', '2023-11-07 07:11:59', 0, 0, 4145731145437184, 4145731145437184, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 50000, 0, '束', '', 1.000000, '', 1.000000, 1, 0.000000, '', 0, '2023-11-07 07:11:59', '', '', '', '', '', 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0, 0, 0, 0, 1.000000, '1000-01-01', '9999-01-01', 0, 1, '2023-11-07 07:11:59', '2023-11-07 07:11:59', '2023-11-07 07:11:59', 0, 0, 40014685017346048, 40009457169731584, 40011274691678208, 0, 0);
INSERT INTO `product` (`id`, `platform_id`, `company_id`, `spu_no`, `sku_no`, `title`, `sub_title`, `sku_title`, `color`, `size`, `spec1`, `spec2`, `spec3`, `images`, `saleable`, `status`, `create_at`, `update_at`, `delete_at`, `version`, `create_account`, `update_account`, `attr1`, `attr2`, `attr3`, `attr4`, `attr5`, `attr6`, `attr7`, `attr8`, `attr9`, `attr10`, `attr11`, `attr12`, `attr13`, `attr14`, `attr15`, `sort`, `free_freight`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `sales_unit`, `base_unit_min_order`, `keyword`, `is_subsidiary`, `shelf_time`, `product_model`, `location_no`, `small_barcode`, `medium_barcode`, `large_barcode`, `small_sales_price`, `small_purchase_price`, `small_market_price`, `small_min_price`, `small_max_price`, `medium_sales_price`, `medium_purchase_price`, `medium_market_price`, `medium_min_price`, `medium_max_price`, `large_sales_price`, `large_purchase_price`, `large_market_price`, `large_min_price`, `large_max_price`, `is_spu`, `is_new`, `is_hot`, `is_special`, `discount`, `discount_start`, `discount_end`, `is_pre_sale`, `is_client_star_discount`, `auto_shelf_time`, `auto_off_shelf_time`, `estimated_arrival_time`, `snapshot_version`, `brand_id`, `category_id`, `category_level1`, `category_level2`, `supplier_id`, `template_id`) VALUES (89377221780836352, 100000, 100100, 'CSM123456', 'CSM1234561', '测试多规格', '', '灰紫色 M C 中国大陆 豪华套餐', '10003', '20001', '30003', '40001', '50003', '', 1, 0, '2023-11-07 07:13:10', '2023-11-07 07:13:10', 0, 0, 4145731145437184, 4145731145437184, '114324', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 50000, 0, '克', '', 1.000000, '', 1.000000, 1, 0.000000, '', 0, '2023-11-07 07:13:10', '', '', '', '', '', 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0, 0, 0, 0, 1.000000, '1000-01-01', '9999-01-01', 0, 1, '2023-11-07 07:13:10', '2023-11-07 07:13:10', '2023-11-07 07:13:10', 0, 0, 40013122202898432, 40009457169731584, 40010653527838720, 0, 0);
INSERT INTO `product` (`id`, `platform_id`, `company_id`, `spu_no`, `sku_no`, `title`, `sub_title`, `sku_title`, `color`, `size`, `spec1`, `spec2`, `spec3`, `images`, `saleable`, `status`, `create_at`, `update_at`, `delete_at`, `version`, `create_account`, `update_account`, `attr1`, `attr2`, `attr3`, `attr4`, `attr5`, `attr6`, `attr7`, `attr8`, `attr9`, `attr10`, `attr11`, `attr12`, `attr13`, `attr14`, `attr15`, `sort`, `free_freight`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `sales_unit`, `base_unit_min_order`, `keyword`, `is_subsidiary`, `shelf_time`, `product_model`, `location_no`, `small_barcode`, `medium_barcode`, `large_barcode`, `small_sales_price`, `small_purchase_price`, `small_market_price`, `small_min_price`, `small_max_price`, `medium_sales_price`, `medium_purchase_price`, `medium_market_price`, `medium_min_price`, `medium_max_price`, `large_sales_price`, `large_purchase_price`, `large_market_price`, `large_min_price`, `large_max_price`, `is_spu`, `is_new`, `is_hot`, `is_special`, `discount`, `discount_start`, `discount_end`, `is_pre_sale`, `is_client_star_discount`, `auto_shelf_time`, `auto_off_shelf_time`, `estimated_arrival_time`, `snapshot_version`, `brand_id`, `category_id`, `category_level1`, `category_level2`, `supplier_id`, `template_id`) VALUES (89377222007328768, 100000, 100100, 'CSM123456', 'CSM1234562', '测试多规格', '', '灰紫色 M C 中国大陆 升级套餐', '10003', '20001', '30003', '40001', '50002', '', 1, 0, '2023-11-07 07:13:10', '2023-11-07 07:13:10', 0, 0, 4145731145437184, 4145731145437184, '114324', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 50000, 0, '克', '', 1.000000, '', 1.000000, 1, 0.000000, '', 0, '2023-11-07 07:13:10', '', '', '', '', '', 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0, 0, 0, 0, 1.000000, '1000-01-01', '9999-01-01', 0, 1, '2023-11-07 07:13:10', '2023-11-07 07:13:10', '2023-11-07 07:13:10', 0, 0, 40013122202898432, 40009457169731584, 40010653527838720, 0, 0);
INSERT INTO `product` (`id`, `platform_id`, `company_id`, `spu_no`, `sku_no`, `title`, `sub_title`, `sku_title`, `color`, `size`, `spec1`, `spec2`, `spec3`, `images`, `saleable`, `status`, `create_at`, `update_at`, `delete_at`, `version`, `create_account`, `update_account`, `attr1`, `attr2`, `attr3`, `attr4`, `attr5`, `attr6`, `attr7`, `attr8`, `attr9`, `attr10`, `attr11`, `attr12`, `attr13`, `attr14`, `attr15`, `sort`, `free_freight`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `sales_unit`, `base_unit_min_order`, `keyword`, `is_subsidiary`, `shelf_time`, `product_model`, `location_no`, `small_barcode`, `medium_barcode`, `large_barcode`, `small_sales_price`, `small_purchase_price`, `small_market_price`, `small_min_price`, `small_max_price`, `medium_sales_price`, `medium_purchase_price`, `medium_market_price`, `medium_min_price`, `medium_max_price`, `large_sales_price`, `large_purchase_price`, `large_market_price`, `large_min_price`, `large_max_price`, `is_spu`, `is_new`, `is_hot`, `is_special`, `discount`, `discount_start`, `discount_end`, `is_pre_sale`, `is_client_star_discount`, `auto_shelf_time`, `auto_off_shelf_time`, `estimated_arrival_time`, `snapshot_version`, `brand_id`, `category_id`, `category_level1`, `category_level2`, `supplier_id`, `template_id`) VALUES (89377222208655360, 100000, 100100, 'CSM123456', 'CSM1234563', '测试多规格爆款', '', '灰紫色 M B 中国大陆 豪华套餐', '10003', '20001', '30002', '40001', '50003', 'product/100100/743443ee-0233-5afe-990b-9d2a600629c8.jpeg', 1, 0, '2023-11-07 07:13:10', '2023-11-07 07:16:31', 0, 0, 4145731145437184, 4145731145437184, '114324', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 50000, 0, '克', '', 1.000000, '', 1.000000, 1, 0.000000, '', 0, '2023-11-07 07:13:10', '', '', '', '', '', 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0, 0, 0, 0, 1.000000, '1000-01-01', '9999-01-01', 0, 1, '2023-11-07 07:13:10', '2023-11-07 07:13:10', '2023-11-07 07:13:10', 0, 0, 40013122202898432, 40009457169731584, 40010653527838720, 0, 0);
INSERT INTO `product` (`id`, `platform_id`, `company_id`, `spu_no`, `sku_no`, `title`, `sub_title`, `sku_title`, `color`, `size`, `spec1`, `spec2`, `spec3`, `images`, `saleable`, `status`, `create_at`, `update_at`, `delete_at`, `version`, `create_account`, `update_account`, `attr1`, `attr2`, `attr3`, `attr4`, `attr5`, `attr6`, `attr7`, `attr8`, `attr9`, `attr10`, `attr11`, `attr12`, `attr13`, `attr14`, `attr15`, `sort`, `free_freight`, `small_unit`, `medium_unit`, `medium_ratio`, `large_unit`, `large_ratio`, `sales_unit`, `base_unit_min_order`, `keyword`, `is_subsidiary`, `shelf_time`, `product_model`, `location_no`, `small_barcode`, `medium_barcode`, `large_barcode`, `small_sales_price`, `small_purchase_price`, `small_market_price`, `small_min_price`, `small_max_price`, `medium_sales_price`, `medium_purchase_price`, `medium_market_price`, `medium_min_price`, `medium_max_price`, `large_sales_price`, `large_purchase_price`, `large_market_price`, `large_min_price`, `large_max_price`, `is_spu`, `is_new`, `is_hot`, `is_special`, `discount`, `discount_start`, `discount_end`, `is_pre_sale`, `is_client_star_discount`, `auto_shelf_time`, `auto_off_shelf_time`, `estimated_arrival_time`, `snapshot_version`, `brand_id`, `category_id`, `category_level1`, `category_level2`, `supplier_id`, `template_id`) VALUES (89377222460313600, 100000, 100100, 'CSM123456', 'CSM1234564', '测试多规格', '', '灰紫色 M B 中国大陆 升级套餐', '10003', '20001', '30002', '40001', '50002', '', 1, 0, '2023-11-07 07:13:10', '2023-11-07 07:13:10', 0, 0, 4145731145437184, 4145731145437184, '114324', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 50000, 0, '克', '', 1.000000, '', 1.000000, 1, 0.000000, '', 0, '2023-11-07 07:13:10', '', '', '', '', '', 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0, 0, 0, 0, 1.000000, '1000-01-01', '9999-01-01', 0, 1, '2023-11-07 07:13:10', '2023-11-07 07:13:10', '2023-11-07 07:13:10', 0, 0, 40013122202898432, 40009457169731584, 40010653527838720, 0, 0);
COMMIT;

-- ----------------------------
-- Table structure for product1
-- ----------------------------
DROP TABLE IF EXISTS `product1`;
CREATE TABLE `product1` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `spu_no` varchar(30) NOT NULL DEFAULT '' COMMENT '产品编号',
  `sku_no` varchar(30) NOT NULL DEFAULT '' COMMENT '规格编号',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '商品标题',
  `sub_title` varchar(50) NOT NULL DEFAULT '' COMMENT '副标题',
  `sku_title` varchar(100) NOT NULL DEFAULT '' COMMENT '规格标题',
  `color` varchar(30) NOT NULL DEFAULT '' COMMENT '颜色 机身颜色 深空黑色,暗紫色,景色',
  `size` varchar(30) NOT NULL DEFAULT '' COMMENT '尺码 存储容量 8G+128G,12G+256G,12G+512G',
  `spec1` varchar(20) NOT NULL DEFAULT '' COMMENT '第一种规格 网络类型 4G全网通,5G全网通',
  `spec2` varchar(20) NOT NULL DEFAULT '' COMMENT '第二种规格 版本类型 中国大陆',
  `spec3` varchar(20) NOT NULL DEFAULT '' COMMENT '第三种规格 官方标配,快充套装,耳机套餐',
  `images` varchar(250) NOT NULL DEFAULT '' COMMENT '商品主图',
  `saleable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否上架 0=下架;1=上架;',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '商品状态 0=正常;1=停采;2=淘汰;3=停售;',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `attr1` varchar(20) NOT NULL DEFAULT '' COMMENT '第一种属性',
  `attr2` varchar(20) NOT NULL DEFAULT '' COMMENT '第二种属性',
  `attr3` varchar(20) NOT NULL DEFAULT '' COMMENT '第三种属性',
  `attr4` varchar(20) NOT NULL DEFAULT '' COMMENT '第四种属性',
  `attr5` varchar(20) NOT NULL DEFAULT '' COMMENT '第五种属性',
  `attr6` varchar(20) NOT NULL DEFAULT '' COMMENT '第六种属性',
  `attr7` varchar(20) NOT NULL DEFAULT '' COMMENT '第七种属性',
  `attr8` varchar(20) NOT NULL DEFAULT '' COMMENT '第八种属性',
  `attr9` varchar(20) NOT NULL DEFAULT '' COMMENT '第九种属性',
  `attr10` varchar(20) NOT NULL DEFAULT '' COMMENT '第十种属性',
  `attr11` varchar(20) NOT NULL DEFAULT '' COMMENT '第十一种属性',
  `attr12` varchar(20) NOT NULL DEFAULT '' COMMENT '第十二种属性',
  `attr13` varchar(20) NOT NULL DEFAULT '' COMMENT '第十三种属性',
  `attr14` varchar(20) NOT NULL DEFAULT '' COMMENT '第十四种属性',
  `attr15` varchar(20) NOT NULL DEFAULT '' COMMENT '第十五种属性',
  `sort` bigint(20) unsigned NOT NULL DEFAULT '50000' COMMENT '排序 DESC',
  `free_freight` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否包邮 0=不包邮;1=包邮;',
  `small_unit` varchar(10) NOT NULL DEFAULT '' COMMENT '小单位',
  `medium_unit` varchar(10) NOT NULL DEFAULT '' COMMENT '中单位',
  `medium_ratio` decimal(21,6) unsigned NOT NULL DEFAULT '1.000000' COMMENT '中单位换算关系',
  `large_unit` varchar(10) NOT NULL DEFAULT '' COMMENT '大单位',
  `large_ratio` decimal(21,6) unsigned NOT NULL DEFAULT '1.000000' COMMENT '大单位换算关系',
  `sales_unit` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '销售单位 1=小单位;2=中单位;3=大单位;',
  `base_unit_min_order` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '最低起订小单位数量 单位为小单位',
  `keyword` varchar(20) NOT NULL DEFAULT '' COMMENT '搜索关键词 空格分隔',
  `is_subsidiary` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为辅料商品 0=普通商品;1=辅料商品;',
  `shelf_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '商品上架时间',
  `product_model` varchar(30) NOT NULL DEFAULT '' COMMENT '商品型号',
  `location_no` varchar(30) NOT NULL DEFAULT '' COMMENT '货位号',
  `small_barcode` varchar(20) NOT NULL DEFAULT '' COMMENT '小单位条形码',
  `medium_barcode` varchar(20) NOT NULL DEFAULT '' COMMENT '中单位条形码',
  `large_barcode` varchar(20) NOT NULL DEFAULT '' COMMENT '大单位条形码',
  `small_sales_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '小单位销售价格 又名配送价',
  `small_purchase_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '小单位进货价格 又名成本价',
  `small_market_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '小单位市场价格 又名全国统一零售价',
  `small_min_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '小单位最低价格 销售价低于此价格不能下单',
  `small_max_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '小单位最高价格 销售价高于此价格不能下单',
  `medium_sales_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '中单位销售价格 又名配送价',
  `medium_purchase_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '中单位进货价格 又名成本价',
  `medium_market_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '中单位市场价格 又名全国统一零售价',
  `medium_min_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '中单位最低价格 销售价低于此价格不能下单',
  `medium_max_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '中单位最高价格 销售价高于此价格不能下单',
  `large_sales_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '大单位销售价格 又名配送价',
  `large_purchase_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '大单位进货价格 又名成本价',
  `large_market_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '大单位市场价格 又名全国统一零售价',
  `large_min_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '大单位最低价格 销售价低于此价格不能下单',
  `large_max_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '大单位最高价格 销售价高于此价格不能下单',
  `is_spu` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为主商品 0=否;1=是;',
  `is_new` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为新品 0=否;1=是;',
  `is_hot` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为热销商品 0=否;1=是;',
  `is_special` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为特价商品 商品折扣 0=普通商品;1=特价商品;',
  `discount` decimal(21,6) unsigned NOT NULL DEFAULT '1.000000' COMMENT '折扣率 取值范围为0-1',
  `discount_start` date NOT NULL DEFAULT '1000-01-01' COMMENT '折扣开始时间',
  `discount_end` date NOT NULL DEFAULT '9999-01-01' COMMENT '折扣结束时间',
  `is_pre_sale` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为预售商品 0=否;1=是;',
  `is_client_star_discount` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否参与客户星级折扣 0=否;1=是;',
  `auto_shelf_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '自动上架时间',
  `auto_off_shelf_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '自动下架时间',
  `estimated_arrival_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '预计到货时间',
  `snapshot_version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '快照版本号',
  `brand_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商品品牌',
  `category_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商品分类',
  `category_level1` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商品一级分类',
  `category_level2` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商品二级分类',
  `supplier_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '供应商',
  `template_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '规格模板',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_sku_no` (`platform_id`,`company_id`,`sku_no`) USING BTREE COMMENT '规格编号',
  UNIQUE KEY `uniq_spec` (`platform_id`,`company_id`,`spu_no`,`color`,`size`,`spec1`,`spec2`,`spec3`) USING BTREE COMMENT '规格',
  KEY `key_spu_no` (`spu_no`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品表SKU';

-- ----------------------------
-- Records of product1
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for product2
-- ----------------------------
DROP TABLE IF EXISTS `product2`;
CREATE TABLE `product2` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `spu_no` varchar(30) NOT NULL DEFAULT '' COMMENT '产品编号',
  `sku_no` varchar(30) NOT NULL DEFAULT '' COMMENT '规格编号',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '商品标题',
  `sub_title` varchar(50) NOT NULL DEFAULT '' COMMENT '副标题',
  `sku_title` varchar(100) NOT NULL DEFAULT '' COMMENT '规格标题',
  `color` varchar(30) NOT NULL DEFAULT '' COMMENT '颜色 机身颜色 深空黑色,暗紫色,景色',
  `size` varchar(30) NOT NULL DEFAULT '' COMMENT '尺码 存储容量 8G+128G,12G+256G,12G+512G',
  `spec1` varchar(20) NOT NULL DEFAULT '' COMMENT '第一种规格 网络类型 4G全网通,5G全网通',
  `spec2` varchar(20) NOT NULL DEFAULT '' COMMENT '第二种规格 版本类型 中国大陆',
  `spec3` varchar(20) NOT NULL DEFAULT '' COMMENT '第三种规格 官方标配,快充套装,耳机套餐',
  `images` varchar(250) NOT NULL DEFAULT '' COMMENT '商品主图',
  `saleable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否上架 0=下架;1=上架;',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '商品状态 0=正常;1=停采;2=淘汰;3=停售;',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `attr1` varchar(20) NOT NULL DEFAULT '' COMMENT '第一种属性',
  `attr2` varchar(20) NOT NULL DEFAULT '' COMMENT '第二种属性',
  `attr3` varchar(20) NOT NULL DEFAULT '' COMMENT '第三种属性',
  `attr4` varchar(20) NOT NULL DEFAULT '' COMMENT '第四种属性',
  `attr5` varchar(20) NOT NULL DEFAULT '' COMMENT '第五种属性',
  `attr6` varchar(20) NOT NULL DEFAULT '' COMMENT '第六种属性',
  `attr7` varchar(20) NOT NULL DEFAULT '' COMMENT '第七种属性',
  `attr8` varchar(20) NOT NULL DEFAULT '' COMMENT '第八种属性',
  `attr9` varchar(20) NOT NULL DEFAULT '' COMMENT '第九种属性',
  `attr10` varchar(20) NOT NULL DEFAULT '' COMMENT '第十种属性',
  `attr11` varchar(20) NOT NULL DEFAULT '' COMMENT '第十一种属性',
  `attr12` varchar(20) NOT NULL DEFAULT '' COMMENT '第十二种属性',
  `attr13` varchar(20) NOT NULL DEFAULT '' COMMENT '第十三种属性',
  `attr14` varchar(20) NOT NULL DEFAULT '' COMMENT '第十四种属性',
  `attr15` varchar(20) NOT NULL DEFAULT '' COMMENT '第十五种属性',
  `sort` bigint(20) unsigned NOT NULL DEFAULT '50000' COMMENT '排序 DESC',
  `free_freight` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否包邮 0=不包邮;1=包邮;',
  `small_unit` varchar(10) NOT NULL DEFAULT '' COMMENT '小单位',
  `medium_unit` varchar(10) NOT NULL DEFAULT '' COMMENT '中单位',
  `medium_ratio` decimal(21,6) unsigned NOT NULL DEFAULT '1.000000' COMMENT '中单位换算关系',
  `large_unit` varchar(10) NOT NULL DEFAULT '' COMMENT '大单位',
  `large_ratio` decimal(21,6) unsigned NOT NULL DEFAULT '1.000000' COMMENT '大单位换算关系',
  `sales_unit` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '销售单位 1=小单位;2=中单位;3=大单位;',
  `base_unit_min_order` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '最低起订小单位数量 单位为小单位',
  `keyword` varchar(20) NOT NULL DEFAULT '' COMMENT '搜索关键词 空格分隔',
  `is_subsidiary` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为辅料商品 0=普通商品;1=辅料商品;',
  `shelf_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '商品上架时间',
  `product_model` varchar(30) NOT NULL DEFAULT '' COMMENT '商品型号',
  `location_no` varchar(30) NOT NULL DEFAULT '' COMMENT '货位号',
  `small_barcode` varchar(20) NOT NULL DEFAULT '' COMMENT '小单位条形码',
  `medium_barcode` varchar(20) NOT NULL DEFAULT '' COMMENT '中单位条形码',
  `large_barcode` varchar(20) NOT NULL DEFAULT '' COMMENT '大单位条形码',
  `small_sales_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '小单位销售价格 又名配送价',
  `small_purchase_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '小单位进货价格 又名成本价',
  `small_market_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '小单位市场价格 又名全国统一零售价',
  `small_min_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '小单位最低价格 销售价低于此价格不能下单',
  `small_max_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '小单位最高价格 销售价高于此价格不能下单',
  `medium_sales_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '中单位销售价格 又名配送价',
  `medium_purchase_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '中单位进货价格 又名成本价',
  `medium_market_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '中单位市场价格 又名全国统一零售价',
  `medium_min_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '中单位最低价格 销售价低于此价格不能下单',
  `medium_max_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '中单位最高价格 销售价高于此价格不能下单',
  `large_sales_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '大单位销售价格 又名配送价',
  `large_purchase_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '大单位进货价格 又名成本价',
  `large_market_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '大单位市场价格 又名全国统一零售价',
  `large_min_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '大单位最低价格 销售价低于此价格不能下单',
  `large_max_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '大单位最高价格 销售价高于此价格不能下单',
  `is_spu` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为主商品 0=否;1=是;',
  `is_new` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为新品 0=否;1=是;',
  `is_hot` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为热销商品 0=否;1=是;',
  `is_special` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为特价商品 商品折扣 0=普通商品;1=特价商品;',
  `discount` decimal(21,6) unsigned NOT NULL DEFAULT '1.000000' COMMENT '折扣率 取值范围为0-1',
  `discount_start` date NOT NULL DEFAULT '1000-01-01' COMMENT '折扣开始时间',
  `discount_end` date NOT NULL DEFAULT '9999-01-01' COMMENT '折扣结束时间',
  `is_pre_sale` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为预售商品 0=否;1=是;',
  `is_client_star_discount` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否参与客户星级折扣 0=否;1=是;',
  `auto_shelf_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '自动上架时间',
  `auto_off_shelf_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '自动下架时间',
  `estimated_arrival_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '预计到货时间',
  `snapshot_version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '快照版本号',
  `brand_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商品品牌',
  `category_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商品分类',
  `category_level1` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商品一级分类',
  `category_level2` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商品二级分类',
  `supplier_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '供应商',
  `template_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '规格模板',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_sku_no` (`platform_id`,`company_id`,`sku_no`) USING BTREE COMMENT '规格编号',
  UNIQUE KEY `uniq_spec` (`platform_id`,`company_id`,`spu_no`,`color`,`size`,`spec1`,`spec2`,`spec3`) USING BTREE COMMENT '规格',
  KEY `key_spu_no` (`spu_no`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品表SKU';

-- ----------------------------
-- Records of product2
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for product_brand
-- ----------------------------
DROP TABLE IF EXISTS `product_brand`;
CREATE TABLE `product_brand` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `brand_no` varchar(50) NOT NULL DEFAULT '' COMMENT '商品品牌编号',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品品牌名字',
  `searching` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否用于搜索过滤 0=否;1=是;',
  `images` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_id` (`platform_id`,`company_id`,`brand_no`,`delete_at`) USING BTREE COMMENT '品牌编号'
) ENGINE=InnoDB AUTO_INCREMENT=52741003664297985 DEFAULT CHARSET=utf8 COMMENT='商品品牌';

-- ----------------------------
-- Records of product_brand
-- ----------------------------
BEGIN;
INSERT INTO `product_brand` (`id`, `platform_id`, `company_id`, `brand_no`, `name`, `searching`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (52740856398090240, 100000, 100100, 'qpl', '七匹狼', 1, '', '2023-07-29 04:53:20', '2023-07-29 04:53:20', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_brand` (`id`, `platform_id`, `company_id`, `brand_no`, `name`, `searching`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (52740951021588480, 100000, 100100, 'dslr', '都市丽人', 1, 'product-brand/100100/1a8ec8b8-2a1c-55f7-b048-32f494c7b4d0.jpeg', '2023-07-29 04:53:42', '2023-09-20 00:35:37', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_brand` (`id`, `platform_id`, `company_id`, `brand_no`, `name`, `searching`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (52741003664297984, 100000, 100100, 'xzl', '喜之郎', 1, '', '2023-07-29 04:53:55', '2023-07-29 04:53:55', 0, 4145731145437184, 4145731145437184, 0);
COMMIT;

-- ----------------------------
-- Table structure for product_brand1
-- ----------------------------
DROP TABLE IF EXISTS `product_brand1`;
CREATE TABLE `product_brand1` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `brand_no` varchar(50) NOT NULL DEFAULT '' COMMENT '商品品牌编号',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品品牌名字',
  `searching` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否用于搜索过滤 0=否;1=是;',
  `images` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_id` (`platform_id`,`company_id`,`brand_no`,`delete_at`) USING BTREE COMMENT '品牌编号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品品牌';

-- ----------------------------
-- Records of product_brand1
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for product_brand2
-- ----------------------------
DROP TABLE IF EXISTS `product_brand2`;
CREATE TABLE `product_brand2` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `brand_no` varchar(50) NOT NULL DEFAULT '' COMMENT '商品品牌编号',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品品牌名字',
  `searching` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否用于搜索过滤 0=否;1=是;',
  `images` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_id` (`platform_id`,`company_id`,`brand_no`,`delete_at`) USING BTREE COMMENT '品牌编号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品品牌';

-- ----------------------------
-- Records of product_brand2
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for product_category
-- ----------------------------
DROP TABLE IF EXISTS `product_category`;
CREATE TABLE `product_category` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `category_no` varchar(50) NOT NULL DEFAULT '' COMMENT '商品分类编号',
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父级分类ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品分类名字',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '分类级别 1=一级;2=二级;3=三级;',
  `searching` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否用于搜索过滤 0=否;1=是;',
  `sort` bigint(20) unsigned NOT NULL DEFAULT '50000' COMMENT '排序 DESC',
  `brand_no` varchar(50) NOT NULL DEFAULT '' COMMENT '分类品牌 公司内部多个主品牌',
  `max_order_number` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '分类最大订购数量提醒',
  `letter` char(1) NOT NULL DEFAULT '' COMMENT '首字母',
  `images` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_id` (`platform_id`,`company_id`,`category_no`,`delete_at`) USING BTREE COMMENT '分类编号'
) ENGINE=InnoDB AUTO_INCREMENT=95129930391752705 DEFAULT CHARSET=utf8 COMMENT='商品分类';

-- ----------------------------
-- Records of product_category
-- ----------------------------
BEGIN;
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40009457169731584, 100000, 100100, '1000', 0, '数码', 1, 0, 50000, '', 0, '', '', '2023-06-24 01:43:20', '2023-06-24 01:54:41', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40010371620278272, 100000, 100100, '10001002', 40009457169731584, '数码配件', 2, 1, 50000, '', 0, '', '', '2023-06-24 01:46:59', '2023-06-24 01:54:45', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40010653527838720, 100000, 100100, '10001001', 40009457169731584, '数码摄影', 2, 1, 50000, '', 0, '', '', '2023-06-24 01:48:06', '2023-06-24 01:54:47', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40011186917478400, 100000, 100100, '10001003', 40009457169731584, '智能设备', 2, 1, 50000, '', 0, '', '', '2023-06-24 01:50:13', '2023-06-24 01:54:50', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40011274691678208, 100000, 100100, '10001004', 40009457169731584, '电子教育', 2, 1, 50000, '', 0, '', '', '2023-06-24 01:50:34', '2023-06-24 01:54:53', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40011340798103552, 100000, 100100, '10001005', 40009457169731584, '数码维修', 2, 1, 50000, '', 0, '', '', '2023-06-24 01:50:50', '2023-06-24 01:54:57', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40011971898249216, 100000, 100100, '100010011001', 40010653527838720, '数码相机', 3, 1, 50000, '', 0, '', '', '2023-06-24 01:53:20', '2023-06-24 01:55:01', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40012794040553472, 100000, 100100, '100010011002', 40010653527838720, '微单相机', 3, 1, 50000, '', 0, '', '', '2023-06-24 01:56:36', '2023-06-24 01:56:36', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40012936630112256, 100000, 100100, '100010011003', 40010653527838720, '单反相机', 3, 1, 50000, '', 0, '', '', '2023-06-24 01:57:10', '2023-06-24 01:57:10', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40012977486827520, 100000, 100100, '100010011004', 40010653527838720, '运动相机', 3, 1, 50000, '', 0, '', '', '2023-06-24 01:57:20', '2023-06-24 01:57:20', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40013044503416832, 100000, 100100, '100010011006', 40010653527838720, '镜头', 3, 1, 50000, '', 0, '', '', '2023-06-24 01:57:36', '2023-06-24 01:57:36', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40013122202898432, 100000, 100100, '100010011007', 40010653527838720, '户外器材', 3, 1, 50000, '', 0, '', '', '2023-06-24 01:57:55', '2023-06-24 01:57:55', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40014048267472896, 100000, 100100, '100010021001', 40010371620278272, '锂电池', 3, 1, 50000, '', 0, '', '', '2023-06-24 02:01:36', '2023-06-24 02:01:36', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40014106467635200, 100000, 100100, '100010021002', 40010371620278272, '单反镜头', 3, 1, 50000, '', 0, '', '', '2023-06-24 02:01:50', '2023-06-24 02:01:50', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40014179792457728, 100000, 100100, '100010021003', 40010371620278272, '二级充电线', 3, 1, 50000, '', 0, '', 'product-category/100100/5672d0b2-fbcd-5336-b152-f90918ea7b50.jpeg', '2023-06-24 02:02:07', '2023-11-23 03:28:14', 0, 4145731145437184, 1, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40014257965895680, 100000, 100100, '100010021004', 40010371620278272, '充电器', 3, 1, 50000, '', 0, '', '', '2023-06-24 02:02:26', '2023-06-24 02:02:26', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40014580579176448, 100000, 100100, '100010041001', 40011274691678208, '早教机', 3, 1, 50000, '', 0, '', '', '2023-06-24 02:03:43', '2023-06-24 02:03:43', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40014634685698048, 100000, 100100, '100010041002', 40011274691678208, '收音机', 3, 1, 50000, '', 0, '', '', '2023-06-24 02:03:56', '2023-06-24 02:03:56', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40014685017346048, 100000, 100100, '100010041003', 40011274691678208, '故事机', 3, 1, 50000, '', 0, '', '', '2023-06-24 02:04:08', '2023-06-24 02:04:08', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40021167695859712, 100000, 100100, '1001', 0, '服饰内衣', 1, 1, 50000, '', 0, '', 'product-category/100100/d901f079-8600-5036-b316-93567ebc7235.jpg', '2023-06-24 02:29:54', '2023-10-20 04:20:22', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40021341079998464, 100000, 100100, '10011001', 40021167695859712, '女装', 2, 1, 50000, '', 0, '', '', '2023-06-24 02:30:36', '2023-06-24 02:30:36', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40021372600193024, 100000, 100100, '10011002', 40021167695859712, '男装', 2, 1, 50000, '', 0, '', '', '2023-06-24 02:30:43', '2023-06-24 02:30:43', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40021442565378048, 100000, 100100, '10011003', 40021167695859712, '内衣', 2, 1, 50000, '', 0, '', '', '2023-06-24 02:31:00', '2023-06-24 02:31:00', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40021786003378176, 100000, 100100, '100110031001', 40021442565378048, '吊带', 3, 1, 50000, '', 0, '', '', '2023-06-24 02:32:22', '2023-06-24 02:32:22', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40021847001141248, 100000, 100100, '100110031002', 40021442565378048, '常规', 3, 1, 50000, '', 0, '', '', '2023-06-24 02:32:37', '2023-06-24 02:32:37', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40021888721883136, 100000, 100100, '100110031003', 40021442565378048, '三角裤', 3, 1, 50000, '', 0, '', '', '2023-06-24 02:32:46', '2023-06-24 02:32:46', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40022004992184320, 100000, 100100, '100110031004', 40021442565378048, '地板袜', 3, 1, 50000, '', 0, '', '', '2023-06-24 02:33:14', '2023-06-24 02:33:14', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40022074164645888, 100000, 100100, '100110031005', 40021442565378048, '隐形袜', 3, 1, 50000, '', 0, '', '', '2023-06-24 02:33:31', '2023-06-24 02:33:31', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40022193161244672, 100000, 100100, '100110031006', 40021442565378048, '平角裤', 3, 1, 50000, '', 0, '', 'product-category/100100/a56ba9e2-852e-592d-869b-ee23635b3826.jpeg', '2023-06-24 02:33:59', '2023-10-20 04:20:04', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40022230977089536, 100000, 100100, '100110031007', 40021442565378048, '丁字/T裤', 3, 1, 50000, '', 0, '', '', '2023-06-24 02:34:08', '2023-06-24 02:34:08', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40022279610044416, 100000, 100100, '100110031008', 40021442565378048, '五趾袜', 3, 1, 50000, '', 0, '', 'product-category/100100/09f3153c-b05b-5eec-be8d-e068224c1e0b.jpeg', '2023-06-24 02:34:20', '2023-11-23 03:27:57', 0, 4145731145437184, 1, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (95124230051598336, 100000, 100100, '1003', 0, '一级分类', 1, 1, 50000, '', 0, '', 'product-category/100100/e63986e1-c4d0-5d2e-9200-4e0e7b2fbf6d.jpg', '2023-11-23 03:49:43', '2023-11-23 03:49:55', 0, 1, 1, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (95129762598621184, 100000, 100100, '10007', 0, '二级分类', 1, 1, 50000, '', 0, '', 'product-category/100100/fb874b23-3a75-5f87-a9ce-1f354564cf52.jpg', '2023-11-23 04:11:42', '2023-11-23 05:39:24', 0, 1, 1, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (95129875656085504, 100000, 100100, '100060001', 95129762598621184, '二级子分类1', 2, 1, 50000, '', 0, '', 'product-category/100100/5eb03c57-2b0e-5b37-9bb3-1dacb5d6e225.jpeg', '2023-11-23 04:12:09', '2023-11-23 05:39:10', 0, 1, 1, 0);
INSERT INTO `product_category` (`id`, `platform_id`, `company_id`, `category_no`, `parent_id`, `name`, `level`, `searching`, `sort`, `brand_no`, `max_order_number`, `letter`, `images`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (95129930391752704, 100000, 100100, '100063333', 95129762598621184, '二级子分类2', 2, 1, 50000, '', 0, '', 'product-category/100100/6e31408a-b3e6-58b5-a3f0-b8151157a697.jpg', '2023-11-23 04:12:22', '2023-11-23 05:38:53', 0, 1, 1, 0);
COMMIT;

-- ----------------------------
-- Table structure for product_category1
-- ----------------------------
DROP TABLE IF EXISTS `product_category1`;
CREATE TABLE `product_category1` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `category_no` varchar(50) NOT NULL DEFAULT '' COMMENT '商品分类编号',
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父级分类ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品分类名字',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '分类级别 1=一级;2=二级;3=三级;',
  `searching` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否用于搜索过滤 0=否;1=是;',
  `sort` bigint(20) unsigned NOT NULL DEFAULT '50000' COMMENT '排序 DESC',
  `brand_no` varchar(50) NOT NULL DEFAULT '' COMMENT '分类品牌 公司内部多个主品牌',
  `max_order_number` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '分类最大订购数量提醒',
  `letter` char(1) NOT NULL DEFAULT '' COMMENT '首字母',
  `images` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_id` (`platform_id`,`company_id`,`category_no`,`delete_at`) USING BTREE COMMENT '分类编号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品分类';

-- ----------------------------
-- Records of product_category1
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for product_category2
-- ----------------------------
DROP TABLE IF EXISTS `product_category2`;
CREATE TABLE `product_category2` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `category_no` varchar(50) NOT NULL DEFAULT '' COMMENT '商品分类编号',
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父级分类ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品分类名字',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '分类级别 1=一级;2=二级;3=三级;',
  `searching` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否用于搜索过滤 0=否;1=是;',
  `sort` bigint(20) unsigned NOT NULL DEFAULT '50000' COMMENT '排序 DESC',
  `brand_no` varchar(50) NOT NULL DEFAULT '' COMMENT '分类品牌 公司内部多个主品牌',
  `max_order_number` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '分类最大订购数量提醒',
  `letter` char(1) NOT NULL DEFAULT '' COMMENT '首字母',
  `images` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_id` (`platform_id`,`company_id`,`category_no`,`delete_at`) USING BTREE COMMENT '分类编号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品分类';

-- ----------------------------
-- Records of product_category2
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for product_content
-- ----------------------------
DROP TABLE IF EXISTS `product_content`;
CREATE TABLE `product_content` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `description` text NOT NULL COMMENT '商品描述信息',
  `packing_list` varchar(300) NOT NULL DEFAULT '' COMMENT '包装清单',
  `after_service` varchar(300) NOT NULL DEFAULT '' COMMENT '售后服务',
  `attr_custom` text NOT NULL COMMENT '自定义属性',
  `product_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '产品ID',
  `images_list` text NOT NULL COMMENT '图片',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `key_product_id` (`product_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=89377223018156033 DEFAULT CHARSET=utf8 COMMENT='产品内容表';

-- ----------------------------
-- Records of product_content
-- ----------------------------
BEGIN;
INSERT INTO `product_content` (`id`, `platform_id`, `company_id`, `description`, `packing_list`, `after_service`, `attr_custom`, `product_id`, `images_list`) VALUES (52739065052794880, 100000, 100100, '', '', '', '', 52739064255877120, '');
INSERT INTO `product_content` (`id`, `platform_id`, `company_id`, `description`, `packing_list`, `after_service`, `attr_custom`, `product_id`, `images_list`) VALUES (52739065069572096, 100000, 100100, '', '', '', '', 52739064411066368, 'product/100100/b8ccd99e-193c-5930-8af9-58572cbc985f.jpg');
INSERT INTO `product_content` (`id`, `platform_id`, `company_id`, `description`, `packing_list`, `after_service`, `attr_custom`, `product_id`, `images_list`) VALUES (52739065082155008, 100000, 100100, '', '', '', '', 52739064524312576, 'product/100100/044d41c3-6423-51ba-98f4-0d5636bcf552.jpg');
INSERT INTO `product_content` (`id`, `platform_id`, `company_id`, `description`, `packing_list`, `after_service`, `attr_custom`, `product_id`, `images_list`) VALUES (52739065098932224, 100000, 100100, '', '', '', '', 52739064654336000, 'product/100100/11be79c0-b283-5336-b4d9-451e5fa9b9ea.jpg,product/100100/1d3d5804-f921-5cf5-a7aa-2b3bb60f7414.jpg,product/100100/d33b2edf-50bd-5ad8-9856-f098e8613ed0.jpeg,product/100100/637e94fa-4697-5d52-897c-86b2720327f3.jpg');
INSERT INTO `product_content` (`id`, `platform_id`, `company_id`, `description`, `packing_list`, `after_service`, `attr_custom`, `product_id`, `images_list`) VALUES (89376927130980352, 100000, 100100, '', '', '', '', 89376926845767680, '');
INSERT INTO `product_content` (`id`, `platform_id`, `company_id`, `description`, `packing_list`, `after_service`, `attr_custom`, `product_id`, `images_list`) VALUES (89377222913298432, 100000, 100100, '', '', '', '', 89377221780836352, '');
INSERT INTO `product_content` (`id`, `platform_id`, `company_id`, `description`, `packing_list`, `after_service`, `attr_custom`, `product_id`, `images_list`) VALUES (89377222946852864, 100000, 100100, '', '', '', '', 89377222007328768, '');
INSERT INTO `product_content` (`id`, `platform_id`, `company_id`, `description`, `packing_list`, `after_service`, `attr_custom`, `product_id`, `images_list`) VALUES (89377222984601600, 100000, 100100, '', '', '', '', 89377222208655360, 'product/100100/743443ee-0233-5afe-990b-9d2a600629c8.jpeg');
INSERT INTO `product_content` (`id`, `platform_id`, `company_id`, `description`, `packing_list`, `after_service`, `attr_custom`, `product_id`, `images_list`) VALUES (89377223018156032, 100000, 100100, '', '', '', '', 89377222460313600, '');
COMMIT;

-- ----------------------------
-- Table structure for product_content1
-- ----------------------------
DROP TABLE IF EXISTS `product_content1`;
CREATE TABLE `product_content1` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `description` text NOT NULL COMMENT '商品描述信息',
  `packing_list` varchar(300) NOT NULL DEFAULT '' COMMENT '包装清单',
  `after_service` varchar(300) NOT NULL DEFAULT '' COMMENT '售后服务',
  `attr_custom` text NOT NULL COMMENT '自定义属性',
  `product_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '产品ID',
  `images_list` text NOT NULL COMMENT '图片',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `key_product_id` (`product_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品内容表';

-- ----------------------------
-- Records of product_content1
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for product_content2
-- ----------------------------
DROP TABLE IF EXISTS `product_content2`;
CREATE TABLE `product_content2` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `description` text NOT NULL COMMENT '商品描述信息',
  `packing_list` varchar(300) NOT NULL DEFAULT '' COMMENT '包装清单',
  `after_service` varchar(300) NOT NULL DEFAULT '' COMMENT '售后服务',
  `attr_custom` text NOT NULL COMMENT '自定义属性',
  `product_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '产品ID',
  `images_list` text NOT NULL COMMENT '图片',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `key_product_id` (`product_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品内容表';

-- ----------------------------
-- Records of product_content2
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for product_extend
-- ----------------------------
DROP TABLE IF EXISTS `product_extend`;
CREATE TABLE `product_extend` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `color_name` varchar(30) NOT NULL DEFAULT '' COMMENT '颜色名字',
  `size_name` varchar(30) NOT NULL DEFAULT '' COMMENT '尺码名字',
  `spec1_name` varchar(30) NOT NULL DEFAULT '' COMMENT '第一种规格名字',
  `spec2_name` varchar(30) NOT NULL DEFAULT '' COMMENT '第二种规格名字',
  `spec3_name` varchar(30) NOT NULL DEFAULT '' COMMENT '第三种规格名字',
  `attr1_name` varchar(50) NOT NULL COMMENT '第一种属性名字',
  `attr2_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第二种属性名字',
  `attr3_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第三种属性名字',
  `attr4_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第四种属性名字',
  `attr5_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第五种属性名字',
  `attr6_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第六种属性名字',
  `attr7_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第七种属性名字',
  `attr8_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第八种属性名字',
  `attr9_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第九种属性名字',
  `attr10_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第十种属性名字',
  `attr11_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第十一种属性名字',
  `attr12_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第十二种属性名字',
  `attr13_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第十三种属性名字',
  `attr14_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第十四种属性名字',
  `attr15_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第十五种属性名字',
  `weight` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '重量 千克',
  `volume` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '体积 立方米',
  `freight_unit` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '运费单位 1=小单位;2=中单位;3=大单位;',
  `purchase_unit` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '采购单位 1=小单位;2=中单位;3=大单位;',
  `production_place` varchar(25) NOT NULL DEFAULT '' COMMENT '产地',
  `shelf_life` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '保质期',
  `shelf_life_unit` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '保质期单位 0=天;1=月;2=年;',
  `small_multiple` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '小单位订货倍数 单位整数',
  `medium_multiple` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '中单位订货倍数 单位整数',
  `large_multiple` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '大单位订货倍数 单位整数',
  `year` varchar(20) NOT NULL DEFAULT '' COMMENT '生产年份',
  `safety_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '安全库存',
  `min_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '最低库存',
  `max_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '最高库存',
  `product_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '产品ID',
  PRIMARY KEY (`id`),
  KEY `key_product_id` (`product_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=89377222888132609 DEFAULT CHARSET=utf8 COMMENT='产品扩展表';

-- ----------------------------
-- Records of product_extend
-- ----------------------------
BEGIN;
INSERT INTO `product_extend` (`id`, `platform_id`, `company_id`, `color_name`, `size_name`, `spec1_name`, `spec2_name`, `spec3_name`, `attr1_name`, `attr2_name`, `attr3_name`, `attr4_name`, `attr5_name`, `attr6_name`, `attr7_name`, `attr8_name`, `attr9_name`, `attr10_name`, `attr11_name`, `attr12_name`, `attr13_name`, `attr14_name`, `attr15_name`, `weight`, `volume`, `freight_unit`, `purchase_unit`, `production_place`, `shelf_life`, `shelf_life_unit`, `small_multiple`, `medium_multiple`, `large_multiple`, `year`, `safety_inventory`, `min_inventory`, `max_inventory`, `product_id`) VALUES (52739064855662592, 100000, 100100, '[\"颜色\",\"红色\"]', '[\"尺码\",\"M\"]', '[\"罩杯\",\"C\"]', '', '', '[\"系列\",\"时尚蕾丝\"]', '[\"面料\",\"超薄\"]', '[\"型号\",\"G7青春版（全网通）\"]', '', '', '', '', '', '', '', '', '', '', '', '', 0.000000, 0.000000, 1, 1, '', 0, 0, 0, 0, 0, '', 0.000000, 0.000000, 0.000000, 52739064255877120);
INSERT INTO `product_extend` (`id`, `platform_id`, `company_id`, `color_name`, `size_name`, `spec1_name`, `spec2_name`, `spec3_name`, `attr1_name`, `attr2_name`, `attr3_name`, `attr4_name`, `attr5_name`, `attr6_name`, `attr7_name`, `attr8_name`, `attr9_name`, `attr10_name`, `attr11_name`, `attr12_name`, `attr13_name`, `attr14_name`, `attr15_name`, `weight`, `volume`, `freight_unit`, `purchase_unit`, `production_place`, `shelf_life`, `shelf_life_unit`, `small_multiple`, `medium_multiple`, `large_multiple`, `year`, `safety_inventory`, `min_inventory`, `max_inventory`, `product_id`) VALUES (52739064910188544, 100000, 100100, '[\"颜色\",\"黑色\"]', '[\"尺码\",\"M\"]', '[\"罩杯\",\"D\"]', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0.000000, 0.000000, 1, 1, '', 0, 0, 0, 0, 0, '', 0.000000, 0.000000, 0.000000, 52739064411066368);
INSERT INTO `product_extend` (`id`, `platform_id`, `company_id`, `color_name`, `size_name`, `spec1_name`, `spec2_name`, `spec3_name`, `attr1_name`, `attr2_name`, `attr3_name`, `attr4_name`, `attr5_name`, `attr6_name`, `attr7_name`, `attr8_name`, `attr9_name`, `attr10_name`, `attr11_name`, `attr12_name`, `attr13_name`, `attr14_name`, `attr15_name`, `weight`, `volume`, `freight_unit`, `purchase_unit`, `production_place`, `shelf_life`, `shelf_life_unit`, `small_multiple`, `medium_multiple`, `large_multiple`, `year`, `safety_inventory`, `min_inventory`, `max_inventory`, `product_id`) VALUES (52739064935354368, 100000, 100100, '[\"颜色\",\"红色\"]', '[\"尺码\",\"XL\"]', '[\"罩杯\",\"D\"]', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0.000000, 0.000000, 1, 1, '', 0, 0, 0, 0, 0, '', 0.000000, 0.000000, 0.000000, 52739064524312576);
INSERT INTO `product_extend` (`id`, `platform_id`, `company_id`, `color_name`, `size_name`, `spec1_name`, `spec2_name`, `spec3_name`, `attr1_name`, `attr2_name`, `attr3_name`, `attr4_name`, `attr5_name`, `attr6_name`, `attr7_name`, `attr8_name`, `attr9_name`, `attr10_name`, `attr11_name`, `attr12_name`, `attr13_name`, `attr14_name`, `attr15_name`, `weight`, `volume`, `freight_unit`, `purchase_unit`, `production_place`, `shelf_life`, `shelf_life_unit`, `small_multiple`, `medium_multiple`, `large_multiple`, `year`, `safety_inventory`, `min_inventory`, `max_inventory`, `product_id`) VALUES (52739064952131584, 100000, 100100, '[\"颜色\",\"红色\"]', '[\"尺码\",\"M\"]', '[\"罩杯\",\"D\"]', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0.000000, 0.000000, 1, 1, '', 0, 0, 0, 0, 0, '', 0.000000, 0.000000, 0.000000, 52739064654336000);
INSERT INTO `product_extend` (`id`, `platform_id`, `company_id`, `color_name`, `size_name`, `spec1_name`, `spec2_name`, `spec3_name`, `attr1_name`, `attr2_name`, `attr3_name`, `attr4_name`, `attr5_name`, `attr6_name`, `attr7_name`, `attr8_name`, `attr9_name`, `attr10_name`, `attr11_name`, `attr12_name`, `attr13_name`, `attr14_name`, `attr15_name`, `weight`, `volume`, `freight_unit`, `purchase_unit`, `production_place`, `shelf_life`, `shelf_life_unit`, `small_multiple`, `medium_multiple`, `large_multiple`, `year`, `safety_inventory`, `min_inventory`, `max_inventory`, `product_id`) VALUES (89376927076454400, 100000, 100100, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0.000000, 0.000000, 1, 1, '', 0, 0, 0, 0, 0, '', 0.000000, 0.000000, 0.000000, 89376926845767680);
INSERT INTO `product_extend` (`id`, `platform_id`, `company_id`, `color_name`, `size_name`, `spec1_name`, `spec2_name`, `spec3_name`, `attr1_name`, `attr2_name`, `attr3_name`, `attr4_name`, `attr5_name`, `attr6_name`, `attr7_name`, `attr8_name`, `attr9_name`, `attr10_name`, `attr11_name`, `attr12_name`, `attr13_name`, `attr14_name`, `attr15_name`, `weight`, `volume`, `freight_unit`, `purchase_unit`, `production_place`, `shelf_life`, `shelf_life_unit`, `small_multiple`, `medium_multiple`, `large_multiple`, `year`, `safety_inventory`, `min_inventory`, `max_inventory`, `product_id`) VALUES (89377222783275008, 100000, 100100, '[\"颜色\",\"灰紫色\"]', '[\"尺码\",\"M\"]', '[\"罩杯\",\"C\"]', '[\"类型\",\"中国大陆\"]', '[\"套餐\",\"豪华套餐\"]', '[\"厚度\",\"厚厚\"]', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0.000000, 0.000000, 1, 1, '', 0, 0, 0, 0, 0, '', 0.000000, 0.000000, 0.000000, 89377221780836352);
INSERT INTO `product_extend` (`id`, `platform_id`, `company_id`, `color_name`, `size_name`, `spec1_name`, `spec2_name`, `spec3_name`, `attr1_name`, `attr2_name`, `attr3_name`, `attr4_name`, `attr5_name`, `attr6_name`, `attr7_name`, `attr8_name`, `attr9_name`, `attr10_name`, `attr11_name`, `attr12_name`, `attr13_name`, `attr14_name`, `attr15_name`, `weight`, `volume`, `freight_unit`, `purchase_unit`, `production_place`, `shelf_life`, `shelf_life_unit`, `small_multiple`, `medium_multiple`, `large_multiple`, `year`, `safety_inventory`, `min_inventory`, `max_inventory`, `product_id`) VALUES (89377222821023744, 100000, 100100, '[\"颜色\",\"灰紫色\"]', '[\"尺码\",\"M\"]', '[\"罩杯\",\"C\"]', '[\"类型\",\"中国大陆\"]', '[\"套餐\",\"升级套餐\"]', '[\"厚度\",\"厚厚\"]', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0.000000, 0.000000, 1, 1, '', 0, 0, 0, 0, 0, '', 0.000000, 0.000000, 0.000000, 89377222007328768);
INSERT INTO `product_extend` (`id`, `platform_id`, `company_id`, `color_name`, `size_name`, `spec1_name`, `spec2_name`, `spec3_name`, `attr1_name`, `attr2_name`, `attr3_name`, `attr4_name`, `attr5_name`, `attr6_name`, `attr7_name`, `attr8_name`, `attr9_name`, `attr10_name`, `attr11_name`, `attr12_name`, `attr13_name`, `attr14_name`, `attr15_name`, `weight`, `volume`, `freight_unit`, `purchase_unit`, `production_place`, `shelf_life`, `shelf_life_unit`, `small_multiple`, `medium_multiple`, `large_multiple`, `year`, `safety_inventory`, `min_inventory`, `max_inventory`, `product_id`) VALUES (89377222858772480, 100000, 100100, '[\"颜色\",\"灰紫色\"]', '[\"尺码\",\"M\"]', '[\"罩杯\",\"B\"]', '[\"类型\",\"中国大陆\"]', '[\"套餐\",\"豪华套餐\"]', '[\"厚度\",\"厚厚\"]', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0.000000, 0.000000, 1, 1, '', 0, 0, 0, 0, 0, '', 0.000000, 0.000000, 0.000000, 89377222208655360);
INSERT INTO `product_extend` (`id`, `platform_id`, `company_id`, `color_name`, `size_name`, `spec1_name`, `spec2_name`, `spec3_name`, `attr1_name`, `attr2_name`, `attr3_name`, `attr4_name`, `attr5_name`, `attr6_name`, `attr7_name`, `attr8_name`, `attr9_name`, `attr10_name`, `attr11_name`, `attr12_name`, `attr13_name`, `attr14_name`, `attr15_name`, `weight`, `volume`, `freight_unit`, `purchase_unit`, `production_place`, `shelf_life`, `shelf_life_unit`, `small_multiple`, `medium_multiple`, `large_multiple`, `year`, `safety_inventory`, `min_inventory`, `max_inventory`, `product_id`) VALUES (89377222888132608, 100000, 100100, '[\"颜色\",\"灰紫色\"]', '[\"尺码\",\"M\"]', '[\"罩杯\",\"B\"]', '[\"类型\",\"中国大陆\"]', '[\"套餐\",\"升级套餐\"]', '[\"厚度\",\"厚厚\"]', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0.000000, 0.000000, 1, 1, '', 0, 0, 0, 0, 0, '', 0.000000, 0.000000, 0.000000, 89377222460313600);
COMMIT;

-- ----------------------------
-- Table structure for product_extend1
-- ----------------------------
DROP TABLE IF EXISTS `product_extend1`;
CREATE TABLE `product_extend1` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `color_name` varchar(30) NOT NULL DEFAULT '' COMMENT '颜色名字',
  `size_name` varchar(30) NOT NULL DEFAULT '' COMMENT '尺码名字',
  `spec1_name` varchar(30) NOT NULL DEFAULT '' COMMENT '第一种规格名字',
  `spec2_name` varchar(30) NOT NULL DEFAULT '' COMMENT '第二种规格名字',
  `spec3_name` varchar(30) NOT NULL DEFAULT '' COMMENT '第三种规格名字',
  `attr1_name` varchar(50) NOT NULL COMMENT '第一种属性名字',
  `attr2_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第二种属性名字',
  `attr3_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第三种属性名字',
  `attr4_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第四种属性名字',
  `attr5_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第五种属性名字',
  `attr6_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第六种属性名字',
  `attr7_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第七种属性名字',
  `attr8_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第八种属性名字',
  `attr9_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第九种属性名字',
  `attr10_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第十种属性名字',
  `attr11_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第十一种属性名字',
  `attr12_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第十二种属性名字',
  `attr13_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第十三种属性名字',
  `attr14_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第十四种属性名字',
  `attr15_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第十五种属性名字',
  `weight` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '重量 千克',
  `volume` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '体积 立方米',
  `freight_unit` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '运费单位 1=小单位;2=中单位;3=大单位;',
  `purchase_unit` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '采购单位 1=小单位;2=中单位;3=大单位;',
  `production_place` varchar(25) NOT NULL DEFAULT '' COMMENT '产地',
  `shelf_life` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '保质期',
  `shelf_life_unit` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '保质期单位 0=天;1=月;2=年;',
  `small_multiple` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '小单位订货倍数 单位整数',
  `medium_multiple` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '中单位订货倍数 单位整数',
  `large_multiple` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '大单位订货倍数 单位整数',
  `year` varchar(20) NOT NULL DEFAULT '' COMMENT '生产年份',
  `safety_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '安全库存',
  `min_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '最低库存',
  `max_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '最高库存',
  `product_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '产品ID',
  PRIMARY KEY (`id`),
  KEY `key_product_id` (`product_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品扩展表';

-- ----------------------------
-- Records of product_extend1
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for product_extend2
-- ----------------------------
DROP TABLE IF EXISTS `product_extend2`;
CREATE TABLE `product_extend2` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `color_name` varchar(30) NOT NULL DEFAULT '' COMMENT '颜色名字',
  `size_name` varchar(30) NOT NULL DEFAULT '' COMMENT '尺码名字',
  `spec1_name` varchar(30) NOT NULL DEFAULT '' COMMENT '第一种规格名字',
  `spec2_name` varchar(30) NOT NULL DEFAULT '' COMMENT '第二种规格名字',
  `spec3_name` varchar(30) NOT NULL DEFAULT '' COMMENT '第三种规格名字',
  `attr1_name` varchar(50) NOT NULL COMMENT '第一种属性名字',
  `attr2_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第二种属性名字',
  `attr3_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第三种属性名字',
  `attr4_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第四种属性名字',
  `attr5_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第五种属性名字',
  `attr6_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第六种属性名字',
  `attr7_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第七种属性名字',
  `attr8_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第八种属性名字',
  `attr9_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第九种属性名字',
  `attr10_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第十种属性名字',
  `attr11_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第十一种属性名字',
  `attr12_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第十二种属性名字',
  `attr13_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第十三种属性名字',
  `attr14_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第十四种属性名字',
  `attr15_name` varchar(50) NOT NULL DEFAULT '' COMMENT '第十五种属性名字',
  `weight` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '重量 千克',
  `volume` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '体积 立方米',
  `freight_unit` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '运费单位 1=小单位;2=中单位;3=大单位;',
  `purchase_unit` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '采购单位 1=小单位;2=中单位;3=大单位;',
  `production_place` varchar(25) NOT NULL DEFAULT '' COMMENT '产地',
  `shelf_life` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '保质期',
  `shelf_life_unit` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '保质期单位 0=天;1=月;2=年;',
  `small_multiple` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '小单位订货倍数 单位整数',
  `medium_multiple` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '中单位订货倍数 单位整数',
  `large_multiple` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '大单位订货倍数 单位整数',
  `year` varchar(20) NOT NULL DEFAULT '' COMMENT '生产年份',
  `safety_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '安全库存',
  `min_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '最低库存',
  `max_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '最高库存',
  `product_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '产品ID',
  PRIMARY KEY (`id`),
  KEY `key_product_id` (`product_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品扩展表';

-- ----------------------------
-- Records of product_extend2
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for product_snapshot
-- ----------------------------
DROP TABLE IF EXISTS `product_snapshot`;
CREATE TABLE `product_snapshot` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `spu_no` varchar(30) NOT NULL DEFAULT '' COMMENT '产品编号',
  `sku_no` varchar(30) NOT NULL DEFAULT '' COMMENT '规格编号',
  `snapshot_version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  `content` mediumtext NOT NULL COMMENT '快照内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品表SKU快照';

-- ----------------------------
-- Records of product_snapshot
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for product_snapshot1
-- ----------------------------
DROP TABLE IF EXISTS `product_snapshot1`;
CREATE TABLE `product_snapshot1` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `spu_no` varchar(30) NOT NULL DEFAULT '' COMMENT '产品编号',
  `sku_no` varchar(30) NOT NULL DEFAULT '' COMMENT '规格编号',
  `snapshot_version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  `content` mediumtext NOT NULL COMMENT '快照内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品表SKU快照';

-- ----------------------------
-- Records of product_snapshot1
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for product_snapshot2
-- ----------------------------
DROP TABLE IF EXISTS `product_snapshot2`;
CREATE TABLE `product_snapshot2` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `spu_no` varchar(30) NOT NULL DEFAULT '' COMMENT '产品编号',
  `sku_no` varchar(30) NOT NULL DEFAULT '' COMMENT '规格编号',
  `snapshot_version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  `content` mediumtext NOT NULL COMMENT '快照内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品表SKU快照';

-- ----------------------------
-- Records of product_snapshot2
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for product_spec
-- ----------------------------
DROP TABLE IF EXISTS `product_spec`;
CREATE TABLE `product_spec` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `group_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商品规格分组ID',
  `spec_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品规格名字',
  `spec_no` varchar(50) NOT NULL DEFAULT '' COMMENT '商品规格编号',
  `group_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '商品规格分组类型 0=商品规格;1=商品属性;2=商品参数;',
  `searching` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否用于搜索过滤 0=否;1=是;',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  `value_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '值类型 商品属性和商品参数只能是0 0=字符串;1=浮点型;2=整型;3=布尔型;4=多行;5=单选项;6=多选项;',
  `value_type_unit` varchar(20) NOT NULL DEFAULT '' COMMENT '属性单位',
  `value_list` varchar(300) NOT NULL DEFAULT '' COMMENT '选项值列表',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_id` (`platform_id`,`company_id`,`group_id`,`spec_no`,`delete_at`) USING BTREE COMMENT '规格编号'
) ENGINE=InnoDB AUTO_INCREMENT=41179221816643585 DEFAULT CHARSET=utf8 COMMENT='商品规格';

-- ----------------------------
-- Records of product_spec
-- ----------------------------
BEGIN;
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (34073770239070209, 100000, 100100, 34073770239070211, '红色', '10001', 0, 0, '2023-06-09 02:20:06', '2023-06-26 15:30:15', 0, 0, 0, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (34073770239070210, 100000, 100100, 34073770239070211, '军绿色', '10004', 0, 0, '2023-06-09 02:20:06', '2023-06-26 15:30:15', 0, 0, 0, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (34073770239070211, 100000, 100100, 34073770239070211, '灰紫色', '10003', 0, 0, '2023-06-09 02:20:06', '2023-06-26 15:30:15', 0, 0, 0, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (34073770239070212, 100000, 100100, 34073770239070212, 'M', '20001', 0, 0, '2023-06-09 02:20:06', '2023-06-26 15:30:15', 0, 0, 0, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (34073770239070213, 100000, 100100, 34073770239070212, 'XL', '20002', 0, 0, '2023-06-09 02:20:06', '2023-06-26 15:30:15', 0, 0, 0, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (34073770239070214, 100000, 100100, 34073770239070213, 'A', '30001', 0, 0, '2023-06-09 02:20:06', '2023-06-26 15:30:15', 0, 0, 0, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (34073770239070215, 100000, 100100, 34073770239070213, 'B', '30002', 0, 0, '2023-06-09 02:20:06', '2023-06-26 15:30:15', 0, 0, 0, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (34073770239070216, 100000, 100100, 34073770239070213, 'C', '30003', 0, 0, '2023-06-09 02:20:06', '2023-06-26 15:30:15', 0, 0, 0, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (34073770239070217, 100000, 100100, 34073770239070213, 'D', '30004', 0, 0, '2023-06-09 02:20:06', '2023-06-26 15:30:15', 0, 0, 0, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (34073770239070218, 100000, 100100, 34073770239070214, '中国大陆', '40001', 0, 0, '2023-06-09 02:20:06', '2023-06-26 15:30:15', 0, 0, 0, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (34073770239070219, 100000, 100100, 34073770239070214, '德国进口', '40002', 0, 0, '2023-06-09 02:20:06', '2023-06-26 15:30:15', 0, 0, 0, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (34073770239070220, 100000, 100100, 34073770239070215, '标准套餐', '50001', 0, 0, '2023-06-09 02:20:06', '2023-06-26 15:30:15', 0, 0, 0, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (34073770239070221, 100000, 100100, 34073770239070215, '升级套餐', '50002', 0, 0, '2023-06-09 02:20:06', '2023-06-26 15:30:15', 0, 0, 0, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (34073770239070222, 100000, 100100, 34073770239070215, '豪华套餐', '50003', 0, 0, '2023-06-09 02:20:06', '2023-06-26 15:30:15', 0, 0, 0, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (34073770239070223, 100000, 100100, 34073770239070215, '顶级套餐', '50004', 0, 0, '2023-06-09 02:20:06', '2023-06-26 15:30:15', 0, 0, 0, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (34073770239070224, 100000, 100100, 34073770239070211, '不分颜色', '10000', 0, 0, '2023-06-09 02:20:06', '2023-06-26 15:30:15', 0, 0, 0, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (34073770239070225, 100000, 100100, 34073770239070216, '极光', '10001', 0, 0, '2023-06-09 02:20:06', '2023-10-07 01:27:48', 0, 0, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (34073770239070226, 100000, 100100, 34073770239070216, '极夜', '10004', 0, 0, '2023-06-09 02:20:06', '2023-06-26 15:30:15', 0, 0, 0, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (34073770239070227, 100000, 100100, 34073770239070217, '8G+128G', '10001', 0, 0, '2023-06-09 02:20:06', '2023-06-26 15:30:15', 0, 0, 0, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (34073770239070228, 100000, 100100, 34073770239070217, '12G+256G', '10004', 0, 1, '2023-06-09 02:20:06', '2023-07-01 00:41:26', 0, 0, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (40945082525945856, 100000, 100100, 40944811741679616, '厚厚', '114324', 1, 0, '2023-06-26 15:41:08', '2023-06-26 15:41:08', 0, 4145731145437184, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (40945132719181824, 100000, 100100, 40944811741679616, '薄', '14234', 1, 0, '2023-06-26 15:41:20', '2023-06-26 15:41:20', 0, 4145731145437184, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41177261088575488, 100000, 100100, 41174810692292608, '机型', '10011', 2, 0, '2023-06-27 07:03:44', '2023-06-27 07:15:54', 0, 4145731145437184, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41177344316149760, 100000, 100100, 41174810692292608, '入网型号', '111', 2, 0, '2023-06-27 07:04:03', '2023-06-27 09:33:59', 0, 4145731145437184, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41177440772558848, 100000, 100100, 41175121951592448, 'CPU型号', '1', 2, 0, '2023-06-27 07:04:26', '2023-06-27 07:15:54', 0, 4145731145437184, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41177480945602560, 100000, 100100, 41175121951592448, '机身颜色', '2', 2, 0, '2023-06-27 07:04:36', '2023-06-27 07:15:54', 0, 4145731145437184, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41177536486576128, 100000, 100100, 41175121951592448, '机身尺寸', '3', 2, 0, '2023-06-27 07:04:49', '2023-06-28 01:29:30', 0, 4145731145437184, 4145731145437184, 0, 4, 'mm', '[\"宽\",\"长\",\"厚\"]');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41177591968829440, 100000, 100100, 41175121951592448, '机身重量', '33', 2, 0, '2023-06-27 07:05:02', '2023-06-27 09:47:03', 0, 4145731145437184, 4145731145437184, 0, 2, 'g', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41177897477738496, 100000, 100100, 41175286729019392, '存储卡', '1111', 2, 0, '2023-06-27 07:06:15', '2023-06-27 07:15:54', 0, 4145731145437184, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41177962137128960, 100000, 100100, 41175286729019392, '运行内存', '234', 2, 0, '2023-06-27 07:06:31', '2023-06-27 14:16:37', 0, 4145731145437184, 4145731145437184, 0, 5, 'GB', '[8,16,32]');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41177990046027776, 100000, 100100, 41175286729019392, '机身内存', '333', 2, 0, '2023-06-27 07:06:37', '2023-06-27 07:15:54', 0, 4145731145437184, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41178291327078400, 100000, 100100, 41175364814376960, '屏幕刷新率', '11', 2, 0, '2023-06-27 07:07:49', '2023-06-27 07:15:54', 0, 4145731145437184, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41178327591030784, 100000, 100100, 41175364814376960, '屏幕尺寸', '2333', 2, 0, '2023-06-27 07:07:58', '2023-06-27 07:15:54', 0, 4145731145437184, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41178364505100288, 100000, 100100, 41175364814376960, '屏幕分辨率', '3333', 2, 0, '2023-06-27 07:08:07', '2023-06-27 07:15:54', 0, 4145731145437184, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41178392007151616, 100000, 100100, 41175364814376960, '屏幕特色', '33333', 2, 0, '2023-06-27 07:08:13', '2023-06-27 07:15:54', 0, 4145731145437184, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41178418993303552, 100000, 100100, 41175364814376960, '屏幕材质', '343434', 2, 0, '2023-06-27 07:08:20', '2023-06-27 07:15:54', 0, 4145731145437184, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41178513583247360, 100000, 100100, 41175403800432640, '电池容量', '111', 2, 0, '2023-06-27 07:08:42', '2023-06-27 07:15:54', 0, 4145731145437184, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41178558432940032, 100000, 100100, 41175403800432640, '电池可拆卸', '2323', 2, 0, '2023-06-27 07:08:53', '2023-06-27 09:52:32', 0, 4145731145437184, 4145731145437184, 0, 3, '可拆卸', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41178589600813056, 100000, 100100, 41175403800432640, '无线充电', '3333', 2, 0, '2023-06-27 07:09:00', '2023-06-27 09:52:47', 0, 4145731145437184, 4145731145437184, 0, 3, '支持', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41178620395393024, 100000, 100100, 41175403800432640, '充电功率', '333', 2, 0, '2023-06-27 07:09:08', '2023-06-27 07:15:54', 0, 4145731145437184, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41178686111748096, 100000, 100100, 41175483450265600, '系统', '222', 2, 0, '2023-06-27 07:09:23', '2023-06-27 07:15:54', 0, 4145731145437184, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41178747730268160, 100000, 100100, 41175725507743744, '5G网络', '111', 2, 0, '2023-06-27 07:09:38', '2023-06-27 07:15:54', 0, 4145731145437184, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41178785734856704, 100000, 100100, 41175725507743744, '4G网络', '2333', 2, 0, '2023-06-27 07:09:47', '2023-06-27 07:15:54', 0, 4145731145437184, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41178817905168384, 100000, 100100, 41175725507743744, 'SIM卡类型', '3333', 2, 0, '2023-06-27 07:09:55', '2023-06-27 07:15:54', 0, 4145731145437184, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41178860003397632, 100000, 100100, 41175725507743744, '3G/2G网络', '343434', 2, 0, '2023-06-27 07:10:05', '2023-06-27 07:15:54', 0, 4145731145437184, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41178893251645440, 100000, 100100, 41175725507743744, '双卡机类型', '43434', 2, 0, '2023-06-27 07:10:13', '2023-06-27 07:15:54', 0, 4145731145437184, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41178926218874880, 100000, 100100, 41175725507743744, 'SIM卡数量', '3434', 2, 0, '2023-06-27 07:10:21', '2023-06-27 07:15:54', 0, 4145731145437184, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41178983588564992, 100000, 100100, 41175776921522176, '充电接口', '111', 2, 0, '2023-06-27 07:10:34', '2023-06-27 07:15:54', 0, 4145731145437184, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41179015159091200, 100000, 100100, 41175776921522176, '数据接口', '2344', 2, 0, '2023-06-27 07:10:42', '2023-06-27 07:15:54', 0, 4145731145437184, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41179040303943680, 100000, 100100, 41175776921522176, '耳机接口', '3333', 2, 0, '2023-06-27 07:10:48', '2023-06-27 09:50:41', 0, 4145731145437184, 4145731145437184, 0, 1, 'mm', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41179086453870592, 100000, 100100, 41175899990790144, '生物识别', '1111', 2, 0, '2023-06-27 07:10:59', '2023-06-27 07:15:54', 0, 4145731145437184, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41179132981284864, 100000, 100100, 41176012482023424, '后摄主像素', '111', 2, 0, '2023-06-27 07:11:10', '2023-06-27 07:15:54', 0, 4145731145437184, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41179159753527296, 100000, 100100, 41176012482023424, '后摄3-tele像素', '33', 2, 0, '2023-06-27 07:11:16', '2023-06-27 07:15:54', 0, 4145731145437184, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41179188308348928, 100000, 100100, 41176012482023424, '前摄主像素', '34343', 2, 0, '2023-06-27 07:11:23', '2023-06-27 07:15:54', 0, 4145731145437184, 4145731145437184, 0, 0, '', '');
INSERT INTO `product_spec` (`id`, `platform_id`, `company_id`, `group_id`, `spec_name`, `spec_no`, `group_type`, `searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`, `value_type`, `value_type_unit`, `value_list`) VALUES (41179221816643584, 100000, 100100, 41176012482023424, '后摄2-超广角像素', '333', 2, 0, '2023-06-27 07:11:31', '2023-06-27 07:15:54', 0, 4145731145437184, 4145731145437184, 0, 0, '', '');
COMMIT;

-- ----------------------------
-- Table structure for product_spec1
-- ----------------------------
DROP TABLE IF EXISTS `product_spec1`;
CREATE TABLE `product_spec1` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `group_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商品规格分组ID',
  `spec_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品规格名字',
  `spec_no` varchar(50) NOT NULL DEFAULT '' COMMENT '商品规格编号',
  `group_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '商品规格分组类型 0=商品规格;1=商品属性;2=商品参数;',
  `searching` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否用于搜索过滤 0=否;1=是;',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  `value_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '值类型 商品属性和商品参数只能是0 0=字符串;1=浮点型;2=整型;3=布尔型;4=多行;5=单选项;6=多选项;',
  `value_type_unit` varchar(20) NOT NULL DEFAULT '' COMMENT '属性单位',
  `value_list` varchar(300) NOT NULL DEFAULT '' COMMENT '选项值列表',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_id` (`platform_id`,`company_id`,`group_id`,`spec_no`,`delete_at`) USING BTREE COMMENT '规格编号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品规格';

-- ----------------------------
-- Records of product_spec1
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for product_spec2
-- ----------------------------
DROP TABLE IF EXISTS `product_spec2`;
CREATE TABLE `product_spec2` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `group_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '商品规格分组ID',
  `spec_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品规格名字',
  `spec_no` varchar(50) NOT NULL DEFAULT '' COMMENT '商品规格编号',
  `group_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '商品规格分组类型 0=商品规格;1=商品属性;2=商品参数;',
  `searching` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否用于搜索过滤 0=否;1=是;',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  `value_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '值类型 商品属性和商品参数只能是0 0=字符串;1=浮点型;2=整型;3=布尔型;4=多行;5=单选项;6=多选项;',
  `value_type_unit` varchar(20) NOT NULL DEFAULT '' COMMENT '属性单位',
  `value_list` varchar(300) NOT NULL DEFAULT '' COMMENT '选项值列表',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_id` (`platform_id`,`company_id`,`group_id`,`spec_no`,`delete_at`) USING BTREE COMMENT '规格编号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品规格';

-- ----------------------------
-- Records of product_spec2
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for product_spec_group
-- ----------------------------
DROP TABLE IF EXISTS `product_spec_group`;
CREATE TABLE `product_spec_group` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `template_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '模板ID',
  `group_no` varchar(50) NOT NULL DEFAULT '' COMMENT '商品规格分组编号',
  `group_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品规格分组名字',
  `group_sku_field` varchar(50) NOT NULL DEFAULT '' COMMENT '商品规格分组对应的商品存储字段',
  `group_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '商品规格分组类型 0=商品规格;1=商品属性;2=商品参数;',
  `group_searching` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '商品规格分组是否支持搜索 0=否;1=是;',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_id` (`platform_id`,`company_id`,`group_no`,`delete_at`) USING BTREE COMMENT '规格分组编号',
  UNIQUE KEY `uniq_group_sku_field` (`platform_id`,`company_id`,`template_id`,`group_type`,`group_sku_field`,`delete_at`) USING BTREE COMMENT '商品存储字段'
) ENGINE=InnoDB AUTO_INCREMENT=41176012482023425 DEFAULT CHARSET=utf8 COMMENT='商品规格分组';

-- ----------------------------
-- Records of product_spec_group
-- ----------------------------
BEGIN;
INSERT INTO `product_spec_group` (`id`, `platform_id`, `company_id`, `template_id`, `group_no`, `group_name`, `group_sku_field`, `group_type`, `group_searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (34073770239070211, 100000, 100100, 0, 'color', '颜色', 'color', 0, 0, '2023-06-09 02:09:49', '2023-06-26 15:37:47', 0, 0, 0, 0);
INSERT INTO `product_spec_group` (`id`, `platform_id`, `company_id`, `template_id`, `group_no`, `group_name`, `group_sku_field`, `group_type`, `group_searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (34073770239070212, 100000, 100100, 0, 'size', '尺码', 'size', 0, 0, '2023-06-09 02:09:49', '2023-06-26 15:38:05', 0, 0, 0, 0);
INSERT INTO `product_spec_group` (`id`, `platform_id`, `company_id`, `template_id`, `group_no`, `group_name`, `group_sku_field`, `group_type`, `group_searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (34073770239070213, 100000, 100100, 0, 'cup', '罩杯', 'spec1', 0, 0, '2023-06-09 02:09:49', '2023-06-26 15:38:13', 0, 0, 0, 0);
INSERT INTO `product_spec_group` (`id`, `platform_id`, `company_id`, `template_id`, `group_no`, `group_name`, `group_sku_field`, `group_type`, `group_searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (34073770239070214, 100000, 100100, 0, 'type', '类型', 'spec2', 0, 0, '2023-06-09 02:09:49', '2023-06-26 15:38:20', 0, 0, 0, 0);
INSERT INTO `product_spec_group` (`id`, `platform_id`, `company_id`, `template_id`, `group_no`, `group_name`, `group_sku_field`, `group_type`, `group_searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (34073770239070215, 100000, 100100, 0, 'package', '套餐', 'spec3', 0, 0, '2023-06-09 02:09:49', '2023-06-26 15:38:24', 0, 0, 0, 0);
INSERT INTO `product_spec_group` (`id`, `platform_id`, `company_id`, `template_id`, `group_no`, `group_name`, `group_sku_field`, `group_type`, `group_searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (34073770239070216, 100000, 100100, 40037520494432256, 'mobile_color', '颜色', 'color', 0, 0, '2023-06-09 02:09:49', '2023-06-26 15:38:28', 0, 0, 0, 0);
INSERT INTO `product_spec_group` (`id`, `platform_id`, `company_id`, `template_id`, `group_no`, `group_name`, `group_sku_field`, `group_type`, `group_searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (34073770239070217, 100000, 100100, 40037520494432256, 'mobile_version', '版本', 'size', 0, 0, '2023-06-09 02:09:49', '2023-11-06 01:49:50', 0, 0, 4145731145437184, 0);
INSERT INTO `product_spec_group` (`id`, `platform_id`, `company_id`, `template_id`, `group_no`, `group_name`, `group_sku_field`, `group_type`, `group_searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40944811741679616, 100000, 100100, 0, '10005', '厚度', 'attr1', 1, 0, '2023-06-26 15:40:03', '2023-06-26 15:40:03', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_spec_group` (`id`, `platform_id`, `company_id`, `template_id`, `group_no`, `group_name`, `group_sku_field`, `group_type`, `group_searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40944868276703232, 100000, 100100, 0, '10003', '系列', 'attr2', 1, 0, '2023-06-26 15:40:17', '2023-06-26 15:40:17', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_spec_group` (`id`, `platform_id`, `company_id`, `template_id`, `group_no`, `group_name`, `group_sku_field`, `group_type`, `group_searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (41174810692292608, 100000, 100100, 0, 'zt1', '主体', '1', 2, 0, '2023-06-27 06:53:59', '2023-06-27 07:57:21', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_spec_group` (`id`, `platform_id`, `company_id`, `template_id`, `group_no`, `group_name`, `group_sku_field`, `group_type`, `group_searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (41175121951592448, 100000, 100100, 0, 'jb', '基本信息', '2', 2, 0, '2023-06-27 06:55:14', '2023-06-27 07:11:54', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_spec_group` (`id`, `platform_id`, `company_id`, `template_id`, `group_no`, `group_name`, `group_sku_field`, `group_type`, `group_searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (41175286729019392, 100000, 100100, 0, 'cc', '存储', '3', 2, 0, '2023-06-27 06:55:53', '2023-06-27 07:11:56', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_spec_group` (`id`, `platform_id`, `company_id`, `template_id`, `group_no`, `group_name`, `group_sku_field`, `group_type`, `group_searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (41175364814376960, 100000, 100100, 0, 'pm', '屏幕', '4', 2, 0, '2023-06-27 06:56:11', '2023-06-27 07:11:58', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_spec_group` (`id`, `platform_id`, `company_id`, `template_id`, `group_no`, `group_name`, `group_sku_field`, `group_type`, `group_searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (41175403800432640, 100000, 100100, 0, 'dc', '电池信息', '5', 2, 0, '2023-06-27 06:56:21', '2023-06-27 07:12:00', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_spec_group` (`id`, `platform_id`, `company_id`, `template_id`, `group_no`, `group_name`, `group_sku_field`, `group_type`, `group_searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (41175483450265600, 100000, 100100, 0, 'cz0', '操作系统', '6', 2, 0, '2023-06-27 06:56:40', '2023-06-27 07:12:02', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_spec_group` (`id`, `platform_id`, `company_id`, `template_id`, `group_no`, `group_name`, `group_sku_field`, `group_type`, `group_searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (41175725507743744, 100000, 100100, 0, 'wl', '网络支持', '7', 2, 0, '2023-06-27 06:57:37', '2023-06-27 07:12:04', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_spec_group` (`id`, `platform_id`, `company_id`, `template_id`, `group_no`, `group_name`, `group_sku_field`, `group_type`, `group_searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (41175776921522176, 100000, 100100, 0, 'sk00', '数据接口', '8', 2, 0, '2023-06-27 06:57:50', '2023-06-27 07:12:06', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_spec_group` (`id`, `platform_id`, `company_id`, `template_id`, `group_no`, `group_name`, `group_sku_field`, `group_type`, `group_searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (41175899990790144, 100000, 100100, 0, 'xs000', '手机特性', '9', 2, 0, '2023-06-27 06:58:19', '2023-06-27 07:12:07', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_spec_group` (`id`, `platform_id`, `company_id`, `template_id`, `group_no`, `group_name`, `group_sku_field`, `group_type`, `group_searching`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (41176012482023424, 100000, 100100, 0, 'sxy11', '摄像头', '10', 2, 0, '2023-06-27 06:58:46', '2023-06-27 07:12:10', 0, 4145731145437184, 4145731145437184, 0);
COMMIT;

-- ----------------------------
-- Table structure for product_spec_group1
-- ----------------------------
DROP TABLE IF EXISTS `product_spec_group1`;
CREATE TABLE `product_spec_group1` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `template_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '模板ID',
  `group_no` varchar(50) NOT NULL DEFAULT '' COMMENT '商品规格分组编号',
  `group_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品规格分组名字',
  `group_sku_field` varchar(50) NOT NULL DEFAULT '' COMMENT '商品规格分组对应的商品存储字段',
  `group_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '商品规格分组类型 0=商品规格;1=商品属性;2=商品参数;',
  `group_searching` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '商品规格分组是否支持搜索 0=否;1=是;',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_id` (`platform_id`,`company_id`,`group_no`,`delete_at`) USING BTREE COMMENT '规格分组编号',
  UNIQUE KEY `uniq_group_sku_field` (`platform_id`,`company_id`,`template_id`,`group_type`,`group_sku_field`,`delete_at`) USING BTREE COMMENT '商品存储字段'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品规格分组';

-- ----------------------------
-- Records of product_spec_group1
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for product_spec_group2
-- ----------------------------
DROP TABLE IF EXISTS `product_spec_group2`;
CREATE TABLE `product_spec_group2` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `template_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '模板ID',
  `group_no` varchar(50) NOT NULL DEFAULT '' COMMENT '商品规格分组编号',
  `group_name` varchar(50) NOT NULL DEFAULT '' COMMENT '商品规格分组名字',
  `group_sku_field` varchar(50) NOT NULL DEFAULT '' COMMENT '商品规格分组对应的商品存储字段',
  `group_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '商品规格分组类型 0=商品规格;1=商品属性;2=商品参数;',
  `group_searching` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '商品规格分组是否支持搜索 0=否;1=是;',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_id` (`platform_id`,`company_id`,`group_no`,`delete_at`) USING BTREE COMMENT '规格分组编号',
  UNIQUE KEY `uniq_group_sku_field` (`platform_id`,`company_id`,`template_id`,`group_type`,`group_sku_field`,`delete_at`) USING BTREE COMMENT '商品存储字段'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品规格分组';

-- ----------------------------
-- Records of product_spec_group2
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for product_template
-- ----------------------------
DROP TABLE IF EXISTS `product_template`;
CREATE TABLE `product_template` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `template_no` varchar(50) NOT NULL DEFAULT '' COMMENT '模板编号',
  `template_name` varchar(50) NOT NULL DEFAULT '' COMMENT '模板名字',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_id` (`platform_id`,`company_id`,`template_no`,`delete_at`) USING BTREE COMMENT '模板编号'
) ENGINE=InnoDB AUTO_INCREMENT=40037520494432257 DEFAULT CHARSET=utf8 COMMENT='商品模板';

-- ----------------------------
-- Records of product_template
-- ----------------------------
BEGIN;
INSERT INTO `product_template` (`id`, `platform_id`, `company_id`, `template_no`, `template_name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40037384649314304, 100000, 100100, 'clothing', '服装模板', '2023-06-24 03:34:23', '2023-06-24 03:34:23', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_template` (`id`, `platform_id`, `company_id`, `template_no`, `template_name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (40037520494432256, 100000, 100100, 'mobile', '手机模板', '2023-06-24 03:34:56', '2023-06-24 03:41:32', 0, 4145731145437184, 4145731145437184, 0);
COMMIT;

-- ----------------------------
-- Table structure for product_unit
-- ----------------------------
DROP TABLE IF EXISTS `product_unit`;
CREATE TABLE `product_unit` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `name` char(10) NOT NULL DEFAULT '' COMMENT '名称',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `uniq_id` (`platform_id`,`company_id`,`name`,`delete_at`) USING BTREE COMMENT '名称',
  KEY `idx_company_id` (`platform_id`,`company_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=39693463251456001 DEFAULT CHARSET=utf8 COMMENT='产品单位';

-- ----------------------------
-- Records of product_unit
-- ----------------------------
BEGIN;
INSERT INTO `product_unit` (`id`, `platform_id`, `company_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (33510330453856256, 100000, 100100, '个', '2023-06-06 03:18:09', '2023-06-06 03:18:09', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_unit` (`id`, `platform_id`, `company_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (33510367590223872, 100000, 100100, '箱', '2023-06-06 03:18:18', '2023-06-06 03:18:18', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_unit` (`id`, `platform_id`, `company_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (33510399496294400, 100000, 100100, '包', '2023-06-06 03:18:26', '2023-06-06 03:18:26', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_unit` (`id`, `platform_id`, `company_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (33510454684946432, 100000, 100100, '条', '2023-06-06 03:18:39', '2023-06-06 03:18:39', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_unit` (`id`, `platform_id`, `company_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (33510488902078464, 100000, 100100, '件', '2023-06-06 03:18:47', '2023-06-06 03:18:47', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_unit` (`id`, `platform_id`, `company_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (39692920290414592, 100000, 100100, '本', '2023-06-23 04:45:32', '2023-06-23 04:45:32', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_unit` (`id`, `platform_id`, `company_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (39692943086456832, 100000, 100100, '根', '2023-06-23 04:45:37', '2023-06-23 04:45:37', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_unit` (`id`, `platform_id`, `company_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (39692964636790784, 100000, 100100, '支', '2023-06-23 04:45:42', '2023-06-23 04:45:42', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_unit` (`id`, `platform_id`, `company_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (39692986719801344, 100000, 100100, '双', '2023-06-23 04:45:47', '2023-06-23 04:45:47', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_unit` (`id`, `platform_id`, `company_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (39693008882503680, 100000, 100100, '盒', '2023-06-23 04:45:53', '2023-06-23 04:45:53', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_unit` (`id`, `platform_id`, `company_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (39693026938982400, 100000, 100100, '把', '2023-06-23 04:45:57', '2023-06-23 04:45:57', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_unit` (`id`, `platform_id`, `company_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (39693094890901504, 100000, 100100, '提', '2023-06-23 04:46:13', '2023-06-23 04:46:13', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_unit` (`id`, `platform_id`, `company_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (39693136531951616, 100000, 100100, '付', '2023-06-23 04:46:23', '2023-06-23 04:46:23', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_unit` (`id`, `platform_id`, `company_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (39693172619743232, 100000, 100100, '组', '2023-06-23 04:46:32', '2023-06-23 04:46:32', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_unit` (`id`, `platform_id`, `company_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (39693192584630272, 100000, 100100, '对', '2023-06-23 04:46:37', '2023-06-23 04:46:37', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_unit` (`id`, `platform_id`, `company_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (39693234506698752, 100000, 100100, '辆', '2023-06-23 04:46:47', '2023-06-23 04:46:47', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_unit` (`id`, `platform_id`, `company_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (39693254022795264, 100000, 100100, '部', '2023-06-23 04:46:51', '2023-06-23 04:46:51', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_unit` (`id`, `platform_id`, `company_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (39693270376386560, 100000, 100100, '台', '2023-06-23 04:46:55', '2023-06-23 04:46:55', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_unit` (`id`, `platform_id`, `company_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (39693286121803776, 100000, 100100, '张', '2023-06-23 04:46:59', '2023-06-23 04:46:59', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_unit` (`id`, `platform_id`, `company_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (39693303519776768, 100000, 100100, '份', '2023-06-23 04:47:03', '2023-06-23 04:47:03', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_unit` (`id`, `platform_id`, `company_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (39693321249099776, 100000, 100100, '米', '2023-06-23 04:47:07', '2023-06-23 04:47:07', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_unit` (`id`, `platform_id`, `company_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (39693338202476544, 100000, 100100, '尺', '2023-06-23 04:47:11', '2023-06-23 04:47:11', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_unit` (`id`, `platform_id`, `company_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (39693358335135744, 100000, 100100, '卷', '2023-06-23 04:47:16', '2023-06-23 04:47:16', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_unit` (`id`, `platform_id`, `company_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (39693381764517888, 100000, 100100, '瓶', '2023-06-23 04:47:22', '2023-06-23 04:47:22', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_unit` (`id`, `platform_id`, `company_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (39693429684441088, 100000, 100100, '克', '2023-06-23 04:47:33', '2023-06-23 04:47:33', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_unit` (`id`, `platform_id`, `company_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (39693447287934976, 100000, 100100, '束', '2023-06-23 04:47:37', '2023-06-23 04:47:37', 0, 4145731145437184, 4145731145437184, 0);
INSERT INTO `product_unit` (`id`, `platform_id`, `company_id`, `name`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (39693463251456000, 100000, 100100, '公斤', '2023-06-23 04:47:41', '2023-06-23 04:47:41', 0, 4145731145437184, 4145731145437184, 0);
COMMIT;

-- ----------------------------
-- Table structure for product_unit1
-- ----------------------------
DROP TABLE IF EXISTS `product_unit1`;
CREATE TABLE `product_unit1` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `name` char(10) NOT NULL DEFAULT '' COMMENT '名称',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `uniq_id` (`platform_id`,`company_id`,`name`,`delete_at`) USING BTREE COMMENT '名称',
  KEY `idx_company_id` (`platform_id`,`company_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品单位';

-- ----------------------------
-- Records of product_unit1
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for product_unit2
-- ----------------------------
DROP TABLE IF EXISTS `product_unit2`;
CREATE TABLE `product_unit2` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `name` char(10) NOT NULL DEFAULT '' COMMENT '名称',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `uniq_id` (`platform_id`,`company_id`,`name`,`delete_at`) USING BTREE COMMENT '名称',
  KEY `idx_company_id` (`platform_id`,`company_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品单位';

-- ----------------------------
-- Records of product_unit2
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for search_plan
-- ----------------------------
DROP TABLE IF EXISTS `search_plan`;
CREATE TABLE `search_plan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '搜索名称',
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为默认搜索 0=否;1=是;',
  `plan` text NOT NULL COMMENT '计划',
  `source_type` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '来源类型',
  `remark` varchar(50) NOT NULL DEFAULT '' COMMENT '备注',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '类型 1=搜索条件;2=列配置;',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_platform_company` (`platform_id`,`company_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=88935026133176321 DEFAULT CHARSET=utf8 COMMENT='常用搜索';

-- ----------------------------
-- Records of search_plan
-- ----------------------------
BEGIN;
INSERT INTO `search_plan` (`id`, `platform_id`, `company_id`, `name`, `is_default`, `plan`, `source_type`, `remark`, `create_at`, `delete_at`, `create_account`, `version`, `type`) VALUES (74870809352605696, 100000, 100100, '成都仓库', 0, '{\"page\":1,\"page_size\":30,\"category_id\":\"40021167695859712,40021442565378048,40022279610044416,40022230977089536,40022193161244672,40022074164645888,40011340798103552,40011274691678208,40011186917478400\",\"brand_id\":\"52740951021588480,52740856398090240\"}', 20230426001340, '', '2023-09-28 06:29:52', 0, 4145731145437184, 0, 1);
INSERT INTO `search_plan` (`id`, `platform_id`, `company_id`, `name`, `is_default`, `plan`, `source_type`, `remark`, `create_at`, `delete_at`, `create_account`, `version`, `type`) VALUES (88935026133176320, 100000, 100100, '热销款', 0, '{\"page\":1,\"page_size\":30,\"key\":\"热\"}', 20230426001340, '', '2023-11-06 01:56:02', 0, 4145731145437184, 0, 1);
COMMIT;

-- ----------------------------
-- Table structure for stock
-- ----------------------------
DROP TABLE IF EXISTS `stock`;
CREATE TABLE `stock` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `warehouse_no` varchar(30) NOT NULL DEFAULT '' COMMENT '仓库编号',
  `sku_no` varchar(30) NOT NULL DEFAULT '' COMMENT 'SKU编号',
  `spu_no` varchar(30) NOT NULL DEFAULT '' COMMENT '产品编号',
  `available_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '可销售库存 用户可下单库存=实物库存+预售库存-不可销售库存-调拨占用库存-锁定库存-活动库存',
  `real_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '实物库存 仓储系统同步到库存系统的实物库存',
  `already_real_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '实物库存已出库数量',
  `lock_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '锁定库存 用户下单完成库存预占锁定',
  `transfer_lock_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '调拨占用库存 调拨单出库占用库存',
  `transferring_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '调拨中库存 调拨单入库还未到账库存',
  `active_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '活动库存 用于秒杀、抢购等各类营销活动的商品库存',
  `non_sale_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '不可销售库存 比如破损了无法销售或者紧急备用库存',
  `pre_sale_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '预售库存',
  `already_pre_sale_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '预售库存已出库数量',
  `cost_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '当前平均成本',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `create_account_name` varchar(30) NOT NULL DEFAULT '' COMMENT '创建人名字',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  `location_no` varchar(30) NOT NULL DEFAULT '' COMMENT '货位号',
  `product_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '产品ID',
  `warehouse_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '仓库ID',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `uniq_company` (`platform_id`,`company_id`,`sku_no`,`warehouse_no`,`delete_at`) USING BTREE COMMENT '库存',
  KEY `idx_warehouse_no` (`warehouse_no`) USING BTREE,
  KEY `idx_goods_id` (`spu_no`) USING BTREE,
  KEY `idx_available` (`available_inventory`),
  KEY `idx_sku` (`warehouse_no`,`sku_no`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='库存';

-- ----------------------------
-- Records of stock
-- ----------------------------
BEGIN;
INSERT INTO `stock` (`id`, `platform_id`, `company_id`, `warehouse_no`, `sku_no`, `spu_no`, `available_inventory`, `real_inventory`, `already_real_inventory`, `lock_inventory`, `transfer_lock_inventory`, `transferring_inventory`, `active_inventory`, `non_sale_inventory`, `pre_sale_inventory`, `already_pre_sale_inventory`, `cost_price`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `location_no`, `product_id`, `warehouse_id`) VALUES (1, 100000, 100100, 'chengdu', '1130000117119', 'BB6110', 0.000000, 0.000000, 2.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, '2023-09-19 00:48:14', '2023-11-08 05:53:27', 0, 4145731145437184, '', 4145731145437184, 8, '', 52739064654336000, 52739595116351489);
INSERT INTO `stock` (`id`, `platform_id`, `company_id`, `warehouse_no`, `sku_no`, `spu_no`, `available_inventory`, `real_inventory`, `already_real_inventory`, `lock_inventory`, `transfer_lock_inventory`, `transferring_inventory`, `active_inventory`, `non_sale_inventory`, `pre_sale_inventory`, `already_pre_sale_inventory`, `cost_price`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `location_no`, `product_id`, `warehouse_id`) VALUES (2, 100000, 100100, 'chengdu', '1130000117116', 'BB6110', 1.000000, 2.000000, 0.000000, 1.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, '2023-09-19 00:48:14', '2023-11-08 01:22:42', 0, 4145731145437184, '', 4145731145437184, 7, '', 52739064255877120, 52739595116351489);
INSERT INTO `stock` (`id`, `platform_id`, `company_id`, `warehouse_no`, `sku_no`, `spu_no`, `available_inventory`, `real_inventory`, `already_real_inventory`, `lock_inventory`, `transfer_lock_inventory`, `transferring_inventory`, `active_inventory`, `non_sale_inventory`, `pre_sale_inventory`, `already_pre_sale_inventory`, `cost_price`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `location_no`, `product_id`, `warehouse_id`) VALUES (3, 100000, 100100, 'chengdu', '1130000117117', 'BB6110', 1.000000, 2.000000, 0.000000, 1.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, '2023-09-19 00:48:14', '2023-11-08 01:22:42', 0, 4145731145437184, '', 4145731145437184, 7, '', 52739064411066368, 52739595116351489);
INSERT INTO `stock` (`id`, `platform_id`, `company_id`, `warehouse_no`, `sku_no`, `spu_no`, `available_inventory`, `real_inventory`, `already_real_inventory`, `lock_inventory`, `transfer_lock_inventory`, `transferring_inventory`, `active_inventory`, `non_sale_inventory`, `pre_sale_inventory`, `already_pre_sale_inventory`, `cost_price`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `location_no`, `product_id`, `warehouse_id`) VALUES (4, 100000, 100100, 'chengdu', '1130000117118', 'BB6110', 0.000000, 0.000000, 2.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, '2023-09-19 00:48:14', '2023-11-08 05:53:27', 0, 4145731145437184, '', 4145731145437184, 8, '', 52739064524312576, 52739595116351489);
INSERT INTO `stock` (`id`, `platform_id`, `company_id`, `warehouse_no`, `sku_no`, `spu_no`, `available_inventory`, `real_inventory`, `already_real_inventory`, `lock_inventory`, `transfer_lock_inventory`, `transferring_inventory`, `active_inventory`, `non_sale_inventory`, `pre_sale_inventory`, `already_pre_sale_inventory`, `cost_price`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `location_no`, `product_id`, `warehouse_id`) VALUES (5, 100000, 100100, 'CD03', '1130000117116', 'BB6110', 13.000000, 15.000000, 0.000000, 2.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, '2023-10-18 02:05:03', '2023-11-08 05:52:43', 0, 4145731145437184, '', 4145731145437184, 3, '', 52739064255877120, 52739539395022848);
INSERT INTO `stock` (`id`, `platform_id`, `company_id`, `warehouse_no`, `sku_no`, `spu_no`, `available_inventory`, `real_inventory`, `already_real_inventory`, `lock_inventory`, `transfer_lock_inventory`, `transferring_inventory`, `active_inventory`, `non_sale_inventory`, `pre_sale_inventory`, `already_pre_sale_inventory`, `cost_price`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `location_no`, `product_id`, `warehouse_id`) VALUES (6, 100000, 100100, 'CD03', '1130000117117', 'BB6110', 49.000000, 50.000000, 0.000000, 1.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, '2023-10-18 02:05:03', '2023-11-08 05:52:43', 0, 4145731145437184, '', 4145731145437184, 4, '', 52739064411066368, 52739539395022848);
INSERT INTO `stock` (`id`, `platform_id`, `company_id`, `warehouse_no`, `sku_no`, `spu_no`, `available_inventory`, `real_inventory`, `already_real_inventory`, `lock_inventory`, `transfer_lock_inventory`, `transferring_inventory`, `active_inventory`, `non_sale_inventory`, `pre_sale_inventory`, `already_pre_sale_inventory`, `cost_price`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `location_no`, `product_id`, `warehouse_id`) VALUES (7, 100000, 100100, 'chengdu', 'CS123456789', 'CS123456', 0.000000, 0.000000, 1.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, '2023-11-08 01:17:18', '2023-11-08 05:53:27', 0, 4145731145437184, '', 4145731145437184, 3, '', 89376926845767680, 52739595116351489);
INSERT INTO `stock` (`id`, `platform_id`, `company_id`, `warehouse_no`, `sku_no`, `spu_no`, `available_inventory`, `real_inventory`, `already_real_inventory`, `lock_inventory`, `transfer_lock_inventory`, `transferring_inventory`, `active_inventory`, `non_sale_inventory`, `pre_sale_inventory`, `already_pre_sale_inventory`, `cost_price`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `location_no`, `product_id`, `warehouse_id`) VALUES (8, 100000, 100100, 'chengdu', 'CSM1234561', 'CSM123456', 0.000000, 0.000000, 1.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, '2023-11-08 01:17:18', '2023-11-08 05:53:27', 0, 4145731145437184, '', 4145731145437184, 3, '', 89377221780836352, 52739595116351489);
INSERT INTO `stock` (`id`, `platform_id`, `company_id`, `warehouse_no`, `sku_no`, `spu_no`, `available_inventory`, `real_inventory`, `already_real_inventory`, `lock_inventory`, `transfer_lock_inventory`, `transferring_inventory`, `active_inventory`, `non_sale_inventory`, `pre_sale_inventory`, `already_pre_sale_inventory`, `cost_price`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `location_no`, `product_id`, `warehouse_id`) VALUES (9, 100000, 100100, 'chengdu', 'CSM1234562', 'CSM123456', 0.000000, 0.000000, 1.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, '2023-11-08 01:17:18', '2023-11-08 05:53:27', 0, 4145731145437184, '', 4145731145437184, 3, '', 89377222007328768, 52739595116351489);
INSERT INTO `stock` (`id`, `platform_id`, `company_id`, `warehouse_no`, `sku_no`, `spu_no`, `available_inventory`, `real_inventory`, `already_real_inventory`, `lock_inventory`, `transfer_lock_inventory`, `transferring_inventory`, `active_inventory`, `non_sale_inventory`, `pre_sale_inventory`, `already_pre_sale_inventory`, `cost_price`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `location_no`, `product_id`, `warehouse_id`) VALUES (10, 100000, 100100, 'chengdu', 'CSM1234563', 'CSM123456', 0.000000, 0.000000, 1.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, '2023-11-08 01:17:18', '2023-11-08 05:53:27', 0, 4145731145437184, '', 4145731145437184, 3, '', 89377222208655360, 52739595116351489);
INSERT INTO `stock` (`id`, `platform_id`, `company_id`, `warehouse_no`, `sku_no`, `spu_no`, `available_inventory`, `real_inventory`, `already_real_inventory`, `lock_inventory`, `transfer_lock_inventory`, `transferring_inventory`, `active_inventory`, `non_sale_inventory`, `pre_sale_inventory`, `already_pre_sale_inventory`, `cost_price`, `create_at`, `update_at`, `delete_at`, `create_account`, `create_account_name`, `update_account`, `version`, `location_no`, `product_id`, `warehouse_id`) VALUES (11, 100000, 100100, 'chengdu', 'CSM1234564', 'CSM123456', 0.000000, 0.000000, 1.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, 0.000000, '2023-11-08 01:17:18', '2023-11-08 05:53:27', 0, 4145731145437184, '', 4145731145437184, 3, '', 89377222460313600, 52739595116351489);
COMMIT;

-- ----------------------------
-- Table structure for stock1
-- ----------------------------
DROP TABLE IF EXISTS `stock1`;
CREATE TABLE `stock1` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `warehouse_no` varchar(30) NOT NULL DEFAULT '' COMMENT '仓库编号',
  `sku_no` varchar(30) NOT NULL DEFAULT '' COMMENT 'SKU编号',
  `spu_no` varchar(30) NOT NULL DEFAULT '' COMMENT '产品编号',
  `available_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '可销售库存 用户可下单库存=实物库存+预售库存-不可销售库存-调拨占用库存-锁定库存-活动库存',
  `real_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '实物库存 仓储系统同步到库存系统的实物库存',
  `already_real_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '实物库存已出库数量',
  `lock_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '锁定库存 用户下单完成库存预占锁定',
  `transfer_lock_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '调拨占用库存 调拨单出库占用库存',
  `transferring_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '调拨中库存 调拨单入库还未到账库存',
  `active_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '活动库存 用于秒杀、抢购等各类营销活动的商品库存',
  `non_sale_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '不可销售库存 比如破损了无法销售或者紧急备用库存',
  `pre_sale_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '预售库存',
  `already_pre_sale_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '预售库存已出库数量',
  `cost_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '当前平均成本',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `create_account_name` varchar(30) NOT NULL DEFAULT '' COMMENT '创建人名字',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  `location_no` varchar(30) NOT NULL DEFAULT '' COMMENT '货位号',
  `product_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '产品ID',
  `warehouse_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '仓库ID',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `uniq_company` (`platform_id`,`company_id`,`sku_no`,`warehouse_no`,`delete_at`) USING BTREE COMMENT '库存',
  KEY `idx_warehouse_no` (`warehouse_no`) USING BTREE,
  KEY `idx_goods_id` (`spu_no`) USING BTREE,
  KEY `idx_available` (`available_inventory`),
  KEY `idx_sku` (`warehouse_no`,`sku_no`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='库存';

-- ----------------------------
-- Records of stock1
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for stock2
-- ----------------------------
DROP TABLE IF EXISTS `stock2`;
CREATE TABLE `stock2` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `warehouse_no` varchar(30) NOT NULL DEFAULT '' COMMENT '仓库编号',
  `sku_no` varchar(30) NOT NULL DEFAULT '' COMMENT 'SKU编号',
  `spu_no` varchar(30) NOT NULL DEFAULT '' COMMENT '产品编号',
  `available_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '可销售库存 用户可下单库存=实物库存+预售库存-不可销售库存-调拨占用库存-锁定库存-活动库存',
  `real_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '实物库存 仓储系统同步到库存系统的实物库存',
  `already_real_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '实物库存已出库数量',
  `lock_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '锁定库存 用户下单完成库存预占锁定',
  `transfer_lock_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '调拨占用库存 调拨单出库占用库存',
  `transferring_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '调拨中库存 调拨单入库还未到账库存',
  `active_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '活动库存 用于秒杀、抢购等各类营销活动的商品库存',
  `non_sale_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '不可销售库存 比如破损了无法销售或者紧急备用库存',
  `pre_sale_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '预售库存',
  `already_pre_sale_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '预售库存已出库数量',
  `cost_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '当前平均成本',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `create_account_name` varchar(30) NOT NULL DEFAULT '' COMMENT '创建人名字',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  `location_no` varchar(30) NOT NULL DEFAULT '' COMMENT '货位号',
  `product_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '产品ID',
  `warehouse_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '仓库ID',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `uniq_company` (`platform_id`,`company_id`,`sku_no`,`warehouse_no`,`delete_at`) USING BTREE COMMENT '库存',
  KEY `idx_warehouse_no` (`warehouse_no`) USING BTREE,
  KEY `idx_goods_id` (`spu_no`) USING BTREE,
  KEY `idx_available` (`available_inventory`),
  KEY `idx_sku` (`warehouse_no`,`sku_no`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='库存';

-- ----------------------------
-- Records of stock2
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for stock_log
-- ----------------------------
DROP TABLE IF EXISTS `stock_log`;
CREATE TABLE `stock_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `stock_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '库存ID',
  `inventory_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '库存类型 1=可售库存;2=实物库存;3=锁定库存;4=活动库存;5=不可售库存;6=调拨占用库存;7=调拨中库存;8=预售库存;9=预售锁定库存;10=预售库存已出库数量;',
  `number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '实际库存',
  `change_number` decimal(21,6) NOT NULL DEFAULT '0.000000' COMMENT '变更库存',
  `real_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '实物库存',
  `cost_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '库存成本',
  `relation_doc` varchar(30) NOT NULL DEFAULT '' COMMENT '关联单据',
  `doc_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '单据类型',
  `remark` varchar(50) NOT NULL DEFAULT '' COMMENT '备注',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `create_account_name` varchar(30) NOT NULL DEFAULT '' COMMENT '创建人名字',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  `warehouse_no` varchar(30) NOT NULL DEFAULT '' COMMENT '仓库编号',
  `sku_no` varchar(30) NOT NULL DEFAULT '' COMMENT 'SKU编号',
  `spu_no` varchar(30) NOT NULL DEFAULT '' COMMENT '产品编号',
  `product_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '产品ID',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_platform_company` (`platform_id`,`company_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=89719549078933505 DEFAULT CHARSET=utf8 COMMENT='库存扣减流水表';

-- ----------------------------
-- Records of stock_log
-- ----------------------------
BEGIN;
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (71523344268267520, 100000, 100100, 1, 2, 1.000000, 1.000000, 0.000000, 0.000000, 'RK2023091900001', 2, '', '2023-09-19 00:48:14', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117119', 'BB6110', 52739064654336000);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (71523344415068160, 100000, 100100, 2, 2, 1.000000, 1.000000, 0.000000, 0.000000, 'RK2023091900001', 2, '', '2023-09-19 00:48:14', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117116', 'BB6110', 52739064255877120);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (71523344507342848, 100000, 100100, 3, 2, 1.000000, 1.000000, 0.000000, 0.000000, 'RK2023091900001', 2, '', '2023-09-19 00:48:14', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117117', 'BB6110', 52739064411066368);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (71523344599617536, 100000, 100100, 4, 2, 1.000000, 1.000000, 0.000000, 0.000000, 'RK2023091900001', 2, '', '2023-09-19 00:48:14', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117118', 'BB6110', 52739064524312576);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (74832852474269696, 100000, 100100, 1, 3, 1.000000, 1.000000, 1.000000, 0.000000, 'XH2023092800001', 20, '', '2023-09-28 03:59:02', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117119', 'BB6110', 52739064654336000);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (74832852583321600, 100000, 100100, 4, 3, 1.000000, 1.000000, 1.000000, 0.000000, 'XH2023092800001', 20, '', '2023-09-28 03:59:02', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117118', 'BB6110', 52739064524312576);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (74832852642041856, 100000, 100100, 2, 3, 1.000000, 1.000000, 1.000000, 0.000000, 'XH2023092800001', 20, '', '2023-09-28 03:59:02', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117116', 'BB6110', 52739064255877120);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (74832852683984896, 100000, 100100, 3, 3, 1.000000, 1.000000, 1.000000, 0.000000, 'XH2023092800001', 20, '', '2023-09-28 03:59:02', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117117', 'BB6110', 52739064411066368);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (82045194731655168, 100000, 100100, 3, 2, 0.500000, -0.500000, 1.000000, 0.000000, 'CK2023101800001', 15, '', '2023-10-18 01:38:18', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117117', 'BB6110', 52739064411066368);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (82045194740043776, 100000, 100100, 3, 3, 0.500000, -0.500000, 1.000000, 0.000000, 'CK2023101800001', 15, '', '2023-10-18 01:38:18', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117117', 'BB6110', 52739064411066368);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (82045194748432384, 100000, 100100, 3, 9, 0.500000, 0.500000, 1.000000, 0.000000, 'CK2023101800001', 15, '', '2023-10-18 01:38:18', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117117', 'BB6110', 52739064411066368);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (82045194945564672, 100000, 100100, 2, 2, 0.000000, -1.000000, 1.000000, 0.000000, 'CK2023101800001', 15, '', '2023-10-18 01:38:18', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117116', 'BB6110', 52739064255877120);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (82045194949758976, 100000, 100100, 2, 3, 0.000000, -1.000000, 1.000000, 0.000000, 'CK2023101800001', 15, '', '2023-10-18 01:38:18', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117116', 'BB6110', 52739064255877120);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (82045194953953280, 100000, 100100, 2, 9, 1.000000, 1.000000, 1.000000, 0.000000, 'CK2023101800001', 15, '', '2023-10-18 01:38:18', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117116', 'BB6110', 52739064255877120);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (82045195008479232, 100000, 100100, 4, 2, 0.000000, -1.000000, 1.000000, 0.000000, 'CK2023101800001', 15, '', '2023-10-18 01:38:18', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117118', 'BB6110', 52739064524312576);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (82045195025256448, 100000, 100100, 4, 3, 0.000000, -1.000000, 1.000000, 0.000000, 'CK2023101800001', 15, '', '2023-10-18 01:38:18', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117118', 'BB6110', 52739064524312576);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (82045195033645056, 100000, 100100, 4, 9, 1.000000, 1.000000, 1.000000, 0.000000, 'CK2023101800001', 15, '', '2023-10-18 01:38:18', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117118', 'BB6110', 52739064524312576);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (82045195083976704, 100000, 100100, 1, 2, 0.000000, -1.000000, 1.000000, 0.000000, 'CK2023101800001', 15, '', '2023-10-18 01:38:18', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117119', 'BB6110', 52739064654336000);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (82045195088171008, 100000, 100100, 1, 3, 0.000000, -1.000000, 1.000000, 0.000000, 'CK2023101800001', 15, '', '2023-10-18 01:38:18', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117119', 'BB6110', 52739064654336000);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (82045195092365312, 100000, 100100, 1, 9, 1.000000, 1.000000, 1.000000, 0.000000, 'CK2023101800001', 15, '', '2023-10-18 01:38:18', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117119', 'BB6110', 52739064654336000);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (82051925763297280, 100000, 100100, 5, 2, 15.000000, 15.000000, 0.000000, 0.000000, 'RK2023100900006', 2, '', '2023-10-18 02:05:03', 0, 4145731145437184, 'admin', 0, 'CD03', '1130000117116', 'BB6110', 52739064255877120);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (82051925935263744, 100000, 100100, 6, 2, 50.000000, 50.000000, 0.000000, 0.000000, 'RK2023100900006', 2, '', '2023-10-18 02:05:03', 0, 4145731145437184, 'admin', 0, 'CD03', '1130000117117', 'BB6110', 52739064411066368);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (82052192755912704, 100000, 100100, 2, 2, 1.000000, 1.000000, 0.000000, 0.000000, 'CK2023101800001', 9, '', '2023-10-18 02:06:07', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117116', 'BB6110', 52739064255877120);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (82052192768495616, 100000, 100100, 2, 3, 1.000000, 1.000000, 0.000000, 0.000000, 'CK2023101800001', 9, '', '2023-10-18 02:06:07', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117116', 'BB6110', 52739064255877120);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (82052192772689920, 100000, 100100, 2, 9, 0.000000, -1.000000, 0.000000, 0.000000, 'CK2023101800001', 9, '', '2023-10-18 02:06:07', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117116', 'BB6110', 52739064255877120);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (82052192948850688, 100000, 100100, 3, 2, 1.000000, 0.500000, 0.500000, 0.000000, 'CK2023101800001', 9, '', '2023-10-18 02:06:07', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117117', 'BB6110', 52739064411066368);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (82052192965627904, 100000, 100100, 3, 3, 1.000000, 0.500000, 0.500000, 0.000000, 'CK2023101800001', 9, '', '2023-10-18 02:06:07', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117117', 'BB6110', 52739064411066368);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (82052192978210816, 100000, 100100, 3, 9, 0.000000, -0.500000, 0.500000, 0.000000, 'CK2023101800001', 9, '', '2023-10-18 02:06:07', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117117', 'BB6110', 52739064411066368);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (82052193091457024, 100000, 100100, 4, 2, 1.000000, 1.000000, 0.000000, 0.000000, 'CK2023101800001', 9, '', '2023-10-18 02:06:07', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117118', 'BB6110', 52739064524312576);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (82052193099845632, 100000, 100100, 4, 3, 1.000000, 1.000000, 0.000000, 0.000000, 'CK2023101800001', 9, '', '2023-10-18 02:06:07', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117118', 'BB6110', 52739064524312576);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (82052193125011456, 100000, 100100, 4, 9, 0.000000, -1.000000, 0.000000, 0.000000, 'CK2023101800001', 9, '', '2023-10-18 02:06:07', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117118', 'BB6110', 52739064524312576);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (82052193238257664, 100000, 100100, 1, 2, 1.000000, 1.000000, 0.000000, 0.000000, 'CK2023101800001', 9, '', '2023-10-18 02:06:07', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117119', 'BB6110', 52739064654336000);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (82052193246646272, 100000, 100100, 1, 3, 1.000000, 1.000000, 0.000000, 0.000000, 'CK2023101800001', 9, '', '2023-10-18 02:06:07', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117119', 'BB6110', 52739064654336000);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (82052193255034880, 100000, 100100, 1, 9, 0.000000, -1.000000, 0.000000, 0.000000, 'CK2023101800001', 9, '', '2023-10-18 02:06:07', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117119', 'BB6110', 52739064654336000);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (82805972363513856, 100000, 100100, 6, 3, 1.000000, 1.000000, 50.000000, 0.000000, 'XH2023102000002', 20, '', '2023-10-20 04:01:22', 0, 4145731145437184, 'admin', 0, 'CD03', '1130000117117', 'BB6110', 52739064411066368);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (82806910893559808, 100000, 100100, 6, 3, 0.000000, -1.000000, 50.000000, 0.000000, 'XH2023102000002', 21, '', '2023-10-20 04:05:06', 0, 4145731145437184, 'admin', 0, 'CD03', '1130000117117', 'BB6110', 52739064411066368);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (82807297704857600, 100000, 100100, 5, 3, 1.000000, 1.000000, 15.000000, 0.000000, 'QH2023102000001', 20, '', '2023-10-20 04:06:38', 0, 4145731145437184, 'admin', 0, 'CD03', '1130000117116', 'BB6110', 52739064255877120);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (88924786348134400, 100000, 100100, 4, 2, 0.000000, -1.000000, 1.000000, 0.000000, 'CK2023110600001', 15, '', '2023-11-06 01:15:21', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117118', 'BB6110', 52739064524312576);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (88924786356523008, 100000, 100100, 4, 3, 0.000000, -1.000000, 1.000000, 0.000000, 'CK2023110600001', 15, '', '2023-11-06 01:15:21', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117118', 'BB6110', 52739064524312576);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (88924786364911616, 100000, 100100, 4, 9, 1.000000, 1.000000, 1.000000, 0.000000, 'CK2023110600001', 15, '', '2023-11-06 01:15:21', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117118', 'BB6110', 52739064524312576);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (88924786570432512, 100000, 100100, 1, 2, 0.000000, -1.000000, 1.000000, 0.000000, 'CK2023110600001', 15, '', '2023-11-06 01:15:21', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117119', 'BB6110', 52739064654336000);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (88924786574626816, 100000, 100100, 1, 3, 0.000000, -1.000000, 1.000000, 0.000000, 'CK2023110600001', 15, '', '2023-11-06 01:15:21', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117119', 'BB6110', 52739064654336000);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (88924786578821120, 100000, 100100, 1, 9, 1.000000, 1.000000, 1.000000, 0.000000, 'CK2023110600001', 15, '', '2023-11-06 01:15:21', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117119', 'BB6110', 52739064654336000);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89650053639180288, 100000, 100100, 2, 2, 2.000000, 1.000000, 1.000000, 0.000000, 'RK2023110800001', 2, '', '2023-11-08 01:17:18', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117116', 'BB6110', 52739064255877120);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89650053790175232, 100000, 100100, 3, 2, 2.000000, 1.000000, 1.000000, 0.000000, 'RK2023110800001', 2, '', '2023-11-08 01:17:18', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117117', 'BB6110', 52739064411066368);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89650053861478400, 100000, 100100, 4, 2, 1.000000, 1.000000, 0.000000, 0.000000, 'RK2023110800001', 2, '', '2023-11-08 01:17:18', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117118', 'BB6110', 52739064524312576);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89650053936975872, 100000, 100100, 1, 2, 1.000000, 1.000000, 0.000000, 0.000000, 'RK2023110800001', 2, '', '2023-11-08 01:17:18', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117119', 'BB6110', 52739064654336000);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89650054087970816, 100000, 100100, 7, 2, 1.000000, 1.000000, 0.000000, 0.000000, 'RK2023110800001', 2, '', '2023-11-08 01:17:18', 0, 4145731145437184, 'admin', 0, 'chengdu', 'CS123456789', 'CS123456', 89376926845767680);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89650054209605632, 100000, 100100, 8, 2, 1.000000, 1.000000, 0.000000, 0.000000, 'RK2023110800001', 2, '', '2023-11-08 01:17:18', 0, 4145731145437184, 'admin', 0, 'chengdu', 'CSM1234561', 'CSM123456', 89377221780836352);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89650054356406272, 100000, 100100, 9, 2, 1.000000, 1.000000, 0.000000, 0.000000, 'RK2023110800001', 2, '', '2023-11-08 01:17:18', 0, 4145731145437184, 'admin', 0, 'chengdu', 'CSM1234562', 'CSM123456', 89377222007328768);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89650054519984128, 100000, 100100, 10, 2, 1.000000, 1.000000, 0.000000, 0.000000, 'RK2023110800001', 2, '', '2023-11-08 01:17:18', 0, 4145731145437184, 'admin', 0, 'chengdu', 'CSM1234563', 'CSM123456', 89377222208655360);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89650054637424640, 100000, 100100, 11, 2, 1.000000, 1.000000, 0.000000, 0.000000, 'RK2023110800001', 2, '', '2023-11-08 01:17:18', 0, 4145731145437184, 'admin', 0, 'chengdu', 'CSM1234564', 'CSM123456', 89377222460313600);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89651354745835520, 100000, 100100, 3, 2, 1.000000, -1.000000, 2.000000, 0.000000, 'CK2023110800001', 15, '', '2023-11-08 01:22:28', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117117', 'BB6110', 52739064411066368);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89651354758418432, 100000, 100100, 3, 3, 0.000000, -1.000000, 2.000000, 0.000000, 'CK2023110800001', 15, '', '2023-11-08 01:22:28', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117117', 'BB6110', 52739064411066368);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89651354766807040, 100000, 100100, 3, 9, 1.000000, 1.000000, 2.000000, 0.000000, 'CK2023110800001', 15, '', '2023-11-08 01:22:28', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117117', 'BB6110', 52739064411066368);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89651354846498816, 100000, 100100, 2, 2, 1.000000, -1.000000, 2.000000, 0.000000, 'CK2023110800001', 15, '', '2023-11-08 01:22:28', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117116', 'BB6110', 52739064255877120);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89651354850693120, 100000, 100100, 2, 3, 0.000000, -1.000000, 2.000000, 0.000000, 'CK2023110800001', 15, '', '2023-11-08 01:22:28', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117116', 'BB6110', 52739064255877120);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89651354854887424, 100000, 100100, 2, 9, 1.000000, 1.000000, 2.000000, 0.000000, 'CK2023110800001', 15, '', '2023-11-08 01:22:28', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117116', 'BB6110', 52739064255877120);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89651413646446592, 100000, 100100, 2, 2, 2.000000, 1.000000, 1.000000, 0.000000, 'CK2023110800001', 9, '', '2023-11-08 01:22:42', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117116', 'BB6110', 52739064255877120);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89651413650640896, 100000, 100100, 2, 3, 1.000000, 1.000000, 1.000000, 0.000000, 'CK2023110800001', 9, '', '2023-11-08 01:22:42', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117116', 'BB6110', 52739064255877120);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89651413654835200, 100000, 100100, 2, 9, 0.000000, -1.000000, 1.000000, 0.000000, 'CK2023110800001', 9, '', '2023-11-08 01:22:42', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117116', 'BB6110', 52739064255877120);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89651413726138368, 100000, 100100, 3, 2, 2.000000, 1.000000, 1.000000, 0.000000, 'CK2023110800001', 9, '', '2023-11-08 01:22:42', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117117', 'BB6110', 52739064411066368);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89651413730332672, 100000, 100100, 3, 3, 1.000000, 1.000000, 1.000000, 0.000000, 'CK2023110800001', 9, '', '2023-11-08 01:22:42', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117117', 'BB6110', 52739064411066368);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89651413734526976, 100000, 100100, 3, 9, 0.000000, -1.000000, 1.000000, 0.000000, 'CK2023110800001', 9, '', '2023-11-08 01:22:42', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117117', 'BB6110', 52739064411066368);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719363803942912, 100000, 100100, 10, 3, 1.000000, 1.000000, 1.000000, 0.000000, 'XH2023110800001', 20, '', '2023-11-08 05:52:43', 0, 4145731145437184, 'admin', 0, 'chengdu', 'CSM1234563', 'CSM123456', 89377222208655360);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719363862663168, 100000, 100100, 11, 3, 1.000000, 1.000000, 1.000000, 0.000000, 'XH2023110800001', 20, '', '2023-11-08 05:52:43', 0, 4145731145437184, 'admin', 0, 'chengdu', 'CSM1234564', 'CSM123456', 89377222460313600);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719363921383424, 100000, 100100, 4, 3, 1.000000, 1.000000, 1.000000, 0.000000, 'XH2023110800001', 20, '', '2023-11-08 05:52:43', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117118', 'BB6110', 52739064524312576);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719363988492288, 100000, 100100, 1, 3, 1.000000, 1.000000, 1.000000, 0.000000, 'XH2023110800001', 20, '', '2023-11-08 05:52:43', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117119', 'BB6110', 52739064654336000);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719364047212544, 100000, 100100, 7, 3, 1.000000, 1.000000, 1.000000, 0.000000, 'XH2023110800001', 20, '', '2023-11-08 05:52:43', 0, 4145731145437184, 'admin', 0, 'chengdu', 'CS123456789', 'CS123456', 89376926845767680);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719364093349888, 100000, 100100, 8, 3, 1.000000, 1.000000, 1.000000, 0.000000, 'XH2023110800001', 20, '', '2023-11-08 05:52:43', 0, 4145731145437184, 'admin', 0, 'chengdu', 'CSM1234561', 'CSM123456', 89377221780836352);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719364139487232, 100000, 100100, 9, 3, 1.000000, 1.000000, 1.000000, 0.000000, 'XH2023110800001', 20, '', '2023-11-08 05:52:43', 0, 4145731145437184, 'admin', 0, 'chengdu', 'CSM1234562', 'CSM123456', 89377222007328768);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719364579889152, 100000, 100100, 5, 3, 2.000000, 1.000000, 15.000000, 0.000000, 'XH2023110800002', 20, '', '2023-11-08 05:52:43', 0, 4145731145437184, 'admin', 0, 'CD03', '1130000117116', 'BB6110', 52739064255877120);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719364634415104, 100000, 100100, 6, 3, 1.000000, 1.000000, 50.000000, 0.000000, 'XH2023110800002', 20, '', '2023-11-08 05:52:43', 0, 4145731145437184, 'admin', 0, 'CD03', '1130000117117', 'BB6110', 52739064411066368);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719548596588544, 100000, 100100, 9, 2, 0.000000, -1.000000, 1.000000, 0.000000, 'CK2023110800002', 15, '', '2023-11-08 05:53:27', 0, 4145731145437184, 'admin', 0, 'chengdu', 'CSM1234562', 'CSM123456', 89377222007328768);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719548600782848, 100000, 100100, 9, 3, 0.000000, -1.000000, 1.000000, 0.000000, 'CK2023110800002', 15, '', '2023-11-08 05:53:27', 0, 4145731145437184, 'admin', 0, 'chengdu', 'CSM1234562', 'CSM123456', 89377222007328768);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719548604977152, 100000, 100100, 9, 9, 1.000000, 1.000000, 1.000000, 0.000000, 'CK2023110800002', 15, '', '2023-11-08 05:53:27', 0, 4145731145437184, 'admin', 0, 'chengdu', 'CSM1234562', 'CSM123456', 89377222007328768);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719548663697408, 100000, 100100, 8, 2, 0.000000, -1.000000, 1.000000, 0.000000, 'CK2023110800002', 15, '', '2023-11-08 05:53:27', 0, 4145731145437184, 'admin', 0, 'chengdu', 'CSM1234561', 'CSM123456', 89377221780836352);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719548672086016, 100000, 100100, 8, 3, 0.000000, -1.000000, 1.000000, 0.000000, 'CK2023110800002', 15, '', '2023-11-08 05:53:27', 0, 4145731145437184, 'admin', 0, 'chengdu', 'CSM1234561', 'CSM123456', 89377221780836352);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719548676280320, 100000, 100100, 8, 9, 1.000000, 1.000000, 1.000000, 0.000000, 'CK2023110800002', 15, '', '2023-11-08 05:53:27', 0, 4145731145437184, 'admin', 0, 'chengdu', 'CSM1234561', 'CSM123456', 89377221780836352);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719548751777792, 100000, 100100, 7, 2, 0.000000, -1.000000, 1.000000, 0.000000, 'CK2023110800002', 15, '', '2023-11-08 05:53:27', 0, 4145731145437184, 'admin', 0, 'chengdu', 'CS123456789', 'CS123456', 89376926845767680);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719548755972096, 100000, 100100, 7, 3, 0.000000, -1.000000, 1.000000, 0.000000, 'CK2023110800002', 15, '', '2023-11-08 05:53:27', 0, 4145731145437184, 'admin', 0, 'chengdu', 'CS123456789', 'CS123456', 89376926845767680);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719548760166400, 100000, 100100, 7, 9, 1.000000, 1.000000, 1.000000, 0.000000, 'CK2023110800002', 15, '', '2023-11-08 05:53:27', 0, 4145731145437184, 'admin', 0, 'chengdu', 'CS123456789', 'CS123456', 89376926845767680);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719548818886656, 100000, 100100, 1, 2, 0.000000, -1.000000, 1.000000, 0.000000, 'CK2023110800002', 15, '', '2023-11-08 05:53:27', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117119', 'BB6110', 52739064654336000);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719548823080960, 100000, 100100, 1, 3, 0.000000, -1.000000, 1.000000, 0.000000, 'CK2023110800002', 15, '', '2023-11-08 05:53:27', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117119', 'BB6110', 52739064654336000);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719548827275264, 100000, 100100, 1, 9, 2.000000, 1.000000, 1.000000, 0.000000, 'CK2023110800002', 15, '', '2023-11-08 05:53:27', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117119', 'BB6110', 52739064654336000);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719548906967040, 100000, 100100, 4, 2, 0.000000, -1.000000, 1.000000, 0.000000, 'CK2023110800002', 15, '', '2023-11-08 05:53:27', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117118', 'BB6110', 52739064524312576);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719548911161344, 100000, 100100, 4, 3, 0.000000, -1.000000, 1.000000, 0.000000, 'CK2023110800002', 15, '', '2023-11-08 05:53:27', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117118', 'BB6110', 52739064524312576);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719548919549952, 100000, 100100, 4, 9, 2.000000, 1.000000, 1.000000, 0.000000, 'CK2023110800002', 15, '', '2023-11-08 05:53:27', 0, 4145731145437184, 'admin', 0, 'chengdu', '1130000117118', 'BB6110', 52739064524312576);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719548986658816, 100000, 100100, 11, 2, 0.000000, -1.000000, 1.000000, 0.000000, 'CK2023110800002', 15, '', '2023-11-08 05:53:27', 0, 4145731145437184, 'admin', 0, 'chengdu', 'CSM1234564', 'CSM123456', 89377222460313600);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719548990853120, 100000, 100100, 11, 3, 0.000000, -1.000000, 1.000000, 0.000000, 'CK2023110800002', 15, '', '2023-11-08 05:53:27', 0, 4145731145437184, 'admin', 0, 'chengdu', 'CSM1234564', 'CSM123456', 89377222460313600);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719548999241728, 100000, 100100, 11, 9, 1.000000, 1.000000, 1.000000, 0.000000, 'CK2023110800002', 15, '', '2023-11-08 05:53:27', 0, 4145731145437184, 'admin', 0, 'chengdu', 'CSM1234564', 'CSM123456', 89377222460313600);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719549062156288, 100000, 100100, 10, 2, 0.000000, -1.000000, 1.000000, 0.000000, 'CK2023110800002', 15, '', '2023-11-08 05:53:27', 0, 4145731145437184, 'admin', 0, 'chengdu', 'CSM1234563', 'CSM123456', 89377222208655360);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719549070544896, 100000, 100100, 10, 3, 0.000000, -1.000000, 1.000000, 0.000000, 'CK2023110800002', 15, '', '2023-11-08 05:53:27', 0, 4145731145437184, 'admin', 0, 'chengdu', 'CSM1234563', 'CSM123456', 89377222208655360);
INSERT INTO `stock_log` (`id`, `platform_id`, `company_id`, `stock_id`, `inventory_type`, `number`, `change_number`, `real_inventory`, `cost_price`, `relation_doc`, `doc_type`, `remark`, `create_at`, `delete_at`, `create_account`, `create_account_name`, `version`, `warehouse_no`, `sku_no`, `spu_no`, `product_id`) VALUES (89719549078933504, 100000, 100100, 10, 9, 1.000000, 1.000000, 1.000000, 0.000000, 'CK2023110800002', 15, '', '2023-11-08 05:53:27', 0, 4145731145437184, 'admin', 0, 'chengdu', 'CSM1234563', 'CSM123456', 89377222208655360);
COMMIT;

-- ----------------------------
-- Table structure for stock_log1
-- ----------------------------
DROP TABLE IF EXISTS `stock_log1`;
CREATE TABLE `stock_log1` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `stock_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '库存ID',
  `inventory_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '库存类型 1=可售库存;2=实物库存;3=锁定库存;4=活动库存;5=不可售库存;6=调拨占用库存;7=调拨中库存;8=预售库存;9=预售锁定库存;10=预售库存已出库数量;',
  `number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '实际库存',
  `change_number` decimal(21,6) NOT NULL DEFAULT '0.000000' COMMENT '变更库存',
  `real_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '实物库存',
  `cost_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '库存成本',
  `relation_doc` varchar(30) NOT NULL DEFAULT '' COMMENT '关联单据',
  `doc_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '单据类型',
  `remark` varchar(50) NOT NULL DEFAULT '' COMMENT '备注',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `create_account_name` varchar(30) NOT NULL DEFAULT '' COMMENT '创建人名字',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  `warehouse_no` varchar(30) NOT NULL DEFAULT '' COMMENT '仓库编号',
  `sku_no` varchar(30) NOT NULL DEFAULT '' COMMENT 'SKU编号',
  `spu_no` varchar(30) NOT NULL DEFAULT '' COMMENT '产品编号',
  `product_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '产品ID',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_platform_company` (`platform_id`,`company_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='库存扣减流水表';

-- ----------------------------
-- Records of stock_log1
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for stock_log2
-- ----------------------------
DROP TABLE IF EXISTS `stock_log2`;
CREATE TABLE `stock_log2` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `stock_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '库存ID',
  `inventory_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '库存类型 1=可售库存;2=实物库存;3=锁定库存;4=活动库存;5=不可售库存;6=调拨占用库存;7=调拨中库存;8=预售库存;9=预售锁定库存;10=预售库存已出库数量;',
  `number` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '实际库存',
  `change_number` decimal(21,6) NOT NULL DEFAULT '0.000000' COMMENT '变更库存',
  `real_inventory` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '实物库存',
  `cost_price` decimal(21,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '库存成本',
  `relation_doc` varchar(30) NOT NULL DEFAULT '' COMMENT '关联单据',
  `doc_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '单据类型',
  `remark` varchar(50) NOT NULL DEFAULT '' COMMENT '备注',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `create_account_name` varchar(30) NOT NULL DEFAULT '' COMMENT '创建人名字',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  `warehouse_no` varchar(30) NOT NULL DEFAULT '' COMMENT '仓库编号',
  `sku_no` varchar(30) NOT NULL DEFAULT '' COMMENT 'SKU编号',
  `spu_no` varchar(30) NOT NULL DEFAULT '' COMMENT '产品编号',
  `product_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '产品ID',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_platform_company` (`platform_id`,`company_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='库存扣减流水表';

-- ----------------------------
-- Records of stock_log2
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for warehouse
-- ----------------------------
DROP TABLE IF EXISTS `warehouse`;
CREATE TABLE `warehouse` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
  `company_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公司ID',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态 0=禁用;1=启用;',
  `warehouse_no` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '编号',
  `warehouse_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `acreages` decimal(21,6) NOT NULL DEFAULT '0.000000' COMMENT '面积 平方米',
  `administrator` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '管理员',
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '电话',
  `mobile` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '手机',
  `city_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '地址区域',
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '详细地址',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
  `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
  `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
  `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_stock_id` (`warehouse_no`) USING BTREE,
  KEY `idx_company_id` (`company_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=52739595116351491 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='仓库';

-- ----------------------------
-- Records of warehouse
-- ----------------------------
BEGIN;
INSERT INTO `warehouse` (`id`, `platform_id`, `company_id`, `status`, `warehouse_no`, `warehouse_name`, `acreages`, `administrator`, `phone`, `mobile`, `city_id`, `remark`, `address`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (52739428627648512, 100000, 100100, 1, 'CD01', '温江仓库', 0.000000, '', '', '', 0, '', '', '2023-07-29 04:47:39', '2023-07-29 04:47:39', 0, 0, 0, 0);
INSERT INTO `warehouse` (`id`, `platform_id`, `company_id`, `status`, `warehouse_no`, `warehouse_name`, `acreages`, `administrator`, `phone`, `mobile`, `city_id`, `remark`, `address`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (52739482901942272, 100000, 100100, 1, 'CD02', '青羊区仓库', 0.000000, '', '', '', 0, '', '', '2023-07-29 04:47:52', '2023-07-29 04:47:52', 0, 0, 0, 0);
INSERT INTO `warehouse` (`id`, `platform_id`, `company_id`, `status`, `warehouse_no`, `warehouse_name`, `acreages`, `administrator`, `phone`, `mobile`, `city_id`, `remark`, `address`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (52739539395022848, 100000, 100100, 1, 'CD03', '高新区仓库', 0.000000, '', '', '', 0, '', '', '2023-07-29 04:48:06', '2023-07-29 04:48:06', 0, 0, 0, 0);
INSERT INTO `warehouse` (`id`, `platform_id`, `company_id`, `status`, `warehouse_no`, `warehouse_name`, `acreages`, `administrator`, `phone`, `mobile`, `city_id`, `remark`, `address`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (52739595116351488, 100000, 100100, 1, 'CD04', '青白江仓库', 0.000000, '', '', '', 0, '', '', '2023-07-29 04:48:19', '2023-07-29 04:48:19', 0, 0, 0, 0);
INSERT INTO `warehouse` (`id`, `platform_id`, `company_id`, `status`, `warehouse_no`, `warehouse_name`, `acreages`, `administrator`, `phone`, `mobile`, `city_id`, `remark`, `address`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (52739595116351489, 100000, 100100, 1, 'chengdu', '成都新仓库', 0.000000, '', '', '', 0, '', '', '2023-07-29 04:48:19', '2023-07-29 04:48:19', 0, 0, 0, 0);
INSERT INTO `warehouse` (`id`, `platform_id`, `company_id`, `status`, `warehouse_no`, `warehouse_name`, `acreages`, `administrator`, `phone`, `mobile`, `city_id`, `remark`, `address`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (52739595116351490, 100000, 100100, 1, 'xian', '新的仓库', 0.000000, '', '', '', 0, '', '', '2023-07-29 04:48:19', '2023-07-29 05:45:32', 0, 0, 0, 0);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
