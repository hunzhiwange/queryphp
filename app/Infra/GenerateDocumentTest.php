<?php

declare(strict_types=1);

namespace App\Infra;

use Carbon\Carbon;
use Leevel\Cache\Proxy\Cache;
use Tests\TestCase;

final class GenerateDocumentTest extends TestCase
{
    public function test1(): void
    {
        Cache::connect('redis')->delete('redis_sequence::'.date('Ymd'));
        $gd = new GenerateDocument();
        $id = $gd->handle();
        static::assertSame($id, date('Ymd').'00001');
        $id = $gd->handle();
        static::assertSame($id, date('Ymd').'00002');
        $id = $gd->handle();
        static::assertSame($id, date('Ymd').'00003');
    }

    public function test2(): void
    {
        Cache::connect('redis')->delete('redis_sequence::'.date('Ymd'));
        $gd = new GenerateDocument(['begin_number' => 2]);
        $id = $gd->handle();
        static::assertSame($id, date('Ymd').'00003');
        $id = $gd->handle();
        static::assertSame($id, date('Ymd').'00004');
        $id = $gd->handle();
        static::assertSame($id, date('Ymd').'00005');
    }

    public function test3(): void
    {
        Cache::connect('redis')->delete('redis_sequence::'.date('Ymd'));
        $gd = new GenerateDocument(['step' => 2]);
        $id = $gd->handle();
        static::assertSame($id, date('Ymd').'00002');
        $id = $gd->handle();
        static::assertSame($id, date('Ymd').'00004');
        $id = $gd->handle();
        static::assertSame($id, date('Ymd').'00006');
    }

    public function test4(): void
    {
        Cache::connect('redis')->delete('redis_sequence:Q:'.date('Ymd'));
        $gd = new GenerateDocument(['guid' => 'Q']);
        $id = $gd->handle();
        static::assertSame($id, 'Q'.date('Ymd').'00001');
        $id = $gd->handle();
        static::assertSame($id, 'Q'.date('Ymd').'00002');
        $id = $gd->handle();
        static::assertSame($id, 'Q'.date('Ymd').'00003');
    }

    public function test5(): void
    {
        Cache::connect('redis')->delete('redis_sequence:Q:'.date('Ymd'));
        $gd = new GenerateDocument(['serial_length' => 3, 'guid' => 'Q']);
        $id = $gd->handle();
        static::assertSame($id, 'Q'.date('Ymd').'001');
        $id = $gd->handle();
        static::assertSame($id, 'Q'.date('Ymd').'002');
        $id = $gd->handle();
        static::assertSame($id, 'Q'.date('Ymd').'003');
    }

    public function test6(): void
    {
        Cache::connect('redis')->delete('redis_sequence:Q:'.date('Ymd'));
        $gd = new GenerateDocument(['separators' => SeparatorsEnum::POINT, 'guid' => 'Q']);
        $id = $gd->handle();
        static::assertSame($id, 'Q.'.date('Ymd').'.00001');
        $id = $gd->handle();
        static::assertSame($id, 'Q.'.date('Ymd').'.00002');
        $id = $gd->handle();
        static::assertSame($id, 'Q.'.date('Ymd').'.00003');
    }

    public function test7(): void
    {
        Cache::connect('redis')->delete('redis_sequence:Q:'.date('Ymd'));
        $gd = new GenerateDocument(['separators' => SeparatorsEnum::DASH, 'guid' => 'Q']);
        $id = $gd->handle();
        static::assertSame($id, 'Q-'.date('Ymd').'-00001');
        $id = $gd->handle();
        static::assertSame($id, 'Q-'.date('Ymd').'-00002');
        $id = $gd->handle();
        static::assertSame($id, 'Q-'.date('Ymd').'-00003');
    }

    public function test8(): void
    {
        Cache::connect('redis')->delete('redis_sequence:Q:'.date('Ymd'));
        $gd = new GenerateDocument(['separators' => SeparatorsEnum::UNDERLINE, 'guid' => 'Q']);
        $id = $gd->handle();
        static::assertSame($id, 'Q_'.date('Ymd').'_00001');
        $id = $gd->handle();
        static::assertSame($id, 'Q_'.date('Ymd').'_00002');
        $id = $gd->handle();
        static::assertSame($id, 'Q_'.date('Ymd').'_00003');
    }

    public function test9(): void
    {
        Cache::connect('redis')->delete('redis_sequence:Q:'.date('Ymd'));
        $gd = new GenerateDocument(['format' => 'ymd', 'guid' => 'Q']);
        $id = $gd->handle();
        static::assertSame($id, 'Q'.date('ymd').'00001');
        $id = $gd->handle();
        static::assertSame($id, 'Q'.date('ymd').'00002');
        $id = $gd->handle();
        static::assertSame($id, 'Q'.date('ymd').'00003');
    }

    public function test10(): void
    {
        Cache::connect('redis')->delete('redis_sequence:Q:'.date('Ymd'));
        $gd = new GenerateDocument(['separators' => SeparatorsEnum::UNDERLINE, 'guid' => 'Q']);
        $id = $gd->handle(function () {
            return 'Q_'.date('Ymd').'_00501';
        });
        static::assertSame($id, 'Q_'.date('Ymd').'_00533');
        $id = $gd->handle();
        static::assertSame($id, 'Q_'.date('Ymd').'_00534');
        $id = $gd->handle();
        static::assertSame($id, 'Q_'.date('Ymd').'_00535');
    }

    public function test11(): void
    {
        Cache::connect('redis')->delete('redis_sequence:Q:'.date('Ymd'));
        $gd = new GenerateDocument(['separators' => SeparatorsEnum::UNDERLINE, 'guid' => 'Q']);
        $id = $gd->handle(function () {
            return 'Q_'.date('Ymd', strtotime(Carbon::yesterday()->toString())).'_00501';
        });
        static::assertSame($id, 'Q_'.date('Ymd').'_00031');
        $id = $gd->handle();
        static::assertSame($id, 'Q_'.date('Ymd').'_00032');
        $id = $gd->handle();
        static::assertSame($id, 'Q_'.date('Ymd').'_00033');
    }

    public function test12(): void
    {
        Cache::connect('redis')->delete('redis_sequence:Q:'.date('Ymd'));
        $gd = new GenerateDocument(['separators' => SeparatorsEnum::UNDERLINE, 'guid' => 'Q', 'safe_next' => 20]);
        $id = $gd->handle(function () {
            return 'Q_'.date('Ymd', strtotime(Carbon::yesterday()->toString())).'_00501';
        });
        static::assertSame($id, 'Q_'.date('Ymd').'_00021');
        $id = $gd->handle();
        static::assertSame($id, 'Q_'.date('Ymd').'_00022');
        $id = $gd->handle();
        static::assertSame($id, 'Q_'.date('Ymd').'_00023');
    }
}
