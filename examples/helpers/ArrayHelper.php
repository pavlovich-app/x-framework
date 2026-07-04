<?php
namespace helpers;

class ArrayHelper
{
    /**
     * @param array $array
     * @param string $column
     * @return float
     */
    public static function sumColumn( array $array, string $column ): float {
        return array_sum( array_column($array, $column) );
    }

    /**
     * @param array $array
     * @param $key
     * @return array
     */
    public static function groupBy(array $array, string $key): array {
        $rez = [];
        foreach( $array as $val ) { $rez[$val[$key]][] = $val; }
        return $rez;
    }

    /**
     * @param array $array
     * @param $column
     * @return array
     */
    public static function uniqueColumn( array $array, $column ): array {
        return array_unique(array_column($array, $column));
    }

    /**
     * @param array $array
     * @param $column
     * @return array
     */
    public static function uniqueColumns( array $array, $column ): array {
        $values = [];
        foreach( $array as $item ){ $values = array_merge($item[$column], $values); }
        return array_unique($values);
    }
}