<?php

namespace LongTailVentures;

class PdoDebug
{
    public static function getPreparedQuery($query, array $queryParams)
    {
        $preparedQuery = $query;

        krsort($queryParams);

        foreach ($queryParams as $column => $value)
            $preparedQuery = str_replace($column, "'$value'", $preparedQuery);

        return $preparedQuery;
    }
}
