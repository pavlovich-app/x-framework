<?php

namespace services;

class IteratorService
{
    private $_pointers = [];

    /**
     * @param array $set
     * @param null $subset_size
     * @return array
     */
    public function combinations( array $set, $subset_size = null )
    {
        $set_size = count($set);

        if (is_null($subset_size)) {
            $subset_size = $set_size;
        }

        if ($subset_size >= $set_size) {
            return [ $set ];
        } else if ($subset_size == 1) {
            return array_chunk($set, 1);
        } else if ($subset_size == 0) {
            return [];
        }

        $combinations = [];
        $set_keys = array_keys($set);
        $this->_pointers = array_slice(array_keys($set_keys), 0, $subset_size);

        $combinations[] = $this->_getCombination($set);
        while ($this->_advancePointers($subset_size - 1, $set_size - 1)) {
            $combinations[] = $this->_getCombination($set);
        }

        return $combinations;
    }

    /**
     * @param $pointer_number
     * @param $limit
     * @return bool
     */
    private function _advancePointers( $pointer_number, $limit )
    {
        if ($pointer_number < 0) {
            return false;
        }

        if ($this->_pointers[$pointer_number] < $limit) {
            $this->_pointers[$pointer_number]++;
            return true;
        } else {
            if ($this->_advancePointers($pointer_number - 1, $limit - 1)) {
                $this->_pointers[$pointer_number] = $this->_pointers[$pointer_number - 1] + 1;
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * @param $set
     * @return array
     */
    private function _getCombination( $set )
    {
        $set_keys = array_keys($set);

        $combination = [];

        foreach ($this->_pointers as $pointer) {
            $combination[$set_keys[$pointer]] = $set[$set_keys[$pointer]];
        }

        return $combination;
    }

    /**
     * @param array $set
     * @param null $subset_size
     * @return array
     */
    public function permutations( array $set, $subset_size = null )
    {
        $combinations = $this->combinations($set, $subset_size);

        $permutations = [];

        foreach ($combinations as $combination) {
            $permutations = array_merge($permutations, $this->_findPermutations($combination) );
        }

        return $permutations;
    }

    /**
     * @param $set
     * @return array
     */
    private function _findPermutations( $set )
    {
        if (count($set) <= 1) {
            return [$set];
        }

        $permutations = [];
        

        list($key, $val) = $this->array_shift_assoc($set);
        $sub_permutations = $this->_findPermutations($set);

        foreach ($sub_permutations as $permutation) {
            $permutations[] = array_merge( [$key => $val] , $permutation);
        }
        
        $set[$key] = $val;

        $start_key = $key;

        $key = $this->_firstKey($set);
        while ($key != $start_key) {

            list($key, $val) = $this->array_shift_assoc($set);
            $sub_permutations = $this->_findPermutations($set);

            foreach ($sub_permutations as $permutation) {
                $item = [$key => $val];
        
                $permutations[] = array_merge($item, $permutation);
            }

            $set[$key] = $val;
            $key = $this->_firstKey($set);
        }

        return $permutations;
    }

    /**
     * @param array $array
     * @return array
     */
    public function array_shift_assoc( array &$array )
    {
        foreach ($array as $key => $val) {
            unset($array[$key]);
            break;
        }
        return [$key, $val];
    }

    /**
     * @param $array
     * @return int|string
     */
    private function _firstKey( $array )
    {
        foreach ($array as $key => $val) {
            break;
        }
        return $key;
    }
}