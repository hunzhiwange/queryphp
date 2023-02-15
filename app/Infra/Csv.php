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
    public function read(string $filePath): array
    {
        if (!is_file($filePath)) {
            throw new \Exception(sprintf('File %s was not found.', $filePath));
        }

        $csv = Reader::createFromPath($filePath);
        $csv->setHeaderOffset(0);
        $records = $notice = $title = [];
        foreach ($csv->getRecords() as $index => $record) {
            // @phpstan-ignore-next-line
            foreach ($record as $key => $value) {
                if (\in_array($index, self::HEADER_INDEX, true)) {
                } elseif (\in_array($index, self::NOTICE_INDEX, true)) {
                    $notice[$key] = $value;
                } elseif (\in_array($index, self::TITLE_INDEX, true)) {
                    $title[$key] = $value;
                } else {
                    $records[$index][$key] = $value;
                }
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
