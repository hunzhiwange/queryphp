<?php

declare(strict_types=1);

namespace App\Infra;

use App\Domain\Model\BaseBrandModel;
use Tests\TestCase;
use stdClass;

class ModelTest extends TestCase
{
    public function testQuickQuery1(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_name|brand_num'] = 'QueryPHP';
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE ( brand_name = 'QueryPHP' OR brand_num = 'QueryPHP' )";
        $this->assertSame($result, $sql);
    }

    public function testQuickQuery1Sub1(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_name'] = 'QueryPHP';
        $map['brand_num'] = 'QueryPHP';
        $map['_logic'] = 'OR';
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE brand_name = 'QueryPHP' OR brand_num = 'QueryPHP'";
        $this->assertSame($result, $sql);
    }

    public function testQuickQueryAndTotal(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_name|brand_num'] = 'QueryPHP';
        $result = $baseBrandModel
            ->where($map)
            ->field('SQL_CALC_FOUND_ROWS brand_id,brand_name')
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT count(*) as count FROM (SELECT     brand_id,brand_name FROM base_brand WHERE ( brand_name = 'QueryPHP' OR brand_num = 'QueryPHP' ) ) t";
        $count = $baseBrandModel->fetchTotalCount();
        $this->assertSame($result, $sql);
        $this->assertTrue(is_int($count));
    }

    public function testQuickQuery2(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_name&brand_num'] =array('品牌1','品牌2','_multi'=>true);
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE ( (brand_name = '品牌1') AND (brand_num = '品牌2') )";
        $this->assertSame($result, $sql);
    }

    public function testQuickQuery2Sub2(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_name'] = '品牌1';
        $map['brand_num']  = '品牌2';
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE brand_name = '品牌1' AND brand_num = '品牌2'";
        $this->assertSame($result, $sql);
    }

    public function testQuickQuery3(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_name&brand_num&brand_logo'] =array('1',array('gt','0'),'QueryPHP','_multi'=>true);
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE ( (brand_name = '1') AND (brand_num > '0') AND (brand_logo = 'QueryPHP') )";
        $this->assertSame($result, $sql);
    }

    public function testQuickQuery3Sub1(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_name'] = '1';
        $map['brand_num'] = array('gt',0);
        $map['brand_logo'] = 'QueryPHP';
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE brand_name = '1' AND brand_num > 0 AND brand_logo = 'QueryPHP'";
        $this->assertSame($result, $sql);
    }

    public function testQuery1(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map = "'brand_name='q' AND brand_num='y'";
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE ( 'brand_name='q' AND brand_num='y' )";
        $this->assertSame($result, $sql);
    }

    public function testQuery2(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_name'] = 'h';
        $map['brand_num'] = 'y';
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE brand_name = 'h' AND brand_num = 'y'";
        $this->assertSame($result, $sql);
    }

    public function testQuery3(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_name'] = 'h';
        $map['brand_num'] = 'y';
        $map['_logic'] = 'OR';
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE brand_name = 'h' OR brand_num = 'y'";
        $this->assertSame($result, $sql);
    }

    public function testQuery4(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map = new stdClass();
        $map->brand_name = 'hello';
        $map->brand_num= 'world';
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE brand_name = 'hello' AND brand_num = 'world'";
        $this->assertSame($result, $sql);
    }

    public function testQuery5(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_name'] = 'h';
        $map['brand_num'] = 'y';
        $map['not_found_field'] = 'y';
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE brand_name = 'h' AND brand_num = 'y'";
        $this->assertSame($result, $sql);
    }

    public function testQuery6(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_name']  = array('eq','h');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE brand_name = 'h'";
        $this->assertSame($result, $sql);
    }

    public function testQuery7(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_name']  = array('neq','h');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE brand_name <> 'h'";
        $this->assertSame($result, $sql);
    }

    public function testQuery8(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_name']  = array('gt','h');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE brand_name > 'h'";
        $this->assertSame($result, $sql);
    }

    public function testQuery9(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_name']  = array('egt','h');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE brand_name >= 'h'";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub1(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_name']  = array('lt','h');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE brand_name < 'h'";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub3(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_name']  = array('elt','h');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE brand_name <= 'h'";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub4(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_name']  = array('like','h%');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE brand_name LIKE 'h%'";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub5(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_name']  = array('notlike','h%');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE brand_name NOT LIKE 'h%'";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub6(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_name'] =array('like',array('%thinkphp%','%q'),'OR');
        $map['brand_num'] =array('notlike',array('%thinkphp%','%q'),'AND');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE (brand_name LIKE '%thinkphp%' OR brand_name LIKE '%q') AND (brand_num NOT LIKE '%thinkphp%' AND brand_num NOT LIKE '%q')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub7(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_id'] =array('between','1,8');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE brand_id BETWEEN '1' AND '8'";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub8(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_id'] =array('between',array('1','8'));
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE brand_id BETWEEN '1' AND '8'";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub9(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_id'] =array('notbetween',array('1','8'));
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE brand_id NOT BETWEEN '1' AND '8'";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub10(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_id'] =array('notbetween','1,8');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE brand_id NOT BETWEEN '1' AND '8'";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub11(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_id'] =array('not in','1,5,8');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE brand_id NOT IN ('1','5','8')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub12(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_id'] =array('in','1,5,8');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE brand_id IN ('1','5','8')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub13(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_id'] =array('in','1,5,8');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE brand_id IN ('1','5','8')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub14(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_id'] =array('in','1,5,8');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE brand_id IN ('1','5','8')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub15(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_id'] =array('not in',array('1','5','8'));
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE brand_id NOT IN ('1','5','8')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub16(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_id'] =array('in',array('1','5','8'));
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE brand_id IN ('1','5','8')";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub17(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_id'] =array('exp',' IN (1,3,8) ');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE brand_id  IN (1,3,8)";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub18(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        // 要修改的数据对象属性赋值
        $data['brand_name'] = 'ThinkPHP';
        $data['company_id'] = array('exp','company_id+1');// 品牌的公司ID加1
        $baseBrandModel->where('brand_id=5')->save($data); // 根据条件保存修改的数据
        $result = $baseBrandModel->getLastSql();
        $result = trim($result);
        $sql = "UPDATE base_brand SET brand_name='ThinkPHP',company_id=company_id+1 WHERE ( brand_id=5 )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub19(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_id'] =array(array('gt',1),array('lt',10));
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE ( brand_id > 1 AND brand_id < 10  )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub20(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_id'] =array(array('gt',3),array('lt',10), 'or');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE ( brand_id > 3 OR brand_id < 10 )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub21(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_id'] =array(array('neq',6),array('gt',3),'and');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE ( brand_id <> 6 AND brand_id > 3  )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub22(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_id'] =array(array('like','%a%'), array('like','%b%'), array('like','%c%'), 'ThinkPHP','or');
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE ( brand_id LIKE '%a%' OR brand_id LIKE '%b%' OR brand_id LIKE '%c%' OR brand_id = 'ThinkPHP' )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub23(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_id'] = array('neq',1);
        $map['brand_name'] = 'ok';
        $map['_string'] = 'company_id=1 AND order_num>10';
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE brand_id <> 1 AND brand_name = 'ok' AND ( company_id=1 AND order_num>10 )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub24(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_id'] = array('gt','100');
        $map['_query'] = 'company_id=1&order_num=100&_logic=or';
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE brand_id > '100' AND ( company_id = '1' OR order_num = '100' )";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub25(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $where['brand_name']  = array('like', '%thinkphp%');
        $where['order_num']  = array('like','%thinkphp%');
        $where['_logic'] = 'or';
        $map['_complex'] = $where;
        $map['brand_id']  = array('gt',1);
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE (  brand_name LIKE '%thinkphp%' OR order_num LIKE '%thinkphp%' ) AND brand_id > 1";
        $this->assertSame($result, $sql);
    }

    public function testQuerySub26(): void
    {
        $baseBrandModel = BaseBrandModel::make();
        $map['brand_id'] = array('gt',1);
        $map['_string'] = ' (brand_name like "%thinkphp%")  OR ( order_num like "%thinkphp") ';
        $result = $baseBrandModel
            ->where($map)
            ->select(['fetch_sql' => true]);
        $result = trim($result);
        $sql = "SELECT   * FROM base_brand WHERE brand_id > 1 AND (  (brand_name like \"%thinkphp%\")  OR ( order_num like \"%thinkphp\")  )";
        $this->assertSame($result, $sql);
    }
}
