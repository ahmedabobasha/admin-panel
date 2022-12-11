<?php include "../config.php";
if(isset($_POST['add_product'])){
$p_name = $_POST['p_name'];
$p_price= $_POST['p_price'];
$p_image_tmp_name = $_FILES['p_image']['tmp_name'];
$p_image = $_FILES['p_image']['name'];
$p_image_folder ="./uploaded_img".$p_image;

    // insert  ######
$stmt = $conn->query("INSERT INTO products (name,price,image) VALUES('$p_name','$p_price','$p_image')");

if($stmt){
   // move_uploaded_file($p_image_tmp_name, $p_image_folder);
   $message[]='prouduct add succesfully';
}else{
   $message[] ='could not add the products';
}
}
// delete 
if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $stmt = $conn->query("DELETE FROM products WHERE id=$delete_id");
    
    if($stmt){
        $message[]="proudect has been deleted";
       
    }else{
         $message[] = "prouduct could not delete";
    }
}
if(isset($_POST['p_update'])){
    $update_p_id = $_POST['p_id'];
    $update_p_name  = $_POST['p_update_name'];
    $update_p_price = $_POST['p_update_price'];
    $update_p_image= $_FILES['update_p_image']['name'];
    $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
    $update_p_image_folder = "./uploaded_img".$update_p_image;
    
   $stmt = $conn->query("UPDATE products SET name ='$update_p_name', price= '$update_p_price', image ='$update_p_image' WHERE id=$update_p_id");

   if($stmt){
    //move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
    $message[] = 'product updated succesfully';
    header('location:admin.php');
 }else{
    $message[] = 'product could not be updated';
    header('location:admin.php');
 }
 

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin panel</title>
</head>
        <!-- font awesome cdn link -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
          <!-- custom css file link -->
<link rel="stylesheet" href="css/style.css">
<body>
    
    <?php

if(isset($message)){
   foreach($message as $message){
      echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
   };
};

?>
<?php include "../header.php";?>
    <div class="continer">
        <section>
            <form action="" method="post" class="add-product-form" enctype="multipart/form-data">
                <h3>add a new product</h3>
                <input type="text" name="p_name" placeholder="enter the product name" class="box" required>
                <input type="number" name="p_price" min="0" placeholder="enter the product price" class="box" required>
                <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" class="box" required>
                <input type="submit" value="add the product" name="add_product" class="btn">
            </form>
        </section>
    </div>

            <!-- SHOW Prouducts -->
<?php 

$con =$conn->query("SELECT * FROM products");

    if(mysqli_num_rows($con) > 0){
        while($row = $con->fetch_assoc()){
          
?>
        <section class="display-product-table">
           <table>
            <thead>
                <tr>
                    <th>name</th>
                    <th>price</th>
                    <th>image</th>
                    <th>created_at</th>
                    <th>action</th>
                </tr>
                <tr>
                    <td><?= $row['name']?></td>
                    <td><?= $row['price']?></td>
                    <td><img src="../uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
                    <td><?= $row['create_at']?></td>
                    <td>
                        <a href="admin.php?delete=<?php echo $row['id'];?>" class="delete-btn" onclick="return confirm('are your sure you want to delete this?');"> <i class="fas fa-trash"></i> Delete</a>
                   
                        <a href="admin.php?edit=<?php echo $row['id']; ?>" class="option-btn"> <i class="fas fa-edit"></i> update </a>
                    </td>

                </tr>
             </thead>
                <?php
            };    
            }else{
               echo "<div class='empty'>no product added</div>";
            };
         ?>
      </tbody>
   </table>

</section>


<section class="edit-form-container">
    <?php 
if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    $stmt=$conn->query("SELECT * FROM products WHERE id=$id");
    $row= ($stmt->fetch_assoc());

 
  
?>
    <form method="POST" enctype="multipart/form-data">
        <img src="../uploaded_img/<?php echo $row['image']; ?>" height="200" alt="">
        <input type="text"  class="box" name=p_update_name  value="<?= $row['name']?>" required>
        <input type="hidden" name="p_id" value="<?= $row['id']?>" required>
        <input type="number" class="box" name=p_update_price value="<?= $row['price']?>" required>
        <input type="file" name="update_p_image" accept="image/png, image/jpg, image/jpeg" class="box" required>
        <input type="submit" name=p_update class="btn" value="update prouduct">
        <a href="admin.php" class="option-btn">cancel </a>

    </form>
    <?php
           
         
         echo "<script>document.querySelector('.edit-form-container').style.display = 'flex'</script>";
       };
   ?>

    
</section>









     <!-- custom css file link -->
    <script src="js/script.js"></script>
</body>
</html>