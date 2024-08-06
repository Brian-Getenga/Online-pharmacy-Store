<?php

include './components/connect.php';

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
   <title>about</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="./css/style.css">

</head>
<body>
   
<?php include './components/user_header.php'; ?>

<div class="mission-container">
    <div class="mission-content">
        <h1>Our Mission</h1>
        <p>As a digital druggist, our mission is twofold: First, we navigate the fast-paced online marketplace as savvy entrepreneurs. Second, we serve as trusted healthcare beacons, offering discreet and reliable services. Our goal is to help customers ‘click’ their health into order, revolutionizing the way they access medications.<br>
        Our online pharmacy is committed to transforming healthcare accessibility. Our mission is to empower patients by providing convenient, secure, and affordable access to medications. We believe that everyone deserves timely and reliable healthcare solutions, regardless of their location or circumstances. Through our user-friendly platform, we aim to bridge the gap between patients and essential medications, ensuring well-being and peace of mind.” 
      </p>
    </div>
    <div class="mission-img">
        <div class="img-top">
            <div class="limg">
                <img src="./images/persion1.jpg" alt="">
            </div>
            <div class="rimg">
            <img src="./images/persion2.jpg" alt="">
            </div>

        </div>
        <div class="img-bottom">
            <img src="./images/persion3.jpg" alt="">
        </div>

    </div>
  </div> 

  <div class="pham-team-conatainer">
    <h1>Meet Our Team</h1>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis laboriosam sint itaque sunt placeat magnam quaerat.</p>
    <div class="team-card-container">
        <div class="team-card">
            <img src="./images/team1.jpg" alt="">
            <div class="team-card-content">
                <h2>Maria Rashid</h2>
                <p>Pharmacists</p>
                <div class="team-icon">
                  <i class="fa-brands fa-facebook"></i>
                  <i class="fa-brands fa-x-twitter"></i>
                    <i class="fa-brands fa-twitter twitter"></i>
                    <i class="fa-brands fa-pinterest Pinterest"></i>
                </div>
            </div>
        </div>
        <div class="team-card">
            <img src="./images/team3.jpg" alt="">
            <div class="team-card-content">
                <h2>Moses Juma</h2>
                <p>Pharmacy technician</p>
                <div class="team-icon">
                  <i class="fa-brands fa-facebook"></i>
                <i class="fa-brands fa-x-twitter"></i>
                    <i class="fa-brands fa-instagram"></i>
                    <i class="fa-brands fa-pinterest Pinterest"></i>
                </div>
            </div>
        </div>

        <div class="team-card">
            <img src="./images/team4.jpg" alt="">
            <div class="team-card-content">
                <h2>Bob Moly</h2>
                <p>Pharmacy/dispensing assist.</p>
                <div class="team-icon">
                  <i class="fa-brands fa-facebook"></i>
                  <i class="fa-brands fa-x-twitter"></i>
                    <i class="fa-brands fa-instagram"></i>
                    <i class="fa-brands fa-pinterest Pinterest"></i>
                </div>
            </div>
        </div>

        <div class="team-card">
            <img src="./images/team3.jpg" alt="">
            <div class="team-card-content">
                <h2>Jane Masai</h2>
                <p>Medicines counter assistant</p>
                <div class="team-icon">
                  <i class="fa-brands fa-facebook"></i>
                  <i class="fa-brands fa-x-twitter"></i>
                    <i class="fa-brands fa-instagram"></i>
                    <i class="fa-brands fa-pinterest Pinterest"></i>
                </div>
            </div>
        </div>

    </div>
    <button class=" btn-info" type="button" style="outline: 1px solid #4cc8dd;">View the team</button>
  </div>


  <div style="text-align:center">
    <h2 style="font-size: 25px" >Meet Our Team</h2>
    <p style="font-size: 14px">Click on the images below:</p>
  </div>
  

  <div class="my-row">
    <div class="my-column">
      <img src="./images/testi10.jpg" alt="Nature" style="width:100%" onclick="myFunction(this);">
    </div>
    <div class="my-column">
      <img src="./images/testi5.jpg" alt="Snow" style="width:100%" onclick="myFunction(this);">
    </div>
    <div class="my-column">
      <img src="./images/testi11.jpg" alt="Mountains" style="width:100%" onclick="myFunction(this);">
    </div>
    <div class="my-column">
      <img src="./images/testi9.jpg" alt="Lights" style="width:100%" onclick="myFunction(this);">
    </div>
  </div>
  
  <div class="my-container p-5">
    <span onclick="this.parentElement.style.display='none'" class="closebtn">×</span>
    <img id="expandedImg" style="width:100%">
    <div id="imgtext"></div>
  </div>

</div>







<?php include './components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="./js/script.js"></script>

<script>

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
        slidesPerView:1,
      },
      768: {
        slidesPerView: 2,
      },
      991: {
        slidesPerView: 3,
      },
   },
});

</script>

<script>
    $(document).ready(function(){
        $('#testimonial-slider').owlCarousel({
            items:1,
            itemsDesktop:[1000,1],
            itemsDesktopSmall:[979,1],
            itemsTablet:[768,1],
            pagination: false,
            navigation:true,
            navigationText:["",""],
            slideSpeed:1000,
            autoPlay:true
        });
    });
</script>
<script>
  function myFunction(imgs) {
  var expandImg = document.getElementById("expandedImg");
  var imgText = document.getElementById("imgtext");
  expandImg.src = imgs.src;
  imgText.innerHTML = imgs.alt;
  expandImg.parentElement.style.display = "block";
}
</script>

</body>
</html>