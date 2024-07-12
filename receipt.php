<?php
include 'components/connect.php';

if(isset($_POST['search'])){
   // Get the phone number from the form input
   $phone_number = filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_STRING);

   // Search for orders with the provided phone number
   $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE number = ?");
   $select_orders->execute([$phone_number]);

   if($select_orders->rowCount() > 0){
      // Fetch and display order information
      echo "<h2>Orders for Phone Number: $phone_number</h2>";
      echo "<table>";
      echo "<tr><th>Order ID</th><th>Name</th><th>Email</th><th>Method</th><th>Address</th><th>Total Products</th><th>Total Price</th><th>Order Date</th></tr>";
      while($order = $select_orders->fetch(PDO::FETCH_ASSOC)){
         echo "<tr>";
         echo "<td>{$order['id']}</td>";
         echo "<td>{$order['name']}</td>";
         echo "<td>{$order['email']}</td>";
         echo "<td>{$order['method']}</td>";
         echo "<td>{$order['address']}</td>";
         echo "<td>{$order['total_products']}</td>";
         echo "<td>{$order['total_price']}</td>";
         echo "<td>{$order['placed_on']}</td>";
         echo "</tr>";
      }
      echo "</table>";
   } else {
      echo "No orders found for phone number: $phone_number";
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<style>
      body {
         font-family: Arial, sans-serif;
         background-color: #f5f5f5;
         margin: 0;
         padding: 0;
      }

      h2 {
         color: #333;
         text-align: center;
         margin-top: 20px;
      }

      table {
         width: 100%;
         border-collapse: collapse;
         margin-top: 20px;
         background-color: #fff;
         border: 2px solid #ddd;
      }

      table, th, td {
         border: 1px solid #ddd;
      }

      th, td {
         padding: 10px;
         text-align: left;
      }

      th {
         background-color: #333;
         color: #fff;
      }

      tr:nth-child(even) {
         background-color: #f2f2f2;
      }

      tr:hover {
         background-color: #ddd;
      }

      label {
         font-weight: bold;
      }

      input[type="text"] {
         width: 100%;
         padding: 5px;
         margin-bottom: 10px;
      }

      input[type="submit"] {
         background-color: #333;
         color: #fff;
         padding: 10px 20px;
         border: none;
         cursor: pointer;
      }

      input[type="submit"]:hover {
         background-color: #555;
      }

      /* Styling for the print button */
      #printButton {
         background-color: #333;
         color: #fff;
         padding: 10px 20px;
         border: none;
         cursor: pointer;
         margin-top: 20px;
      }

      #printButton:hover {
         background-color: #555;
      }

      /* Additional styles for better appearance */
      .container {
         max-width: 800px;
         margin: 0 auto;
         padding: 20px;
         background-color: #fff;
         border: 2px solid #ddd;
         border-radius: 10px;
         box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
      }
   </style>







</head>
<body>
   <!-- Your HTML form to search for orders by phone number -->
   <form action="" method="POST">
      <label for="phone_number">Enter Phone Number:</label>
      <input type="text" name="phone_number" id="phone_number" required>
      <input type="submit" name="search" value="Search Orders">
   </form>
   
   <!-- ... (other HTML content) ... -->
   <button id="printButton">Print Receipt</button>
   <a href="/KidsToyStore" id="backToHome">Back to Home</a>
<script>
     const printButton = document.getElementById("printButton");
     printButton.addEventListener("click", () => {
         window.print();
     });
 </script>
</body>
</html>
