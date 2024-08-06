<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>

   <style>
      body {
   font-family: Arial, sans-serif;
   background: #f4f4f9;
   margin: 0;
   padding: 0;
   display: flex;
   justify-content: center;
   align-items: center;
   height: 100vh;
}

.contact {
   background: #fff;
   padding: 20px;
   border-radius: 8px;
   box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
   max-width: 400px;
   width: 100%;
   box-sizing: border-box;
}

.contact h3 {
   margin-bottom: 15px;
   font-size: 24px;
   color: #333;
   text-align: center;
}

.contact .box {
   width: 100%;
   padding: 10px 15px;
   margin-bottom: 15px;
   border: 1px solid #ddd;
   border-radius: 5px;
   font-size: 16px;
   box-sizing: border-box;
   transition: all 0.3s ease;
}

.contact .box:focus {
   border-color: #777;
}

.contact textarea.box {
   resize: none;
   height: 100px;
}

.contact .btn {
   display: block;
   width: 100%;
   padding: 10px 0;
   background: #007bff;
   color: #fff;
   border: none;
   border-radius: 5px;
   font-size: 18px;
   cursor: pointer;
   transition: background 0.3s ease;
}

.contact .btn:hover {
   background: #0056b3;
}

   </style>
</head>
<body>
<section class="contact_container">
   <div class="contact">
<form action="" method="post">
   <h3>Get in Touch</h3>
   <input type="text" name="name" placeholder="Name" required maxlength="20" class="box">
   <input type="email" name="email" placeholder="Email" required maxlength="50" class="box">
   <input type="number" name="number" min="0" max="9999999999" placeholder="Phone Number" required onkeypress="if(this.value.length == 10) return false;" class="box">
   <textarea name="msg" class="box" placeholder="Message" cols="30" rows="10"></textarea>
   <input type="submit" value="Send Message" name="send" class="btn">
</form>
</div>

</section>

</body>
</html>