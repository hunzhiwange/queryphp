<?php

declare(strict_types=1);

namespace App\Infra;

use League\Csv\Reader;

/**
 * Csv 处理.
 */
class Csv
{
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
            foreach ($record as $key => $value) {
                if (1 === $index) {
                    $notice[$key] = $value;
                } elseif (2 === $index) {
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
