<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE-edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <style>
      /* CSS for the Cancel Order button */
      .cancel-button {
         background-color: red;
         color: white;
         padding: 4px 8px;
         border: none;
         border-radius: 4px;
         cursor: pointer;
         text-decoration: none;
         display: inline-block;
      }

      .cancel-button:hover {
         background-color: darkred;
      }
   </style>


</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="orders">

   <h1 class="heading">placed orders</h1>

   <div class="box-container">

   <?php
      if($user_id == ''){
         echo '<p class="empty">please login to see your orders</p>';
      }else{
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
         $select_orders->execute([$user_id]);
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p>placed on : <span><?= $fetch_orders['placed_on']; ?></span></p>
      <p>name : <span><?= $fetch_orders['name']; ?></span></p>
      <p>email : <span><?= $fetch_orders['email']; ?></span></p>
      <p>number : <span><?= $fetch_orders['number']; ?></span></p>
      <p>address : <span><?= $fetch_orders['address']; ?></span></p>
      <p>payment method : <span><?= $fetch_orders['method']; ?></span></p>
      <p>your orders : <span><?= $fetch_orders['total_products']; ?></span></p>
      <p>total price : <span>$<?= $fetch_orders['total_price']; ?>/-</span></p>
      <p>order status: <span style="color:<?php 
      if($fetch_orders['payment_status'] == 'pending'){ 
         echo 'red'; 
      }else{ 
         echo 'green'; 
      }; 
   ?>"><?= $fetch_orders['payment_status']; ?></span>
   <?php 
      if($fetch_orders['payment_status'] == 'pending'){ 
   ?>
   <!-- Pass the order id to the cancel_order.php file -->
   <a href="#" class="cancel-button" onclick="confirmCancellation(<?= $fetch_orders['id'] ?>);">Cancel Order</a>

<script>
function confirmCancellation(orderId) {
    var confirmation = window.confirm("Are you sure you want to cancel this order?");

    if (confirmation) {
        // If the user clicks "OK," you can redirect to the cancel_order.php page.
        window.location.href = "cancel_order.php?id=" + orderId;
    } else {
        // If the user clicks "Cancel," you can perform any other desired action.
        // For example, do nothing or display a message.
    }
}
</script>

   <?php } ?>
   </div>
   <?php
      }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }
      }
   ?>

   </div>

</section>

<?php include 'components/footer.php'; ?>

<!-- JavaScript to handle the button click event -->
<script src="js/script.js"></script>
<!-- Inside your HTML, add the following JavaScript code -->
<!-- Inside your HTML, add the following JavaScript code -->
<!-- Inside your HTML, add the following JavaScript code -->
<script>
   function cancelOrder(id) {
      // Display a custom confirmation dialog
      var confirmation = window.confirm("Do you want to cancel the order?");

      if (confirmation) {
         // If the user clicks "OK" in the custom dialog, proceed with the cancellation
         // You can implement the logic to cancel the order using AJAX or other methods
         // You may need to send a request to your server to perform the cancelation
         // In this example, I'll just log a message for demonstration purposes
         console.log("Order canceled."); // Display a message to confirm the cancellation
      } else {
         // If the user clicks "Cancel" in the custom dialog, do nothing
         console.log("Order not canceled.");
      }
   }
</script>



</body>
</html>
