<?php

declare(strict_types=1);

namespace App\Infra;

use League\Csv\Reader;

/**
 * Csv 处理.
 */
class Csv
{
    public const HEADER_INDEX = [0];

    public const NOTICE_INDEX = [1];

    public const TITLE_INDEX = [2];

    /**
     * @throws \League\Csv\Exception
     * @throws \Exception
     */
    public function read(string $filePathOrContent, bool $isContent = false): array
    {
        if (!$isContent) {
            if (!is_file($filePathOrContent)) {
                throw new \Exception(sprintf('File %s was not found.', $filePathOrContent));
            }

            $csv = Reader::createFromPath($filePathOrContent);
        } else {
            $csv = Reader::createFromString($filePathOrContent);
        }

        $csv->setHeaderOffset(0);
        $records = $notice = $title = [];
        foreach ($csv->getRecords() as $index => $record) {
            $emptyRecord = true;
            // @phpstan-ignore-next-line
            foreach ($record as $key => $value) {
                /**
                 * CSV 导入的数据都是字符串.
                 *
                 * @phpstan-ignore-next-line
                 */
                $value = trim($value);
                if (\in_array($index, self::NOTICE_INDEX, true)) {
                    $notice[$key] = $value;
                } elseif (\in_array($index, self::TITLE_INDEX, true)) {
                    $title[$key] = $value;
                } else {
                    if ($emptyRecord && '' !== $value) {
                        $emptyRecord = false;
                    }
                    $records[$index][$key] = $value;
                }
            }

            if ($emptyRecord && isset($records[$index])) {
                unset($records[$index]);
            }
        }

        if ($records) {
            $records = array_values($records);
        }

        return [
            'header' => $title,
            'notice' => $notice,
            'data' => $records,
        ];
    }
}
