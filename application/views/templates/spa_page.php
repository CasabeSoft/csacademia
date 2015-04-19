<!DOCTYPE html>
<html lang="<?php echo lang($lang_code)?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo "CSAcademia - " . $title ?></title>
        <meta name="description" content="<?php echo $description ?>">
        <meta name="author" content="CasabeSoft <contacto@casabesoft.com>">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- Fav and touch icons -->
        <link rel="shortcut icon" href="../assets/img/favicon.ico">   
        <?php
        $currentPage = $this->location.$this->router->fetch_method();
        if (file_exists(APPPATH . '../assets/css/'.$currentPage.'.css')) {
        ?>
        <link rel="stylesheet" href="../assets/css/<?php echo $currentPage?>.css">
        <?php } ?>
    </head>
    <body>
        <!-- Start page content -->
        <?php echo $content ?>
        <!-- End page content -->

        <script src="//cdnjs.cloudflare.com/ajax/libs/require.js/2.1.17/require.min.js"></script>
        <?php if (file_exists(APPPATH . '../assets/js/views/'.$currentPage.'.js')) { ?>
        <script>
        require(['../assets/js/config.js'], function () {
            require(['app/views/<?php echo $currentPage ?>']);
        });
        </script>
        <?php } ?>
    </body>
</html>