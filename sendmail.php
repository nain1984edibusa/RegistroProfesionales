<?php
require("include/header.inc.php");
require("css/main-style.inc.php");
require('class/mysql_table.php');
require('class/format_db_content.php');
require('css/css-func.inc.php');
require_once ("PHPMailer/mailer.php");
require('footer-mail.php');

function token_gen() {
    $alpha = "abcdefghijklmnopqrstuvwxyz";
    $alpha_upper = strtoupper($alpha);
    $numeric = "0123456789";
    $chars = "";
    $length = '10';
    $chars .= $alpha;
    $chars .= $alpha_upper;
    $chars .= $numeric;
    $len = strlen($chars);
    $pw = str_shuffle($chars);
    for ($i = 0; $i < $length; $i++) {
        $pw .= substr($pw, rand(0, $len - 1), 1);
    };
    $pw = substr($pw, 0, $length);
    return $pw = str_shuffle($pw);
}

;

#		$fp=file("/tmp/tit-arqueo-csv.csv");
#		$fp=file("a-notificaciones.csv");
#		$fp=file("r-notificaciones.csv");
$j = 1;
if (!isset($_POST['idodcum'])) {
    ?>
    <form action='sendmail.php' method='post'>
        <input type='text' name='idodcum'>
        <input type='submit' name='send' value='notificar'>
    </form>
    <?php
} else {
    echo "<table border='1'>";
    echo "<tr><td>username</td><td>realname</td><td>token</td><td>mail</td><td>mail2</td></tr>";

//		foreach ($fp as $fila){
#		echo '<br>'.$fila;
#			$campos[0]=str_replace("\n",'',$fila);
    $campos[0] = $_POST['idodcum'];
#			$sql.="".$campos[0].","; //[0]username
#			$sql.="'".$campos[1]."',"; //[1]realn
#			$sql.="'".$campos[2]."',"; //[2]bd		
#			$sql.="'".$campos[3]."',"; //[3]clave
#			$sql.="'".$campos[4]."',"; //[4]mail
#			$sql.="'".$campos[5]."',"; //[5]mail2
#			$sql.="'".$campos[6]."',"; //[6]token
    $html_body_adic = '';
    $alt_body_adic = '';
    $get_p = $db->query("SELECT * FROM user WHERE username='" . $campos[0] . "' and userEstado=0");
    $get_p->setFetchMode(PDO::FETCH_ASSOC);
    $personas = $get_p->fetchAll();
    foreach ($personas as $persona) {
        $profes_ = $db->query("SELECT * FROM Profesiones WHERE Profesional_idProfesional='" . $persona['username'] . "' ");
        $profes_->setFetchMode(PDO::FETCH_ASSOC);
        $profes = $profes_->fetchAll();
        $bds = '';
        foreach ($profes as $profe) {
            $bds .= format_cont_db('TipoProfesionalId', $profe['TipoProfesional_TipoProfesionalId']) . '<br>';
        };
        #	 echo $persona['realname'].' '.$persona['ProfesionalApellidos'].'-->'.$ins_post.'<br>'.$sql_it.'<br>'.$sql_sr.'<br>'.$sql_va.'<hr>';
        $tmp_token = token_gen();
        '<br>' . $set_c = "UPDATE user SET userTokenReg ='$tmp_token' WHERE username ='" . $persona['username'] . "'";
//				echo "<tr><td>".$persona['username'].'</td><td>'.$persona['realname'].'</td><td>'.$bds.'</td><td>'.$persona['email'].'</td><td>'.$persona['email2'].'</td><td>'.$tmp_token.'</td></tr>';
        $campos[0] = $persona['username'];
        $campos[1] = $persona['realname'];
        $campos[2] = $bds;
        $campos[4] = $persona['email'];
        $campos[5] = $persona['email2'];
        $campos[6] = $tmp_token;
        try {
            $db->beginTransaction();
            if (isset($set_c)) {
                $stmt_c = $db->prepare($set_c);
            };
            if (isset($stmt_c)) {
                $stmt_c->execute();
            };
            $db->commit();
        } catch (PDOException $ex) {
            $db->rollBack();
            echo $ex->getMessage();
        };
    };
    if (!isset($ex)) {
        $html_body = "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 TRANSITIONAL//EN'>";
        $html_body .= "<HTML>";
        $html_body .= "<HEAD>";
        $html_body .= "<META HTTP-EQUIV='Content-Type' CONTENT='text/html; CHARSET=UTF-8'>";
        $html_body .= "<META NAME='GENERATOR' CONTENT='GtkHTML/4.6.6'>";
        $html_body .= "</HEAD>";
        $html_body .= "<BODY TEXT='#333333' LINK='#fc6f5d' BGCOLOR='#f9f9f9'>";
        $html_body .= "Estimado(a) Colega:<BR>\n<B> " . $campos['1'] . " </B><BR>\n<BR>\n";
        $html_body .= "El Instituto Nacional de Patrimonio Cultural (INPC), en uso de las atribuciones que le faculta la Ley de Patrimonio Cultural y su respectivo Reglamento, ";
        $html_body .= "presta el Servicio de Registro y Consulta de Profesionales Arqueólogos/as, Paleontólogos/as, y Restauradores/as de Bienes Culturales Patrimoniales Muebles ";
        $html_body .= "y Museos.<BR>\n<BR>\nEste Servicio fue mejorado en beneficio de los usuarios, por lo que a partir del día 9 de noviembre del 2014, el INPC lo brinda vía On-line, ";
        $html_body .= "ingresando a la Página Web de la institución mediante el link:  http://" . $_SERVER['SERVER_NAME'] . "/<BR>\n<BR>\n Invitamos a usted como " . str_replace('<br>', '; ', $campos['2']) . "  ya registrado en ";
        $html_body .= "nuestra Base de Datos, a que actualice su registro en la <b>Nueva Base de Datos On-line</b> y de esta manera forme parte de las personas registradas en línea.<BR>\n Es ";
        $html_body .= "importante que usted verifique y actualice la información pre-cargada en nuestro Sistema, caso contrario su registro no aparecerá en la Base de Datos On-line.<BR>\n<BR>\n";
        $html_body .= "<p>Para actualizar su registro en la Nueva Base De Datos On-line, debe seguir los siguientes pasos:</p>";
        $html_body .= "<ol>\n\n";
        $html_body .= "<li style='margin-left:10,0000pt;'>\tActivar la Cuenta de Usuario, siguiendo el enlace: Cambio de Contraseña.<BR>\n El Usuario que utilizará para activar la cuenta, será su número de Cédula de Ciudadanía / Pasaporte.</li>\n";
        $html_body .= "<li style='margin-left:10,0000pt;'>\tCambiar  la Contraseña.</li>\n";
        $html_body .= "<li style='margin-left:10,0000pt;'>\tIniciar la sesión en la Aplicación Web &ldquo;Registro y Consulta de Profesionales&rdquo;.</li>\n";
        $html_body .= "<li style='margin-left:10,0000pt;'>\tActualizar la información en el formulario electrónico pre-cargado con sus datos.</li>\n";
        $html_body .= "<li style='margin-left:10,0000pt;'>\tUna vez actualizados los datos, su registro se habilitar&aacute; en la Base de Datos P&uacute;blica luego del proceso de verificación por parte del INPC, lo que le será notificado mediante correo electrónico.</li>\n";
        $html_body .= "</ol>\n\n";
        $html_body .= " Las credenciales para la activaci&oacute;n de su registro son:<BR>\n";
        $html_body .= "Usuario: <b> " . $campos[0] . " </b><BR>\n";
        '<br>' . $html_body .= "<a HREF='http://" . $_SERVER['SERVER_NAME'] . "/comp-migr.php?token=" . $campos[6] . "'>Cambio de contrase&ntilde;a</a> (http://" . $_SERVER['SERVER_NAME'] . "/comp-migr.php?token=" . $campos[6] . ")<BR>\n<BR>\n";

        $html_body .= "<p>Agradecemos la atención que preste a la presente</p>";
        $html_body_adic . "<BR>\n<BR>\n";
        $html_body .= $footer_html;
        $html_body .= "<BR>\n<BR>\n<BR>\n</TD></TR></TABLE></BODY></HTML>";
        $altbody = "Estimado(a) Colega: \n" . $campos[1] . " \n\n";
        $altbody .= "El Instituto Nacional de Patrimonio Cultural (INPC), en uso de las atribuciones que le faculta la Ley de Patrimonio Cultural y su respectivo Reglamento,";
        $altbody .= "presta el Servicio de Registro y Consulta de Profesionales Arqueólogos/as, Paleontólogos/as, y Restauradores/as de Bienes Culturales Patrimoniales Muebles";
        $altbody .= "y Museos.\n\nEste Servicio fue mejorado en beneficio de los usuarios, por lo que a partir del día 9 de noviembre del 2014, el INPC lo brinda vía On-line,";
        $altbody .= "ingresando a la Página Web de la institución mediante el link:  http://" . $_SERVER['SERVER_NAME'] . "/\n\nInvitamos a usted como " . str_replace('<br>', '; ', $campos['2']);
        $altbody .= "ya registrado en nuestra Base de Datos, a que actualice su registro en la Nueva Base de Datos On-line y de esta manera forme parte de las personas registradas en línea.\nEs ";
        $altbody .= "importante que usted verifique y actualice la información pre-cargada en nuestro Sistema, caso contrario su registro no aparecerá en la Base de Datos On-line.\n\n";
        $altbody .= "Para actualizar su registro en la Nueva Base De Datos On-line, debe seguir los siguientes pasos:\n\n";
        $altbody .= "\t\t 1.Activar la Cuenta de Usuario, siguiendo el enlace: Cambio de Contraseña.\n\t\t\tEl Usuario que utilizará para activar la cuenta, será su número de Cédula de Ciudadanía / Pasaporte.\n";
        $altbody .= "\t\t 2.Cambiar  la Contraseña.\n";
        $altbody .= "\t\t 3.Iniciar la sesión en la Aplicación Web Registro y Consulta de Profesionales.\n";
        $altbody .= "\t\t 4.Actualizar la información en el formulario electrónico pre-cargado con sus datos.\n";
        $altbody .= "\t\t 5.Una vez actualizados los datos, su registro se habilitar&aacute; en la Base de Datos P&uacute;blica luego del proceso de verificación por parte del INPC, lo que le será notificado mediante correo electrónico.\n\n";

        $altbody .= "Las credenciales para la activaci&oacute;n de su registro son:\n";
        $altbody .= "Usuario: " . $campos[0] . " \n";
        $altbody .= "Cambio de Contraseña: http://" . $_SERVER['SERVER_NAME'] . "/comp-migr.php?token=$campos[6]\n\n";
        $altbody .= "Agradecemos la atención que preste a la presente\n\n";
        $altbody .= $footer_text;
        $altbody = $altbody;

        //envio de notifiacion
        // asunto y cuerpo alternativo del mensaje
        $subj = "Proceso de Actualización de Datos Personales y Académicos, Registro de Profesionales INPC";
        $mail->Subject = $subj;
        $mail->AltBody = $altbody;
        // si el cuerpo del mensaje es HTML
        $mail->MsgHTML($html_body);
        // podemos hacer varios AddAdress
        $mail->AddAddress($campos[4], $campos[1]);
        if ($campos[5] != '') {
            $mail->AddAddress($campos[5], $campos[1]);
        };
        if (!$mail->Send()) {
            echo "<tr><td colspan='6' Error enviando mail a : " . $campos[1] . ' ' . $campos[0] . ' ' . $mail->ErrorInfo . "</td></tr>";
        } else {
            echo "<tr><td>" . $campos[0] . '</td><td>' . $campos[1] . '</td><td>' . $campos[6] . '</td><td>' . $campos[4] . '</td><td>' . $campos[5] . '</td></tr>';
        };
        $mail->clearAddresses();
#					echo "<tr><td>".$campos[0].'</td><td>'.$campos[1].'</td><td>'.$campos[2].'</td><td>'.$campos[4].'</td><td>'.$campos[5].'</td><td>'.$campos[6].'</td></tr>';
        // fin envio notificacion
        $j++;
    };
//		};
    echo "</table>";
    echo "<form action='sendmail.php' method='post'><input type='submit' value='Nueva notificacion'></form>";
};
?> 

