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
        <link rel="stylesheet" href="<?php echo site_url('assets/lib/bootstrap/3.3.4/css/bootstrap.min.css') ?>">
        <link href="//cdn.kendostatic.com/2015.1.429/styles/kendo.common-material.min.css" rel="stylesheet" />
        <link href="//cdn.kendostatic.com/2015.1.429/styles/kendo.material.min.css" rel="stylesheet" />
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- Fav and touch icons -->
        <?php if ($subdomain_match_client) { ?>
        <link rel="shortcut icon" href="<?php echo site_url('assets'.$client_theme.'/img/favicon.ico') ?>">
        <?php } else { ?>
        <link rel="shortcut icon" href="<?php echo site_url('assets/img/favicon.ico') ?>">
        <?php }
        $currentPage = $this->location.$this->router->fetch_method();
if (file_exists(APPPATH . '../assets/css/'.$currentPage.'.css')) { ?>
        <link rel="stylesheet" href="<?php echo site_url('assets/css/'.$currentPage.'.css') ?>">
<?php } ?>
        <?php if ($subdomain_match_client) {?>
        <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets'.$client_theme.'/css/client-bs3.css') ?>">
        <?php } ?>
    </head>
    <body>
        <!-- Start page content -->
        <?php echo $content ?>
        <!-- End page content -->

        <script src="//cdnjs.cloudflare.com/ajax/libs/require.js/2.1.17/require.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <?php if (file_exists(APPPATH . '../assets/js/views/'.$currentPage.'.js')) { ?>
        <script>
        require(["<?php echo site_url("assets/js/config.js") ?>"], function () {
            require(['app/views/<?php echo $currentPage ?>']);
        });
        </script>
        <?php } ?>
    </body>
</html>