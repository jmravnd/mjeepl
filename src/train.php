<?php
// src/train.php
require_once __DIR__ . '/../vendor/autoload.php';

use Phpml\Regression\LeastSquares;
use Phpml\ModelManager;
use Phpml\CrossValidation\RandomSplit;
use Phpml\Metric\Regression;

// --- helpers ---
function load_dataset($csvPath) {
    $fh = fopen($csvPath, 'r');
    $header = fgetcsv($fh); // skip header

    $samples = [];
    $targets = [];

    while (($row = fgetcsv($fh)) !== false) {

        // Skip empty or malformed rows
        if (!is_array($row) || count($row) !== 8) {
            continue;
        }

        list($month, $day, $weather, $start, $end, $route, $capacity, $passengers) = $row;

        // Convert to numeric
        $month = (int)$month;
        $day = (int)$day;
        $weather = (int)$weather;
        $start = (int)$start;
        $end = (int)$end;
        $route = (int)$route;
        $capacity = (int)$capacity;
        $passengers = (float)$passengers;

        // FINAL FIXED FEATURE SET: 7 FEATURES
        $samples[] = [
            $month,
            $day,
            $weather,
            $start,
            $end,
            $route,
            $capacity
        ];

        $targets[] = $passengers;
    }

    fclose($fh);
    return [$samples, $targets];
}

// --- main ---
list($samples, $targets) = load_dataset(__DIR__ . '/../data/passengers.csv');

echo "Samples: " . count($samples) . PHP_EOL;
echo "Targets: " . count($targets) . PHP_EOL;
echo "Features per sample: " . count($samples[0]) . PHP_EOL;

// split into train/test (70/30)
$datasetSplit = new RandomSplit(new \Phpml\Dataset\ArrayDataset($samples, $targets), 0.3);
$trainSamples = $datasetSplit->getTrainSamples();
$trainTargets = $datasetSplit->getTrainLabels();
$testSamples = $datasetSplit->getTestSamples();
$testTargets = $datasetSplit->getTestLabels();

// train regression
$regression = new LeastSquares();
$regression->train($trainSamples, $trainTargets);

// evaluate
$predictions = $regression->predict($testSamples);
$mae = Regression::meanAbsoluteError($testTargets, $predictions);
$mse = Regression::meanSquaredError($testTargets, $predictions);

echo "MAE: $mae\n";
echo "MSE: $mse\n";

// save model
$modelPath = __DIR__ . '/../model/passenger_regression.model';
$modelManager = new ModelManager();
$modelManager->saveToFile($regression, $modelPath);

echo "Model saved to $modelPath\n";
