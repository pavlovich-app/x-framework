<?php
namespace controllers;

use core\Controller;
use helpers\ArrayHelper;
use services\RestaurantsService;

class DefaultController extends Controller
{
    /**
     * @return string
     * @throws \Exception
     */
    public function indexAction(): string
    {
        $path = PUBLIC_DIR.'menu/data2.csv';

        if( !file_exists($path) ){
            throw new \Exception('File does not exists', 500);
        }

        if ( ($resource = fopen($path, "r")) === false ) {
            throw new \Exception('File does not exists', 500);
        }

        $product_list  = RestaurantsService::fetchProducts( $resource );

        $product_names = ArrayHelper::uniqueColumns($product_list, 'names');

        if( isset($this->get['products']) && !array_diff($this->get['products'], $product_names) ){
            $restaurants = ArrayHelper::groupBy($product_list, 'restaurant_id');
            $restaurants = RestaurantsService::filter($this->get['products'], $restaurants);
            $better      = RestaurantsService::findBetter( $restaurants, $this->get['products'] );
        }

        return $this->render('default:index', [
            'product_names' => $product_names,
            'better'        => $better ?? null,
        ]);
    }



    /** TEST ACTION
     * @return string
     * @throws \Exception
     */
    public function contactsAction(): string
    {
        return $this->render('default:contacts');
    }

    /** TEST ACTION
     * @return string
     * @throws \Exception
     */
    public function aboutAction(): string
    {
        return $this->render('default:about');
    }
}