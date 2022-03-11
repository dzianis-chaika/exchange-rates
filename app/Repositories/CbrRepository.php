<?php

namespace App\Repositories;

use DateInterval;
use DateTime;
use DOMDocument;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CbrRepository implements CbrRepositoryInterface
{
    const BASE_URI = 'http://www.cbr.ru/scripts';

    /**
     * @return array<int, array>
     */
    public function getDailyRates()
    {
        $res = Http::get(static::BASE_URI . '/XML_daily.asp');
        if (!$res->successful()) {
            Log::error('Error getting daily rates from cbr.ru service!');
            return [];
        }

        $doc = new DOMDocument();
        if (!$doc->loadXML($res->body())) {
            Log::error('Error parsing daily rates XML response from cbr.ru service!');
            return [];
        }

        $rates = [];
        $valutes = $doc->getElementsByTagName('Valute');

        foreach ($valutes as $valute) {
            $rate = [
                'valuteID' => $valute->getAttribute('ID'),
            ];

            $elems = $valute->getElementsByTagName('NumCode');
            if (count($elems)) {
                $rate['numCode'] = $elems[0]->textContent;
            }

            $elems = $valute->getElementsByTagName('CharCode');
            if (count($elems)) {
                $rate['charCode'] = $elems[0]->textContent;
            }

            $elems = $valute->getElementsByTagName('Name');
            if (count($elems)) {
                $rate['name'] = $elems[0]->textContent;
            }

            $elems = $valute->getElementsByTagName('Value');
            if (count($elems)) {
                $rate['value'] = str_replace(',', '.', $elems[0]->textContent);
            }

            $rates[] = $rate;
        }

        return $rates;
    }

    /**
     * @param  string  $valuteID
     * @param  \DateTime|null  $from
     * @param  \DateTime|null  $to
     * @return array<int, array>
     */
    public function getDynamicRates($valuteID, $from = null, $to = null)
    {
        if (is_null($from)) {
            $from = (new DateTime())->sub(new DateInterval('P1M'));
        }

        if (is_null($to)) {
            $to = new DateTime();
        }

        $res = Http::get(
            static::BASE_URI . "/XML_dynamic.asp?date_req1={$from->format('d/m/Y')}&date_req2={$to->format('d/m/Y')}&VAL_NM_RQ={$valuteID}"
        );

        if (!$res->successful()) {
            Log::error('Error getting dynamic rates from cbr.ru service!');
            return [];
        }

        $doc = new DOMDocument();
        if (!$doc->loadXML($res->body())) {
            Log::error('Error parsing dynamic rates XML response from cbr.ru service!');
            return [];
        }

        $rates = [];
        $records = $doc->getElementsByTagName('Record');

        foreach ($records as $record) {
            $elems = $record->getElementsByTagName('Value');
            if (count($elems)) {
                $rates[] = [
                    'date' => $record->getAttribute('Date'),
                    'value' => str_replace(',', '.', $elems[0]->textContent),
                ];
            }
        }

        return $rates;
    }
}
