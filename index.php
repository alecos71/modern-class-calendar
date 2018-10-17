<?php
  /**
  * @author  Xu Ding
  * @website https://www.StarTutorial.com
  * @revised by Alessandro Marinuzzi
  * @website https://www.alecos.it/
  * @revised 10.17.2018
  **/
  date_default_timezone_set('Europe/Rome');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
  <meta http-equiv="content-type" content="text/html;charset=utf-8">
  <title>Php Calendar</title>
  <link rel="stylesheet" type="text/css" media="screen" href="calendar.css">
</head>

<body>

<?php
  $lang = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2) : 'en';
  if ($lang == "it") {
    include("calendar_it.php");
  } else {
    include("calendar_en.php");
  }
?>

</body>

</html>
