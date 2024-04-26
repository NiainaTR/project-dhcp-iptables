<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hote</title>
</head>
<body>
    <?php foreach($hosts as $d):?>
        <?=$d['nom_hosts'] ?>
        <?=$d['mac'] ?>
    <?php endforeach; ?>
</body>
</html>