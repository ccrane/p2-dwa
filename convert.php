<?php
require 'inc/helpers.php';
require 'inc/Form.php';
require 'inc/FixerAPI.php';

use DWA\P2\FixerAPI;
use DWA\Form;

# Start the session
session_start();

$form = new Form($_POST);

# Get FORM input if it exists.
$convertFrom = $form->get('convertFrom');
$convertTo = $form->get('convertTo');
$amountToConvert = $form->get('amountToConvert');
$period = $form->get('period');

$convertedAmount = 0;
$averageConversionRate = 0;
$errors = [];

# Only calculate converted amount if form is submitted and valid.
if ($form->isSubmitted()) {
    $errors = $form->validate([
        'convertFrom' => 'required',
        'convertTo' => 'required',
        'amountToConvert' => 'required|numeric|min:1',
        'period' => 'required'
    ]);
    if (!$form->hasErrors) {
        # connect to Fixer API endpoint.
        $fixer = new FixerAPI($convertFrom, $convertTo, $period, $amountToConvert);
        # calculate converted amount and retrieve conversion rates
        $convertedAmount = $fixer->convert();
        $averageConversionRate = $fixer->getAverageConversionRate();
    }
}

# Store our results in the session
$_SESSION['results'] = [
    'convertFrom' => $convertFrom,
    'convertTo' => $convertTo,
    'amountToConvert' => $amountToConvert,
    'period' => $period,
    'convertedAmount' => $convertedAmount,
    'averageConversionRate' => $averageConversionRate,
    'errors' => $errors,
    'hasErrors' => $form->hasErrors
];

# Redirect back main converter UI
header('Location: index.php');