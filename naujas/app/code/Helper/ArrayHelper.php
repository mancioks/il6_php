<?php

namespace Helper;

class ArrayHelper
{
    public static function rowsToIds($data)
    {
        $ids = [];

        foreach ($data as $row) {
            $ids[] = $row["id"];
        }

        return $ids;
    }
}