<?php

namespace App\Repositories;

interface CbrRepositoryInterface
{
    /**
     * @return array<int, array>
     */
    public function getDailyRates();

    /**
     * @param  string  $valuteID
     * @param  \DateTime|null  $from
     * @param  \DateTime|null  $to
     * @return array<int, array>
     */
    public function getDynamicRates($valuteID, $from = null, $to = null);
}
