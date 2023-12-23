<?php

require_once 'Database.php';
require_once 'TransactionAnalyzer.php';

try {
    $db = new Database();
    
    $transactionAnalyzer = new TransactionAnalyzer($db);
    
    $userId = $_GET['user_id'] ?? null;

    if (!$userId) {
        echo json_encode([
            'success' => false,
            'message' => 'User not set'
        ]);
        exit();
    }
    
    $response = $transactionAnalyzer->analyzeUserBalance($userId);
    
    echo json_encode($response);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database connection error: ' . $e->getMessage()
    ]);
} finally {
    $db->closeConnection();
}
