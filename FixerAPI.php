<?php
/**
 * This class will service as an interface to the Bank of Canada Valet API,
 * which provides access to foreign exchange rates.
 * https://www.bankofcanada.ca/valet/docs
 */

namespace DWA\P2;

class FixerAPI
{
    private const FIXER_API_BASE_URL = 'http://data.fixer.io/api/';
    private const FIXER_API_TIMESERIES_ENPOINT_URL = FixerAPI::FIXER_API_BASE_URL . 'timeseries';
    private const FIXER_API_LATEST_ENPOINT_URL = FixerAPI::FIXER_API_BASE_URL . 'latest';
    private const FIXER_API_ACCESS_KEY = '27108040923da4cd86416d7924e9a908';

    private $fromCurrency;
    private $toCurrency;
    private $period;
    private $amountToConvert;
    private $averageConversionRate;

    public function __construct($fromCurrency, $toCurrency, $period, $amountToConvert)
    {
        $this->fromCurrency = $fromCurrency;
        $this->toCurrency = $toCurrency;
        $this->period = strtoupper($period);
        $this->amountToConvert = $amountToConvert;
        $this->averageConversionRate = 0;
    }

    public function getCurrencyFrom()
    {
        return $this->fromCurrency;
    }

    public function getCurrencyTo()
    {
        return $this->toCurrency;
    }

    public function getPeriod()
    {
        return $this->period;
    }

    public function getCovertedAmount()
    {
        return $this->amountToConvert;
    }

    public function getAverageConversionRate()
    {
        return $this->averageConversionRate;
    }

    public function convert()
    {
        $results = $this->getForeignExchangeRates();

        $sum = 0;
        foreach ($results['rates'] as $value) {
            $sum += $value[$this->toCurrency];
        }

        $this->averageConversionRate = $sum / count($results['rates']);

        $convertedAmount = $this->averageConversionRate * $this->amountToConvert;

        return $convertedAmount;
    }

    /*
     * Get Foreign Exchanges rates
     * @retruns
     */
    private function getForeignExchangeRates()
    {
        $url = $this->buildEndpointURL();

        $ch = curl_init();

        // Set the url, number of GET vars, GET data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute request
        $result = curl_exec($ch);

        // Close connection
        curl_close($ch);

        // get the result and parse to JSON
        $result_arr = json_decode($result, true);

        return $result_arr;
    }

    /*
     * Returns the endpoint url based on the period.
     */
    private function buildEndpointURL()
    {
        $endPoint = FixerAPI::FIXER_API_TIMESERIES_ENPOINT_URL;

        $startDate = new \DateTime();

        $query = [
            'access_key' => FixerAPI::FIXER_API_ACCESS_KEY,
            'base' => $this->fromCurrency,
            'symbols' => $this->toCurrency,
            'end_date' => (new \DateTime())->format('Y-m-d')
        ];

        if (strcmp($this->period, 'WEEKLY') == 0) {
            $startDate->sub(new \DateInterval('P1W'));
        } else if (strcmp($this->period, 'MONTHLY') == 0) {
            $startDate->sub(new \DateInterval('P1M'));
        } else if (strcmp($this->period, 'SIX MONTHS') == 0) {
            $startDate->sub(new \DateInterval('P6M'));
        } else if (strcmp($this->period, 'YEARLY') == 0) {
            $startDate->sub(new \DateInterval('P1Y'));
        } else {
            //DAILY IS DEFAULT. NOTHING TO DO.
        }

        $query['start_date'] = $startDate->format('Y-m-d');

        return $endPoint . '?' . http_build_query($query);
    }
}