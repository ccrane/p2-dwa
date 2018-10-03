<?php
require 'FixerAPI.php';

use DWA\P2\FixerAPI;


# Start the session, since we'll be using it below
session_start();

$supportedSymbols = FixerAPI::getSupportedSymbols();

# Get the data from the session
$results = $_SESSION['results'] ?? null;

$hasErrors = $results['hasErrors'] ?? null;
$errors = $results['errors'] ?? null;
$convertFrom = $results['convertFrom'] ?? null;
$convertTo = $results['convertTo'] ?? null;
$amountToConvert = $results['amountToConvert'] ?? null;
$period = $results['period'] ?? null;

# Clear the session
session_unset();