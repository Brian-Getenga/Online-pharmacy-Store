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
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="orders">
   <h1 class="heading">Placed Orders</h1>
   <div class="box-container">
      <?php
      if ($user_id == '') {
         echo '<p class="empty">Please login to see your orders.</p>';
      } else {
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
         $select_orders->execute([$user_id]);
         if ($select_orders->rowCount() > 0) {
            while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
      ?>
      <div class="box">
         <div class="order-details">
            <p><span>Placed on:</span> <?= $fetch_orders['placed_on']; ?></p>
            <p><span>Name:</span> <?= $fetch_orders['name']; ?></p>
            <p><span>Email:</span> <?= $fetch_orders['email']; ?></p>
            <p><span>Number:</span> <?= $fetch_orders['number']; ?></p>
            <p><span>Address:</span> <?= $fetch_orders['address']; ?></p>
            <p><span>Payment Method:</span> <?= $fetch_orders['method']; ?></p>
            <p><span>Your Orders:</span> <?= $fetch_orders['total_products']; ?></p>
            <p><span>Total Price:</span> ksh <?= $fetch_orders['total_price']; ?></p>
            <p><span>Payment Status:</span> <span class="payment-status <?= strtolower($fetch_orders['payment_status']); ?>"><?= $fetch_orders['payment_status']; ?></span></p>
         </div>
      </div>
      <?php
            }
         } else {
            echo '<p class="empty">No orders placed yet!</p>';
         }
      }
      ?>
   </div>
</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>