<?php

$validar=select_mysql("*","employees","username='".$_POST['username']."' and password='".md5($_POST['password'])."' and deleted=0");



if($validar['count']>=1){


$_SESSION['user']=$validar['result'][0]['person_id'];

$newURL='?';

header('Location: '.$newURL);


}elseif($_GET['logintoken']=='2004998d9999skkjjshhak' && $_GET['offline']=='true'){

$_SESSION['user']="offlineuser";

$newURL='?';

header('Location: '.$newURL);

}else{
$show_pres="";
global $application_config;
if($application_config['show_presales_button']=="NO"){
$show_pres="style=\"display:none;\"";
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
                <title><?php echo SITE_NAME; ?></title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="icon" href="favicon.ico" type="image/x-icon"/>
        <link rel="stylesheet" rev="stylesheet" href="css/bootstrap.min.css?up=<?php echo date("Ymd"); ?>" />
        <link rel="stylesheet" rev="stylesheet" href="css/font-awesome.min.css?up=<?php echo date("Ymd"); ?>" />
        <link rel="stylesheet" rev="stylesheet" href="css/unicorn-login.css?up=<?php echo date("Ymd"); ?>" />
        <link rel="stylesheet" rev="stylesheet" href="css/unicorn-login-custom.css?up=<?php echo date("Ymd"); ?>" />

        <script src="js/jquery.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
        <script src="js/bootstrap.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>

        <script type="text/javascript">
            $(document).ready(function ()
            {
                //If we have an empty username focus
                if ($("#username").val() == '')
                {
                    $("#username").focus();
                }
                else
                {
                    $("#password").focus();
                }
            });
        </script>
    </head>
    <body>
        

        <div id="container">
            <div id="logo">

<?php
if( file_exists(APPDIR."images/custom_logo.png")){
$logo_url="images/custom_logo.png";
}else{
$logo_url="images/logo.png";
}

?>
                <img src="<?php echo $logo_url; ?>" alt=""/>            </div>
            <div id="loginbox">            
                    <form action="?logintoken=<?php echo md5(date("Ymdhis").rand(100,999).rand(1000,9999)); ?>" method="post" accept-charset="utf-8" class="form login-form" id="loginform" autocomplete="off">                <p><b><?php echo SITE_NAME; ?></b> </br> Ingrese su Usuario y Contraseña</p>
<div class="alert alert-info" role="alert"><i class="fa fa-info-circle fa-fw"></i> Pronto tus Comisiones estarán disponibles de fórma automática y en tiempo real desde este portal (Mercurio) </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" name="username" value="" id="username" class="form-control" placeholder="Usuario" size="20"  />                </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" name="password" value="" id="password" class="form-control" placeholder="Clave" size="20"  />
                </div>
                <hr />
                <div class="form-actions">
                    <div class="pull-left">
                        <br />


  <!-- <span class="label label-info"> --> 
                    </div>
                    <div class="pull-right"><input type="submit" class="btn btn-success" value="Iniciar Sesión" /></div>
<a href="?logintoken=2004998d9999skkjjshhak&offline=true" class="btn btn-success" <?php echo $show_pres; ?> >Portal Cliente</a>
                </div>
                </form>

            </div>

                <div class="alert alert-danger">
                    <strong>Error</strong>
    <div class="error">Usuario/Clave inválidos</div>
                </div>




        </div>

    </body>
</html>

<?php

}

?>
