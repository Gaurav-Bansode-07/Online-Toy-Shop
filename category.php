<?php
include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};

include 'components/wishlist_cart.php';

// Retrieve and sanitize the category parameter
$category = isset($_GET['category']) ? htmlspecialchars($_GET['category']) : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ucfirst($category); ?></title>

    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="products">
    <h1 class="heading"><?= ucfirst($category); ?></h1>
    <div class="box-container">
        <?php
        // Fetch products based on the selected category
        $select_products = $conn->prepare("SELECT * FROM `products` WHERE category = :category");
        $select_products->bindParam(':category', $category, PDO::PARAM_STR);
        $select_products->execute();

        if ($select_products->rowCount() > 0) {
            while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
                // Display each product here, including its category
                $product_id = $fetch_product['id'];
                $product_name = $fetch_product['name'];
                $product_price = $fetch_product['price'];
                $product_image = $fetch_product['image_01'];
                $product_category = $fetch_product['category']; // Fetch the category

                // You can display the product category along with other product details
                echo '<form action="" method="post" class="box">';
                echo '<input type="hidden" name="pid" value="' . $product_id . '">';
                echo '<input type="hidden" name="name" value="' . $product_name . '">';
                echo '<input type="hidden" name="price" value="' . $product_price . '">';
                echo '<input type="hidden" name="image" value="' . $product_image . '">';
                echo '<button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>';
                echo '<a href="quick_view.php?pid=' . $product_id . '" class="fas fa-eye"></a>';
                echo '<img src="uploaded_img/' . $product_image . '" alt="">';
                echo '<div class="name">' . $product_name . '</div>';
                echo '<div class="category">' . $product_category . '</div>'; // Display the category
                echo '<div class="flex">';
                echo '<div class="price"><span>$</span>' . $product_price . '<span>/-</span></div>';
                echo '<input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">';
                echo '</div>';
                echo '<input type="submit" value="add to cart" class="btn" name="add_to_cart">';
                echo '</form>';
            }
        } else {
            echo '<p class="empty">No products found!</p>';
        }
        ?>
    </div>
</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
