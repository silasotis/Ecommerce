<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
};

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
    $delete_message->execute([$delete_id]);
    header('location:messages.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>messages</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="stylesheet" href="../css/admin_style.css">

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 0px solid #dddddd;
            text-align: left;
            font-size: 16px;
        }

        th {
            background-color: #f2f2f2;
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 12px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 10px;
            cursor: pointer;
        }

        .message-row {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <?php include '../components/admin_header.php'; ?>

    <section class="contacts">

        <h1 class="heading">messages</h1>

        <div class="box-container">

            <?php
            $select_messages = $conn->prepare("SELECT * FROM `messages`");
            $select_messages->execute();
            if ($select_messages->rowCount() > 0) {
                while ($fetch_message = $select_messages->fetch(PDO::FETCH_ASSOC)) {
            ?>

                    <div class="message-row">
                        <table>
                            <tr>
                                <th>Attribute</th>
                                <th>Value</th>
                                <!--<th>Action</th>-->
                            </tr>
                            <tr>
                                <td>User ID</td>
                                <td><?= $fetch_message['user_id']; ?></td>
                                <td>|</td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td><?= $fetch_message['name']; ?></td>
                                <td>|</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><?= $fetch_message['email']; ?></td>
                                <td>|</td>
                            </tr>
                            <tr>
                                <td>Number</td>
                                <td><?= $fetch_message['number']; ?></td>
                                <td>|</td>
                            </tr>
                            <tr>
                                <td>Message</td>
                                <td><?= $fetch_message['message']; ?></td>
                               <!-- <td>
                                    <a href="messages.php?delete=<?= $fetch_message['id']; ?>" onclick="return confirm('delete this message?');" class="delete-btn">delete</a>
                                </td>-->
                            </tr>
							
                        </table>
                    </div>

            <?php
                }
            } else {
                echo '<p class="empty">you have no messages</p>';
            }
            ?>

        </div>

    </section>

    <script src="../js/admin_script.js"></script>

</body>

</html>
