<?php
  /**
  * @author  Xu Ding
  * @website https://www.StarTutorial.com
  * @revised by Alessandro Marinuzzi
  * @website https://www.alecos.it/
  * @revised 16.11.2020 • UTF-8 •
  **/
  ini_set('default_charset', 'UTF-8');
  date_default_timezone_set('Europe/Rome');
  $lang = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2) : 'en';
?>
<!DOCTYPE html>

<html lang="<?php echo $lang; ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Php Calendar</title>
  <link rel="stylesheet" type="text/css" media="screen" href="calendar.css">
</head>

<body>

<?php
  if (file_exists(realpath("calendar_$lang.php"))) {
    include("calendar_$lang.php");
  } else {
    echo "No Calendar to View";
  }
?>

</body>

</html>
