<?php

declare(strict_types=1);

namespace Helper;

class ArrayHelper
{
    /**
     * @param array $data
     * @return array
     */
    public static function rowsToIds(array $data): array
    {
        $ids = [];

        foreach ($data as $row) {
            $ids[] = $row["id"];
        }

        return $ids;
    }
}