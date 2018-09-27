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
    <div class="row justify-content-center">
        <div class="col-6">
            <h2 class="text-center">Currency Converter</h2>
            <p>Use the currency converter below to convert any amount between different national currencies using the average rate for a given period.</p>
            <form action="index.php" method="POST">
                <div class="form-group">
                    <label for="convertFrom">From:</label>
                    <select class="form-control" id="convertFrom" name="convertFrom">
                        <option value="USD" selected>US Dollar (USD)</option>
                        <option value="CAD">Canadian Dollar (CAD)</option>
                        <option value="GBP">British Pound (GBP)</option>
                        <option value="AUD">Australian Dollar (AUD)</option>
                        <option value="EUR">Euro (EUR)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="convertTo">To:</label>
                    <select class="form-control" id="convertTo" name="convertTo">
                        <option value="USD">US Dollar (USD)</option>
                        <option value="CAD" selected>Canadian Dollar (CAD)</option>
                        <option value="GBP">British Pound (GBP)</option>
                        <option value="AUD">Australian Dollar (AUD)</option>
                        <option value="EUR">Euro (EUR)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="amountToConvert">Amount: </label>
                    <input type="number"
                           class="form-control"
                           id="amountToConvert"
                           name="amountToConvert"
                           min="1"
                           value="1.00">
                </div>
                <div class="form-group">
                    <Label>Average Rate Period</label><br/>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="dailyAverage" name="period" value="daily">
                        <label class="form-check-label" for="dailyAverage">Daily</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="weeklyAverage" name="period" value="weekly">
                        <label class="form-check-label" for="weeklyAverage">Weekly</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="monthlyAverage" name="period" value="monthly">
                        <label class="form-check-label" for="monthlyAverage">Monthly</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input"
                               type="radio"
                               id="sixMonthAverage"
                               name="period"
                               value="sixmonths">
                        <label class="form-check-label" for="sixMonthAverage">Six Months</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="yearlyAverage" name="period" value="yearly">
                        <label class="form-check-label" for="yearlyAverage">Yearly</label>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" name="convert" class="btn btn-primary">Convert</button>
                </div>
            </form>
            <?php if (isset($_POST["convert"])): ?>
                <div class="alert alert-success" role="alert">
                    <pre>
                        <?php var_dump($_POST); ?>
                    </pre>
                </div>
            <?php endif; ?>
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