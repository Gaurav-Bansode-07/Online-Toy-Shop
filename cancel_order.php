<?php
include 'components/connect.php';

if (isset($_GET['id'])) {
   $order_id = $_GET['id'];
   
   // Prepare and execute a SQL query to delete the order with the specified ID
   $delete_order = $conn->prepare("DELETE FROM orders WHERE id = ?");
   $delete_order->execute([$order_id]);

   if ($delete_order) {
      // Order was successfully deleted
      header('Location:orders.php'); // Redirect to a suitable page
   } else {
      // Handle the case where the order deletion failed
      echo 'Order cancellation failed. Please try again later.';
   }
} else {
   // Handle the case where the 'id' parameter is not set
   echo 'Invalid request.';
}
?>
