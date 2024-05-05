<?php
session_start();

include 'connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && ($_POST['action'] === 'add'
    or $_POST['action'] === 'update' or $_POST['action'] === 'delete')) {
    $customerId = $_SESSION['user_id'];
    $productId = isset($_POST['productId']) ? intval($_POST['productId']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $response = ['productId' => $productId];
    if ($customerId && $productId && $quantity) {
        $conn = new mysqli($servername, $username, $password, $dbname, $port);
        // Check if the product is already in the cart
        $checkSql = "SELECT * FROM cart WHERE customer_id = ? AND product_id = ?";
        $stmt = $conn->prepare($checkSql);
        $stmt->bind_param("ii", $customerId, $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Product exists in the cart, update quantity
            $cartItem = $result->fetch_assoc();
            if($_POST['action'] === 'add' or $_POST['action'] === 'update') {
                if($_POST['action'] === 'add'){
                    $newQuantity = $cartItem['quantity'] + $quantity;
                }else{
                    $newQuantity = $quantity;
                }
                $updateSql = "UPDATE cart SET quantity = ? WHERE cart_id = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bind_param("ii", $newQuantity, $cartItem['cart_id']);
            }else{
                $updateSql = "DELETE FROM cart WHERE cart_id = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bind_param("i", $cartItem['cart_id']);
            }
            $updateStmt->execute();
        } else {
            if($_POST['action'] === 'add' or $_POST['action'] === 'update') {
                // Product does not exist in the cart, add new
                $insertSql = "INSERT INTO cart (customer_id, product_id, quantity) VALUES (?, ?, ?)";
                $insertStmt = $conn->prepare($insertSql);
                $insertStmt->bind_param("iii", $customerId, $productId, $quantity);
                $insertStmt->execute();
            }
        }

        if ($conn->affected_rows > 0) {
            echo json_encode(['message' => 'Cart updated successfully']);
        } else {
            echo json_encode(['message' => 'Error updating cart: " . $conn->error . "']);
        }
        $conn->close();
    } else {
        echo json_encode(['message' => 'Error: Missing parameters']);
    }
}  else if ($_GET['action'] == 'getItemCount') {
    $conn = new mysqli($servername, $username, $password, $dbname, $port);
    $userId = $_SESSION['user_id'];
    $query = "SELECT SUM(quantity) as total_quantity FROM cart WHERE customer_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $conn->close();
    echo json_encode(['count' => isset($row['total_quantity']) ? $row['total_quantity'] : 0]);
}
else {
    echo json_encode(['message' => 'Invalid request']);
}
exit;
?>
