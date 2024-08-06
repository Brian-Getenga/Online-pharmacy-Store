<?php

include './components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include './components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="./css/style.css">
   <script src="https://kit.fontawesome.com/7516121dff.js" crossorigin="anonymous"></script>

</head>
<body>
   
<?php include './components/user_header.php'; ?>



<div class="home-bg">

<section class="home">

   <div class="swiper home-slider">
   
   <div class="swiper-wrapper">

   <div class="swiper-slide slide">
         <div class="image">
            <img src="./images/hy.png" alt="">
         </div>
         <div class="content">
            <span>upto 50% off</span>
            <h3>Hyland's 4 Kids Cough Syrup with 100% Natural Honey</h3>
            <a href="./shop.php" class="btn">Book now</a>
         </div>
      </div>

   <div class="swiper-slide slide">
         <div class="image">
         <img src="./images/pharmacy-delivery.png" alt="">
         </div>
         <div class="content">
            <span>Free devivery</span>
            <h3>Order now and get free delivery services</h3>
            <a href="../orders.php" class="btn">Order now</a>
         </div>
      </div>

      <div class="swiper-slide slide">
         <div class="image">
         <img src="./images/hpt.png" alt="">
         </div>
         <div class="content">
            <span>upto 50% off</span>
            <h3>Hypertension is the medical term to define blood pressure.</h3>
            <a href="./shop.php" class="btn">shop now</a>
         </div>
      </div>

      
   </div>

      <div class="swiper-pagination"></div>

   </div>

</section>

</div>

<section class="category">

   <!--<h1 class="heading">Shop by category</h1>-->

   <div class="swiper category-slider">

   <div class="swiper-wrapper">

   <a href="category.php?category=pain"category.php?category=cough" class="swiper-slide slide">
      <img src="./images/backpain.png" alt="">
      <h3>Pain relief</h3>
   </a>

   <a href="category.php?category=Hypertension" class="swiper-slide slide">
      <img src="./images/hypertantion.png" alt="">
      <h3>Hypertension</h3>
   </a>

   <a href="category.php?category=Cough" class="swiper-slide slide">
      <img src="./images/sneezing.png" alt="">
      <h3>Cough, cold &flu</h3>
   </a>

   <a href="category.php?category=beauty & skin care" class="swiper-slide slide">
      <img src="./images/beauty.png" alt="">
      <h3>beauty & skin care</h3>
   </a>

   <a href="category.php?category=Allergy relief" class="swiper-slide slide">
      <img src="./images/allergy.png" alt="">
      <h3>Allergy relief</h3>
   </a>

   <a href="category.php?category=washing" class="swiper-slide slide">
      <img src="../images/icon-6.png" alt="">
      <h3>New</h3>
   </a>

   <a href="category.php?category=smartphone" class="swiper-slide slide">
      <img src="../images/icon-7.png" alt="">
      <h3>Eye care</h3>
   </a>

   <a href="category.php?category=watch" class="swiper-slide slide">
      <img src="../images/icon-8.png" alt="">
      <h3>Baby care</h3>
   </a>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>

<section class="home-products">

   <h1 class="heading">latest products</h1>

   <div class="products-container">

   <div class="product-card">

   <?php
     $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 8"); 
     $select_products->execute();
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="slide">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
      <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
      <!--<input type="submit" value="add to cart" class="btn " name="add_to_cart">-->
      <input type="number" name="qty" class="qty home-qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
      <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
      <img src="./uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
      <div class="name"><?= $fetch_product['name']; ?></div>
      <div class="flex">
         <div class="price"><span>Ksh </span><?= $fetch_product['price']; ?><span></span></div>
         <div class="ratings">
         <i class="fa-solid fa-star"></i>
         <i class="fa-solid fa-star"></i>
         <i class="fa-solid fa-star"></i>
         <i class="fa-solid fa-star"></i>
         <i class="fa-regular fa-star-half-stroke"></i>
         </div>
      </div>
      <div class="group-btn">
         <input type="submit" value="Add to cart" class="gbtn" name="add_to_cart">
         <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="gbtn1">View product</a>
      </div>
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>


    
                                    
<div class="banner1">
        <div class="banner-card">
            <div class="banner-content">
                <h1 style="color: white;">STARTING WITH $19</h1>
                <P style="color: white;">Your day life protection</P>
                <h2 style="color: white;">protain supplement</h2>
                <button type="button" class="btn-success" style="border-radius: 10px;">Shop now</button>
            </div>
        </div>

        <div class="banner-card  banner-card2 ">
            <div class="banner-content">
                <h1>GET UP TO $26</h1>
                <P>Starting with $19</P>
                <h2>immunity Booster</h2>
                <button type="button " class=" btn-info" >Shop now</button>
            </div>
        </div>
    </div>



    <section class="home-products">

   <h1 class="heading">Featured products</h1>

   <div class="products-container">

   <div class="product-card">

   <?php
     $select_products = $conn->prepare("SELECT * FROM `products` WHERE id BETWEEN 32 AND 39"); 
     $select_products->execute();
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="slide">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
      <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
      <!--<input type="submit" value="add to cart" class="btn " name="add_to_cart">-->
      <input type="number" name="qty" class="qty home-qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
      <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
      <img src="./uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
      <div class="name"><?= $fetch_product['name']; ?></div>
      <div class="flex">
         <div class="price"><span>Ksh </span><?= $fetch_product['price']; ?><span></span></div>
         <div class="ratings">
         <i class="fa-solid fa-star"></i>
         <i class="fa-solid fa-star"></i>
         <i class="fa-solid fa-star"></i>
         <i class="fa-solid fa-star"></i>
         <i class="fa-regular fa-star-half-stroke"></i>
         </div>
      </div>
      <div class="group-btn">
         <input type="submit" value="Add to cart" class="gbtn" name="add_to_cart">
         <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="gbtn1">View product</a>
      </div>
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>

<div class="banner2">
        <div class="banner2-card">
            <div class="banner2-content">
                <h1 style="color: white;">BLACK FRIDAY OFFER</h1>
                <P style="color: white;">Save up to <span>15%</span></P>
                <h2 style="color: white;">Free Delivery On $ 200 purchase</h2>
                <button type="button" class="btn btn-success" style="border-radius: 10px;">Shop now</button>
            </div>
        </div>

        <div class="banner2-card  banner-card2 ">
            <div class="banner2-content">
                <h1>END WEEK PROMOTION</h1>
                <P>Get 60% off today </P>
                <h2>Get skin care product <h2>
                <button type="button " class="btn btn-info" >Shop now</button>
            </div>
        </div>
    </div>

<?php include './components/footer.php'; ?>




<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>


<script>

var swiper = new Swiper(".home-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
    },
});

 var swiper = new Swiper(".category-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
         slidesPerView: 2,
       },
      650: {
        slidesPerView: 3,
      },
      768: {
        slidesPerView: 4,
      },
      1024: {
        slidesPerView: 5,
      },
   },
});

var swiper = new Swiper(".products-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      550: {
        slidesPerView: 2,
      },
      768: {
        slidesPerView: 2,
      },
      1024: {
        slidesPerView: 3,
      },
   },
});

</script>


<script src="./js/script.js"></script>
</body>
</html>