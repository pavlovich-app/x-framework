<?php
namespace services;

use helpers\ArrayHelper;

class RestaurantsService
{
    /**
     * @param $resource
     * @return array|null
     * @throws \Exception
     */
    public static function fetchProducts( $resource ): ?array
    {
        $product_list = [];
        while ( ($row = fgetcsv($resource, 1000, ',')) !== false ) {
            $products  = array_filter( array_splice($row, 2), 'strlen');
            $relations = array_splice($row, 0, 2);
            $product_list[] = ['restaurant_id' => $relations[0], 'price' => $relations[1], 'names' => $products];
        } fclose($resource);
        return $product_list;
    }

    /**
     * @param array $order
     * @param array $restaurants
     * @return array
     */
    public static function filter( array $order, array $restaurants ): array {
        /** remove restaurants **/
        foreach ( $restaurants as $restaurant_id => &$restaurant ) {

            $names = ArrayHelper::uniqueColumns($restaurant, 'names');

            if( array_diff ($order, $names) ){
                unset($restaurants[$restaurant_id]); continue;
            }

            foreach( $restaurant as $key => $product ){
                if( count( array_diff($order, $product['names']) ) >= count($order) ){
                    unset($restaurant[$key]); continue;
                }
            }
        }
        return $restaurants;
    }

    /**
     * @param array $restaurants
     * @param array $order
     * @return array|null
     */
    public static function findBetter(array $restaurants, array $order ): ?array {
        $better = null;
        foreach ( $restaurants as $restaurant ){
            $better = self::lowPrice($better, self::betterPermutation($restaurant, $order) );
        }

        return $better;
    }

    /**
     * @param $restaurant
     * @param $order
     * @return array|null
     */
    public static function betterPermutation( $restaurant, $order ): array
    {

        $iterator = new IteratorService;
        $better = null;

        $permutations = $iterator->permutations( $restaurant, count($order) );

        foreach( $permutations as $permutation ){
            $variation = [];
            $left = $order;
            foreach ( $permutation as $item ){

                if(count( array_diff($left, $item['names']) ) <> count($left) ){
                    $left = array_diff($left, $item['names']);
                    $variation[] = $item;
                }

                if( !$left && (!$better || ArrayHelper::sumColumn($variation, 'price') < ArrayHelper::sumColumn($better, 'price')) ) {
                    $better = $variation;
                    continue;
                }
            }
        }

        return $better;
    }

    /**
     * @param array $restaurant
     * @param array $order
     * @return array|null
     */
    public static function getVariation( array $restaurant, array $order ): ?iterable
    {
        $combination = [];
        $iterator = new IteratorService;
        
        foreach ( $iterator->combinations($restaurant, function( $item ) use ( $order ) {

            if( !count(array_diff($order, ArrayHelper::uniqueColumns($item, 'names')) ) ) {
                return $item;
            }

            return null;
        },  count($order), $order ) as $value ){

            if( !count($combination) || ArrayHelper::sumColumn($value, 'price') < ArrayHelper::sumColumn($combination, 'price') ){
                $combination[] = $value;
            }
        }
        
        return $combination;
    }


    /**
     * @param array|null $old_variation
     * @param array|null $new_variation
     * @return array
     */
    public static function lowPrice ( ?array $old_variation, ?array $new_variation ): array
    {
        if( !$old_variation || ArrayHelper::sumColumn($new_variation, 'price') < ArrayHelper::sumColumn($old_variation, 'price')){
            return $new_variation;
        }
        return $old_variation;
    }

}