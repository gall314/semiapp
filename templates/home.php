<!DOCTYPE html>
<html>
<head>
<title>Gabinet WSB</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="img/favicons/favicon.ico">
<!--GOOGLEFONTS-->
<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<link href="https://fonts.googleapis.com/css?family=Shadows+Into+Light+Two" rel="stylesheet">
<!--BOOTSTRAP-->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="styles/aux_style.css" rel="stylesheet" type="text/css" />
<link href="styles/style.css" rel="stylesheet" type="text/css" />
 

</head>
<body>
	
    <header>
        <div class="container" id="top">
            
                <!--div id="header"-->
                <?php #require_once 'templates/header.php';?>
                <!--/div-->
                <div id="menu">
                <?php require_once 'templates/menu.php';?>
                </div>
            
        </div>
    </header>
    <div class="correct">-</div>
    <section>
          <!--div class="container-fluid carwide"-->
                <!--div class="row">
                    ?php #echo $place_x ?>
                </div-->
          
                <!--div class="row" id="content"-->
                <div id="content">
                       <?php echo $content_x;?>
                </div>
    </section>   
    <footer>
            <div>
                <?php require_once 'templates/footer.php'; ?>
            </div>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   
    </body>
    <script src="scripts/myscript.js"></script>
</html>
