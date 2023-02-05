<?php

declare(strict_types=1);

namespace App\Infra;

use Exception;
use Leevel\Http\Request;
use stdClass;
use Tests\TestCase;
use Throwable;

class ModelTest extends TestCase
{
    public function testQuickQuery1(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_name|brand_num'] = 'QueryPHP';
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE ( `brand_name` = 'QueryPHP' OR `brand_num` = 'QueryPHP' )";
        $this->assertSame($result, $sql);
    }

    public function testQuickQuery1Sub1(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_name'] = 'QueryPHP';
        $map['brand_num'] = 'QueryPHP';
        $map['_logic'] = 'OR';
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_name` = 'QueryPHP' OR `brand_num` = 'QueryPHP'";
        $this->assertSame($result, $sql);
    }

    public function testQuickQueryAndTotal(): void
    {
        container()->instance('company_id', 0);

        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_name|brand_num'] = 'QueryPHP';
        $data = $baseBrandModel
            ->where($map)
            ->field('brand_id,brand_name')
            ->limit(5)
            ->select();
        $result = trim($baseBrandModel->getLastSql());
        $sql = "SELECT  `brand_id`,`brand_name` FROM `base_brand` WHERE ( `brand_name` = 'QueryPHP' OR `brand_num` = 'QueryPHP' ) LIMIT 5";
        $this->assertSame($result, $sql);

        $data = $baseBrandModel
            ->where($map)
            ->field('brand_id,brand_name')
            ->limit(5)
            ->count();
        $result = trim($baseBrandModel->getLastSql());
        $sql = "SELECT  COUNT(*) AS count FROM `base_brand` WHERE ( `brand_name` = 'QueryPHP' OR `brand_num` = 'QueryPHP' ) LIMIT 1";
        $this->assertSame($result, $sql);

        $data = $baseBrandModel
            ->where($map)
            ->field('brand_id,brand_name')
            ->limit(5)
            ->findListAndCount();
        $result = trim($baseBrandModel->getLastSql());
        $sql = "SELECT  `brand_id`,`brand_name` FROM `base_brand` WHERE `company_id` = 0 LIMIT 5";
        $this->assertSame($result, $sql);

        $count = $baseBrandModel->fetchTotalCount();
        $this->assertTrue(is_int($count));
    }

    public function testQuickQuery2(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_name&brand_num'] = array('品牌1', '品牌2', '_multi' => true);
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE ( (`brand_name` = '品牌1') AND (`brand_num` = '品牌2') )";
        $this->assertSame($result, $sql);
    }

    public function testQuickQuery2Sub2(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_name'] = '品牌1';
        $map['brand_num'] = '品牌2';
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_name` = '品牌1' AND `brand_num` = '品牌2'";
        $this->assertSame($result, $sql);
    }

    public function testQuickQuery3(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['`brand_name`&brand_num&`brand_logo`'] = array('1', array('gt', '0'), 'QueryPHP', '_multi' => true);
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE ( (`brand_name` = '1') AND (`brand_num` > '0') AND (`brand_logo` = 'QueryPHP') )";
        $this->assertSame($result, $sql);
    }

    public function testQuickQuery3Sub1(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_name'] = '1';
        $map['brand_num'] = array('gt', 0);
        $map['brand_logo'] = 'QueryPHP';
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_name` = '1' AND `brand_num` > 0 AND `brand_logo` = 'QueryPHP'";
        $this->assertSame($result, $sql);
    }

    public function testQuery1(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map = "brand_name='q' AND brand_num='y'";
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE ( brand_name='q' AND brand_num='y' )";
        $this->assertSame($result, $sql);
    }

    public function testQuery2(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_name'] = 'h';
        $map['brand_num'] = 'y';
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_name` = 'h' AND `brand_num` = 'y'";
        $this->assertSame($result, $sql);
    }

    public function testQuery3(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_name'] = 'h';
        $map['brand_num'] = 'y';
        $map['_logic'] = 'OR';
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_name` = 'h' OR `brand_num` = 'y'";
        $this->assertSame($result, $sql);
    }

    public function testQuery4(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map = new stdClass();
        $map->brand_name = 'hello';
        $map->brand_num = 'world';
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_name` = 'hello' AND `brand_num` = 'world'";
        $this->assertSame($result, $sql);
    }

    public function testQuery5(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_name'] = 'h';
        $map['brand_num'] = 'y';
        $map['not_found_field'] = 'y';
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_name` = 'h' AND `brand_num` = 'y'";
        $this->assertSame($result, $sql);
    }

    public function testQuery6(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_name'] = array('eq', 'h');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_name` = 'h'";
        $this->assertSame($result, $sql);
    }

    public function testQuery7(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_name'] = array('neq', 'h');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_name` <> 'h'";
        $this->assertSame($result, $sql);
    }

    public function testQuery8(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_name'] = array('gt', 'h');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_name` > 'h'";
        $this->assertSame($result, $sql);
    }

    public function testQuery9(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_name'] = array('egt', 'h');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_name` >= 'h'";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub1(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_name'] = array('lt', 'h');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_name` < 'h'";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub3(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_name'] = array('elt', 'h');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_name` <= 'h'";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub4(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_name'] = array('like', 'h%');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_name` LIKE 'h%'";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub5(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_name'] = array('notlike', 'h%');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_name` NOT LIKE 'h%'";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub6(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_name'] = array('like', array('%thinkphp%', '%q'), 'OR');
        $map['brand_num'] = array('notlike', array('%thinkphp%', '%q'), 'AND');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE (`brand_name` LIKE '%thinkphp%' OR `brand_name` LIKE '%q') AND (`brand_num` NOT LIKE '%thinkphp%' AND `brand_num` NOT LIKE '%q')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub7(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_id'] = array('between', '1,8');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_id` BETWEEN '1' AND '8'";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub8(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_id'] = array('between', array('1', '8'));
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_id` BETWEEN '1' AND '8'";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub9(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_id'] = array('notbetween', array('1', '8'));
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_id` NOT BETWEEN '1' AND '8'";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub10(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_id'] = array('notbetween', '1,8');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_id` NOT BETWEEN '1' AND '8'";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub11(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_id'] = array('not in', '1,5,8');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_id` NOT IN ('1','5','8')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub12(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_id'] = array('in', '1,5,8');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_id` IN ('1','5','8')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub13(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_id'] = array('in', '1,5,8');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_id` IN ('1','5','8')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub14(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_id'] = array('in', '1,5,8');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_id` IN ('1','5','8')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub15(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_id'] = array('not in', array('1', '5', '8'));
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_id` NOT IN ('1','5','8')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub16(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_id'] = array('in', array('1', '5', '8'));
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_id` IN ('1','5','8')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub17(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_id'] = array('exp', ' IN (1,3,8) ');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_id`  IN (1,3,8)";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub18(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        // 要修改的数据对象属性赋值
        $data['brand_name'] = 'ThinkPHP';
        $data['company_id'] = array('exp', 'company_id+1');// 品牌的公司ID加1
        $baseBrandModel->where('brand_id=5')->save($data); // 根据条件保存修改的数据
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "UPDATE `base_brand` SET `brand_name`='ThinkPHP',`company_id`=company_id+1 WHERE ( brand_id=5 )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub19(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_id'] = array(array('gt', 1), array('lt', 10));
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE ( `brand_id` > 1 AND `brand_id` < 10  )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub20(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_id'] = array(array('gt', 3), array('lt', 10), 'or');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE ( `brand_id` > 3 OR `brand_id` < 10 )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub21(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_id'] = array(array('neq', 6), array('gt', 3), 'and');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE ( `brand_id` <> 6 AND `brand_id` > 3  )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub22(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_id'] = array(array('like', '%a%'), array('like', '%b%'), array('like', '%c%'), 'ThinkPHP', 'or');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE ( `brand_id` LIKE '%a%' OR `brand_id` LIKE '%b%' OR `brand_id` LIKE '%c%' OR `brand_id` = 'ThinkPHP' )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub23(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_id'] = array('neq', 1);
        $map['brand_name'] = 'ok';
        $map['_string'] = 'company_id=1 AND order_num>10';
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_id` <> 1 AND `brand_name` = 'ok' AND ( company_id=1 AND order_num>10 )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub24(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_id'] = array('gt', '100');
        $map['_query'] = 'company_id=1&order_num=100&_logic=or';
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_id` > '100' AND ( `company_id` = '1' OR `order_num` = '100' )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub25(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $where['brand_name'] = array('like', '%thinkphp%');
        $where['order_num'] = array('like', '%thinkphp%');
        $where['_logic'] = 'or';
        $map['_complex'] = $where;
        $map['brand_id'] = array('gt', 1);
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE (  `brand_name` LIKE '%thinkphp%' OR `order_num` LIKE '%thinkphp%' ) AND `brand_id` > 1";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub26(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_id'] = array('gt', 1);
        $map['_string'] = ' (`brand_name` like "%thinkphp%")  OR ( order_num like "%thinkphp") ';
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_id` > 1 AND (  (`brand_name` like \"%thinkphp%\")  OR ( order_num like \"%thinkphp\")  )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub27(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $count = $baseBrandModel
            ->count();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  COUNT(*) AS count FROM `base_brand` LIMIT 1";
        $this->assertSame($result, $sql);
        $this->assertTrue(is_int($count));
    }

    public function testQuerySub28(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $count = $baseBrandModel
            ->count('brand_id');
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  COUNT(brand_id) AS count FROM `base_brand` LIMIT 1";
        $this->assertSame($result, $sql);
        $this->assertTrue(is_int($count));
    }

    public function testQuerySub29(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $count = $baseBrandModel
            ->max('brand_id');
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  MAX(brand_id) AS max FROM `base_brand` LIMIT 1";
        $this->assertSame($result, $sql);
        $this->assertTrue(is_int($count));
    }

    public function testQuerySub30(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $count = $baseBrandModel
            ->where('brand_id>0')->min('brand_id');
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  MIN(brand_id) AS min FROM `base_brand` WHERE ( brand_id>0 ) LIMIT 1";
        $this->assertSame($result, $sql);
        $this->assertTrue(is_int($count));
    }

    public function testQuerySub31(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('brand_id>0')->avg('brand_id');
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  AVG(brand_id) AS avg FROM `base_brand` WHERE ( brand_id>0 ) LIMIT 1";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub32(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('brand_id>0')
            ->sum('brand_id');
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  SUM(brand_id) AS sum FROM `base_brand` WHERE ( brand_id>0 ) LIMIT 1";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub33(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->query("select * from `base_brand` WHERE `brand_id`=83");
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "select * from `base_brand` WHERE `brand_id`=83";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub34(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->execute("update `base_brand` set `brand_name`='hello' WHERE `brand_id`=83");
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "update `base_brand` set `brand_name`='hello' WHERE `brand_id`=83";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub35(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->getByBrandName('liu21st');
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_name` = 'liu21st' LIMIT 1";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub36(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->getByBrandLogo('liu21st');
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_logo` = 'liu21st' LIMIT 1";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub37(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->getFieldByBrandName('Google', 'brand_id');
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  `brand_id` FROM `base_brand` WHERE `brand_name` = 'Google' LIMIT 1";
        $this->assertSame($result, $sql);
    }


    public function testQuerySub38(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $subQuery = $baseBrandModel
            ->field('brand_id,brand_name')
            ->table('base_brand')
            ->group('brand_name')
            ->where([
                'brand_id' => 1,
            ])
            ->order('brand_id DESC')
            ->select(false);
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  `brand_id`,`brand_name` FROM `base_brand` GROUP BY brand_name ORDER BY brand_id DESC";
        $this->assertSame($result, $sql);
        $this->assertSame($subQuery, '( ' . $sql . '  )');
    }

    public function testQuerySub39(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $subQuery = $baseBrandModel
            ->field('brand_id,brand_name')
            ->table('base_brand')
            ->group('brand_name')
            ->where([
                'brand_id' => 1,
            ])
            ->order('brand_id DESC')
            ->buildSql();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  `brand_id`,`brand_name` FROM `base_brand` GROUP BY brand_name ORDER BY brand_id DESC";
        $this->assertSame($result, $sql);
        $this->assertSame($subQuery, '( ' . $sql . '  )');
    }

    public function testQuerySub40(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $subQuery = $baseBrandModel
            ->field('brand_id,brand_name')
            ->group('brand_id')
            ->where([
                'brand_id' => 1,
            ])
            ->order('brand_id DESC')
            ->buildSql();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  `brand_id`,`brand_name` FROM `base_brand` WHERE `brand_id` = 1 GROUP BY brand_id ORDER BY brand_id DESC";
        $this->assertSame($result, $sql);
        $this->assertSame($subQuery, '( ' . $sql . '  )');

        $baseBrandModel
            ->table($subQuery . ' a')
            ->where([
                'a.brand_name' => '你好',
            ])
            ->order('a.brand_id DESC')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM ( SELECT  `brand_id`,`brand_name` FROM `base_brand` WHERE `brand_id` = 1 GROUP BY brand_id ORDER BY brand_id DESC  ) a WHERE a.brand_name = '你好' ORDER BY a.brand_id DESC";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub41(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->forceMaster()
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "/*FORCE_MASTER*/ SELECT  * FROM `base_brand`";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub42(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->limit('0,5')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` LIMIT 0,5";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub43(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->limit(1, 5)
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` LIMIT 1,5";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub44(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->group('brand_id')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` GROUP BY brand_id";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub45(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->order('brand_id DESC')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` ORDER BY brand_id DESC";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub46(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->field('brand_id')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  `brand_id` FROM `base_brand`";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub47(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->comment('注释')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` /*注释*/";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub48(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->page(3, 5)
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` LIMIT 10,5";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub49(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->page('3,5')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` LIMIT 10,5";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub50(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('brand_id=1 AND `brand_name`=1')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE ( brand_id=1 AND `brand_name`=1 )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub51(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where("brand_id=%d and `brand_name`='%s' and `brand_logo`='%f'", array(1, 'hello', 0.5))
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE ( brand_id=1 and `brand_name`='hello' and `brand_logo`='0.500000' )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub52(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where("brand_id=%d and `brand_name`='%s' and `brand_logo`='%f'", 1, 'hello', 0.5)
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE ( brand_id=1 and `brand_name`='hello' and `brand_logo`='0.500000' )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub53(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_name'] = 'thinkphp';
        $map['brand_logo'] = '1';
        $baseBrandModel
            ->where($map)
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_name` = 'thinkphp' AND `brand_logo` = '1'";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub54(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_name'] = 'thinkphp';
        $map['brand_logo'] = 'thinkphp';
        $where['brand_logo'] = '1';
        $baseBrandModel
            ->where($map)
            ->where($where)
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_name` = 'thinkphp' AND `brand_logo` = '1'";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub55(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->table('base_brand')
            ->where('brand_id<2')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE ( brand_id<2 )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub56(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->table('base_brand')
            ->where('brand_id<2')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE ( brand_id<2 )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub57(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->field('brand.brand_name,p.name')
            ->table('base_brand brand,permission p')
            ->limit(10)
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  brand.brand_name,p.name FROM base_brand brand,permission p LIMIT 10";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub58(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->field('brand.`brand_name`,p.name')
            ->table(array('`base_brand`' => 'brand', 'permission' => 'p'))
            ->limit(10)
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  brand.`brand_name`,p.name FROM `base_brand` `brand`,`permission` `p` LIMIT 10";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub59(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->alias('a')
            ->join('permission b ON b.id= a.brand_id')
            ->limit(10)
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM base_brand a INNER JOIN permission b ON b.id= a.brand_id  LIMIT 10";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub60(): void
    {
        container()->instance('company_id', 999);
        http_request()->request->set('brand_name', 'hello');
        http_request()->server->set('REQUEST_METHOD', Request::METHOD_POST);
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where(['brand_name' => 'hello'])
            ->delete();
        $baseBrandModel->create(['brand_name' => 'hello']);
        $baseBrandModel->add();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "INSERT INTO `base_brand` (`brand_name`,`company_id`) VALUES ('hello','999')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub61(): void
    {
        container()->instance('company_id', 999);
        http_request()->request->set('brand_name', 'hello');
        http_request()->server->set('REQUEST_METHOD', Request::METHOD_POST);
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where(['brand_name' => 'hello'])
            ->delete();
        $baseBrandModel->create();
        $baseBrandModel->add();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "INSERT INTO `base_brand` (`brand_name`,`company_id`) VALUES ('hello','999')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub62(): void
    {
        container()->instance('company_id', 999);
        http_request()->request->set('brand_name', 'hello');
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel->brand_name = 'helloworld';
        $baseBrandModel->add();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "INSERT INTO `base_brand` (`brand_name`) VALUES ('helloworld')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub63(): void
    {
        container()->instance('company_id', 999);
        http_request()->request->set('brand_name', 'hello');
        $baseBrandModel = BaseBrandTestModel::make();
        $data['brand_name'] = 'helloworld';
        $baseBrandModel->data($data)->add();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "INSERT INTO `base_brand` (`brand_name`) VALUES ('helloworld')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub67(): void
    {
        container()->instance('company_id', 999);
        http_request()->request->set('brand_name', 'hello');
        $baseBrandModel = BaseBrandTestModel::make();
        $data['brand_name'] = 'helloworld';
        $baseBrandModel->data()->add($data);
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "INSERT INTO `base_brand` (`brand_name`) VALUES ('helloworld')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub64(): void
    {
        container()->instance('company_id', 999);
        http_request()->request->set('brand_name', 'hello');
        $baseBrandModel = BaseBrandTestModel::make();
        $data = new stdClass();
        $data->brand_name = 'helloworld';
        $baseBrandModel->data($data)->add();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "INSERT INTO `base_brand` (`brand_name`) VALUES ('helloworld')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub65(): void
    {
        container()->instance('company_id', 999);
        http_request()->request->set('brand_name', 'hello');
        $baseBrandModel = BaseBrandTestModel::make();
        $data = 'brand_name=hi&brand_logo=hello';
        $baseBrandModel->data($data)->add();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "INSERT INTO `base_brand` (`brand_name`,`brand_logo`) VALUES ('hi','hello')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub68(): void
    {
        container()->instance('company_id', 999);
        http_request()->request->set('brand_name', 'hello');
        $baseBrandModel = BaseBrandTestModel::make();
        $data['brand_id'] = 8;
        $data['brand_name'] = '流年';
        $data['brand_logo'] = 'thinkphp@qq.com';
        $baseBrandModel->data($data)->save();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "UPDATE `base_brand` SET `brand_name`='流年',`brand_logo`='thinkphp@qq.com' WHERE `brand_id` = 8";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub69(): void
    {
        container()->instance('company_id', 999);
        http_request()->request->set('brand_name', 'hello');
        $baseBrandModel = BaseBrandTestModel::make();
        $data['brand_id'] = 8;
        $data['brand_name'] = '流年';
        $data['brand_logo'] = 'thinkphp@qq.com';
        $baseBrandModel->data()->save($data);
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "UPDATE `base_brand` SET `brand_name`='流年',`brand_logo`='thinkphp@qq.com' WHERE `brand_id` = 8";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub70(): void
    {
        container()->instance('company_id', 999);
        http_request()->request->set('brand_name', 'hello');
        $baseBrandModel = BaseBrandTestModel::make();
        $data['brand_name'] = '流年';
        $data['brand_logo'] = 'thinkphp@qq.com';
        $baseBrandModel
            ->where(['brand_id' => 8])
            ->save($data);
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "UPDATE `base_brand` SET `brand_name`='流年',`brand_logo`='thinkphp@qq.com' WHERE `brand_id` = 8";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub71(): void
    {
        container()->instance('company_id', 999);
        http_request()->request->set('brand_name', 'hello');
        $baseBrandModel = BaseBrandTestModel::make();
        $data['brand_name'] = '流年';
        $data['brand_logo'] = 'thinkphp@qq.com';
        $id = $baseBrandModel->add($data);
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "INSERT INTO `base_brand` (`brand_name`,`brand_logo`) VALUES ('流年','thinkphp@qq.com')";
        $this->assertSame($result, $sql);

        $baseBrandModelNew = BaseBrandTestModel::make();
        $map['brand_id'] = $id;
        $baseBrandModelNew
            ->where($map)
            ->find();
        $data = $baseBrandModelNew->data();
        $this->assertSame($id, $data['brand_id']);
        $this->assertSame('流年', $data['brand_name']);
        $this->assertSame('thinkphp@qq.com', $data['brand_logo']);
    }

    public function testQuerySub72(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->field('`brand_id`,`brand_name`,`brand_logo`')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  `brand_id`,`brand_name`,`brand_logo` FROM `base_brand`";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub73(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->field('`brand_id`,`brand_name`,`brand_logo` as logo')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  `brand_id`,`brand_name`,`brand_logo` as logo FROM `base_brand`";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub74(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->field('SUM(brand_id),`brand_name`,`brand_logo` as logo')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  SUM(brand_id),`brand_name`,`brand_logo` as logo FROM `base_brand`";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub75(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->field(['brand_id', 'brand_name', 'brand_logo'])
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  `brand_id`,`brand_name`,`brand_logo` FROM `base_brand`";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub76(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->field(['brand_id', 'brand_name', 'brand_logo' => 'logo2'])
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  `brand_id`,`brand_name`,`brand_logo` AS `logo2` FROM `base_brand`";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub77(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->field([
                'brand_id',
                "concat(`brand_name`,'-',brand_id)" => 'true_name',
                'LEFT(`brand_logo`,7)' => 'sub_logo'
            ])
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  `brand_id`,concat(`brand_name`,'-',brand_id) AS `true_name`,LEFT(`brand_logo`,7) AS `sub_logo` FROM `base_brand`";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub78(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->field()
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand`";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub79(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->field('*')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand`";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub80(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->field(true)
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  `brand_id`,`company_id`,`status`,`order_num`,`brand_num`,`brand_name`,`brand_logo`,`brand_about`,`update_date`,`create_date`,`brand_letter`,`seo_keywords` FROM `base_brand`";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub81(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->field('brand_id', true)
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  `company_id`,`status`,`order_num`,`brand_num`,`brand_name`,`brand_logo`,`brand_about`,`update_date`,`create_date`,`brand_letter`,`seo_keywords` FROM `base_brand`";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub82(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->field('brand_id,company_id', true)
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  `status`,`order_num`,`brand_num`,`brand_name`,`brand_logo`,`brand_about`,`update_date`,`create_date`,`brand_letter`,`seo_keywords` FROM `base_brand`";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub83(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->field(['brand_id', 'company_id'], true)
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  `status`,`order_num`,`brand_num`,`brand_name`,`brand_logo`,`brand_about`,`update_date`,`create_date`,`brand_letter`,`seo_keywords` FROM `base_brand`";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub84(): void
    {
        container()->instance('company_id', 999);
        http_request()->server->set('REQUEST_METHOD', Request::METHOD_POST);
        http_request()->request->set('status', 'F');
        http_request()->request->set('brand_name', 'hello');
        http_request()->request->set('brand_logo', 'yes');
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where(['brand_name' => 'hello'])
            ->delete();
        $baseBrandModel
            ->field('brand_logo,brand_name')
            ->create();
        $data = $baseBrandModel->data();
        $json = <<<'eot'
            {
                "brand_name": "hello",
                "brand_logo": "yes",
                "company_id": 999
            }
            eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $data
            )
        );
    }

    public function testQuerySub85(): void
    {
        container()->instance('company_id', 999);
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->field('brand_logo,brand_name')
            ->where('brand_id=1')
            ->save([
                'status' => 'F',
                'brand_name' => 'hello',
                'brand_logo' => 'yes'
            ]);
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "UPDATE `base_brand` SET `brand_name`='hello',`brand_logo`='yes' WHERE ( brand_id=1 )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub86(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('status=1')
            ->order('brand_id desc')
            ->limit(5)
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE ( status=1 ) ORDER BY brand_id desc LIMIT 5";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub87(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('status=1')
            ->order('brand_id desc,status')
            ->limit(5)
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE ( status=1 ) ORDER BY brand_id desc,status LIMIT 5";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub88(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('status=1')
            ->order(array('status', 'brand_id' => 'desc'))
            ->limit(5)
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE ( status=1 ) ORDER BY `status`,`brand_id` desc LIMIT 5";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub89(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('status>1')
            ->limit(3)
            ->save(array('brand_name' => 'A'));
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "UPDATE `base_brand` SET `brand_name`='A' WHERE ( status>1 ) LIMIT 3";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub90(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('status>1')
            ->limit('10,25')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE ( status>1 ) LIMIT 10,25";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub91(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('status>1')
            ->limit(10, 25)
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE ( status>1 ) LIMIT 10,25";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub92(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('status>1')
            ->page('1,10')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE ( status>1 ) LIMIT 0,10";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub93(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('status>1')
            ->page('2,10')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE ( status>1 ) LIMIT 10,10";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub94(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('status>1')
            ->page(2, 10)
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE ( status>1 ) LIMIT 10,10";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub95(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('status>1')
            ->limit(25)
            ->page(3)
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE ( status>1 ) LIMIT 50,25";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub96(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('status>1')
            ->page('3,25')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE ( status>1 ) LIMIT 50,25";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub97(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('status>1')
            ->field('brand_name,max(brand_id)')
            ->group('brand_logo')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  `brand_name`,max(brand_id) FROM `base_brand` WHERE ( status>1 ) GROUP BY brand_logo";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub98(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('status>1')
            ->field('`brand_name`,max(brand_id)')
            ->group('`brand_logo`,status')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  `brand_name`,max(brand_id) FROM `base_brand` WHERE ( status>1 ) GROUP BY `brand_logo`,status";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub99(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('status>1')
            ->field('`brand_name`,max(brand_id)')
            ->group('`brand_logo`,status')
            ->having('count(status)>3')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  `brand_name`,max(brand_id) FROM `base_brand` WHERE ( status>1 ) GROUP BY `brand_logo`,status HAVING count(status)>3";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub100(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->join('permission ON permission.id = `base_brand`.brand_id')
            ->join('role ON role.id = `base_brand`.brand_id')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` INNER JOIN permission ON permission.id = `base_brand`.brand_id INNER JOIN role ON role.id = `base_brand`.brand_id";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub101(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->join([
                'permission ON permission.id = `base_brand`.brand_id',
                'role ON role.id = `base_brand`.brand_id',
            ])
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` INNER JOIN permission ON permission.id = `base_brand`.brand_id INNER JOIN role ON role.id = `base_brand`.brand_id";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub102(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->join('LEFT JOIN permission ON permission.id = `base_brand`.brand_id')
            ->join('LEFT JOIN role ON role.id = `base_brand`.brand_id')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` LEFT JOIN permission ON permission.id = `base_brand`.brand_id LEFT JOIN role ON role.id = `base_brand`.brand_id";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub103(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->join('RIGHT JOIN permission ON permission.id = `base_brand`.brand_id')
            ->join('RIGHT JOIN role ON role.id = `base_brand`.brand_id')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` RIGHT JOIN permission ON permission.id = `base_brand`.brand_id RIGHT JOIN role ON role.id = `base_brand`.brand_id";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub104(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->field('`brand_name` as name')
            ->table('base_brand')
            ->union('SELECT name FROM permission')
            ->union('SELECT name FROM role')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  `brand_name` as name FROM `base_brand` UNION SELECT name FROM permission UNION SELECT name FROM role";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub105(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->field('`brand_name` as name')
            ->table('base_brand')
            ->union(array('field' => 'name', 'table' => 'permission'))
            ->union(array('field' => 'name', 'table' => 'role'))
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  `brand_name` as name FROM `base_brand` UNION SELECT  `name` FROM `permission`  UNION SELECT  `name` FROM `role`";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub106(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->field('`brand_name` as name')
            ->table('base_brand')
            ->union(array('SELECT name FROM permission', 'SELECT name FROM role'))
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  `brand_name` as name FROM `base_brand` UNION SELECT name FROM permission UNION SELECT name FROM role";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub107(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->field('`brand_name` as name')
            ->table('base_brand')
            ->union('SELECT name FROM permission', true)
            ->union('SELECT name FROM role', true)
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  `brand_name` as name FROM `base_brand` UNION ALL SELECT name FROM permission UNION ALL SELECT name FROM role";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub108(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->field('`brand_name` as name')
            ->table('base_brand')
            ->union(array('SELECT name FROM permission', 'SELECT name FROM role'), true)
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  `brand_name` as name FROM `base_brand` UNION ALL SELECT name FROM permission UNION ALL SELECT name FROM role";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub109(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->distinct(true)
            ->field('brand_name')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  DISTINCT  `brand_name` FROM `base_brand`";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub110(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->lock(true)
            ->field('brand_name')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  `brand_name` FROM `base_brand`  FOR UPDATE";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub111(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('brand_id=83')
            ->cache(true)
            ->find();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE ( brand_id=83 ) LIMIT 1";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub112(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('brand_id=83')
            ->cache(true, 60)
            ->find();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE ( brand_id=83 ) LIMIT 1";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub113(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('brand_id=83')
            ->cache('sql:hello', 60)
            ->find();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE ( brand_id=83 ) LIMIT 1";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub114(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->comment('查询考试前十名分数')
            ->where('brand_id=83')
            ->find();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE ( brand_id=83 ) LIMIT 1  /*查询考试前十名分数*/";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub115(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $sqlResult = $baseBrandModel
            ->fetchSql(true)
            ->find(1);
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_id` = 1 LIMIT 1";
        $this->assertSame($result, $sql);
        $this->assertSame(trim($sqlResult), $sql);
    }

    public function testQuerySub116(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(
            'Error query express:[not_found_field=>y]'
        );

        $baseBrandModel = BaseBrandTestModel::make();
        $map['brand_name'] = 'h';
        $map['brand_num'] = 'y';
        $map['not_found_field'] = 'y';
        $baseBrandModel
            ->strict(true)
            ->where($map)
            ->select();
    }

    // public function testQuerySub117(): void
    // {
    //     $baseBrandModel = BaseBrandModel::make();
    //     $baseBrandModel
    //         ->index('user')
    //         ->select();
    //     $result = $baseBrandModel->getLastSql();
    //     $result = trim($result);
    //     $sql = "SELECT  * FROM `base_brand` WHERE `brand_id` = 1 LIMIT 1";
    //     $this->assertSame($result, $sql);
    // }

    public function testQuerySub118(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->scope('normal')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `status` = 'T'";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub119(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->scope('latest')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` ORDER BY create_date DESC LIMIT 10";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub120(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->scope('normal')
            ->scope('latest')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `status` = 'T' ORDER BY create_date DESC LIMIT 10";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub121(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->scope('normal,latest,new')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `status` = 'T' ORDER BY create_date DESC LIMIT 10";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub122(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->scope()
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_logo` = 'yes' LIMIT 20";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub123(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->scope('default')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_logo` = 'yes' LIMIT 20";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub124(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->scope('default', ['order' => 'brand_id DESC'])
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_logo` = 'yes' ORDER BY brand_id DESC LIMIT 20";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub125(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->scope('normal,latest', ['order' => 'brand_id DESC'])
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `status` = 'T' ORDER BY brand_id DESC LIMIT 10";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub126(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->scope(array(
                'field' => '`brand_id`,`brand_name`',
                'limit' => 5,
                'where' => 'status=1',
                'order' => 'create_date DESC'
            ))
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  `brand_id`,`brand_name` FROM `base_brand` WHERE status=1 ORDER BY create_date DESC LIMIT 5";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub127(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->limit(8)
            ->scope('normal')
            ->order('brand_id desc')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `status` = 'T' ORDER BY brand_id desc LIMIT 8";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub128(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->normal(array('limit' => 5))
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `status` = 'T' LIMIT 5";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub129(): void
    {
        container()->instance('company_id', 999);
        http_request()->request->set('brand_name', 'hello');
        http_request()->server->set('REQUEST_METHOD', Request::METHOD_POST);
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->create();
        $data = $baseBrandModel->data();
        $json = <<<'eot'
            {
                "brand_name": "hello",
                "company_id": 999
            }
            eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $data
            )
        );
    }

    public function testQuerySub130(): void
    {
        container()->instance('company_id', 999);
        http_request()->request->set('brand_name', 'ThinkPHP');
        http_request()->server->set('REQUEST_METHOD', Request::METHOD_POST);
        $data['brand_name'] = 'ThinkPHP';
        $data['brand_logo'] = 'ThinkPHP@gmail.com';
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->create($data);
        $data = $baseBrandModel->data();
        $json = <<<'eot'
            {
                "brand_name": "ThinkPHP",
                "brand_logo": "ThinkPHP@gmail.com",
                "company_id": 999
            }
            eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $data
            )
        );
    }

    public function testQuerySub131(): void
    {
        container()->instance('company_id', 999);
        http_request()->request->set('brand_name', 'ThinkPHP');
        http_request()->server->set('REQUEST_METHOD', Request::METHOD_POST);
        $data = new stdClass();
        $data->brand_name = 'ThinkPHP';
        $data->brand_logo = 'ThinkPHP@gmail.com';
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->create($data);
        $data = $baseBrandModel->data();
        $json = <<<'eot'
            {
                "brand_name": "ThinkPHP",
                "brand_logo": "ThinkPHP@gmail.com",
                "company_id": 999
            }
            eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $data
            )
        );
    }

    public function testQuerySub132(): void
    {
        container()->instance('company_id', 999);
        http_request()->request->set('brand_name', 'ThinkPHP');
        http_request()->server->set('REQUEST_METHOD', Request::METHOD_POST);
        $data = new stdClass();
        $data->brand_name = 'ThinkPHP';
        $data->brand_logo = 'ThinkPHP@gmail.com';
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->create($data);
        $data = $baseBrandModel->data();
        $json = <<<'eot'
            {
                "brand_name": "ThinkPHP",
                "brand_logo": "ThinkPHP@gmail.com",
                "company_id": 999
            }
            eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $data
            ));
        $this->assertSame($baseBrandModel->brand_logo, 'ThinkPHP@gmail.com');

        $baseBrandModel->brand_logo = 'new logo';
        $data = $baseBrandModel->data();
        $json = <<<'eot'
            {
                "brand_name": "ThinkPHP",
                "brand_logo": "new logo",
                "company_id": 999
            }
            eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $data
            ));
    }

    public function testQuerySub133(): void
    {
        container()->instance('company_id', 999);
        http_request()->request->set('brand_name', 'ThinkPHP');
        http_request()->server->set('REQUEST_METHOD', Request::METHOD_POST);
        $data = new stdClass();
        $data->brand_name = 'ThinkPHP';
        $data->brand_logo = 'ThinkPHP@gmail.com';
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->create($data, Model::MODEL_UPDATE);
        $data = $baseBrandModel->data();
        $json = <<<'eot'
            {
                "brand_name": "ThinkPHP",
                "brand_logo": "ThinkPHP@gmail.com"
            }
            eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $data
            ));
    }

    public function testQuerySub134(): void
    {
        container()->instance('company_id', 999);
        http_request()->request->set('brand_name', 'ThinkPHP');
        http_request()->server->set('REQUEST_METHOD', Request::METHOD_POST);
        $data = new stdClass();
        $data->brand_name = 'ThinkPHP';
        $data->brand_logo = 'ThinkPHP@gmail.com';
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->create($data, Model::MODEL_INSERT);
        $data = $baseBrandModel->data();
        $json = <<<'eot'
            {
                "brand_name": "ThinkPHP",
                "brand_logo": "ThinkPHP@gmail.com",
                "company_id": 999
            }
            eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $data
            ));
    }

    public function testQuerySub135(): void
    {
        container()->instance('company_id', 999);
        http_request()->request->set('brand_name', 'ThinkPHP');
        http_request()->server->set('REQUEST_METHOD', Request::METHOD_POST);
        $data = new stdClass();
        $data->brand_name = 'ThinkPHP';
        $data->brand_logo = 'ThinkPHP@gmail.com';
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->create($data, Model::MODEL_BOTH);
        $data = $baseBrandModel->data();
        $json = <<<'eot'
            {
                "brand_name": "ThinkPHP",
                "brand_logo": "ThinkPHP@gmail.com"
            }
            eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $data
            ));
    }

    public function testQuerySub136(): void
    {
        container()->instance('company_id', 999);
        http_request()->request->set('brand_name', 'ThinkPHP');
        http_request()->server->set('REQUEST_METHOD', Request::METHOD_POST);
        $data = new stdClass();
        $data->brand_id = 1;
        $data->brand_name = 'ThinkPHP';
        $data->brand_logo = 'ThinkPHP@gmail.com';
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->create($data, Model::MODEL_BOTH);
        $data = $baseBrandModel->data();
        $json = <<<'eot'
            {
                "brand_id": 1,
                "brand_name": "ThinkPHP",
                "brand_logo": "ThinkPHP@gmail.com"
            }
            eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $data
            ));
    }

    public function testQuerySub137(): void
    {
        container()->instance('company_id', 999);
        http_request()->request->set('brand_name', 'ThinkPHP');
        http_request()->server->set('REQUEST_METHOD', Request::METHOD_POST);
        $data = new stdClass();
        $data->brand_id = 1;
        $data->brand_name = 'ThinkPHP';
        $data->brand_logo = 'ThinkPHP@gmail.com';
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->create($data, Model::MODEL_INSERT);
        $data = $baseBrandModel->data();
        $json = <<<'eot'
            {
                "brand_id": 1,
                "brand_name": "ThinkPHP",
                "brand_logo": "ThinkPHP@gmail.com",
                "company_id": 999
            }
            eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $data
            ));
    }

    public function testQuerySub138(): void
    {
        container()->instance('company_id', 999);
        http_request()->request->set('brand_name', 'ThinkPHP');
        http_request()->server->set('REQUEST_METHOD', Request::METHOD_POST);
        $data = new stdClass();
        $data->brand_name = 'ThinkPHP';
        $data->brand_logo = 'ThinkPHP@gmail.com';
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->create($data, Model::MODEL_BOTH);
        $data = $baseBrandModel->data();
        $json = <<<'eot'
            {
                "brand_name": "ThinkPHP",
                "brand_logo": "ThinkPHP@gmail.com"
            }
            eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $data
            ));

        $baseBrandModel->add();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "INSERT INTO `base_brand` (`brand_name`,`brand_logo`) VALUES ('ThinkPHP','ThinkPHP@gmail.com')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub139Sub1(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(
            'Data type invalid.'
        );

        container()->instance('company_id', 999);
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->create();
    }

    public function testQuerySub139(): void
    {
        container()->instance('company_id', 999);
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel->brand_name = 'ThinkPHP';
        $baseBrandModel->brand_logo = 'ThinkPHP@gmail.com';
        $data = $baseBrandModel->data();
        $json = <<<'eot'
            {
                "brand_name": "ThinkPHP",
                "brand_logo": "ThinkPHP@gmail.com"
            }
            eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $data
            ));

        $baseBrandModel->add();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "INSERT INTO `base_brand` (`brand_name`,`brand_logo`) VALUES ('ThinkPHP','ThinkPHP@gmail.com')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub140(): void
    {
        container()->instance('company_id', 999);
        $baseBrandModel = BaseBrandTestModel::make();
        $data['brand_name'] = 'ThinkPHP';
        $data['brand_logo'] = 'ThinkPHP@gmail.com';
        $baseBrandModel
            ->data($data)
            ->add();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "INSERT INTO `base_brand` (`brand_name`,`brand_logo`) VALUES ('ThinkPHP','ThinkPHP@gmail.com')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub141(): void
    {
        container()->instance('company_id', 999);
        http_request()->request->set('brand_name', 'thinkphp');
        http_request()->server->set('REQUEST_METHOD', Request::METHOD_POST);
        $data['brand_name'] = 'thinkphp';
        $data['brand_logo'] = 'thinkphp@gmail.com';
        $data['status'] = 1;
        $data['test'] = 'test';
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->field('brand_name')
            ->create($data);
        $data = $baseBrandModel->data();
        $json = <<<'eot'
            {
                "brand_name": "thinkphp",
                "company_id": 999
            }
            eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $data
            ));
    }

    public function testQuerySub142(): void
    {
        container()->instance('company_id', 999);
        $baseBrandModel = BaseBrandTestModel::make();
        $data['brand_name'] = 'ThinkPHP';
        $data['brand_logo'] = 'ThinkPHP@gmail.com';
        $baseBrandModel
            ->add($data);
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "INSERT INTO `base_brand` (`brand_name`,`brand_logo`) VALUES ('ThinkPHP','ThinkPHP@gmail.com')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub143(): void
    {
        container()->instance('company_id', 999);
        $baseBrandModel = BaseBrandTestModel::make();
        $data['brand_name'] = 'ThinkPHP';
        $data['brand_logo'] = 'ThinkPHP@gmail.com';
        $baseBrandModel
            ->add($data, [], true);
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "REPLACE INTO `base_brand` (`brand_name`,`brand_logo`) VALUES ('ThinkPHP','ThinkPHP@gmail.com')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub144(): void
    {
        container()->instance('company_id', 999);
        $baseBrandModel = BaseBrandTestModel::make();
        $data['brand_name'] = '<b>ThinkPHP</b>';
        $data['brand_logo'] = '<b>ThinkPHP@gmail.com</b>';
        $baseBrandModel
            ->data($data)
            ->filter('strip_tags')
            ->add();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "INSERT INTO `base_brand` (`brand_name`,`brand_logo`) VALUES ('ThinkPHP','ThinkPHP@gmail.com')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub145(): void
    {
        container()->instance('company_id', 999);
        $baseBrandModel = BaseBrandTestModel::make();
        $dataList[] = array('brand_name' => 'thinkphp', 'brand_logo' => 'thinkphp@gamil.com');
        $dataList[] = array('brand_name' => 'onethink', 'brand_logo' => 'onethink@gamil.com');
        $baseBrandModel
            ->addAll($dataList);
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "INSERT INTO `base_brand` (`brand_name`,`brand_logo`) VALUES ('thinkphp','thinkphp@gamil.com'),('onethink','onethink@gamil.com')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub146(): void
    {
        container()->instance('company_id', 999);
        $baseBrandModel = BaseBrandTestModel::make();
        $data['brand_name'] = '<b>ThinkPHP</b>';
        $data['brand_logo'] = '<b>ThinkPHP@gmail.com</b>';
        $id = $baseBrandModel
            ->data($data)
            ->filter('strip_tags')
            ->add();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "INSERT INTO `base_brand` (`brand_name`,`brand_logo`) VALUES ('ThinkPHP','ThinkPHP@gmail.com')";
        $this->assertSame($result, $sql);

        $baseBrandModel->where('brand_id=' . $id)->find();
        $this->assertSame($id, $baseBrandModel->data()['brand_id']);
    }

    public function testQuerySub147(): void
    {
        container()->instance('company_id', 999);
        $baseBrandModel = BaseBrandTestModel::make();
        $data['brand_name'] = '<b>ThinkPHP</b>';
        $data['brand_logo'] = '<b>ThinkPHP@gmail.com</b>';
        $id = $baseBrandModel
            ->data($data)
            ->filter('strip_tags')
            ->add();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "INSERT INTO `base_brand` (`brand_name`,`brand_logo`) VALUES ('ThinkPHP','ThinkPHP@gmail.com')";
        $this->assertSame($result, $sql);

        $list = $baseBrandModel->where('brand_id=' . $id)->select();
        $this->assertSame($id, $list[0]['brand_id']);
        $this->assertSame('ThinkPHP', $list[0]['brand_name']);
    }

    public function testQuerySub148(): void
    {
        container()->instance('company_id', 999);
        $baseBrandModel = BaseBrandTestModel::make();
        $data['brand_name'] = '<b>ThinkPHP</b>';
        $data['brand_logo'] = '<b>ThinkPHP@gmail.com</b>';
        $id = $baseBrandModel
            ->data($data)
            ->filter('strip_tags')
            ->add();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "INSERT INTO `base_brand` (`brand_name`,`brand_logo`) VALUES ('ThinkPHP','ThinkPHP@gmail.com')";
        $this->assertSame($result, $sql);

        $value = $baseBrandModel->where('brand_id=' . $id)->getField('brand_name');
        $this->assertSame('ThinkPHP', $value);
    }

    public function testQuerySub149(): void
    {
        container()->instance('company_id', 999);
        $baseBrandModel = BaseBrandTestModel::make();
        $data['brand_name'] = '<b>ThinkPHP</b>';
        $data['brand_logo'] = '<b>ThinkPHP@gmail.com</b>';
        $id = $baseBrandModel
            ->data($data)
            ->filter('strip_tags')
            ->add();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "INSERT INTO `base_brand` (`brand_name`,`brand_logo`) VALUES ('ThinkPHP','ThinkPHP@gmail.com')";
        $this->assertSame($result, $sql);

        $value = $baseBrandModel->where('brand_id=' . $id)->getField('brand_name', true);
        $this->assertSame(['ThinkPHP'], $value);
    }

    public function testQuerySub150(): void
    {
        container()->instance('company_id', 999);
        $baseBrandModel = BaseBrandTestModel::make();
        $data['brand_name'] = '<b>ThinkPHP</b>';
        $data['brand_logo'] = '<b>ThinkPHP@gmail.com</b>';
        $id = $baseBrandModel
            ->data($data)
            ->filter('strip_tags')
            ->add();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "INSERT INTO `base_brand` (`brand_name`,`brand_logo`) VALUES ('ThinkPHP','ThinkPHP@gmail.com')";
        $this->assertSame($result, $sql);

        $value = $baseBrandModel->where('brand_id=' . $id)->getField('brand_name,brand_logo');
        $this->assertSame(['ThinkPHP' => 'ThinkPHP@gmail.com'], $value);
    }

    public function testQuerySub151(): void
    {
        container()->instance('company_id', 999);
        $baseBrandModel = BaseBrandTestModel::make();
        $data['brand_name'] = '<b>ThinkPHP</b>';
        $data['brand_logo'] = '<b>ThinkPHP@gmail.com</b>';
        $id = $baseBrandModel
            ->data($data)
            ->filter('strip_tags')
            ->add();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "INSERT INTO `base_brand` (`brand_name`,`brand_logo`) VALUES ('ThinkPHP','ThinkPHP@gmail.com')";
        $this->assertSame($result, $sql);

        $value = $baseBrandModel->where('brand_id=' . $id)->getField('brand_id,brand_name,brand_logo');
        $json = <<<eot
            {
                "{$id}": {
                    "brand_id": {$id},
                    "brand_name": "ThinkPHP",
                    "brand_logo": "ThinkPHP@gmail.com"
                }
            }
            eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $value
            )
        );
    }

    public function testQuerySub152(): void
    {
        container()->instance('company_id', 999);
        $baseBrandModel = BaseBrandTestModel::make();
        $data['brand_name'] = '<b>ThinkPHP</b>';
        $data['brand_logo'] = '<b>ThinkPHP@gmail.com</b>';
        $id = $baseBrandModel
            ->data($data)
            ->filter('strip_tags')
            ->add();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "INSERT INTO `base_brand` (`brand_name`,`brand_logo`) VALUES ('ThinkPHP','ThinkPHP@gmail.com')";
        $this->assertSame($result, $sql);

        $value = $baseBrandModel->where('brand_id=' . $id)->getField('brand_id,brand_name,brand_logo', ':');
        $json = <<<eot
            {
                "{$id}": "ThinkPHP:ThinkPHP@gmail.com"
            }
            eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $value
            )
        );
    }

    public function testQuerySub153(): void
    {
        container()->instance('company_id', 999);
        $baseBrandModel = BaseBrandTestModel::make();
        $data['brand_name'] = '<b>ThinkPHP</b>';
        $data['brand_logo'] = '<b>ThinkPHP@gmail.com</b>';
        $id = $baseBrandModel
            ->data($data)
            ->filter('strip_tags')
            ->add();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "INSERT INTO `base_brand` (`brand_name`,`brand_logo`) VALUES ('ThinkPHP','ThinkPHP@gmail.com')";
        $this->assertSame($result, $sql);

        $value = $baseBrandModel->where('brand_id=' . $id)->getField('brand_id,brand_name', 5);
        $json = <<<eot
            {
                "{$id}": "ThinkPHP"
            }
            eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $value
            )
        );
    }

    public function testQuerySub154(): void
    {
        container()->instance('company_id', 999);
        $baseBrandModel = BaseBrandTestModel::make();
        $data['brand_name'] = '<b>ThinkPHP</b>';
        $data['brand_logo'] = '<b>ThinkPHP@gmail.com</b>';
        $id = $baseBrandModel
            ->data($data)
            ->filter('strip_tags')
            ->add();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "INSERT INTO `base_brand` (`brand_name`,`brand_logo`) VALUES ('ThinkPHP','ThinkPHP@gmail.com')";
        $this->assertSame($result, $sql);

        $value = $baseBrandModel->where('brand_id=' . $id)->getField('brand_id', 3);
        $json = <<<eot
            [
                {$id}
            ]
            eot;

        $this->assertSame(
            $json,
            $this->varJson(
                $value
            )
        );
    }

    public function testQuerySub155(): void
    {
        container()->instance('company_id', 999);
        $baseBrandModel = BaseBrandTestModel::make();
        $data['brand_name'] = 'ThinkPHP';
        $data['brand_logo'] = 'ThinkPHP@gmail.com';
        $id = $baseBrandModel
            ->where('brand_id=5')
            ->save($data);
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "UPDATE `base_brand` SET `brand_name`='ThinkPHP',`brand_logo`='ThinkPHP@gmail.com' WHERE ( brand_id=5 )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub156(): void
    {
        container()->instance('company_id', 999);
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel->brand_name = 'ThinkPHP';
        $baseBrandModel->brand_logo = 'ThinkPHP@gmail.com';
        $baseBrandModel
            ->where('brand_id=5')
            ->save();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "UPDATE `base_brand` SET `brand_name`='ThinkPHP',`brand_logo`='ThinkPHP@gmail.com' WHERE ( brand_id=5 )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub157(): void
    {
        container()->instance('company_id', 999);
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel->brand_id = 3;
        $baseBrandModel->brand_name = 'ThinkPHP';
        $baseBrandModel->brand_logo = 'ThinkPHP@gmail.com';
        $baseBrandModel
            ->save();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "UPDATE `base_brand` SET `brand_name`='ThinkPHP',`brand_logo`='ThinkPHP@gmail.com' WHERE `brand_id` = 3";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub158(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(
            'Operation wrong.'
        );

        container()->instance('company_id', 999);
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel->brand_name = 'ThinkPHP';
        $baseBrandModel->brand_logo = 'ThinkPHP@gmail.com';
        $baseBrandModel
            ->save();
    }

    public function testQuerySub159(): void
    {
        container()->instance('company_id', 999);
        $baseBrandModel = BaseBrandTestModel::make();
        $data['brand_id'] = 3;
        $data['brand_name'] = '<b>ThinkPHP</b>';
        $data['brand_logo'] = '<b>ThinkPHP@gmail.com</b>';
        $baseBrandModel
            ->data($data)
            ->filter('strip_tags')
            ->save();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "UPDATE `base_brand` SET `brand_name`='ThinkPHP',`brand_logo`='ThinkPHP@gmail.com' WHERE `brand_id` = '3'";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub160(): void
    {
        container()->instance('company_id', 999);
        $baseBrandModel = BaseBrandTestModel::make();
        $data['brand_name'] = 'ThinkPHP';
        $data['brand_logo'] = 'ThinkPHP@gmail.com';
        $baseBrandModel
            ->where('brand_id=5')
            ->data($data)
            ->save();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "UPDATE `base_brand` SET `brand_name`='ThinkPHP',`brand_logo`='ThinkPHP@gmail.com' WHERE ( brand_id=5 )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub161(): void
    {
        container()->instance('company_id', 999);
        http_request()->server->set('REQUEST_METHOD', Request::METHOD_POST);
        http_request()->request->set('brand_name', 'hello');
        http_request()->request->set('brand_id', 1);
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where(['brand_name' => 'hello'])
            ->delete();
        $baseBrandModel->create();
        $baseBrandModel->save();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "UPDATE `base_brand` SET `brand_name`='hello' WHERE `brand_id` = 1";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub162(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('brand_id=5')
            ->setField('brand_name', 'ThinkPHP');
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "UPDATE `base_brand` SET `brand_name`='ThinkPHP' WHERE ( brand_id=5 )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub163(): void
    {
        $data = array('brand_name' => 'ThinkPHP', 'brand_logo' => 'ThinkPHP@gmail.com');
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('brand_id=5')
            ->setField($data);
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "UPDATE `base_brand` SET `brand_name`='ThinkPHP',`brand_logo`='ThinkPHP@gmail.com' WHERE ( brand_id=5 )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub164(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('brand_id=5')
            ->setInc('order_num', 3);
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "UPDATE `base_brand` SET `order_num`=order_num+3 WHERE ( brand_id=5 )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub165(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('brand_id=5')
            ->setInc('order_num');
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "UPDATE `base_brand` SET `order_num`=order_num+1 WHERE ( brand_id=5 )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub166(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('brand_id=5')
            ->setDec('order_num', 7);
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "UPDATE `base_brand` SET `order_num`=order_num-7 WHERE ( brand_id=5 )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub167(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('brand_id=5')
            ->setDec('order_num');
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "UPDATE `base_brand` SET `order_num`=order_num-1 WHERE ( brand_id=5 )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub168(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->delete(5);
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "DELETE FROM `base_brand` WHERE `brand_id` = 5";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub169(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('brand_id=5')
            ->delete();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "DELETE FROM `base_brand` WHERE ( brand_id=5 )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub170(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->delete('1,2,5');
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "DELETE FROM `base_brand` WHERE `brand_id` IN ('1','2','5')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub171(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('status=0')
            ->delete();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "DELETE FROM `base_brand` WHERE ( status=0 )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub172(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('status=0')
            ->order('create_date')
            ->limit('5')
            ->delete();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "DELETE FROM `base_brand` WHERE ( status=0 ) ORDER BY create_date LIMIT 5";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub173(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(
            'Invalid delete condition.'
        );
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->delete();
    }

    public function testQuerySub174(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->where('1')
            ->delete();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "DELETE FROM `base_brand` WHERE ( 1 )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub175(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->find(8);
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_id` = 8 LIMIT 1";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub176(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->select('1,3,8');
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `brand_id` IN ('1','3','8')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub177(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $id = $baseBrandModel
            ->data(['brand_name' => 'hello'])
            ->add();
        $baseBrandModel->find($id);
        $baseBrandModel->brand_name = 'TOPThink';
        $baseBrandModel->save();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $this->assertTrue(strpos($result, "`brand_name`='TOPThink'") !== false);
    }

    public function testQuerySub178(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel->brand_id = 1;
        $baseBrandModel->brand_name = 'TOPThink';
        $baseBrandModel->save();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $this->assertTrue(strpos($result, "`brand_name`='TOPThink'") !== false);
    }

    public function testQuerySub179(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $id = $baseBrandModel
            ->data(['brand_name' => 'hello'])
            ->add();
        $baseBrandModel->find($id);
        $baseBrandModel->delete();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "DELETE FROM `base_brand` WHERE `brand_id` = {$id}";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub180(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel->delete('5,6');
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "DELETE FROM `base_brand` WHERE `brand_id` IN ('5','6')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub181(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->forceMaster()
            ->find('5,6');
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "/*FORCE_MASTER*/ SELECT  * FROM `base_brand` WHERE `brand_id` = '5,6' LIMIT 1";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub182(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $id = null;
        $baseBrandModel->transaction(function () use (&$id) {
            $baseBrandModel = BaseBrandTestModel::make();
            $id = $baseBrandModel
                ->data(['brand_name' => 'hello'])
                ->add();
        });

        $data = $baseBrandModel
            ->forceMaster()
            ->find($id);
        $this->assertSame($data['brand_id'], $id);
    }

    public function testQuerySub183(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(
            'Error message'
        );

        $baseBrandModel = BaseBrandTestModel::make();
        $id = null;
        try {
            $baseBrandModel->transaction(function () use (&$id) {
                $baseBrandModel = BaseBrandTestModel::make();
                $id = $baseBrandModel
                    ->data(['brand_name' => 'hello'])
                    ->add();
                throw new Exception('Error message');
            });
        } finally {
            $data = $baseBrandModel
                ->forceMaster()
                ->find($id);
            $this->assertSame(true, $id > 0);
            $this->assertSame(true, empty($data));
        }
    }

    public function testQuerySub184(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(
            'Error message'
        );

        $baseBrandModel = BaseBrandTestModel::make();
        $id = null;
        $baseBrandModel->startTrans();

        try {
            $id = $baseBrandModel
                ->data(['brand_name' => 'hello'])
                ->add();
            throw new Exception('Error message');
            $baseBrandModel->commit();
        } catch (Throwable $e) {
            $baseBrandModel->rollBack();

            throw $e;
        } finally {
            $data = $baseBrandModel
                ->forceMaster()
                ->find($id);
            $this->assertSame(true, $id > 0);
            $this->assertSame(true, empty($data));
        }
    }

    public function testQuerySub185(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $id = null;
        $baseBrandModel->startTrans();
        try {
            $id = $baseBrandModel
                ->data(['brand_name' => 'hello'])
                ->add();
            $baseBrandModel->commit();
        } catch (Throwable $e) {
            $baseBrandModel->rollBack();

            throw $e;
        } finally {
            $data = $baseBrandModel
                ->forceMaster()
                ->find($id);
            $this->assertSame($data['brand_id'], $id);
        }
    }

    public function testQuerySub186(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(
            'Data type invalid.'
        );

        $baseBrandModel = BaseBrandTestModel::make();
        $id = $baseBrandModel
            ->add();
    }

    public function testQuerySub187(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $id = $baseBrandModel
            ->add([
                'brand_name' => 'hello world',
            ]);
        $this->assertSame(true, $id > 0);
    }

    public function testQuerySub188(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(
            'Data type invalid.'
        );

        $baseBrandModel = BaseBrandTestModel::make();
        $affectedRow = $baseBrandModel
            ->save();
    }

    public function testQuerySub189(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $id = $baseBrandModel
            ->add([
                'brand_name' => 'hello world',
            ]);

        $affectedRow = $baseBrandModel
            ->data(['brand_id' => $id, 'brand_name' => 'new'])
            ->save();
        $this->assertSame($affectedRow, 1);
    }

    public function testQuerySub190(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(
            'customer error'
        );

        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel->defineError();
    }

    public function testQuerySub191(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(
            'Data type invalid.'
        );

        $baseBrandModel = BaseBrandTestModel::make();
        $id = $baseBrandModel
            ->addAll([]);
    }

    public function testQuerySub192(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $id = $baseBrandModel
            ->where('brand_id>2')
            ->field('brand_id,brand_name,5')
            ->limit(3)
            ->selectAdd('brand_name,brand_logo,brand_about','base_brand');

        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "INSERT INTO `base_brand` (`brand_name`,`brand_logo`,`brand_about`) SELECT  `brand_id`,`brand_name`,5 FROM `base_brand` WHERE ( brand_id>2 ) LIMIT 3";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub193(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(
            'Email格式错误'
        );

        $baseBrandModel = BaseBrandTestModel::make();
        $id = $baseBrandModel
            ->create(['seo_keywords' => 'hello'])
            ->add();
    }

    public function testQuerySub194(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(
            'Email格式错误;URL 格式错误;'
        );
        $baseBrandModel = BaseBrandTestModel::make();
        $id = $baseBrandModel
            ->patchValidate()
            ->create(['seo_keywords' => 'hello', 'brand_letter' => 'logo'])
            ->add();
    }

    public function testQuerySub195(): void
    {
        container()->instance('company_id', 0);
        $baseBrandModel = BaseBrandTestModel::make();
        $data = $baseBrandModel
            ->getList(['limit'=>'0,5']);
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `status` = 'T' AND `company_id` = 0 ORDER BY order_num DESC, brand_id ASC LIMIT 0,5";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub196(): void
    {
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->alias('a')
            ->where('a.brand_id=1')
            ->select();
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM base_brand a WHERE ( a.brand_id=1 )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub197(): void
    {
        container()->instance('company_id', 0);
        $baseBrandModel = BaseBrandTestModel::make();
        $id = $baseBrandModel
            ->add([
                'brand_name' => 'hello world',
            ]);
        $id = $baseBrandModel
            ->updateInfo([
                'brand_id'=>$id,
                'brand_name' => 'new',
            ]);
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "UPDATE `base_brand` SET `brand_name`='new'";
        $this->assertSame(true, false !== strpos($result, $sql));
    }

    public function testQuerySub198(): void
    {
        container()->instance('company_id', 0);
        $baseBrandModel = BaseBrandTestModel::make();
        $id = $baseBrandModel
            ->updateInfo([
                'brand_name' => 'new2',
            ]);
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "INSERT INTO `base_brand` (`brand_name`,`company_id`,`brand_num`,`brand_letter`) VALUES ('new2','0',";
        $this->assertSame(true, false !== strpos($result, $sql));
    }

    public function testQuerySub199(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(
            'error'
        );

        container()->instance('company_id', 0);
        $baseBrandModel = BaseBrandTestModel::make();
        $id = $baseBrandModel
            ->trans1([
                'first' => 'new1',
                'second' => 'new2',
            ]);
    }

    public function testQuerySub200(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(
            'error'
        );

        container()->instance('company_id', 0);
        $baseBrandModel = BaseBrandTestModel::make();
        $id = transaction(fn() => $baseBrandModel
            ->trans2([
                'first' => 'new1',
                'second' => 'new2',
            ]));
    }

    public function testQuerySub201(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(
            'error'
        );

        container()->instance('company_id', 0);
        $baseBrandModel = BaseBrandTestModel::make();
        $id = $baseBrandModel
            ->trans2([
                'first' => 'new1',
                'second' => 'new2',
            ]);
    }

    public function testQuerySub202(): void
    {
        container()->instance('company_id', 0);
        $baseBrandModel = BaseBrandTestModel::make();
        $id = transaction(fn() => $baseBrandModel
            ->trans3([
                'first' => 'new1',
                'second' => 'new2',
            ]));
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "INSERT INTO `base_brand` (`brand_name`) VALUES ('new2')";
        $this->assertSame($result, $sql);
        $this->assertSame($id, 'yes');
    }

    public function testQuerySub203(): void
    {
        container()->instance('company_id', 0);
        $baseBrandModel = BaseBrandTestModel::make();
        $id = $baseBrandModel
            ->add([
                'brand_name' => 'hello world',
            ]);
        $data = $baseBrandModel
            ->getInfo(['map' => ['brand_id' => $id]]);
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `status` = 'T' AND `brand_id` = {$id} AND `company_id` = 0 LIMIT 1";
        $this->assertSame($result, $sql);
        $this->assertSame($data['brand_id'], $id);
    }

    public function testQuerySub204(): void
    {
        container()->instance('company_id', 0);
        $baseBrandModel = BaseBrandTestModel::make();
        $data = $baseBrandModel
            ->getInfo(['map' => ['brand_id' => 'not_found']]);
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  * FROM `base_brand` WHERE `status` = 'T' AND `brand_id` = 'not_found' AND `company_id` = 0 LIMIT 1";
        $this->assertSame($result, $sql);
        $this->assertSame([], $data);
    }

    public function testQuerySub205(): void
    {
        container()->instance('company_id', 0);
        $baseBrandModel = BaseBrandTestModel::make();
        $data = $baseBrandModel
            ->getListSelect(['limit'=>'0,5']);
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "SELECT  `brand_id`,`brand_name` FROM `base_brand` WHERE `status` = 'T' AND `company_id` = 0 ORDER BY order_num DESC, brand_id ASC LIMIT 0,5";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub206(): void
    {
        container()->instance('company_id', 0);
        $baseBrandModel = BaseBrandTestModel::make();
        $data = $baseBrandModel
            ->getBrandNum();
        $this->assertSame(strlen($data), 5);
    }

    public function testQuerySub207(): void
    {
        container()->instance('company_id', 0);
        $baseBrandModel = BaseBrandTestModel::make();
        $id = $baseBrandModel
            ->add([
                'brand_name' => 'hello world',
            ]);
        $baseBrandModel
            ->delInfo(['brand_id' => $id]);
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "UPDATE `base_brand` SET `company_id`='0',`status`='F' WHERE `brand_id` = {$id}";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub208(): void
    {
        container()->instance('company_id', 0);
        $baseBrandModel = BaseBrandTestModel::make();
        $id = $baseBrandModel
            ->add([
                'brand_name' => 'hello world',
            ]);
        $baseBrandModel
            ->delInfoReal(['brand_id' => $id]);
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "DELETE FROM `base_brand` WHERE `brand_id` = {$id} AND `company_id` = 0";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub209(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(
            'Invalid delete condition.'
        );

        container()->instance('company_id', 0);
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->delete();
    }

    public function testQuerySub210(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(
            'Empty where condition.'
        );

        container()->instance('company_id', 0);
        $baseBrandModel = BaseBrandTestModel::make();
        $baseBrandModel
            ->delete(['b_id' => 5]);
    }

    public function testQuerySub211(): void
    {
        container()->instance('company_id', 0);
        $baseBrandModel = BaseBrandTestModel::make();
        $id = $baseBrandModel
            ->trans4([
                'first' => 'new1',
                'second' => 'new2',
            ]);
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "INSERT INTO `base_brand` (`brand_name`) VALUES ('new2')";
        $this->assertSame($result, $sql);
        $this->assertSame($id, 'yes');
    }

    public function testQuerySub212(): void
    {
        container()->instance('company_id', 0);
        $baseBrandModel = BaseBrandTestModel::make();
        $id = $baseBrandModel
            ->trans5([
                'first' => 'new1',
                'second' => 'new2',
            ]);
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "INSERT INTO `base_brand` (`brand_name`) VALUES ('new2')";
        $this->assertSame($result, $sql);
        $this->assertSame($id, 'yes');
    }
}
