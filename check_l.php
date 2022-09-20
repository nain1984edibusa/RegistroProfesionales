<?php
//	require("include/header.inc.php");
require('class/format_db_content.php');
require('class/mysql_table.php');
require('css/css-func.inc.php');
require ('class/aes.class.php');     // AES PHP implementation
require ('class/aesctr.class.php');  // AES Counter Mode implementation 
require_once ("PHPMailer/mailer.php");
require('footer-mail.php');
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: http://" . $_SERVER['SERVER_NAME']);
    //header("Location: http://regprof.inpc.gob.ec");
    exit;
};
session_destroy();
?>

<html>
    <body style="background-color:#E8EDFC; background-image:url(image/loading.gif);background-repeat: no-repeat; background-position: center middle;">
    <center>
            <!--<img src='image/loading.gif'><br>-->
        <br><br><br> <h3>CONECTANDO...</h3>
        <br><br><br><br><br><br><br><br><br>
        <h3>POR FAVOR SEA PACIENTE MIENTRAS SE ESTABLECE LA CONEXI&Oacute;N</h3>
    </center>
    <?php
    $user = AesCtr::decrypt($_POST['xx'], $_POST['x'], 256);
    $pass = AesCtr::decrypt($_POST['yy'], $_POST['x'], 256);
    if (isset($_POST['aa'])) {
        $npass = AesCtr::decrypt($_POST['aa'], $_POST['x'], 256);
    };
    if (isset($_POST['tt']) and $_POST['tt'] != '') {
        $token = AesCtr::decrypt($_POST['tt'], $_POST['x'], 256);
    };
    $stmt = $db->query("SELECT password,realname,userEstado,userTokenReg,TipoUsuario_idTipoUsuario FROM user WHERE username='" . $user . "'");
    if ($stmt->rowCount() > 0) {
        $us = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($us['userEstado'] and $us['userTokenReg'] == NULL) { //usuarios registrados Y ACTIVOS
            $pw_check = $db->query("SELECT password('" . $pass . "') = '" . $us['password'] . "' as pwdOk");
            $pwd_ = $pw_check->fetch(PDO::FETCH_ASSOC);
            if ($pwd_['pwdOk']) {
                $sql_us = "UPDATE user SET userTokenReg=NULL WHERE username='" . $user . "'";
                $stmt = $db->prepare($sql_us);
                if (isset($sql_us)) {
                    $stmt->execute();
                };
                switch ($us['TipoUsuario_idTipoUsuario']) {
                    case 1://administrador
                        session_start();
                        $_SESSION['logged'] = 1;
                        $_SESSION['user'] = $user;
                        $_SESSION['tuser'] = $us['TipoUsuario_idTipoUsuario'];
                        $_SESSION['user_realn'] = $us['realname'];
                        $_SESSION['laccess'] = date('Y/m/d***h:i:s');
                        ?>
                        <script>/*alert('Bienvenid@ <?php echo $us['realname'] ?>');*/
                            document.body.innerHTML += '<form id="redir" action="admin-gui.php" method="post"></form>';
                            document.getElementById("redir").submit();</script>
                        <?php
                        exit;
                        break;
                    case 2:
                        session_start();
                        $_SESSION['logged'] = 1;
                        $_SESSION['user'] = $user;
                        $_SESSION['tuser'] = $us['TipoUsuario_idTipoUsuario'];
                        $_SESSION['user_realn'] = $us['realname'];
                        $_SESSION['laccess'] = date('Y/m/d***h:i:s');
                        ?>
                        <script>/*alert('Bienvenid@ <?php echo $us['realname'] ?>');*/
                            document.body.innerHTML += '<form id="redir" action="director-gui.php" method="post"><input type="hidden" name="lg" value="1"></form>';
                            document.getElementById("redir").submit();</script>
                        <?php
                        exit;
                        break;
                    case 3:
                        session_start();
                        $_SESSION['logged'] = 1;
                        $_SESSION['user'] = $user;
                        $_SESSION['tuser'] = $us['TipoUsuario_idTipoUsuario'];
                        $_SESSION['user_realn'] = $us['realname'];
                        $_SESSION['laccess'] = date('Y/m/d***h:i:s');
                        ?>
                        <script>alert('Bienvenid@ <?php echo $us['realname'] ?>');
                            document.body.innerHTML += '<form id="redir" action="postulante-gui.php" method="post"></form>';
                            document.getElementById("redir").submit();</script>
                        <?php
                        exit;
                        break;
                    case 5://verificador
                        session_start();
                        $_SESSION['logged'] = 1;
                        $_SESSION['log'] = 1;
                        $_SESSION['user'] = $user;
                        $_SESSION['tuser'] = $us['TipoUsuario_idTipoUsuario'];
                        $_SESSION['user_realn'] = $us['realname'];
                        $_SESSION['laccess'] = date('Y/m/d***h:i:s');
                        ?>
                        <script>/*alert('Bienvenid@ <?php echo $us['realname'] ?>');*/
                            document.body.innerHTML += '<form id="redir" action="verificador-gui.php" method="post"><input type="hidden" name="lg" value="1"></form>';
                            document.getElementById("redir").submit();</script>
                        <?php
                        exit;
                        break;
                    case 4://validador
                        session_start();
                        $_SESSION['logged'] = 1;
                        $_SESSION['user'] = $user;
                        $_SESSION['tuser'] = $us['TipoUsuario_idTipoUsuario'];
                        $_SESSION['user_realn'] = $us['realname'];
                        $_SESSION['laccess'] = date('Y/m/d***h:i:s');
                        ?>
                        <script>/*alert('Bienvenid@ <?php echo $us['realname'] ?>');*/
                            document.body.innerHTML += '<form id="redir" action="validador-gui.php" method="post"></form>';
                            document.getElementById("redir").submit();</script>
                        <?php
                        exit;
                        break;
                };
                ?>
                <script>alert('Enlace de ingreso incorrecto');
                    document.body.innerHTML += '<form id="redir" action="index.php" method="post"></form>';
                    document.getElementById("redir").submit();</script>
                <?php
                exit;
            } else {
                ?>
                <script>alert('Clave incorrectos');
                    history.go(-1);/*
                     document.body.innerHTML += '<form id="redir" action="log-im.php" method="post"></form>';
                     document.getElementById("redir").submit();*/</script>
                <?php
            };
        } else {  //USUARIOS EN PROCESO DE ACTIVACION DE CUENTA DE USUARIO
            if (isset($token) and!$us['userEstado'] and $us['userTokenReg'] == $token) {
                $pw_check = $db->query("SELECT password('" . $pass . "') = '" . $us['password'] . "' as pwdOk");
                $pwd_ = $pw_check->fetch(PDO::FETCH_ASSOC);
                if ($pwd_['pwdOk']) {
                    $inserto = 0;
                    switch ($us['TipoUsuario_idTipoUsuario']) {
                        case 3:
                            //REGISTRO DE LA PROFESION SOLICITADA
                            $get_profesion = $db->query("SELECT * FROM Profesiones WHERE TipoProfesional_TipoProfesionalId=" . $_POST['tipop'] . " and Profesional_idProfesional='" . $user . "'");
                            $profesion = $get_profesion->fetch(PDO::FETCH_ASSOC);

                            $sql_post = "INSERT INTO Postulacion (PostulacionFechaI,Profesiones_idProfesiones) VALUES (CONVERT_TZ(concat(CURDATE(),' ',CURTIME()),'+00:00','-05:00')," . $profesion['idProfesiones'] . ")"; //INGRESO POSTULACION
                            $get_mail_verficador = $db->query("SELECT realname,email,email2 FROM user WHERE username in (SELECT user_username FROM UsuarioManejaProfesional WHERE TipoProfesional_TipoProfesionalId in (SELECT TipoProfesional_TipoProfesionalId FROM Profesiones WHERE Profesional_idProfesional ='" . $user . "' and TipoProfesional_TipoProfesionalId=" . $_POST['tipop'] . ")) and TipoUsuario_idTipoUsuario = 5");
                            $mails = $get_mail_verficador->fetch(PDO::FETCH_ASSOC);
                            break;
                    };
                    $sql_act_user = "UPDATE user SET userEstado=1,userTokenReg=NULL,password=password('" . $npass . "') WHERE username='" . $user . "'"; //activo la cuenta de usuario

                    try {
                        $db->beginTransaction();
                        if (isset($sql_post)) {
                            $stmt_post = $db->prepare($sql_post);
                        };
                        $stmt_au = $db->prepare($sql_act_user);
                        if (isset($stmt_au)) {
                            $stmt_au->execute();
                        };
                        if (isset($stmt_post)) {
                            $stmt_post->execute();
                        };
                        $db->commit();
                        $inserto = 1;
                    } catch (PDOException $ex) {
                        //Something went wrong rollback!
                        $db->rollBack();
                        echo $ex->getMessage();
                        $inserto = 0;
                        //echo 'algo fallo';
                        exit;
                    };
                    if (!isset($ex) and $us['TipoUsuario_idTipoUsuario'] == '3' and $inserto) {  // si se realiza la activacion notifico al verificador......
#				$get_tiprof = $db->query("SELECT TipoProfesional_TipoProfesionalId FROM Profesional WHERE idProfesional='".$user."'");
#				$tiprof= $get_tiprof->fetch(PDO::FETCH_ASSOC);    //se reemplaza por $tipop
                        //require("css/main-style.inc.php");
                        $html_body = "
					<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 TRANSITIONAL//EN'><HTML><HEAD>
					  <META HTTP-EQUIV='Content-Type' CONTENT='text/html; CHARSET=UTF-8'>
					  <META NAME='GENERATOR' CONTENT='GtkHTML/4.6.6'></HEAD>
					<BODY TEXT='#333333' LINK='#fc6f5d' BGCOLOR='#f9f9f9'>
					Estimado(a)<B> " . $mails['realname'] . " </B>:<BR><BR>El/la Profesional <b>" . $us['realname'] . "</b> ingres&oacute; una solicitud  
					para registrarse en la Base de Datos de Profesionales :&nbsp; <B>" . format_cont_db('TipoProfesionalId', $_POST['tipop']) . "</B><BR><BR>
					Por favor ingrese al Sistema para revisar las solicitudes pendientes<BR><BR>
					<A HREF='http://" . $_SERVER['SERVER_NAME'] . "/'>SERVICIO DE REGISTRO DE PROFESIONALES </A><BR><BR><BR>";
                        $html_body .= $footer_html;
                        $html_body .= "<BR><BR><BR></TD></TR></TABLE></BODY></HTML>";

                        $altbody = "
					Estimado(a) " . $mails['realname'] . " :\n\n
					 El/la Profesional " . $us['realname'] . " ingresó una solicitud para registrarse en la Base de Datos de Profesionales:&nbsp; " . format_cont_db('TipoProfesionalId', $_POST['tipop']) . "\n\n
					Por favor ingrese al Sistema para revisar las solicitudes pendientes\n\n
					http://" . $_SERVER['SERVER_NAME'] . " \n\n";
                        $altbody .= $footer_text;
                        $altbody = utf8_decode($altbody);
                        $ok_text = utf8_encode(utf8_decode("Se notificó a la Dirección de Conservación y Salvaguardia de Bienes Patrimoniales Culturales sobre su solicitud de Registro"));
                        //envio de notifiacion
                        // asunto y cuerpo alternativo del mensaje
                        $mail->Subject = "Nueva Solicitud de Registro";
                        $mail->AltBody = $altbody;
                        // si el cuerpo del mensaje es HTML
                        $mail->MsgHTML($html_body);

                        // podemos hacer varios AddAdress
                        $mail->AddAddress($mails['email'], $mails['realname']);
                        $coma = '';
                        if (isset($mails) and $mails['email2'] != '') {
                            $mail->AddAddress($mails['email2'], $mails['realname']);
                            $coma = ', ';
                        };
                        // fin envio notificacion
                        if (!$mail->Send()) {
                            echo "Error enviando: " . $mail->ErrorInfo;
                        };
                    };
                    switch ($us['TipoUsuario_idTipoUsuario']) {
                        case 2:
                            session_start();
                            $_SESSION['logged'] = 1;
                            $_SESSION['user'] = $user;
                            $_SESSION['tuser'] = $us['TipoUsuario_idTipoUsuario'];
                            $_SESSION['user_realn'] = $us['realname'];
                            $_SESSION['laccess'] = date('Y/m/d***h:i:s');
                            ?>
                            <script>/*alert('Bienvenid@ <?php echo $us['realname'] ?>');*/
                                document.body.innerHTML += '<form id="redir" action="director-gui.php" method="post"></form>';
                                document.getElementById("redir").submit();</script>
                            <?php
                            exit;
                            break;
                        case 3:
                            session_start();
                            $_SESSION['logged'] = 1;
                            $_SESSION['user'] = $user;
                            $_SESSION['tuser'] = $us['TipoUsuario_idTipoUsuario'];
                            $_SESSION['user_realn'] = $us['realname'];
                            $_SESSION['laccess'] = date('Y/m/d***h:i:s');
                            ?>
                            <script>alert('Bienvenid@ <?php echo $us['realname'] ?>\n<?php echo $ok_text; ?>');
                                document.body.innerHTML += '<form id="redir" action="postulante-gui.php" method="post"></form>';
                                document.getElementById("redir").submit();</script>
                            <?php
                            exit;
                            break;
                        case 4:
                            session_start();
                            $_SESSION['logged'] = 1;
                            $_SESSION['user'] = $user;
                            $_SESSION['tuser'] = $us['TipoUsuario_idTipoUsuario'];
                            $_SESSION['user_realn'] = $us['realname'];
                            $_SESSION['laccess'] = date('Y/m/d***h:i:s');
                            ?>
                            <script>/*alert('Bienvenid@ <?php echo $us['realname'] ?>');*/
                                document.body.innerHTML += '<form id="redir" action="validador-gui.php" method="post"></form>';
                                document.getElementById("redir").submit();</script>
                            <?php
                            exit;
                            break;
                        case 5:
                            session_start();
                            $_SESSION['logged'] = 1;
                            $_SESSION['user'] = $user;
                            $_SESSION['tuser'] = $us['TipoUsuario_idTipoUsuario'];
                            $_SESSION['user_realn'] = $us['realname'];
                            $_SESSION['laccess'] = date('Y/m/d***h:i:s');
                            ?>
                            <script>/*alert('Bienvenid@ <?php echo $us['realname'] ?>');*/
                                document.body.innerHTML += '<form id="redir" action="verificador-gui.php" method="post"></form>';
                                document.getElementById("redir").submit();</script>
                            <?php
                            exit;
                            break;
                    };
                    exit;
                } else {
                    ?>
                    <script>alert('Datos incorrectos: Clave Temporal');
                        history.go(-1);/*
                         document.body.innerHTML += '<form id="redir" action="log-im.php" method="post"></form>';
                         document.getElementById("redir").submit();*/</script>
                    <?php
                    exit;
                };
            } else {
                if (isset($token)) {
                    ?>
                    <script>alert('Datos incorrectos: Token, Pruebe cerrando la ventana y haga click en el enlace del correo nuevamente');
                        history.go(-1);/*
                         document.body.innerHTML += '<form id="redir" action="log-im.php" method="post"></form>';
                         document.getElementById("redir").submit();*/</script>
                <?php
                exit;
            };
        };
        ?>
            <script>alert('Usuario Inhabilitado o en proceso de restablecimiento de <?php echo utf8_encode(utf8_decode('contraseña')) ?>\n Si no esta restableciendo su <?php echo utf8_encode(utf8_decode('contraseña')) ?> y recibe este mensaje, comunicarse a info.rpc@inpc.gob.ec para soluciones');
                document.body.innerHTML += '<form id="redir" action="log-im.php" method="post"></form>';
                document.getElementById("redir").submit();</script>
            <?php
        };
    } else {
        ?>
        <script>alert('Datos incorrectos: Usuario no registrado');
            history.go(-1);
            /*document.body.innerHTML += '<form id="redir" action="log-im.php" method="post"></form>';
             document.getElementById("redir").submit();*/</script>
    <?php
};

$db = null;
exit;
//http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers
?>
</body>
</html>



