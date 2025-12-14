<?php
// public/predict.php
require_once __DIR__ . '/../vendor/autoload.php';

use Phpml\ModelManager;

// ensure history file exists
$historyFile = __DIR__ . '/../data/history.json';
if (!file_exists($historyFile)) {
    file_put_contents($historyFile, json_encode([]));
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo 'Use the form.';
    exit;
}

$month = (int)$_POST['month'];
$day   = (int)$_POST['day'];
$weather = (int)$_POST['weather'];
$start = (int)$_POST['start'];
$end = (int)$_POST['end'];
$route = (int)$_POST['route'];
$cap = (int)$_POST['cap'];

$features = [
    $month, $day, $weather,
    $start, $end,
    $route, $cap
];

// Load model
$modelPath = __DIR__ . '/../model/passenger_regression.model';
$modelManager = new ModelManager();
$regression = $modelManager->restoreFromFile($modelPath);

// Predict
$predicted = $regression->predict([$features]);
$passengers = round($predicted[0]);

// Gross Fare
if ($route == 1) {
    $rate = ($passengers <= 40) ? 40.5 :
            (($passengers <= 80) ?  35.5 : 30.5);
} else {
    $rate = ($passengers <= 40) ? 11.7 :
            (($passengers <= 80) ? 11.3 : 10.5);
}

$fare = $passengers * $rate;


// Icons
$weatherIcon = ($weather === 1) ? " ☀️ Sunny" : " 🌧 Rainy";
$routeIcon = ($route === 1) ? "Route 1 (San Pablo → Tanauan)" : "Route 2 (San Pablo → Wawa)";

// Save history
$entry = [
    "month" => $month,
    "day" => $day,
    "weather" => $weatherIcon,
    "start" => $start,
    "end" => $end,
    "route" => $routeIcon,
    "capacity" => $cap,
    "passengers" => $passengers,
    "fare" => $fare,
    "time" => date("Y-m-d H:i:s")
];

$history = json_decode(file_get_contents($historyFile), true);
array_unshift($history, $entry); // add newest first
$history = array_slice($history, 0, 5); // keep last 5 only
file_put_contents($historyFile, json_encode($history, JSON_PRETTY_PRINT));
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Prediction Result</title>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <script>
(function() {
    const theme = localStorage.getItem("theme");

    if (theme === "dark") {
        document.documentElement.classList.add("dark");
    } else {
        document.documentElement.classList.remove("dark");
    }
})();
</script>
<title>Passenger Prediction Result</title>

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: "Inter", "Segoe UI", Arial, sans-serif;
        background: linear-gradient(145deg, #e9eef3, #f6f8fa);
        display: flex;
        justify-content: center;
        align-items: flex-start;
        min-height: 100vh;
        padding: 30px 0;
    }

    .container {
        background: #ffffff;
        width: 92%;
        max-width: 460px;
        padding: 30px;
        border-radius: 18px;
        box-shadow: 0 8px 22px rgba(0,0,0,0.12);
        animation: fadeIn 0.4s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    h1 {
        font-size: 26px;
        font-weight: 700;
        text-align: center;
        color: #232323;
        margin-bottom: 20px;
    }

    .value-box {
        background: #f3f7ff;
        color: #0d6efd;
        font-size: 48px;
        font-weight: 800;
        text-align: center;
        padding: 20px 10px;
        border-radius: 14px;
        margin-bottom: 25px;
        border: 1px solid #dce7ff;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        background: #fafbfd;
        padding: 14px 18px;
        border-radius: 12px;
        border: 1px solid #e8e8e8;
        margin-bottom: 12px;
        font-size: 17px;
        color: #444;
    }

    .info-label {
        font-weight: 600;
        color: #222;
    }

    .fare-box {
        text-align: center;
        padding: 20px;
        margin-top: 20px;
        margin-bottom: 15px;
        background: #e9fbee;
        border: 1px solid #c8f3d0;
        border-radius: 14px;
    }

    .fare-box span {
        display: block;
        font-size: 18px;
        color: #2d7d46;
        margin-bottom: 6px;
    }

    .fare-value {
        font-size: 32px;
        font-weight: 800;
        color: #27ae60;
    }

    /* ------------------------------ */
    /* Modern Gradient Button (Option 1) */
    /* ------------------------------ */
    .btn {
        width: 100%;
        display: inline-block;
        text-align: center;
        padding: 15px 0;
        font-size: 18px;
        font-weight: 600;
        color: #fff;
        background: linear-gradient(135deg, #0d6efd, #4a8bff);
        border-radius: 12px;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
        transition: 0.25s ease;
    }

    .btn:hover {
        background: linear-gradient(135deg, #0a58ca, #3c73d9);
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2);
    }

/* Dark Mode Adjustments */
.dark body {
    background: #121212 !important; /* Deep black background for dark mode */
    color: #e0e0e0; /* Light text for readability */
}

.dark .container {
    background: #1e1e1e !important; /* Darker container background */
    color: #e0e0e0; /* Ensure text within container remains readable */
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3); /* Subtle shadow for depth */
}

.dark h1 {
    color: #fff !important; /* White color for the heading */
}

.dark .value-box {
    background: #2d2d2d !important; /* Darker value box for contrast */
    color: #f39c12 !important; /* Warm golden color for emphasis */
}

.dark .info-row {
    background: #2a2a2a !important; /* Darker rows for info */
    border: 1px solid #444444; /* Softer border color */
    color: #e0e0e0; /* Light text for info rows */
}

.dark .info-label {
    color: #b0b0b0 !important; /* Lighter label color */
}

.dark .fare-box {
    background: #333333 !important; /* Dark background for fare box */
    border: 1px solid #444444; /* Soft border to maintain visual hierarchy */
}

.dark .fare-box span {
    color: #b0b0b0 !important; /* Lighter text color for the "Estimated Fare" label */
}

.dark .fare-value {
    color: #27ae60 !important; /* Green color for fare value */
}

.dark .btn {
    background: #1a73e8 !important; /* Bright blue button to stand out */
    color: white !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); /* Subtle shadow for depth */
}

.dark .btn:hover {
    background: #1359b3 !important; /* Darker blue on hover */
    transform: translateY(-2px); /* Slight lift effect */
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.3); /* Deep shadow on hover */
}

/* Darker border and shadow effects for better aesthetics */
.dark .container, .dark .info-row, .dark .fare-box {
    border-radius: 14px; /* Rounded corners for a smooth feel */
}

.dark .value-box {
    border-radius: 12px; /* Slightly less rounded for value box */
}

</style>
</head>

<body>

<div class="container">

    <h1>Passenger Prediction</h1>

    <div class="value-box"><?= $passengers ?></div>

    <div class="info-row">
        <div class="info-label">Weather</div>
        <div><?= $weatherIcon ?></div>
    </div>

    <div class="info-row">
        <div class="info-label">Route</div>
        <div><?= $routeIcon ?></div>
    </div>

    <div class="fare-box">
        <span>Estimated Fare</span>
        <div class="fare-value">₱<?= number_format($fare, 2) ?></div>
    </div>

    <a class="btn" href="index.php">Predict Again</a>
</div>

</body>
</html>

<?php
include 'dbconnect.php';

// Convert weather from form to number
// 1 = Sunny, 0 = Rainy
$weather = (int)$_POST['weather']; 
date_default_timezone_set('Asia/Manila');

$entry = [
    "month" => $month,
    "day" => $day,
    "weather" => $weather,
    "start" => $start,
    "end" => $end,
    "route" => $routeIcon,
    "capacity" => $cap,
    "passengers" => $passengers,
    "fare" => $fare,
    "time" => date("Y-m-d H:i:s") // This now gives correct local time
];


$query = "INSERT INTO jeep 
          (month, day, weather, start, end, route, capacity, passengers, fare, time)
          VALUES
          (:month, :day, :weather, :start, :end, :route, :capacity, :passengers, :fare, :time)";

$stmt = $conn->prepare($query);

$stmt->bindParam(':month', $entry['month'], PDO::PARAM_INT);
$stmt->bindParam(':day', $entry['day'], PDO::PARAM_INT);
$stmt->bindParam(':weather', $entry['weather'], PDO::PARAM_INT);
$stmt->bindParam(':start', $entry['start'], PDO::PARAM_STR);
$stmt->bindParam(':end', $entry['end'], PDO::PARAM_STR);
$stmt->bindParam(':route', $entry['route'], PDO::PARAM_STR);
$stmt->bindParam(':capacity', $entry['capacity'], PDO::PARAM_INT);
$stmt->bindParam(':passengers', $entry['passengers'], PDO::PARAM_INT);
$stmt->bindParam(':fare', $entry['fare'], PDO::PARAM_STR);
$stmt->bindParam(':time', $entry['time'], PDO::PARAM_STR);

$stmt->execute();
