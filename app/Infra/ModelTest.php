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
}
