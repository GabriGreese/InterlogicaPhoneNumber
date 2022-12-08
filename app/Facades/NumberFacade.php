<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class NumberFacade
 *
 * @package App\Facades
 */
class NumberFacade extends Facade
{
    /**
     * @return string
     */
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \App\Models\Number::class;
    }

    /**
     * Check for phone # validity and
     * correct the number if requested
     *
     * @param $number
     * @param $returnCorrected
     *
     * @return array
     */
    public static function checkValidity($number, $returnCorrected = false)
    {
        $res['status'] = true;

        $number = (string)$number;

        if (!is_numeric($number)) {
            $res['status'] = false;
        }

        // check for formal correctness
        $numbersStartWith = '278';
        $numbersMaxLength = 11;

        $regex = '/^(' . $numbersStartWith . '\d{8})$/m'; // rule: a number starts with 278 and should be 11 digits
        preg_match_all($regex, $number, $found, PREG_SET_ORDER, 0);
        if (empty($found)) {
            $res['status'] = false;
        }

        if ($returnCorrected && !$res['status']) {
            $number = preg_replace('[\D]', '', $number); // only numbers

            if (substr($number, 0, 3) !== $numbersStartWith) {
                // number does not start with '278'
                $res['suggested'] = substr('278' . $number . '00000000', 0, $numbersMaxLength);
            } else {
                // number does start with '278;
                $res['suggested'] = substr($number . '00000000', 0, $numbersMaxLength);
            }
        }

        return $res;
    }

}
