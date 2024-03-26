<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['update_payment'])){
   $order_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];
   $payment_status = filter_var($payment_status, FILTER_SANITIZE_STRING);
   $update_payment = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
   $update_payment->execute([$payment_status, $order_id]);
   $message[] = 'payment status updated!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   header('location:placed_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>placed orders</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="orders">

<h1 class="heading">placed orders</h1>

<div class="box-container">

   <?php
      $select_orders = $conn->prepare("SELECT * FROM `orders` ORDER BY id DESC");
      $select_orders->execute();
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
		font-size: 14px;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
    }

    select, input {
        padding: 5px;
        margin-right: 5px;
		font-size: 14px;
    }

    .flex-btn {
        display: flex;
        align-items: center;
    }

    .option-btn {
        background-color: #4caf50;
        color: white;
        border: none;
        padding: 8px 12px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        cursor: pointer;
    }

    .delete-btn {
        background-color: #f44336;
        color: white;
        border: none;
        padding: 8px 12px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        cursor: pointer;
        margin-left: 5px;
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
        <td>Number</td>
        <td><?= $fetch_orders['number']; ?></td>
    </tr>
    <tr>
        <td>Address</td>
        <td><?= $fetch_orders['address']; ?></td>
    </tr>
    <tr>
        <td>Total Products</td>
        <td><?= $fetch_orders['total_products']; ?></td>
    </tr>
    <tr>
        <td>Total Price</td>
        <td>KES<?= $fetch_orders['total_price']; ?>/-</td>
    </tr>
    <tr>
        <td>Payment Method</td>
        <td><?= $fetch_orders['method']; ?></td>
    </tr>
    <tr>
        <td>Payment Status</td>
        <td>
            <form action="" method="post">
                <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                <select name="payment_status" class="select">
                    <option selected disabled><?= $fetch_orders['payment_status']; ?></option>
                    <option value="pending">pending</option>
                    <option value="processing">processing</option>
                    <option value="on_transit">on transit</option>
                    <option value="delivered">Delivered</option>
                    <option value="completed">completed</option>
                    <option value="cancelled">cancelled</option>
                </select>
                <div class="flex-btn">
                    <input type="submit" value="update" class="option-btn" name="update_payment">
                    <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('delete this order?');">delete</a>
                </div>
            </form>
        </td>
    </tr>
</table>

   <?php
         }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }
   ?>

</div>

</section>

</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>