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

   <h1 class="heading">placed orders</h1>

   <div class="box-container">

   <?php
      if($user_id == ''){
         echo '<p class="empty">please login to see your orders</p>';
      }else{
		      $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? ORDER BY id DESC");

         $select_orders->execute([$user_id]);
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 12px;
        font-size: 16px;
    }

    th {
        background-color: #f2f2f2;
    }

    .status-pending {
        color: red;
    }

    .status-completed {
        color: green;
    }
</style>

<table>
    <tr>
        <th>Attribute</th>
        <th>Value</th>
    </tr>
    <tr>
        <td>Placed On</td>
        <td><?= $fetch_orders['placed_on']; ?></td>
    </tr>
    <tr>
        <td>Name</td>
        <td><?= $fetch_orders['name']; ?></td>
    </tr>
    <tr>
        <td>Email</td>
        <td><?= $fetch_orders['email']; ?></td>
    </tr>
    <tr>
        <td>Number</td>
        <td><?= $fetch_orders['number']; ?></td>
    </tr>
    <tr>
        <td>Address</td>
        <td><?= $fetch_orders['address']; ?></td>
    </tr>
    <tr>
        <td>Payment Method</td>
        <td><?= $fetch_orders['method']; ?></td>
    </tr>
    <tr>
        <td>Your Orders</td>
        <td><?= $fetch_orders['total_products']; ?></td>
    </tr>
    <tr>
        <td>Total Price</td>
        <td>KES<?= $fetch_orders['total_price']; ?>/-</td>
    </tr>
    <tr>
        <td>Payment Status</td>
        <td class="<?= ($fetch_orders['payment_status'] == 'pending') ? 'status-pending' : 'status-completed'; ?>">
            <?= $fetch_orders['payment_status']; ?>
        </td>
    </tr>
</table>

   <?php
      }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }
      }
   ?>

   </div>

</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>