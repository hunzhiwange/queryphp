<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class PermissionResource extends AbstractMigration
{
    public function up(): void
    {
        $this->struct();
        $this->seed();
    }

    public function down(): void
    {
        $this->table('permission_resource')->drop()->save();
    }

    private function struct(): void
    {
        $sql = <<<'EOT'
            CREATE TABLE `permission_resource` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
                `platform_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '平台ID',
                `permission_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '权限ID',
                `resource_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '资源ID',
                `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
                `delete_at` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '删除时间 0=未删除;大于0=删除时间;',
                `create_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '创建账号',
                `update_account` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '更新账号',
                `version` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作版本号',
                PRIMARY KEY (`id`),
                UNIQUE KEY `uniq_permission_resource` (`platform_id`,`permission_id`,`resource_id`,`delete_at`) USING BTREE COMMENT '权限资源关联'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限资源关联';
            EOT;
        $this->execute($sql);
    }

    private function seed(): void
    {
        $sql = <<<'EOT'
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566731648307200, 100000, 4146175016046592, 4145944266412032, '2019-01-31 01:14:34', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566731665084416, 100000, 4146175032823808, 4145944388046848, '2019-01-31 09:22:11', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566731677667328, 100000, 4146175041212416, 4145944027336704, '2019-01-31 01:54:59', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566731690250240, 100000, 4146175041212416, 4145944199303168, '2019-01-31 09:23:37', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566731702833152, 100000, 4146175041212416, 4145944216080384, '2019-01-31 01:54:59', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566731723804672, 100000, 4146175041212416, 4145944228663296, '2019-01-31 09:23:37', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566731740581888, 100000, 4146175041212416, 4145944241246208, '2019-01-31 09:23:37', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566731757359104, 100000, 4146175041212416, 4145944295772160, '2019-01-31 09:23:37', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566731790913536, 100000, 4146175041212416, 4145944425795584, '2019-01-31 09:23:37', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566731816079360, 100000, 4146175041212416, 4145944438378496, '2019-01-31 09:23:37', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566731837050880, 100000, 4146175041212416, 4145944455155712, '2019-01-31 09:23:37', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566731866411008, 100000, 4146175041212416, 4145944656482304, '2019-01-31 09:23:37', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566731887382528, 100000, 4146175053795328, 4145944014753792, '2019-01-31 09:24:27', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566731912548352, 100000, 4146175053795328, 4145944144777216, '2019-01-31 09:24:27', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566731929325568, 100000, 4146175053795328, 4145944157360128, '2019-01-31 09:24:27', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566731946102784, 100000, 4146175053795328, 4145944169943040, '2019-01-31 09:24:27', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566731971268608, 100000, 4146175053795328, 4145944186720256, '2019-01-31 09:24:27', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566731983851520, 100000, 4146175053795328, 4145944333520896, '2019-01-31 09:24:27', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566731996434432, 100000, 4146175053795328, 4145944467738624, '2019-01-31 09:24:27', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732029988864, 100000, 4146175053795328, 4145944480321536, '2019-01-31 09:24:27', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732071931904, 100000, 4146175053795328, 4145944492904448, '2019-01-31 09:24:27', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732092903424, 100000, 4146175053795328, 4145944509681664, '2019-01-31 09:24:27', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732109680640, 100000, 4146175053795328, 4145944627122176, '2019-01-31 09:24:27', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732126457856, 100000, 4146175053795328, 4145944669065216, '2019-01-31 09:50:17', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732155817984, 100000, 4146175053795328, 4145944694231040, '2019-01-31 09:52:50', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732176789504, 100000, 4146175070572544, 4145944002170880, '2019-01-31 09:25:04', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732193566720, 100000, 4146175070572544, 4145944090251264, '2019-01-31 09:25:04', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732214538240, 100000, 4146175070572544, 4145944102834176, '2019-01-31 09:25:04', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732231315456, 100000, 4146175070572544, 4145944119611392, '2019-01-31 09:25:04', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732256481280, 100000, 4146175070572544, 4145944128000000, '2019-01-31 09:25:04', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732281647104, 100000, 4146175070572544, 4145944308355072, '2019-01-31 09:25:04', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732294230016, 100000, 4146175070572544, 4145944388046848, '2019-01-31 09:25:04', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732311007232, 100000, 4146175070572544, 4145944555819008, '2019-01-31 09:25:04', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732327784448, 100000, 4146175070572544, 4145944568401920, '2019-01-31 09:25:04', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732340367360, 100000, 4146175070572544, 4145944585179136, '2019-01-31 09:25:04', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732352950272, 100000, 4146175070572544, 4145944601956352, '2019-01-31 09:25:04', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732361338880, 100000, 4146175070572544, 4145944643899392, '2019-01-31 09:25:04', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732373921792, 100000, 4146175070572544, 4145944681648128, '2019-01-31 09:50:30', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732420059136, 100000, 4146175070572544, 4145944706813952, '2019-01-31 09:53:16', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732432642048, 100000, 4146175078961152, 4145943985393664, '2019-01-31 09:25:35', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732449419264, 100000, 4146175078961152, 4145944039919616, '2019-01-31 09:25:35', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732462002176, 100000, 4146175078961152, 4145944052502528, '2019-01-31 09:25:35', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732478779392, 100000, 4146175078961152, 4145944065085440, '2019-01-31 09:25:35', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732491362304, 100000, 4146175078961152, 4145944077668352, '2019-01-31 09:25:35', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732499750912, 100000, 4146175078961152, 4145944320937984, '2019-01-31 09:25:35', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732512333824, 100000, 4146175078961152, 4145944522264576, '2019-01-31 09:25:35', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732524916736, 100000, 4146175078961152, 4145944530653184, '2019-01-31 09:25:35', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732541693952, 100000, 4146175078961152, 4145944543236096, '2019-01-31 09:25:35', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732566859776, 100000, 4146175078961152, 4145944585179136, '2019-01-31 09:25:35', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732587831296, 100000, 4146175078961152, 4145944614539264, '2019-01-31 09:25:35', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732600414208, 100000, 4146175091544064, 4145944400629760, '2019-01-31 09:21:27', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732612997120, 100000, 4146175091544064, 4145944413212672, '2019-01-31 09:21:27', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732629774336, 100000, 4146175104126976, 4145944371269632, '2019-01-31 09:21:44', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732650745856, 100000, 4146175116709888, 4145944253829120, '2019-01-31 09:21:55', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732663328768, 100000, 4146175116709888, 4145944278994944, '2019-01-31 09:21:55', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732684300288, 100000, 4146175116709888, 4145944346103808, '2019-01-31 09:21:55', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732696883200, 100000, 4146175167041536, 4145944765534208, '2021-01-14 01:32:12', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732713660416, 100000, 4146175154458624, 4145944748756992, '2021-01-14 01:31:59', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732730437632, 100000, 4146175141875712, 4145944736174080, '2021-01-14 01:31:50', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732743020544, 100000, 4146175129292800, 4145944723591168, '2021-01-14 01:31:40', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732759797760, 100000, 4146175041212416, 4145944778117120, '2021-07-22 07:38:07', '2023-03-26 13:08:00', 0, 0, 0, 0);
INSERT INTO `permission_resource`(`id`, `platform_id`, `permission_id`, `resource_id`, `create_at`, `update_at`, `delete_at`, `create_account`, `update_account`, `version`) VALUES (7566732772380672, 100000, 4146175041212416, 4145944790700032, '2021-08-14 06:30:47', '2023-03-26 13:08:00', 0, 0, 0, 0);
EOT;
        $this->execute($sql);
    }
}
