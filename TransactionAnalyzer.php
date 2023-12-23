<?php

class TransactionAnalyzer
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function analyzeUserBalance($userId)
    {
        $conn = $this->db->getConnection();

        $userCheck = "SELECT * FROM transactions WHERE paid_by = $userId OR paid_to = $userId";
        $result = $conn->query($userCheck);
        if ($result === false || $result->num_rows === 0) {
            return [
                'success' => false,
                'message' => 'User not found'
            ];
        }

        $sqlOutgoing = "SELECT SUM(amount) AS total_outgoing FROM transactions WHERE paid_by = $userId";
        $resultOutgoing = $conn->query($sqlOutgoing);
        $totalOutgoing = ($resultOutgoing->num_rows > 0) ? $resultOutgoing->fetch_assoc()['total_outgoing'] : 0;

        $sqlIncoming = "SELECT SUM(amount) AS total_incoming FROM transactions WHERE paid_to = $userId";
        $resultIncoming = $conn->query($sqlIncoming);
        $totalIncoming = ($resultIncoming->num_rows > 0) ? $resultIncoming->fetch_assoc()['total_incoming'] : 0;

        $balance = $totalIncoming - $totalOutgoing;

        $response = [
            'user_id' => $userId,
            'balance' => $balance
        ];

        return $response;
    }
}
