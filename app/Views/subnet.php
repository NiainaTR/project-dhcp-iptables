<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subnet</title>
</head>
<body>
    <?php foreach($subnet as $d):?>
        <?=$d['subnet'] ?>
        <?=$d['netmask'] ?>
    <?php endforeach; ?>
    <a href="/index.php/Hote">Go to Hosts</a>
</body>
</html>
