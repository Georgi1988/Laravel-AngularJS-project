/*
 Navicat Premium Data Transfer

 Source Server         : Dell Tmall
 Source Server Type    : MySQL
 Source Server Version : 50634
 Source Host           : rm-vy1qi05dbh29t5cb6.mysql.rds.aliyuncs.com:3306
 Source Schema         : dbdn20akk3sz9

 Target Server Type    : MySQL
 Target Server Version : 50634
 File Encoding         : 65001

 Date: 05/11/2017 16:01:54
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for dcs_badges
-- ----------------------------
DROP TABLE IF EXISTS `dcs_badges`;
CREATE TABLE `dcs_badges`  (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `user_id` int(14) NOT NULL,
  `table_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `table_id` int(14) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 241 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for dcs_cardrule_templates
-- ----------------------------
DROP TABLE IF EXISTS `dcs_cardrule_templates`;
CREATE TABLE `dcs_cardrule_templates`  (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `rule_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `card_code_length` tinyint(4) NOT NULL,
  `length_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `length_description` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `length_info` varchar(512) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password_length` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password_type` enum('l','n','l+n') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'n',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `rule_code`(`rule_code`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of dcs_cardrule_templates
-- ----------------------------
INSERT INTO `dcs_cardrule_templates` VALUES (1, '16-01', 16, '4, 4, 4, 4', '', '{\"retail\":{\"type\":\"dic_retail\",\"select\":\"auto\",\"length\":4},\"gen_order_00AA\":{\"type\":\"gen_order_00AA\",\"select\":\"auto\",\"length\":4},\"physical_card\":{\"type\":\"physical_card\",\"select\":\"auto\",\"length\":1},\"service_type\":{\"type\":\"dic_service_type\",\"select\":\"auto\",\"length\":3},\"random1\":{\"type\":\"random\",\"select\":\"auto\",\"length\":4}}', '10,16', 'n', NULL, NULL);
INSERT INTO `dcs_cardrule_templates` VALUES (3, '17-01', 17, '5, 4, 4, 4', '', '{\"province\":{\"type\":\"dic_province\",\"select\":\"auto\",\"length\":2},\"random1\":{\"type\":\"random\",\"select\":\"auto\",\"length\":3},\"gen_year\":{\"type\":\"gen_year\",\"select\":\"auto\",\"length\":4},\"gen_month_day\":{\"type\":\"gen_month_day\",\"select\":\"auto\",\"length\":4},\"custom\":{\"type\":\"custom\",\"select\":\"manual\",\"length\":1},\"random2\":{\"type\":\"random\",\"select\":\"auto\",\"length\":3}}', '16,17,18', 'n', NULL, NULL);
INSERT INTO `dcs_cardrule_templates` VALUES (5, '17-02', 17, '6, 6, 5', '', '{\"card_type\":{\"type\":\"dic_card_type\",\"select\":\"manual\",\"length\":2},\"area\":{\"type\":\"dic_area\",\"select\":\"auto\",\"length\":4},\"expire_date\":{\"type\":\"expire_date\",\"select\":\"auto\",\"length\":6},\"random1\":{\"type\":\"random\",\"select\":\"auto\",\"length\":5}}', '16,17,18', 'n', NULL, NULL);
INSERT INTO `dcs_cardrule_templates` VALUES (6, '18-01', 18, '3, 8, 5, 2', '', '{\"custom\":{\"type\":\"custom\",\"select\":\"manual\",\"length\":3},\"expire_date\":{\"type\":\"expire_date\",\"select\":\"auto\",\"length\":8},\"random1\":{\"type\":\"random\",\"select\":\"auto\",\"length\":5}}', '16,17,18', 'n', NULL, NULL);
INSERT INTO `dcs_cardrule_templates` VALUES (7, '18-02', 18, '4, 8, 4, 2', '', '{\"custom1\":{\"type\":\"custom\",\"select\":\"manual\",\"length\":4},\"random1\":{\"type\":\"random\",\"select\":\"auto\",\"length\":8},\"custom2\":{\"type\":\"custom\",\"select\":\"manual\",\"length\":4},\"random2\":{\"type\":\"random\",\"select\":\"auto\",\"length\":2}}', '16,17,18', 'n', NULL, NULL);
INSERT INTO `dcs_cardrule_templates` VALUES (10, '18-03', 18, '3, 8, 5, 2', '', '{\"custom1\":{\"type\":\"custom\",\"select\":\"manual\",\"length\":6},\"gen_date\":{\"type\":\"gen_date\",\"select\":\"auto\",\"length\":6},\"custom2\":{\"type\":\"custom\",\"select\":\"manual\",\"length\":1},\"random\":{\"type\":\"random\",\"select\":\"auto\",\"length\":5}}', '16,17,18', 'n', NULL, NULL);

-- ----------------------------
-- Table structure for dcs_cards
-- ----------------------------
DROP TABLE IF EXISTS `dcs_cards`;
CREATE TABLE `dcs_cards`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `passwd` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` int(11) NOT NULL,
  `dealer_id` int(11) NULL DEFAULT NULL,
  `user_id` int(11) NULL DEFAULT NULL,
  `agree_reg` enum('n','r','d') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `status` int(11) NOT NULL DEFAULT 0,
  `register_datetime` datetime(0) NULL DEFAULT NULL,
  `active_datetime` datetime(0) NULL DEFAULT NULL,
  `customer_id` int(11) NULL DEFAULT NULL,
  `machine_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `valid_period` datetime(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11978 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;


-- ----------------------------
-- Table structure for dcs_customers
-- ----------------------------
DROP TABLE IF EXISTS `dcs_customers`;
CREATE TABLE `dcs_customers`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 50 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for dcs_dealer_corporations
-- ----------------------------
DROP TABLE IF EXISTS `dcs_dealer_corporations`;
CREATE TABLE `dcs_dealer_corporations`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '00',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `code`(`code`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of dcs_dealer_corporations
-- ----------------------------
INSERT INTO `dcs_dealer_corporations` VALUES (1, '01', '翰林汇');
INSERT INTO `dcs_dealer_corporations` VALUES (2, '02', '神州数码');
INSERT INTO `dcs_dealer_corporations` VALUES (3, '05', '长虹佳华');
INSERT INTO `dcs_dealer_corporations` VALUES (4, '66', '京东');

-- ----------------------------
-- Table structure for dcs_dealers
-- ----------------------------
DROP TABLE IF EXISTS `dcs_dealers`;
CREATE TABLE `dcs_dealers`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `corporation` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '00' COMMENT 'corporation code(Ex 66: jingdong) ',
  `code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_type_id` int(11) NULL DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `area` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `province` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `dd_account` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `check_order` int(2) NOT NULL DEFAULT 0,
  `check_ordered` int(2) NOT NULL DEFAULT 0,
  `check_product` int(2) NOT NULL DEFAULT 0,
  `detail_id` int(11) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 42 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of dcs_dealers
-- ----------------------------
INSERT INTO `dcs_dealers` VALUES (1, '00', '', 'DELL 本店', 1, '华东 - 安徽省 - 合肥市', '华东', '安徽省', '合肥市', '18512342345', '44672379', 0, 0, 0, 1, 0, NULL, '2017-09-12 12:53:19', '2017-10-25 23:12:46');

-- ----------------------------
-- Table structure for dcs_dealers_detail
-- ----------------------------
DROP TABLE IF EXISTS `dcs_dealers_detail`;
CREATE TABLE `dcs_dealers_detail`  (
  `id` int(10) UNSIGNED NOT NULL,
  `shop_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dealer_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dealer_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dealer_kind` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `upper_dealer_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `upper_dealer_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `area` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_district` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_level` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `zone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `township` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `area_boss_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_dealer_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_boss_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_boss_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cm_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_kind` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_kind` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_kind_1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_property` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_direction` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_area_of_shop` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_monthly_sales` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_communication_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_postal_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_phone_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_boss_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_boss_phone_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_boss_mobile_phone_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_boss_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `receipt_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `receipt_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `receipt_phone_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `receipt_mobile_phone_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `cooperation_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `application_time` date NOT NULL,
  `apply_for_approval_time` date NOT NULL,
  `modify_approval_time` date NOT NULL,
  `cancel_cooperation_approval_time` date NULL DEFAULT NULL,
  `comment` date NULL DEFAULT NULL,
  `cooperation_kind` date NOT NULL,
  `it_mall_whole_name` date NOT NULL,
  `it_mall_short_name` date NOT NULL,
  `location_kind` date NOT NULL,
  `area_of_dell` date NOT NULL,
  `after_sales_service_point` date NULL DEFAULT NULL,
  `last_renovated_time` date NULL DEFAULT NULL,
  `dell_pay` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `use_decoration_fund` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `counter_number` int(11) NOT NULL,
  `snp_cabinet_number` int(11) NOT NULL,
  `commitment_sales` int(11) NOT NULL,
  `shop_level` int(11) NOT NULL,
  `nobody_shop` tinyint(1) NOT NULL,
  `platform_shop_rating` int(11) NULL DEFAULT NULL,
  `registration_hours` int(11) NOT NULL,
  `registration_approval_hours` int(11) NOT NULL,
  `line_under_report` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `township_level` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `process_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `retail_manager_user_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for dcs_dictionaries
-- ----------------------------
DROP TABLE IF EXISTS `dcs_dictionaries`;
CREATE TABLE `dcs_dictionaries`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `keyword` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `keyword`(`keyword`, `value`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 48 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of dcs_dictionaries
-- ----------------------------
INSERT INTO `dcs_dictionaries` VALUES (1, 'dic_retail', '1001', '中国-翰林汇', '2017-11-03 22:46:52', '2017-11-03 22:46:52');
INSERT INTO `dcs_dictionaries` VALUES (2, 'dic_retail', '1002', '中国-神州数码', '2017-11-03 22:47:26', '2017-11-03 22:47:26');
INSERT INTO `dcs_dictionaries` VALUES (3, 'dic_retail', '1003', '中国-台湾', '2017-11-03 22:48:02', '2017-11-03 22:48:02');
INSERT INTO `dcs_dictionaries` VALUES (4, 'dic_area', '01', '华北', '2017-11-03 22:49:22', '2017-11-03 22:49:22');
INSERT INTO `dcs_dictionaries` VALUES (5, 'dic_area', '02', '东北', '2017-11-03 22:49:36', '2017-11-03 22:49:36');
INSERT INTO `dcs_dictionaries` VALUES (6, 'dic_area', '03', '华东', '2017-11-03 22:49:56', '2017-11-03 22:49:56');
INSERT INTO `dcs_dictionaries` VALUES (7, 'dic_area', '04', '华中', '2017-11-03 22:50:18', '2017-11-03 22:50:18');
INSERT INTO `dcs_dictionaries` VALUES (8, 'dic_area', '05', '华南', '2017-11-03 22:50:47', '2017-11-03 22:50:47');
INSERT INTO `dcs_dictionaries` VALUES (9, 'dic_area', '06', '西南', '2017-11-03 22:51:18', '2017-11-03 22:51:18');
INSERT INTO `dcs_dictionaries` VALUES (10, 'dic_area', '07', '西北', '2017-11-03 22:51:30', '2017-11-03 22:51:30');
INSERT INTO `dcs_dictionaries` VALUES (11, 'dic_province', '01', '北京市', '2017-11-03 22:59:53', '2017-11-03 23:00:52');
INSERT INTO `dcs_dictionaries` VALUES (12, 'dic_province', '02', '天津市', '2017-11-03 23:09:38', '2017-11-03 23:09:38');
INSERT INTO `dcs_dictionaries` VALUES (13, 'dic_province', '03', '河北省', '2017-11-03 23:09:48', '2017-11-03 23:09:48');
INSERT INTO `dcs_dictionaries` VALUES (14, 'dic_province', '04', '山西省', '2017-11-03 23:10:00', '2017-11-03 23:10:00');
INSERT INTO `dcs_dictionaries` VALUES (15, 'dic_province', '05', '内蒙古自治区', '2017-11-03 23:10:10', '2017-11-03 23:10:10');
INSERT INTO `dcs_dictionaries` VALUES (16, 'dic_province', '06', '辽宁省', '2017-11-03 23:10:20', '2017-11-03 23:10:20');
INSERT INTO `dcs_dictionaries` VALUES (17, 'dic_province', '07', '吉林省', '2017-11-03 23:10:30', '2017-11-03 23:10:30');
INSERT INTO `dcs_dictionaries` VALUES (18, 'dic_province', '08', '黑龙江省', '2017-11-03 23:10:40', '2017-11-03 23:10:40');
INSERT INTO `dcs_dictionaries` VALUES (19, 'dic_province', '09', '上海市', '2017-11-03 23:10:50', '2017-11-03 23:10:50');
INSERT INTO `dcs_dictionaries` VALUES (20, 'dic_province', '10', '江苏省', '2017-11-03 23:11:00', '2017-11-03 23:11:00');
INSERT INTO `dcs_dictionaries` VALUES (21, 'dic_province', '11', '浙江省', '2017-11-03 23:11:09', '2017-11-03 23:11:09');
INSERT INTO `dcs_dictionaries` VALUES (22, 'dic_province', '12', '安徽省', '2017-11-03 23:11:18', '2017-11-03 23:11:18');
INSERT INTO `dcs_dictionaries` VALUES (23, 'dic_province', '13', '福建省', '2017-11-03 23:11:27', '2017-11-03 23:11:27');
INSERT INTO `dcs_dictionaries` VALUES (24, 'dic_province', '14', '江西省', '2017-11-03 23:11:35', '2017-11-03 23:11:35');
INSERT INTO `dcs_dictionaries` VALUES (25, 'dic_province', '15', '山东省', '2017-11-03 23:11:44', '2017-11-03 23:11:44');
INSERT INTO `dcs_dictionaries` VALUES (26, 'dic_province', '16', '河南省', '2017-11-03 23:11:54', '2017-11-03 23:11:54');
INSERT INTO `dcs_dictionaries` VALUES (27, 'dic_province', '17', '湖北省', '2017-11-03 23:12:02', '2017-11-03 23:12:02');
INSERT INTO `dcs_dictionaries` VALUES (28, 'dic_province', '18', '湖南省', '2017-11-03 23:12:10', '2017-11-03 23:12:10');
INSERT INTO `dcs_dictionaries` VALUES (29, 'dic_province', '19', '广东省', '2017-11-03 23:12:18', '2017-11-03 23:12:18');
INSERT INTO `dcs_dictionaries` VALUES (30, 'dic_province', '20', '广西壮族自治区', '2017-11-03 23:12:27', '2017-11-03 23:12:27');
INSERT INTO `dcs_dictionaries` VALUES (31, 'dic_province', '21', '海南省', '2017-11-03 23:12:39', '2017-11-03 23:12:39');
INSERT INTO `dcs_dictionaries` VALUES (32, 'dic_province', '22', '重庆市', '2017-11-03 23:12:47', '2017-11-03 23:12:47');
INSERT INTO `dcs_dictionaries` VALUES (33, 'dic_province', '23', '四川省', '2017-11-03 23:12:56', '2017-11-03 23:12:56');
INSERT INTO `dcs_dictionaries` VALUES (34, 'dic_province', '24', '贵州省', '2017-11-03 23:13:05', '2017-11-03 23:13:05');
INSERT INTO `dcs_dictionaries` VALUES (35, 'dic_province', '25', '云南省', '2017-11-03 23:13:15', '2017-11-03 23:13:15');
INSERT INTO `dcs_dictionaries` VALUES (36, 'dic_province', '26', '西藏自治区', '2017-11-03 23:13:23', '2017-11-03 23:13:23');
INSERT INTO `dcs_dictionaries` VALUES (37, 'dic_province', '27', '陕西省', '2017-11-03 23:13:31', '2017-11-03 23:13:31');
INSERT INTO `dcs_dictionaries` VALUES (38, 'dic_province', '28', '甘肃省', '2017-11-03 23:13:39', '2017-11-03 23:13:39');
INSERT INTO `dcs_dictionaries` VALUES (39, 'dic_province', '29', '青海省', '2017-11-03 23:13:47', '2017-11-03 23:13:47');
INSERT INTO `dcs_dictionaries` VALUES (40, 'dic_province', '30', '宁夏回族自治区', '2017-11-03 23:13:58', '2017-11-03 23:13:58');
INSERT INTO `dcs_dictionaries` VALUES (41, 'dic_province', '31', '新疆维吾尔自治区', '2017-11-03 23:14:07', '2017-11-03 23:14:07');
INSERT INTO `dcs_dictionaries` VALUES (42, 'dic_province', '32', '台湾省', '2017-11-03 23:14:16', '2017-11-03 23:14:16');
INSERT INTO `dcs_dictionaries` VALUES (43, 'dic_province', '33', '香港特别行政区', '2017-11-03 23:14:25', '2017-11-03 23:14:25');
INSERT INTO `dcs_dictionaries` VALUES (44, 'dic_province', '34', '澳门特别行政区', '2017-11-03 23:14:34', '2017-11-03 23:14:34');
INSERT INTO `dcs_dictionaries` VALUES (45, 'dic_card_type', '16', '礼品卡', '2017-11-03 23:15:35', '2017-11-03 23:15:35');
INSERT INTO `dcs_dictionaries` VALUES (46, 'dic_card_type', '17', '充值卡', '2017-11-03 23:15:49', '2017-11-03 23:15:49');
INSERT INTO `dcs_dictionaries` VALUES (47, 'dic_service_type', '908', '戴尔XPS笔记本升级1年', '2017-11-03 23:16:23', '2017-11-03 23:16:23');

-- ----------------------------
-- Table structure for dcs_histories
-- ----------------------------
DROP TABLE IF EXISTS `dcs_histories`;
CREATE TABLE `dcs_histories`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `dealer_id` int(11) NOT NULL,
  `operation_time` datetime(0) NOT NULL,
  `ip_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_mobile` tinyint(1) NOT NULL,
  `module_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `operation_kind` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `operation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 188 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for dcs_machine_codes
-- ----------------------------
DROP TABLE IF EXISTS `dcs_machine_codes`;
CREATE TABLE `dcs_machine_codes`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `card_id` int(11) NOT NULL DEFAULT 0,
  `register_date` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `code`(`code`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 430 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of dcs_machine_codes
-- ----------------------------
INSERT INTO `dcs_machine_codes` VALUES (287, '7ZRW4Z1', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (288, 'JFSLX02', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (289, '27B3B32', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (290, '2VFTS32', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (291, 'G35PQX1', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (292, 'CVBBR32', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (293, 'FQV3N32', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (294, 'JNJVJW1', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (295, '9KVZ242', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (296, 'FYC2342', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (297, '4HMVS32', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (298, 'H7YTRY1', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (299, '5NLMT32', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (300, '30XPH22', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (301, '23DXLW1', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (302, 'G7GPH22', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (303, '39RP302', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (304, '91XW4Z1', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (305, 'HRWD412', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (306, 'HNMV912', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (307, '6T5Y242', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (308, 'G8J2SZ1', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (309, '42BVJ42', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (310, '603WP32', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (311, '1DT9B32', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (312, 'DN3ZJ22', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (313, '9FDF932', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (314, '1T0D502', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (315, '8745X32', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (316, 'C6K3L22', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (317, 'DMNX932', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (318, 'GJ1M732', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (319, '6HCS712', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (320, 'C88BSZ1', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (321, 'F50BW32', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (322, 'GSDR402', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (323, '5HGL432', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (324, '8DHQ3Z1', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (325, '71QTX32', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (326, '2HRZ4Z1', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (327, '1XBW912', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (328, '4YYX632', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (329, '5G5FW32', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (330, '11NYX32', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (331, '86JTF32', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (332, 'BJ1P532', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (333, 'BK7LX02', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (334, 'G7LP402', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (335, '6717H22', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (336, 'BTZ1X32', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (337, 'J588X32', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (338, 'BSMV212', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (339, '4TV8X32', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (340, 'GSZPH22', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (341, '6H1Q302', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (342, 'BXVP432', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (343, 'C104H22', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (344, '5V04K42', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (345, '1VWBK42', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (346, 'J1RM242', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (347, '8ZDV212', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (348, '2J2T702', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (349, '1DBGF32', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (350, 'F4F0712', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (351, 'H6NM302', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (352, 'HMGJ302', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (353, 'DZLTC32', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (354, 'G4WBL22', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (355, '3J92B12', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (356, '7YCR402', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (357, '6JS5512', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (358, '1X24L22', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (359, 'CZ1Z4Z1', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (360, '4Y5WH22', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (361, '6965X32', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (362, 'DXTN932', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (363, 'HTY6C32', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (364, '5R19L22', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (365, 'DPGBF32', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (366, '1N5DB32', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (367, 'FN5DB32', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (368, 'BW1GD32', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (369, '7P10Z22', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (370, '9VPPD32', 0, '2017-10-24 12:09:32', '2017-10-24 12:09:32', '2017-10-24 12:09:32');
INSERT INTO `dcs_machine_codes` VALUES (371, 'HCHW912', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (372, 'J9Q0632', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (373, '2YV1L22', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (374, 'F41X532', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (375, '1SWX242', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (376, '2412932', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (377, 'BPVM722', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (378, '2JR3Y32', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (379, '81F4H22', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (380, '31WV502', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (381, 'B1WF932', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (382, '1JYVD32', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (383, '520P4Z1', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (384, 'BTKV2Z1', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (385, 'DLKF932', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (386, 'G41FD32', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (387, 'GL52X32', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (388, 'B9LX532', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (389, '2V3V402', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (390, 'BNFW4Z1', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (391, '4BPRBV1', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (392, '334DJ42', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (393, '79Q22Z1', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (394, '6SZB432', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (395, '64D5K22', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (396, 'JWM5X32', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (397, 'FN8D2X1', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (398, 'CJHL912', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (399, '3YKWQX1', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (400, '31WRY22', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (401, '4H8Z1Y1', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (402, '22HZVW1', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (403, 'FJGW4Z1', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (404, '11BD3Z1', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (405, '3SSXQX1', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (406, '9R0P4Z1', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (407, 'C0K7MW1', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (408, '36QZ4Z1', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (409, '5155412', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (410, 'G5GDLW1', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (411, 'CT1D2Z1', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (412, 'D7DWDT1', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (413, '8WQ6RX1', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (414, 'DS9X3Z1', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (415, 'H31BGV1', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (416, 'DP22B12', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (417, '3QVZ512', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (418, '627MR32', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (419, 'FHX9SZ1', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (420, 'CQS11Z1', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (421, 'BZDRQY1', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (422, 'BZ6L2X1', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (423, '6FQPLW1', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (424, 'FRYC722', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (425, 'JZ2N3Z1', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (426, 'BFLC2Z1', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (427, '3CX6C32', 0, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:09:33');
INSERT INTO `dcs_machine_codes` VALUES (428, 'GLJYX32', 10713, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-26 00:41:33');
INSERT INTO `dcs_machine_codes` VALUES (429, '7PMVD32', 360, '2017-10-24 12:09:33', '2017-10-24 12:09:33', '2017-10-24 12:58:17');

-- ----------------------------
-- Table structure for dcs_messages
-- ----------------------------
DROP TABLE IF EXISTS `dcs_messages`;
CREATE TABLE `dcs_messages`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL,
  `src_dealer_id` int(11) NOT NULL,
  `src_user_id` int(11) NOT NULL,
  `tag_dealer_id` int(11) NULL DEFAULT NULL,
  `tag_user_id` int(11) NULL DEFAULT NULL,
  `url` varchar(511) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(511) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `html_message` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_id` int(11) NOT NULL,
  `register_date` datetime(0) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 163 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for dcs_migrations
-- ----------------------------
DROP TABLE IF EXISTS `dcs_migrations`;
CREATE TABLE `dcs_migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 60 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of dcs_migrations
-- ----------------------------
INSERT INTO `dcs_migrations` VALUES (44, '2017_08_28_184652_create_users_table', 1);
INSERT INTO `dcs_migrations` VALUES (45, '2017_09_13_083349_create_product_level_table', 1);
INSERT INTO `dcs_migrations` VALUES (46, '2017_09_13_083546_create_product_table', 1);
INSERT INTO `dcs_migrations` VALUES (47, '2017_09_13_083656_create_dealer_table', 1);
INSERT INTO `dcs_migrations` VALUES (48, '2017_09_13_083755_create_price_table', 1);
INSERT INTO `dcs_migrations` VALUES (49, '2017_09_13_083839_create_promotion_level_table', 1);
INSERT INTO `dcs_migrations` VALUES (50, '2017_09_13_083913_create_promotion_dealer_table', 1);
INSERT INTO `dcs_migrations` VALUES (51, '2017_09_13_083949_create_customer_table', 1);
INSERT INTO `dcs_migrations` VALUES (52, '2017_09_13_084012_create_card_table', 1);
INSERT INTO `dcs_migrations` VALUES (53, '2017_09_13_084104_create_user_table', 1);
INSERT INTO `dcs_migrations` VALUES (54, '2017_09_13_084124_create_role_table', 1);
INSERT INTO `dcs_migrations` VALUES (55, '2017_09_13_084141_create_user_role_table', 1);
INSERT INTO `dcs_migrations` VALUES (56, '2017_09_13_084219_create_order_table', 1);
INSERT INTO `dcs_migrations` VALUES (57, '2017_09_13_084246_create_red_packet_table', 1);
INSERT INTO `dcs_migrations` VALUES (58, '2017_09_13_084316_create_history_table', 1);
INSERT INTO `dcs_migrations` VALUES (59, '2017_09_13_084602_create_option_table', 1);

-- ----------------------------
-- Table structure for dcs_options
-- ----------------------------
DROP TABLE IF EXISTS `dcs_options`;
CREATE TABLE `dcs_options`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `dealer_id` int(11) NOT NULL,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;


-------------------------------
-- Table structure for dcs_orders
-- ----------------------------
DROP TABLE IF EXISTS `dcs_orders`;
CREATE TABLE `dcs_orders`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  `src_dealer_id` int(11) NOT NULL,
  `tag_dealer_id` int(11) NULL DEFAULT NULL,
  `status` int(11) NULL DEFAULT NULL,
  `code_list` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `agree` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: non-allowed, 1: allowed',
  `card_type` tinyint(4) NOT NULL,
  `valid_period` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 53 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for dcs_prices
-- ----------------------------
DROP TABLE IF EXISTS `dcs_prices`;
CREATE TABLE `dcs_prices`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `dealer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `standard_price` int(11) NULL DEFAULT NULL,
  `purchase_price` int(11) NULL DEFAULT NULL,
  `wholesale_price` int(11) NULL DEFAULT NULL,
  `sale_price` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for dcs_product_levels
-- ----------------------------
DROP TABLE IF EXISTS `dcs_product_levels`;
CREATE TABLE `dcs_product_levels`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 33 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of dcs_product_levels
-- ----------------------------
INSERT INTO `dcs_product_levels` VALUES (1, 1, '常规产品', '2017-09-12 12:00:00', '2017-09-16 15:14:34');
INSERT INTO `dcs_product_levels` VALUES (2, 1, '非常规产品', '2017-09-12 12:00:00', '2017-09-16 14:41:53');
INSERT INTO `dcs_product_levels` VALUES (3, 1, '非国行产品', '2017-09-12 12:00:00', '2017-09-12 12:00:00');
INSERT INTO `dcs_product_levels` VALUES (4, 2, '第二级产品分类', '2017-09-12 12:00:00', '2017-09-12 12:00:00');
INSERT INTO `dcs_product_levels` VALUES (5, 1, '特别产品', '2017-09-13 11:53:19', '2017-09-16 14:42:03');
INSERT INTO `dcs_product_levels` VALUES (8, 2, '正品登记本', '2017-09-13 11:53:19', '2017-09-16 16:13:33');
INSERT INTO `dcs_product_levels` VALUES (9, 2, '非正品', '2017-09-13 11:53:19', '2017-09-13 11:53:19');
INSERT INTO `dcs_product_levels` VALUES (13, 2, '正品', '2017-09-13 11:55:20', '2017-09-13 11:55:20');
INSERT INTO `dcs_product_levels` VALUES (14, 2, '非正品', '2017-09-13 11:55:20', '2017-09-13 11:55:20');
INSERT INTO `dcs_product_levels` VALUES (18, 2, '正品', '2017-09-13 11:56:04', '2017-09-13 11:56:04');
INSERT INTO `dcs_product_levels` VALUES (19, 2, '挺好正品', '2017-09-13 11:56:04', '2017-09-16 13:53:38');
INSERT INTO `dcs_product_levels` VALUES (20, 1, '国际产品', '2017-09-16 15:58:06', '2017-09-16 16:02:56');
INSERT INTO `dcs_product_levels` VALUES (21, 2, '好像产品', '2017-09-16 16:01:57', '2017-09-16 16:02:33');
INSERT INTO `dcs_product_levels` VALUES (22, 1, '开业礼物', '2017-09-16 16:12:24', '2017-09-16 16:12:48');
INSERT INTO `dcs_product_levels` VALUES (23, 2, '开业产品', '2017-09-16 16:13:05', '2017-09-16 16:13:05');
INSERT INTO `dcs_product_levels` VALUES (24, 2, '测试分类', '2017-10-06 07:59:34', '2017-10-06 07:59:34');
INSERT INTO `dcs_product_levels` VALUES (25, 3, '自定1', '2017-10-14 17:52:47', '2017-10-14 17:52:47');
INSERT INTO `dcs_product_levels` VALUES (26, 3, '自定2', '2017-10-14 17:53:05', '2017-10-14 17:53:05');
INSERT INTO `dcs_product_levels` VALUES (27, 1, '游戏卡 推广', '2017-10-15 11:35:41', '2017-10-15 11:35:41');
INSERT INTO `dcs_product_levels` VALUES (28, 1, 'Game', '2017-10-18 09:51:59', '2017-10-18 09:51:59');
INSERT INTO `dcs_product_levels` VALUES (29, 2, 'Sina', '2017-10-18 09:52:56', '2017-10-18 09:52:56');
INSERT INTO `dcs_product_levels` VALUES (30, 2, 'Sina', '2017-10-18 09:55:03', '2017-10-18 09:55:03');
INSERT INTO `dcs_product_levels` VALUES (31, 1, 'WOO2', '2017-10-25 12:13:08', '2017-10-25 15:06:42');
INSERT INTO `dcs_product_levels` VALUES (32, 1, 'WOO', '2017-10-25 12:13:18', '2017-10-25 12:13:18');

-- ----------------------------
-- Table structure for dcs_products
-- ----------------------------
DROP TABLE IF EXISTS `dcs_products`;
CREATE TABLE `dcs_products`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `level1_id` int(11) NOT NULL,
  `level2_id` int(11) NOT NULL,
  `level3_id` int(11) NULL DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `valid_period` int(11) NOT NULL DEFAULT 0,
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `standard_price` int(11) NOT NULL,
  `purchase_price_level` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sale_price` int(14) NULL DEFAULT NULL,
  `order_limit_down_level` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `order_limit_up_level` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `service_type` smallint(4) NOT NULL,
  `price_sku` int(11) NULL DEFAULT NULL,
  `price_si` int(11) NULL DEFAULT NULL,
  `price_st` int(11) NULL DEFAULT NULL,
  `price_so` int(11) NULL DEFAULT NULL,
  `price_fd` int(11) NULL DEFAULT NULL,
  `price_mdf` int(11) NULL DEFAULT NULL,
  `discount_rate` double(8, 2) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of dcs_products
-- ----------------------------
INSERT INTO `dcs_products` VALUES (1, 22, 14, 26, '卡卡卡', '｛阿000819｝', '我是开业礼品哦', 1, 36, 'uploads/products/logo/20171023162122_44769.jpeg', 0, NULL, NULL, NULL, NULL, 0, 100, NULL, NULL, NULL, NULL, NULL, NULL, '2017-10-23 16:21:22', '2017-10-23 16:21:22');
INSERT INTO `dcs_products` VALUES (2, 1, 4, NULL, 'Remon', '111-1234', 'Asdff', 1, 24, 'uploads/products/logo/20171023175513_89755.jpeg', 0, NULL, 0, NULL, NULL, 835, 20, NULL, NULL, NULL, NULL, NULL, NULL, '2017-10-23 17:55:13', '2017-10-23 19:30:09');
INSERT INTO `dcs_products` VALUES (3, 2, 8, NULL, 'Te', '345-7654', 'Test project', 1, 24, 'uploads/products/logo/20171026220317_48218.jpeg', 0, NULL, NULL, NULL, NULL, 333, 50, NULL, NULL, NULL, NULL, NULL, NULL, '2017-10-23 19:26:09', '2017-10-26 22:03:17');
INSERT INTO `dcs_products` VALUES (4, 2, 8, NULL, 'Teste', '345-6554', 'Fffghhhf', 0, 24, 'uploads/products/logo/20171023192821_13607.jpeg', 0, NULL, 0, NULL, NULL, 333, 20, NULL, NULL, NULL, NULL, NULL, NULL, '2017-10-23 19:28:21', '2017-10-23 21:07:07');
INSERT INTO `dcs_products` VALUES (5, 1, 8, NULL, 'Test', '2334-6554', 'Test gggg', 1, 24, 'uploads/products/logo/20171023235542_74545.jpeg', 0, NULL, NULL, NULL, NULL, 777, 90, NULL, NULL, NULL, NULL, NULL, NULL, '2017-10-23 23:55:42', '2017-10-23 23:55:42');
INSERT INTO `dcs_products` VALUES (6, 1, 8, NULL, 'Test card', '456-7891', 'Test gjyhgkghj', 1, 12, 'uploads/products/logo/20171024065953_93378.jpeg', 0, NULL, NULL, NULL, NULL, 555, 60, NULL, NULL, NULL, NULL, NULL, NULL, '2017-10-24 06:59:53', '2017-10-24 07:00:15');
INSERT INTO `dcs_products` VALUES (7, 2, 13, 26, '水壶', '09872《日¥¥¥》', '不到半年时间多久', 1, 12, 'uploads/products/logo/20171024122309_32340.jpeg', 0, NULL, 0, NULL, NULL, 29, 100, NULL, NULL, NULL, NULL, NULL, NULL, '2017-10-24 12:23:09', '2017-10-24 12:24:08');
INSERT INTO `dcs_products` VALUES (8, 22, 24, 25, 'kksksk', 'dfgsg0483r979487', 'dgsdgsdfgsdfgsgdfsgdfgdqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqsssssssssssssssssssssssssssssssssssssssqdddddddddddddddddddddddddddddddddddddddddddeerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrregagvsadgfadfadsfasfdasfadgsdgsdfgsdfgsgdfsgdfgdqqqqqqqqqqqqqqqqqqqqqqqq', 1, 12, 'uploads/products/logo/20171025120955_54927.jpeg', 0, NULL, 0, NULL, NULL, 123, 88, NULL, NULL, NULL, NULL, NULL, NULL, '2017-10-25 12:09:55', '2017-10-25 13:56:58');
INSERT INTO `dcs_products` VALUES (9, 22, 29, 26, 'oooooppoo', 'sfsk212321', 'sdfffffffffffffffffffffffffff', 1, 12, 'uploads/products/logo/20171025122849_49157.jpeg', 0, NULL, 0, NULL, NULL, 123, 99, NULL, NULL, NULL, NULL, NULL, NULL, '2017-10-25 12:28:49', '2017-10-25 12:29:39');
INSERT INTO `dcs_products` VALUES (10, 22, 23, 25, '123456789', '3131354', '12333333333333333333333333333333333333333333', 0, 12, 'uploads/products/logo/20171025123259_15649.jpeg', 0, NULL, 0, NULL, NULL, 123, 80, NULL, NULL, NULL, NULL, NULL, NULL, '2017-10-25 12:32:59', '2017-10-27 13:25:57');
INSERT INTO `dcs_products` VALUES (11, 1, 8, 25, '10月26日', '1234-4556', '123455667888', 1, 6, 'uploads/products/logo/20171026004808_86873.jpeg', 0, NULL, 0, NULL, NULL, 123, 123, NULL, NULL, NULL, NULL, NULL, NULL, '2017-10-26 00:48:09', '2017-10-27 13:25:05');
INSERT INTO `dcs_products` VALUES (12, 1, 18, 26, '我都回家待机而动', '0987543', '寒暑假哈哈哈哈给', 1, 1, 'uploads/products/logo/20171030214130_57910.jpeg', 0, '[20,30,40]', 50, '[10,10,10]', '[100,100,100]', 877, 10, NULL, NULL, NULL, NULL, NULL, NULL, '2017-10-30 21:41:30', '2017-10-31 13:11:47');

-- ----------------------------
-- Table structure for dcs_promotions
-- ----------------------------
DROP TABLE IF EXISTS `dcs_promotions`;
CREATE TABLE `dcs_promotions`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `dealer_id` int(11) NULL DEFAULT NULL,
  `level` int(11) NULL DEFAULT NULL,
  `promotion_price` int(11) NOT NULL,
  `promotion_start_date` date NOT NULL,
  `promotion_end_date` date NOT NULL,
  `promotion_network` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of dcs_promotions
-- ----------------------------
INSERT INTO `dcs_promotions` VALUES (5, 12, 1, 1, 80, '2017-11-01', '2017-11-30', 0, '2017-11-04 12:53:23', '2017-11-04 12:53:23');
INSERT INTO `dcs_promotions` VALUES (6, 12, 1, 2, 80, '2017-11-01', '2017-11-30', 0, '2017-11-04 12:54:08', '2017-11-04 12:54:08');

-- ----------------------------
-- Table structure for dcs_red_packet_settings
-- ----------------------------
DROP TABLE IF EXISTS `dcs_red_packet_settings`;
CREATE TABLE `dcs_red_packet_settings`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `dealer_id` int(14) NULL DEFAULT NULL,
  `product_id` int(14) NULL DEFAULT NULL,
  `redpacket_type` tinyint(3) NOT NULL,
  `redpacket_start_date` date NOT NULL,
  `redpacket_end_date` date NOT NULL,
  `redpacket_rule` float(14, 4) NOT NULL,
  `redpacket_price` float(14, 4) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of dcs_red_packet_settings
-- ----------------------------
INSERT INTO `dcs_red_packet_settings` VALUES (1, 1, 1, 1, '2017-11-03', '2017-11-07', 10000.0000, 1000.0000, '2017-11-03 04:12:06', '2017-11-03 04:12:12');

-- ----------------------------
-- Table structure for dcs_red_packets
-- ----------------------------
DROP TABLE IF EXISTS `dcs_red_packets`;
CREATE TABLE `dcs_red_packets`  (
  `id` int(14) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(14) NOT NULL,
  `dealer_id` int(14) NOT NULL,
  `rule_id` int(14) NOT NULL,
  `price` float(14, 4) NOT NULL,
  `count` int(11) NOT NULL,
  `is_arrival` int(2) NULL DEFAULT 0,
  `is_proposal` int(2) NULL DEFAULT 0,
  `proposal_at` date NULL DEFAULT NULL,
  `is_approval` int(2) NULL DEFAULT 0,
  `approval_at` date NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for dcs_roles
-- ----------------------------
DROP TABLE IF EXISTS `dcs_roles`;
CREATE TABLE `dcs_roles`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of dcs_roles
-- ----------------------------
INSERT INTO `dcs_roles` VALUES (1, '经理', '', '2017-09-13 11:52:41', '2017-09-13 11:52:41');
INSERT INTO `dcs_roles` VALUES (2, '店长', '', '2017-09-13 11:52:41', '2017-09-13 11:52:41');
INSERT INTO `dcs_roles` VALUES (3, '店员', '', '2017-09-13 11:52:41', '2017-09-13 11:52:41');

-- ----------------------------
-- Table structure for dcs_sales
-- ----------------------------
DROP TABLE IF EXISTS `dcs_sales`;
CREATE TABLE `dcs_sales`  (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL,
  `product_id` int(11) NOT NULL,
  `card_id` int(14) NOT NULL,
  `tag_dealer_id` int(14) NOT NULL,
  `src_dealer_id` int(14) NOT NULL DEFAULT 0,
  `seller_id` int(14) NULL DEFAULT NULL,
  `purchase_price` decimal(10, 4) NOT NULL DEFAULT 0.0000,
  `promotion_price` decimal(10, 4) NOT NULL DEFAULT 0.0000,
  `sale_price` decimal(10, 4) NOT NULL,
  `sale_date` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `balance_state` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `card_id`(`card_id`, `tag_dealer_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2613 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for dcs_shop_kinds
-- ----------------------------
DROP TABLE IF EXISTS `dcs_shop_kinds`;
CREATE TABLE `dcs_shop_kinds`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of dcs_shop_kinds
-- ----------------------------
INSERT INTO `dcs_shop_kinds` VALUES (1, '家用品类点', '2017-10-01 09:44:58', '2017-10-01 09:44:58');
INSERT INTO `dcs_shop_kinds` VALUES (2, '家用专卖点', '2017-10-01 09:44:58', '2017-10-01 09:44:58');
INSERT INTO `dcs_shop_kinds` VALUES (3, 'Alienware专卖点', '2017-10-01 09:44:58', '2017-10-01 09:44:58');
INSERT INTO `dcs_shop_kinds` VALUES (4, '家用专卖大店', '2017-10-01 09:44:58', '2017-10-01 09:44:58');
INSERT INTO `dcs_shop_kinds` VALUES (5, '成就商用专卖点', '2017-10-01 09:44:58', '2017-10-01 09:44:58');
INSERT INTO `dcs_shop_kinds` VALUES (6, '商用金钻点', '2017-10-01 09:44:58', '2017-10-01 09:44:58');
INSERT INTO `dcs_shop_kinds` VALUES (7, '成就专买大店', '2017-10-01 09:44:58', '2017-10-01 09:44:58');
INSERT INTO `dcs_shop_kinds` VALUES (8, '成就商用专柜', '2017-10-01 09:44:58', '2017-10-01 09:44:58');
INSERT INTO `dcs_shop_kinds` VALUES (9, '家用专柜', '2017-10-01 09:44:58', '2017-10-01 09:44:58');
INSERT INTO `dcs_shop_kinds` VALUES (10, '家用金钻店', '2017-10-01 09:44:58', '2017-10-01 09:44:58');
INSERT INTO `dcs_shop_kinds` VALUES (11, '家用乡镇专店', '2017-10-01 09:44:58', '2017-10-01 09:44:58');
INSERT INTO `dcs_shop_kinds` VALUES (12, '淘宝专卖店', '2017-10-01 09:44:58', '2017-10-01 09:44:58');
INSERT INTO `dcs_shop_kinds` VALUES (13, '成就商用品类点', '2017-10-01 09:44:58', '2017-10-01 09:44:58');
INSERT INTO `dcs_shop_kinds` VALUES (14, '成就商用虚拟店', '2017-10-01 09:44:58', '2017-10-01 09:44:58');
INSERT INTO `dcs_shop_kinds` VALUES (15, '高端点', '2017-10-01 09:44:58', '2017-10-01 09:44:58');
INSERT INTO `dcs_shop_kinds` VALUES (16, '品类点', '2017-10-01 09:44:58', '2017-10-01 09:44:58');

-- ----------------------------
-- Table structure for dcs_shop_levels
-- ----------------------------
DROP TABLE IF EXISTS `dcs_shop_levels`;
CREATE TABLE `dcs_shop_levels`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of dcs_shop_levels
-- ----------------------------
INSERT INTO `dcs_shop_levels` VALUES (1, '1星级', '2017-10-01 09:44:59', '2017-10-01 09:44:59');
INSERT INTO `dcs_shop_levels` VALUES (2, '2星级', '2017-10-01 09:44:59', '2017-10-01 09:44:59');
INSERT INTO `dcs_shop_levels` VALUES (3, '3星级', '2017-10-01 09:44:59', '2017-10-01 09:44:59');
INSERT INTO `dcs_shop_levels` VALUES (4, '4星级', '2017-10-01 09:44:59', '2017-10-01 09:44:59');
INSERT INTO `dcs_shop_levels` VALUES (5, '5星级', '2017-10-01 09:44:59', '2017-10-01 09:44:59');
INSERT INTO `dcs_shop_levels` VALUES (6, 'C', '2017-10-01 09:44:59', '2017-10-01 09:44:59');
INSERT INTO `dcs_shop_levels` VALUES (7, 'C+', '2017-10-01 09:44:59', '2017-10-01 09:44:59');
INSERT INTO `dcs_shop_levels` VALUES (8, 'C-', '2017-10-01 09:44:59', '2017-10-01 09:44:59');

-- ----------------------------
-- Table structure for dcs_shop_properties
-- ----------------------------
DROP TABLE IF EXISTS `dcs_shop_properties`;
CREATE TABLE `dcs_shop_properties`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of dcs_shop_properties
-- ----------------------------
INSERT INTO `dcs_shop_properties` VALUES (1, '专卖店', '2017-10-01 09:44:59', '2017-10-01 09:44:59');
INSERT INTO `dcs_shop_properties` VALUES (2, '品类点', '2017-10-01 09:44:59', '2017-10-01 09:44:59');
INSERT INTO `dcs_shop_properties` VALUES (3, '专柜', '2017-10-01 09:44:59', '2017-10-01 09:44:59');
INSERT INTO `dcs_shop_properties` VALUES (4, '虚拟店', '2017-10-01 09:44:59', '2017-10-01 09:44:59');

-- ----------------------------
-- Table structure for dcs_stocks
-- ----------------------------
DROP TABLE IF EXISTS `dcs_stocks`;
CREATE TABLE `dcs_stocks`  (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `product_id` int(14) NOT NULL,
  `dealer_id` int(14) NOT NULL,
  `size_in_store` int(11) NOT NULL,
  `size_of_just_empire` int(11) NOT NULL,
  `size_of_empire30` int(11) NOT NULL,
  `size_of_saled` int(11) NOT NULL,
  `size_of_registered` int(11) NOT NULL,
  `size_of_activated` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for dcs_users
-- ----------------------------
DROP TABLE IF EXISTS `dcs_users`;
CREATE TABLE `dcs_users`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dd_account` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dealer_id` int(11) NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_message_id` int(11) NOT NULL DEFAULT 0,
  `last_product_id` int(14) NOT NULL DEFAULT 0,
  `last_purchase_id` int(14) NOT NULL DEFAULT 0,
  `last_order_id` int(14) NOT NULL DEFAULT 0,
  `last_price_id` int(14) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of dcs_users
-- ----------------------------
INSERT INTO `dcs_users` VALUES (6, '赵斤', 1, '18640211091', '', '1254232969931006755', 1, 'http://static.dingtalk.com/media/lADPACOG8243U8BkZA_100_100.jpg', 137, 162, 0, 162, 0, '2017-10-01 17:03:57', '2017-11-04 20:18:39');
INSERT INTO `dcs_users` VALUES (7, 'Cui', 1, '13390245749', 'rubyshine72@outlook.com', '125527541998633', 1, 'http://static.dingtalk.com/media/lADPBbCc1QSwIYrNAkDNAkA_576_576.jpg', 152, 156, 119, 150, 0, '2017-10-01 17:06:57', '2017-11-04 11:45:52');
INSERT INTO `dcs_users` VALUES (8, '金永日', 2, '18512452149', 'heracles1989223@yandex.com', '125700410644490715', 34, '', 137, 119, 79, 79, 0, '2017-10-01 17:14:47', '2017-10-31 13:37:41');
INSERT INTO `dcs_users` VALUES (9, '马工', 1, '13901055262', '', '305638641249529', 1, '', 0, 0, 0, 0, 0, '2017-10-02 09:51:55', '2017-10-08 16:42:58');
INSERT INTO `dcs_users` VALUES (10, '朴文虎', 1, '18600039990', '', '093643305526229723', 1, '', 117, 135, 0, 133, 0, '2017-10-08 18:10:19', '2017-10-30 21:55:29');
INSERT INTO `dcs_users` VALUES (11, 'Eva', 3, '13910169990', '', '141168522270064', 18, '', 0, 0, 0, 0, 0, '2017-10-10 11:26:48', '2017-10-11 17:04:14');
INSERT INTO `dcs_users` VALUES (12, 'SY', 2, '15104007277', '', '14116961012662', 36, '', 39, 35, 39, 39, 0, '2017-10-10 11:28:25', '2017-10-24 12:41:42');
INSERT INTO `dcs_users` VALUES (13, '钩子', 2, '18309810103', '', '09364332401203143', 35, '', 137, 135, 38, 38, 0, '2017-10-10 14:22:33', '2017-11-01 14:19:55');
INSERT INTO `dcs_users` VALUES (14, 'Tommy2017', 1, '13080896213', '', '1369186826-136386494', 1, '', 119, 156, 22, 150, 0, '2017-10-10 22:08:13', '2017-11-04 04:23:02');
INSERT INTO `dcs_users` VALUES (16, '郑幽', 2, '18600987212', '', '14120401691173452', 37, '', 105, 40, 43, 0, 0, '2017-10-11 17:22:00', '2017-10-27 10:58:40');
INSERT INTO `dcs_users` VALUES (17, '王建伟', 2, '18910528811', '', '013356222529199408', 40, '', 116, 79, 99, 99, 0, '2017-10-15 15:40:07', '2017-10-27 14:39:59');
INSERT INTO `dcs_users` VALUES (18, '王', 2, '17710363511', '', '095265111829579', 39, '', 100, 0, 100, 100, 0, '2017-10-15 19:37:34', '2017-10-26 00:30:53');
INSERT INTO `dcs_users` VALUES (19, 'wjw', 2, '13953128811', '', '1418686166117764', 38, '', 137, 119, 96, 95, 0, '2017-10-15 19:40:17', '2017-11-02 11:48:46');
INSERT INTO `dcs_users` VALUES (20, '元先生', 1, '18698808679', '', '145226165920666714', 1, '', 162, 162, 0, 162, 0, '2017-11-05 11:54:19', '2017-11-05 12:07:54');

SET FOREIGN_KEY_CHECKS = 1;
