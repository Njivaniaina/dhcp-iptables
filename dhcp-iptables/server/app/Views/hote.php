<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subnet</title>
</head>
<body>
    <?php foreach($host as $h):?>
        <?=$h['nom_hosts'] ?>
        <?=$h['mac'] ?>
    <?php endforeach; ?>
</body>
</html>