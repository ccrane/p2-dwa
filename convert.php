<?php
require 'inc/helpers.php';
require 'inc/Form.php';
require 'FixerAPI.php';

use DWA\P2\FixerAPI;

# Start the session
session_start();

$convertFrom = $_POST['convertFrom'] ?? false;
$convertTo = $_POST['convertTo'] ?? false;
$amountToConvert = $_POST['amountToConvert'] ?? false;
$period = $_POST['period'] ?? false;

$convertedAmount = 0;
$averageConversionRate = 0;

if ($convertFrom && $convertTo && $convertTo && $period) {
    # connect to Fixer API endpoint and retrieve conversion rates.
    # calculate converted amount
    $fixer = new FixerAPI($convertFrom, $convertTo, $period, $amountToConvert);

    $convertedAmount = $fixer->convert();
    $averageConversionRate = $fixer->getAverageConversionRate();
}

# Store our results in the session
$_SESSION['results'] = [
    'convertFrom' => $convertFrom,
    'convertTo' => $convertTo,
    'amountToConvert' => $amountToConvert,
    'period' => $period,
    'convertedAmount' => $convertedAmount,
    'averageConversionRate' => $averageConversionRate
];

# Redirect back main converter UI
header('Location: index.php');