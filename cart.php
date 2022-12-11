<?php 
include "config.php";

if(isset($_POST['update_update_btn'])){
    $id =$_POST['update_quantity_id'];
    $quantity=$_POST['update_quantity'];
    $stmt = $conn->query("update cart SET quantity =$quantity WHERE id='$id' ");

}

if(isset($_GET['remove'])){
    $remove_id = $_GET['remove'];
   $stmt = $conn->query("DELETE FROM cart WHERE id='$remove_id' ");
   
}

if(isset($_GET['delete_all'])){
    $delete_all =$_GET['delete_all'];
    $stmt = $conn->query("DELETE FROM cart");

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>shoping cart</title>
           <!-- font awesome cdn link -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
          <!-- custom css file link -->
<link rel="stylesheet" href="admin/css/style.css">
</head>
<body>
   
    <?php include "header.php"?>
    <div class="continer">
        <section class="shopping-cart">
            <h3 class="heading">shoping cart</h3>
            <table>
                <thead>
                    <tr>
                        <th>image</th>
                        <th>name</th>
                        <th>price</th> 
                        <th>quantity</th>
                        <th>total price</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $stmt = $conn->query("select * from cart");
                    $grand_total = 0; ######
                    if(mysqli_num_rows($stmt) > 0){
                        while($row =$stmt->fetch_assoc()){
                           // var_dump($row['image']);
                ?>
                <tr>
                    <td><img src="uploaded_img/<?php echo $row['image'] ;?>" height="100" alt="" ></td>
                    <td><?php echo $row['name'] ;?></td>
                    <td>$<?php echo number_format($row['price'])  ;?>/-</td>
                    <td>
                        <form method="POST">
                            <input type="hidden"name="update_quantity_id"  value="<?= $row['id']?>">
                            <input type="number"name="update_quantity" min="1" value="<?= $row['quantity']?>">

                            <input type="submit" name="update_update_btn" value="update">
                            

                        </form>
                    </td>
                    <td>  $<?= $sub_total = number_format($row['price'])* $row['quantity']?>/-  </td>
                    <td><a href="cart.php?remove=<?php echo $row['id']?>" onclick="return confirm('remove item from cart?')"class="delete-btn"> <i class="fas fa-trash"></i> remove</a></td>
                    
                </tr>
                
                <?php 
                $grand_total += $sub_total; 
                //var_dump($grand_total);
                ?>
                 <?php
                        };
                    };
                    ?>
                <tr class="table-bottom">
                    <td><a href="products.php" class="option-btn" style="margin-top: 0;">continue shoping</a></td>
                    <td colspan="3">grand total</td>
                    <td>$<?= $grand_total?>/-</td>
                    <td><a href="cart.php?delete_all" onclick="return confirm('DELETE ALL item from cart?')" class="delete-btn"> <i class="fas fa-trash"></i>delete all</a></td>
                </tr>
               
                </tbody>
            </table>

            <div class="checkout-btn">
                <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">procced to checkout</a>
            </div>
            
        </section>
    </div>






  <!-- custom css file link -->
  <script src="js/script.js"></script>
</body>
</html>