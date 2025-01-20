<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="<?= ASSET; ?>css/style.css">
</head>

<body>
    <h1><?php echo $data; ?></h1>
    <?php 
    function hashPassword($password, $cost = 10){
        $options = [
            'cost' => $cost
        ];

        return password_hash($password, PASSWORD_BCRYPT, $options);
    }

    echo hashPassword("secret123");
    ?>
</body>

</html>