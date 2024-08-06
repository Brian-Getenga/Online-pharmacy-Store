<?php

include './components/connect.php';
include './accessToken.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = 'flat no. '. $_POST['flat'] .', '. $_POST['street'] .', '. $_POST['city'] .', '. $_POST['state'] .', '. $_POST['country'] .' - '. $_POST['pin_code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      if($method == "Mpesa"){
          // Mpesa STK Push Integration
          date_default_timezone_set('Africa/Nairobi');
          $processrequestUrl = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
          $callbackurl = 'https://your-callback-url.com/callback.php'; // Replace with your actual callback URL

          $passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919"; // Replace with your actual passkey
          $BusinessShortCode = '174379'; // Replace with your actual business shortcode
          
          $Timestamp = date('YmdHis');
          $Password = base64_encode($BusinessShortCode . $passkey . $Timestamp);
          
          // Format the phone number
          if (substr($number, 0, 1) == '0') {
              $phone = '254' . substr($number, 1);
          } else if (substr($number, 0, 3) == '254') {
              $phone = $number;
          } else {
              $phone = '254' . $number;
          }
          
          $Amount = $total_price;
          $PartyA = $phone;
          $PartyB = $BusinessShortCode;
          $AccountReference = 'Afyapharmacy'; // Replace with your account reference
          $TransactionDesc = 'STK Push Payment'; // Replace with your transaction description
          
          $stkpushheader = [
              'Content-Type:application/json',
              'Authorization:Bearer ' . $access_token
          ];
          
          $curl = curl_init();
          curl_setopt($curl, CURLOPT_URL, $processrequestUrl);
          curl_setopt($curl, CURLOPT_HTTPHEADER, $stkpushheader);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($curl, CURLOPT_POST, true);
          
          $curl_post_data = array(
              'BusinessShortCode' => $BusinessShortCode,
              'Password' => $Password,
              'Timestamp' => $Timestamp,
              'TransactionType' => 'CustomerPayBillOnline',
              'Amount' => $Amount,
              'PartyA' => $PartyA,
              'PartyB' => $PartyB,
              'PhoneNumber' => $PartyA,
              'CallBackURL' => $callbackurl,
              'AccountReference' => $AccountReference,
              'TransactionDesc' => $TransactionDesc
          );
          
          $data_string = json_encode($curl_post_data);
          curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
          
          $curl_response = curl_exec($curl);
          if ($curl_response === false) {
              echo 'Curl error: ' . curl_error($curl);
          } else {
              $data = json_decode($curl_response);
              if (isset($data->ResponseCode) && $data->ResponseCode == "0") {
                  $CheckoutRequestID = $data->CheckoutRequestID;
                  echo "The CheckoutRequestID for this transaction is: " . $CheckoutRequestID;
              } else {
                  echo 'Error initiating transaction: ' . $curl_response;
              }
          }
          
          curl_close($curl);
      }

      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      $message[] = 'order placed successfully!';
   }else{
      $message[] = 'your cart is empty';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="./css/style.css">

</head>
<body>
   
<?php include './components/user_header.php'; ?>

<section class="checkout-orders">
   <div class="container">
      <form action="" method="POST" class="checkout-form">

         <div class="order-summary">
            <h2>Your Orders</h2>
            <div class="order-items">
               <?php
               $grand_total = 0;
               $total_products = '';
               $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
               $select_cart->execute([$user_id]);

               if ($select_cart->rowCount() > 0) {
                  while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                     $cart_item_name = $fetch_cart['name'];
                     $cart_item_price = $fetch_cart['price'];
                     $cart_item_quantity = $fetch_cart['quantity'];

                     // Calculate total price for each item
                     $item_total_price = $cart_item_price * $cart_item_quantity;
                     $grand_total += $item_total_price;

                     // Prepare item display text
                     $total_products .= "{$cart_item_name} (ksh {$cart_item_price} x {$cart_item_quantity}) - ";
               ?>
                     <div class="order-item">
                        <span class="item-name"><?= $cart_item_name; ?></span>
                        <span class="item-price">ksh <?= $cart_item_price; ?> x <?= $cart_item_quantity; ?></span>
                     </div>
               <?php
                  }
               } else {
                  echo '<p class="empty">Your cart is empty!</p>';
               }
               ?>
               <input type="hidden" name="total_products" value="<?= rtrim($total_products, ' - '); ?>">
               <input type="hidden" name="total_price" value="<?= $grand_total; ?>">
               <div class="grand-total">Grand Total: <span>ksh <?= $grand_total; ?></span></div>
            </div>
         </div>

         <div class="order-details">
            <h2>Shipping Details</h2>
            <div class="form-fields">
               <div class="form-row">
                  <div class="form-group">
                     <label for="name">Your Name</label>
                     <input type="text" id="name" name="name" placeholder="Enter your name" maxlength="50" required>
                  </div>
                  <div class="form-group">
                     <label for="number">Your Number</label>
                     <input type="tel" id="number" name="number" placeholder="Enter your number" minlength="10" maxlength="10" required>
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group">
                     <label for="email">Your Email</label>
                     <input type="email" id="email" name="email" placeholder="Enter your email" maxlength="50" required>
                  </div>
                  <div class="form-group">
                     <label for="method">Payment Method</label>
                     <select id="method" name="method" required>
                        <option value="cash on delivery">Cash on Delivery</option>
                        <option value="credit card">Credit Card</option>
                        <option value="Mpesa">Mpesa</option>
                        <option value="paypal">Paypal</option>
                     </select>
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group">
                     <label for="flat">Address Line 01</label>
                     <input type="text" id="flat" name="flat" placeholder="E.g. Flat number" maxlength="50" required>
                  </div>
                  <div class="form-group">
                     <label for="street">Address Line 02</label>
                     <input type="text" id="street" name="street" placeholder="E.g. Street name" maxlength="50" required>
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group">
                     <label for="city">City</label>
                     <input type="text" id="city" name="city" placeholder="E.g. Nairobi" maxlength="50" required>
                  </div>
                  <div class="form-group">
                     <label for="state">State</label>
                     <input type="text" id="state" name="state" placeholder="State" maxlength="50">
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group">
                     <label for="country">Country</label>
                     <input type="text" id="country" name="country" placeholder="E.g. Kenya" maxlength="50" required>
                  </div>
                  <div class="form-group">
                     <label for="pin_code">Pin Code</label>
                     <input type="number" id="pin_code" name="pin_code" placeholder="E.g. 123456" minlength="6" maxlength="6" required>
                  </div>
               </div>
            </div>
         </div>

         <button type="submit" name="order" class="order-btn <?= ($grand_total > 0) ? '' : 'disabled'; ?>">Place Order</button>

      </form>
   </div>
</section>

<?php include './components/footer.php'; ?>

<script src="./js/script.js"></script>

</body>
</html>
