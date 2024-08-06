<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>

<head>
<script src="https://kit.fontawesome.com/7516121dff.js" crossorigin="anonymous"></script>
<script src="script.js"></script>
<link rel="stylesheet" href="style.css">
</head>


<div class="top-nav" id="back-top">
            <div class="top-nav-contact">
                <i class="fa-solid fa-phone call"></i>
            <div class="top-nav-number">0720176750</div>
            <i class="fa-solid fa-envelope email"></i>
            <div class="top-nav-number">afyapharmacy@gmail.com</div>
            </div>
            <div class="social-icon">
               <a href="https://x.com/" target="_blank"><i class="fa-brands fa-square-x-twitter" ></i></a>
               <a href="https://www.pinterest.com/" target="_blank"><i class="fa-brands fa-pinterest" ></i></a>
               <a href="https://www.instagram.com/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
            </div>
        </div>

<header class="header">

   <section class="flex">

      <a href="./home.php" class="logo">Afya<span>pharmacy</span></a>

      <nav class="navbar">
         <a class="active"href="./home.php">home</a>
         <a href="./shop.php">shop</a>
         <a href="./orders.php">orders</a>
         <a type="button" id="myBtn" >Submit prescription</a>
         <a href="./about.php">about us</a> 
         <a href="./contact.php">contact</a>
      </nav>

      <div class="icons">
         <?php
            $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
            $count_wishlist_items->execute([$user_id]);
            $total_wishlist_counts = $count_wishlist_items->rowCount();

            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_counts = $count_cart_items->rowCount();
         ?>
         <div id="menu-btn" class="fas fa-bars"></div>
         <a href="./search_page.php"><img src="./images/search.png" alt=""></a>
         <a href="./wishlist.php"><img src="./images/heart.png" alt=""><span><?= $total_wishlist_counts; ?></span></a>
         <a href="./cart.php"><img src="./images/Scart.png" alt=""><span><?= $total_cart_counts; ?></span></a>
         <div id="user-btn"><img src="./images/profile.png" alt=""></div>
      </div>

      <div class="profile">
         <?php          
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><?= $fetch_profile["name"]; ?></p>
         <a href="./update_user.php" class="btn">update profile</a>
         <div class="flex-btn">
            <a href="./user_register.php" class="option-btn">register</a>
            <a href="./user_login.php" class="option-btn">login</a>
         </div>
         <a href="./components/user_logout.php" class="delete-btn" onclick="return confirm('logout from the website?');">logout</a> 
         <?php
            }else{
         ?>
         <!--<p>please login or register first!</p>-->
         <div class="flex-btn">
            <a href="./user_register.php" class="option-btn">register</a>
            <a href="./user_login.php" class="btn">login</a>
         </div>
         <?php
            }
         ?>      
         
         
      </div>

   </section>
   

</header>

<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content animate ">
    <span class="closeM">&times;</span>
    <div class="model-container">
        <img src="./images/pres" alt="">
        <div class="model-text">
            <h1>Prescriptions Delivered To Your Door</h1>
            <p>To ensure the security of your data we are currently taking prescriptions via WhatsApp only. Please click below to submit your prescription. You will be redirected to WhatsApp and speak directly to a Pharmacist from our team.</p>

            <!--<button type="button" class="option-btn">Submit Prescription</button>-->
            <a href="https://wa.me/+254791291745" target="_blank" class="option-btn">Submit Prescription</a>
        </div>

      </div>
  </div>

</div>