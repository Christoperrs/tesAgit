<?php
include 'db.php';

try {
    $query = "
  SELECT 
            country,
            item_type AS item, 
            (units_sold * unit_price) AS revenue
        FROM salesorder
        LIMIT 20
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $sales_summary = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode(['status' => 'OK', 'items' => $sales_summary]);

} catch (PDOException $e) {
 
    echo "Error: " . $e->getMessage();
}
?>
