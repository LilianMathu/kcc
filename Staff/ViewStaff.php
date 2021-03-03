<?php

?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="app.css">

    <title>View All Staff</title>
</head>

<body>
    <h1>Staff</h1>

    <p>
        <a href="RegisterStaff.php" class="btn btn-success" >Add new</a>
    </p>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Image</th>
                <th scope="col">Title</th>
                <th scope="col">Price</th>
                <th scope="col">Create_Date</th>
                <th scope="col">Action</th>

            </tr>
        </thead>
        <tbody>

            <?php
            foreach ($products as $i => $product) :  ?>

            <tr>
                <th scope="row"><?php echo $i + 1  //because the iterations start with zero, and you don't want the table to start with a zero ?></th>
                <td></td>
                <td><?php echo $product['title'] ?></td>
                <td><?php echo $product['price'] ?></td>
                <td><?php echo $product['create_date'] ?></td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-primary">Edit</button>
                    <button type="button" class="btn btn-sm  btn-outline-danger">Delete</button>
                </td>

            </tr>

            <?php endforeach;   ?>

        </tbody>
    </table>


</body>

</html>