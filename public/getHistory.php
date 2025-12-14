<?php
include 'dbconnect.php';

header('Content-Type: application/json');

try {
    $query = "SELECT 
                time,
                route,
                weather,
                passengers,
                fare
              FROM jeep
              ORDER BY time DESC";

    $stmt = $conn->prepare($query);
    $stmt->execute();

    $history = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Ensure numeric values
    foreach ($history as &$row) {
        $row['route'] = (string)$row['route'];
        $row['weather'] = (int)$row['weather'];
        $row['passengers'] = (int)$row['passengers'];
        $row['fare'] = (float)$row['fare'];
    }

    echo json_encode($history);
    exit;

} catch (PDOException $e) {
    echo json_encode([]);
    exit;
}
