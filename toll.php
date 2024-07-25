<?php
include 'db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vehicle_number = $_POST['vehicle_number'];
    $toll_booth_id = $_POST['toll_booth_id'];
    $amount = $_POST['amount'];

    // Check if vehicle exists
    $stmt = $pdo->prepare('SELECT id FROM vehicles WHERE vehicle_number = ?');
    $stmt->execute([$vehicle_number]);
    $vehicle = $stmt->fetch();

    if ($vehicle) {
        // Record payment
        $stmt = $pdo->prepare('INSERT INTO toll_payments (vehicle_id, toll_booth_id, amount) VALUES (?, ?, ?)');
        $stmt->execute([$vehicle['id'], $toll_booth_id, $amount]);
        echo 'Payment recorded successfully';
    } else {
        echo 'Vehicle not found';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Record Toll Payment</title>
</head>
<body>
    <form method="POST">
        <input type="text" name="vehicle_number" placeholder="Vehicle Number" required>
        <select name="toll_booth_id">
            <!-- Options should be populated from the database -->
            <option value="1">Booth 1</option>
            <option value="2">Booth 2</option>
        </select>
        <input type="number" name="amount" placeholder="Amount" required>
        <button type="submit">Record Payment</button>
    </form>
</body>
</html>
