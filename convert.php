<?php
# Start the session
session_start();

$convertFrom = $_POST['convertFrom'] ?? false;
$convertTo = $_POST['convertTo'] ?? false;
$amountToConvert = $_POST['amountToConvert'] ?? false;
$period = $_POST['period'] ?? false;

if ($convertFrom && $convertTo && $amount && $period) {
    # connect to BOC valet endpoint and retrieve conversion rates.
    # calculate converted amount
}

# Store our results in the session
$_SESSION['results'] = [
    'convertFrom' => $convertFrom,
    'convertTo' => $convertTo,
    'amountToConvert' => $amountToConvert,
    'period' => $period,
    'convertedAmount' => '???'
];

# Redirect back main converter UI
header('Location: index.php');