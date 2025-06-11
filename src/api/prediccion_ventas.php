<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../etl/predictive_analysis.php';

$predictor = new PredictiveAnalysis($pdo);
$predicciones = $predictor->predictDemand(null, 14);
echo json_encode($predicciones); 