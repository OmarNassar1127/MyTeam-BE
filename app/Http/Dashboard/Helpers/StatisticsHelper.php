<?php

namespace App\Http\Dashboard\Helpers;

class StatisticsHelper
{
    /**
     * Calculate the percentage change between two numbers.
     *
     * @param  float|int  $oldNumber
     * @param  float|int  $newNumber
     * @return float
     */
    public static function calculatePercentageChange($oldNumber, $newNumber)
    {
        if ($oldNumber == 0) {
            return $newNumber > 0 ? 100 : 0; // Avoid division by zero
        }
        return (($newNumber - $oldNumber) / $oldNumber) * 100;
    }
}
