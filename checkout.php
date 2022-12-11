<?php include "config.php" ;

if(isset($_POST['order_btn'])){
    
    $cart_stmt =$conn->query("SELECT * FROM cart");
    $price_total=0;
    
    if(mysqli_num_rows($cart_stmt) > 0){
        while($row =$cart_stmt->fetch_assoc()){
                $product_name[]=$row['name'].' ('.$row['quantity'] .' )';
                $product_price =$row['price'] * $row['quantity'];
                $price_total += $product_price;
            };
    };
        $total_product =implode(', ',$product_name);
    $name =$_POST['name'];
    $number =$_POST['number'];
    $email =$_POST['email'];
    $method =$_POST['method'] ;
    $flat = $_POST['flat'];
    $street =$_POST['street'];
    $city =$_POST['city'];
    $state =$_POST['state'];
    $country =$_POST['country'];
    $pin_code=$_POST['pin_code'];
    $detail_query =$conn->query("INSERT INTO `order`(name, number, email, method, flat, street, city, state, country, pin_code, total_products, total_price) VALUES('$name','$number','$email','$method','$flat','$street','$city','$state','$country','$pin_code','$total_product','$price_total')") or die('query failed');
     if($cart_stmt  && $detail_query){
        echo "
        <div class='order-message-container'>
        <div class='message-container'>
           <h3>thank you for shopping!</h3>
           <div class='order-detail'>
              <span>".$total_product."</span>
              <span class='total'> total : $".$price_total."/-  </span>
           </div>
           <div class='customer-details'>
              <p> your name : <span>".$name."</span> </p>
              <p> your number : <span>".$number."</span> </p>
              <p> your email : <span>".$email."</span> </p>
              <p> your address : <span>".$flat.", ".$street.", ".$city.", ".$state.", ".$country." - ".$pin_code."</span> </p>
              <p> your payment mode : <span>".$method."</span> </p>
              <p>(*pay when product arrives*)</p>
           </div>
              <a href='products.php' class='btn'>continue shopping</a>
           </div>
        </div>
        ";
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
               <!-- font awesome cdn link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
          <!-- custom css file link -->
    <link rel="stylesheet" href="admin/css/style.css">
</head>

<body>
    <?php include "header.php"?>
    
<div class="container">
    <section class="checkout-form">
     <form method="POST">
            <h3 class="heading">complete your order</h3> 
<div class="display-order">               
    <?php 
    $stmt =$conn->query("SELECT * FROM cart");
    $grand_total = 0;
    if(mysqli_num_rows($stmt) > 0){
        while($row = $stmt->fetch_assoc()){
            $total_price= $row['price'] * $row['quantity'];
            $grand_total += $total_price;
    ?>

       <span><?= $row['name']?>(<?= $row['quantity']?>)</span>

       

 <?php }
    }?>
<span class="grand-total"> grand total : $<?= $grand_total ?>/- </span>     
</div>      
            <div class="flex">
            <div class="inputBox">
                <span>your name</span>
                <input type="text" name="name" placeholder="enter your name" required>
            </div>
            <div class="inputBox">
                <span>your number</span>
                <input type="number" name="number" placeholder="enter your number" required>
            </div>
            <div class="inputBox">
                <span>your email</span>
                <input type="email" name="email" placeholder="enter your email" required>
            </div>
            <div class="inputBox">
                <span>payment method</span>
                <select name="method">
                    <option value="cash on delivery">cash on delivery</option>
                    <option value="credit cart">credit cart</option>
                    <option value="paypal">paypal</option>
                </select>
            </div>
           
            <div class="inputBox">
                <span>address line 1</span>
                <input type="text" name="flat"  placeholder="e.g. flat no." required>
            </div>
            <div class="inputBox">
                <span>address line 2</span>
                <input type="text" placeholder="e.g. street name" name="street" required>
            </div>
    
            <div class="inputBox">
                <span>city</span>
                <input type="text" name="city" placeholder="e.mumbai" required>
            </div>

            <div class="inputBox">
                <span>state</span>
                <input type="text" placeholder="e.g. maharashtra" name="state" required>
            </div>
            <div class="inputBox">
                <span>country</span>
                <input type="text" placeholder="e.g. india" name="country" required>
            </div>
            <div class="inputBox">
                <span>pin code</span>
                <input type="text" placeholder="e.g. 123456" name="pin_code" required>
            </div>
            </div>
                <input type="submit" value="order now" name="order_btn" class="btn">
           
            </div>
        </form>
        

    </section>

</div>
    













    
<!-- custom css file link -->
<script src="js/script.js"></script>
</body>
</html>