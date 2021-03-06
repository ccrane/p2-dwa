<?php
require 'inc/logic.php';
require 'inc/helpers.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Currency Converter</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans"/>
    <link rel="stylesheet"
          type="text/css"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
          crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/css/main.css"/>
</head>
<body>
<div class="container-fluid">
    <div class="row justify-content-center my-5">
        <div class="col-5">
            <div class="card">
                <h3 class="card-header">Currency Converter</h3>
                <div class="card-body">
                    <h5 class="card-title">Go ahead, give it a try!</h5>
                    <p class="card-text">
                        Use the currency converter below to convert between different national currencies using the average exchange
                        rate for the selected period.
                    </p>
                    <p class="card-text font-italic text-center text-danger">* Required fields.</p>
                    <form action="convert.php" method="POST">
                        <div class="form-group">
                            <label for="convertFrom">From:<span class='text-danger'>&nbsp;*</span></label>
                            <select class="form-control" id="convertFrom" name="convertFrom" required>
                                <option value=""> --- Select Currency ---</option>
                                <?php foreach ($supportedSymbols as $symbol => $name) : ?>
                                    <option value="<?= $symbol ?>" <?= (isset($convertFrom) && ($convertFrom == $symbol)) ? " selected" : "" ?>><?= $name ?> (<?= $symbol ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="convertTo">To:<span class='text-danger'>&nbsp;*</span></label>
                            <select class="form-control" id="convertTo" name="convertTo" required>
                                <option value=""> --- Select Currency ---</option>
                                <?php foreach ($supportedSymbols as $symbol => $name) : ?>
                                    <option value="<?= $symbol ?>"<?= (isset($convertTo) && ($convertTo == $symbol)) ? " selected" : "" ?>><?= $name ?> (<?= $symbol ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="amountToConvert">Amount:<span class='text-danger'>&nbsp;*</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="number"
                                       class="form-control"
                                       id="amountToConvert"
                                       name="amountToConvert"
                                       min="1"
                                       value="<?= isset($amountToConvert) ? sanitize($amountToConvert) : "1.00" ?>"
                                       required>
                            </div>
                        </div>
                        <div class="form-group">
                            <Label>Average Rate Period:<span class='text-danger'>&nbsp;*</span></label><br/>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                       type="radio"
                                       id="dailyAverage"
                                       name="period"
                                       value="Daily"
                                       required
                                    <?= (isset($period) && (strtoupper($period) == 'DAILY')) ? " checked" : "" ?>>
                                <label class="form-check-label" for="dailyAverage">Daily</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                       type="radio"
                                       id="weeklyAverage"
                                       name="period"
                                       required
                                       value="Weekly" <?= (isset($period) && (strtoupper($period) == 'WEEKLY')) ? " checked" : "" ?>>
                                <label class="form-check-label" for="weeklyAverage">Weekly</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                       type="radio"
                                       id="monthlyAverage"
                                       name="period"
                                       required
                                       value="Monthly" <?= (isset($period) && (strtoupper($period) == 'MONTHLY')) ? " checked" : "" ?>>
                                <label class="form-check-label" for="monthlyAverage">Monthly</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                       type="radio"
                                       id="sixMonthAverage"
                                       name="period"
                                       required
                                       value="Six Month" <?= (isset($period) && (strtoupper($period) == 'SIX MONTH')) ? " checked" : "" ?>>
                                <label class="form-check-label" for="sixMonthAverage">Six Months</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                       type="radio"
                                       id="yearlyAverage"
                                       name="period"
                                       required
                                       value="Yearly" <?= (isset($period) && (strtoupper($period) == 'YEARLY')) ? " checked" : "" ?>>
                                <label class="form-check-label" for="yearlyAverage">Yearly</label>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" name="convert" class="btn btn-outline-primary">Convert</button>
                        </div>
                    </form>
                    <?php if ($hasErrors): ?>
                        <div class='alert alert-danger mb-3' role="alert">
                            <h4>Errors</h4>
                            <hr>
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif ?>
                    <?php if (isset($results) && !$hasErrors): ?>
                        <div class="alert alert-success mb-3" role="alert">
                            <h4>Success!</h4>
                            <hr>
                            <p class="text-center">
                                Using the
                                <strong><?= $period ?></strong> average exchange rate
                                <strong><?= $results["averageConversionRate"] ?></strong>
                            </p>
                            <p class="text-center">
                                <strong><?= $amountToConvert . " " . $convertFrom ?></strong> is equivalent to
                                <strong><?= number_format($results["convertedAmount"], 2) ?> <?= $convertTo ?></strong>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"
        integrity="sha384-pjaaA8dDz/5BgdFUPX6M/9SUZv4d12SUPF0axWc+VRZkx5xU3daN+lYb49+Ax+Tl"
        crossorigin="anonymous"></script>
</body>
</html>