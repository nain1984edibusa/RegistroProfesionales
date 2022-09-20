<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    #header("Location: http://localhost/");
    header ("Location: http://".$_SERVER['SERVER_NAME']);
    exit;
};
require("include/header.inc.php");
require("css/main-style.inc.php");
require('class/mysql_table.php');
require('css/css-func.inc.php');
require('class/format_db_content.php');
?>
<SCRIPT LANGUAGE="JavaScript1.2" src="java/type.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript1.2" src="java/formsm.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript1.2" src="java/check_post.js" charset="ISO-8859-15"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript1.2" src="java/check_fun.js" charset="ISO-8859-15"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript1.2" src="java/dinamico.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript1.2" >
    var url_base = "http://www.senescyt.gob.ec/web/guest/index.php/consultas/";

    var url_, fa_1, fa_2, fa_3, fa_4, fa_5, fa_6;
    function getc() {
        var cont = String(post1.idPaisr.options[post1.idPaisr.selectedIndex].value);
        if (cont == "undefined" || cont == '') {
            alert('Escoja Pais Residencia');
        } else {
            post1.id_.value = cont;
        }
        ;
    }
    ;
    function infodigital_() {
        if (post1.idTipoDocID.options[post1.idTipoDocID.selectedIndex].value == 1) {
            if (!check_ci(post1.docid.value, false, 1)) {
                if (post1.docid.value != post1.ant_docid.value) {
                    finfod.loaded.value = 0;
                }
                ;
                if (finfod.loaded.value == 0) {
//						alert(post1.ant_docid.value+' '+post1.docid.value);
                    finfod.docid.value = post1.docid.value;
                    finfod.submit();
                    post1.ant_docid.value = post1.docid.value;
//						alert(post1.ant_docid.value+' '+post1.docid.value);
                }
                ;
                finfod.loaded.value = 1;
                return false;
            } else {
                post1.docid.focus();
            }
            ;
        } else {
            alert('La <?php echo utf8_decode('verficación') ?> con Dato Seguro solo funciona para personas que tienen <?php echo utf8_decode('cédula') ?>');
        }
        ;
    }
    ;
    function despliega() {
        if (post1.idTipoDocID.options[post1.idTipoDocID.selectedIndex].value == 1 && !check_ci(post1.docid.value, false, 1)) {
            if (true) {
                expandit2('infod', 1);
                finfod.vis.value = 1;
                infodigital_();
            } else {
                /*expandit2('infod',0);
                 finfod.vis.value=0*/
            };
        } else {
            alert('La <?php echo utf8_decode('verficación') ?> con Dato Seguro solo funciona para personas que tienen <?php echo utf8_decode('cédula') ?>');
        };
        return false;
    }
    ;
</SCRIPT>
<HTML>
    <BODY >
        <form name="cher" action="homeg.php" method="post" >
            <input type="hidden" name="resol">
            <input type="hidden" name="subsys">
            <input type="hidden" name="tus">
            <input type="hidden" name="topico">
        </form>
        <a name='begin'></a>	
<?php include("theader.php") ?>

        <table align="center" width="100%" border='1' cellspacing='0' style="border-style:solid; border: 1px solid lightgray;">
            <tr>
                    <td valign='middle' align='center' colspan='4' class='literatura'><!--<img src='image/regcard.png'>--><font size='+1'><b> SOLICITUD DE REGISTRO </b> </font><br>
                </td>
            </tr>
            <tr>
<!--                    <td rowspan='1' width='25%' class='menubar' align="center" onMouseOver="overTD(this, '#d9dbdd');" onMouseOut="outTD(this, '');" onClick="cher.action = 'index.php';cher.submit()"><a href="http://<?php echo $_SERVER[SERVER_NAME]; ?>"><img src='image/home.png'>INICIO</a></td>-->
                    <td width='25%'  class='menubar' align="center" onMouseOver="overTD(this, '#d9dbdd');" onMouseOut="outTD(this, '');" onClick="return _submit('cher', 'browse-db-gui.php');return false;"><a href="Javascript:" onClick="return _submit('cher', 'browse-db-gui.php');return false;"><!--<img src='image/browse.png'>-->Base de Datos de Profesionales</a></td>
                    <td rowspan='1'  width='25%'  class='menubar'align="center" onMouseOver="overTD(this, '#d9dbdd');" onMouseOut="outTD(this, '');" onClick="cher.tus.value = '0';return _submit('cher', 'log-im.php');"><a href="Javascript:" onClick="cher.tus.value = '0';return _submit('cher', 'log-im.php');"><!--<img src='image/login.png'>-->Iniciar Sesi&oacute;n</a></td>
                <td rowspan='1' width='25%'  align="center" align='center' class='menubar'>
                    <a href="JavaScript:" onClick="abrir('http://<?php echo $_SERVER['SERVER_NAME']; ?>/manual/MANUAL-USUARIO-EXTERNO.pdf', 'help', ancho, alto, 0);
                            return false;"><img height='90%' src='image/copy_w18d.png'>Ayuda-Manual Profesional Solicitante</a>
                </td>
            </tr>
    <!--  <tr>
                    <td width='25%'  class='menubar'  align="center"  onClick="cher.target='_self';return _submit('cher','browse-db-gui-r.php');"><a href="Javascript:" onClick="cher.target='_self';return _submit('cher','browse-db-gui.php');">Base de Datos de Restauradores</a>
                    </td>
      </tr>-->
        </table>
        <hr>
        <table border='0' align='center' width='60%'>
            <tr>
                <td class='seccion2' align='center'>
                    <h2>Solicitud de Registro: <?php echo format_cont_db('TipoProfesionalId', $_POST['TPI']) ?></h2>
                </td>
            </tr>
        </table>
        <br>
    <center><img height='40' src='image/proces1.png'></center><br>
    <td >
        <table width="90%" align='center' border="0" cellpadding='2'>
            <tr>
                <td align='left' bgcolor='#ffffff' colspan='2' class='literatura'>
                    <strong><!--Servicio de-->Solicitud de Registro </strong>
                    <p align='left' STYLE="  font-family: arial;  text-align:justify; margin-top:5; margin-right:5; margin-bottom:5; margin-left:5%;">
                        &Eacute;sta&nbsp;informaci&oacute;n ser&aacute; verificada por el Instituto Nacional de Patrimonio Cultural, guardando la confidencialidad de la misma<!--En este formulario, el profesional que desee ser considerado para la ejecuci&oacute;n de trabajos relativos al patriomonio 
                        cultural del estado, ingresar&aacute; sus datos personales, as&iacute; como tambien los de su formaci&oacute;n acad&eacute;mica.<br><br>
                        La informaci&oacute;n ingresada ser&aacute; validada y verificada por funcionarios del INPC, despu&eacute;s se emitir&aacute; un informe t&eacute;cnico y
                        la consecuente respuesta a la solicitud de ingreso, que, ser&aacute; notificada al profesional via correo electr&oacute;nico. Si la
                        solicitud es aceptada, autom&aacute;ticamente se ingresar&aacute; en la base de datos en l&iacute;nea que estar&aacute; disponible para consulta p&uacute;blica-->
                    </p>
                </td>
            </tr>
        </table>
    </td>
</tr>
</table>
<!--	</DIV>-->

<form name="post1" action="" method="post" onSubmit="" >
    <input type="hidden" name="id_">
    <input type="hidden" name="id_ciu">
    <input type="hidden" name="ciu_co">
    <input type="hidden" name="subsys">
    <input type="hidden" name="ant_docid">
    <input type='hidden' name='TipoProfesionalId' value="<?php echo $_POST['TPI'] ?>">
    <input type="hidden" name="is_post" value='1'>
    <input type="hidden" name="spe" value="<?php echo format_cont_db('TipoProfesionalId', $_POST['TPI']) ?>">
    <tr><td colspan='3'><br><br> </td></tr>
    <table border='0' cellspacing='1' align='center' width='90%'>
        <tr>
            <td colspan='3'><br><br> </td>
        </tr>
        <tr valign='center'>
            <td align='center' class='seccion2'>
                <strong><font size='+1'>INFORMACI&Oacute;N PERSONAL</font> </strong>
                <table border='0' width ='100%' cellpadding='2' >
                    <tr  bgcolor='#ffffff'>
                        <td width='30%'>
                            <b><!--<font color='black' size='+1'>*</font>-->DOCUMENTO IDENTIFICACI&Oacute;N:</b><br> <?php load_of_db('idTipoDocID', '') ?>
                            <input type="text" name="docid" value="" size="20" maxlength="45" onFocus="set_bgcolor(this, '<?php echo $usr_bgc ?>')" onBlur="set_bgcolor(this, '');/*if(post1.idTipoDocID.options[post1.idTipoDocID.selectedIndex].value==1){expandit2('infodigital',1)}else{expandit2('infodigital',0)};*/" onClick="/*if(post1.idTipoDocID.options[post1.idTipoDocID.selectedIndex].value==1){expandit2('infodigital',1)}else{expandit2('infodigital',0)};*/">
                            <P style="  font-family: arial;  text-align:justify; margin-top:5; margin-right:2%; margin-bottom:5; margin-left:2%;">
                                <b>Nota:</b>Si usted es profesional extranjero, especifique como documento de identificaci&oacute;n su <b> n&uacute;mero de pasaporte</b> , para poder verificar su formaci&oacute;n acad&eacute;mica con la registrada en SENESCYT
                            </P>
                        </td>
                        <td  width='30%'>
                            <b><!--<font color='black' size='+1'>*</font>-->APELLIDOS:</b><br> <input type="text" name="lname" value="" size="30" maxlength="45" onFocus="set_bgcolor(this, '<?php echo $usr_bgc ?>')" onBlur="set_bgcolor(this, '')" onClick="">
                        </td>
                        <td  width='30%'>
                            <b><!--<font color='black' size='+1'>*</font>-->NOMBRES:</b><br> <input type="text" name="name" value="" size="30" maxlength="45" onFocus="set_bgcolor(this, '<?php echo $usr_bgc ?>')" onBlur="set_bgcolor(this, '')" onClick="">
                        </td>
                    </tr>
                    <tr bgcolor='#ffffff'>
                            <!--<td>
                            <b><font color='black' size='+1'>*</font>G&eacute;nero: <br>
                                    <SELECT NAME="genero" size="1"  onFocus="set_bgcolor(this,'<?php echo $usr_bgc ?>')" onBlur="set_bgcolor(this,'')">
                                            <OPTION selected value="M">Masculino</OPTION>
                                            <OPTION  value="F">Femenino</OPTION>
                                    </SELECT>
                            </td>-->							
                        <td colspan='2'>
                            <b><!--<font color='black' size='+1'>*</font>-->PA&Iacute;S NACIMIENTO:</b><br> <?php load_of_db('idNacionalidad', 'EC') ?>
                        </td>
                        <td>
                            <b><!--<font color='black' size='+1'>*</font>-->FECHA NACIMIENTO (aaaa/mm/dd):</b><br> <input type="text" name="fnac" value="" size="11" maxlength="10" onFocus="set_bgcolor(this, '<?php echo $usr_bgc ?>')" onBlur="set_bgcolor(this, '')" onClick="">
                        </td>
                    </tr>
                    <tr bgcolor='#ffffff'>
                        <td>
                            <b><!--<font color='black' size='+1'>*</font>-->PA&Iacute;S RESIDENCIA:</b><br> <?php load_of_db('idPaisr', 'EC') ?>
                        </td>
                        <td>
                            <b><!--<font color='black' size='+1'>*</font>--><a class='info' style="color:black; font-size:12px" name='sen' href="Javascript:  " onClick="getc();abrir('', 'get_c', ancho / 3, alto / 3, 0);
                                    post1.target = 'get_c';post1.action = 'get_c.php';
                                    post1.submit();return false;">CIUDAD RESIDENCIA<img src='image/downa.png'> </a></b><br> 
                            <input type="text" disabled name="ciudadr" value="" size="20" maxlength="45" onClick="">
                        </td>
                        <td>
                            <b><!--<font color='black' size='+1'>*</font>-->DIRECCI&Oacute;N:</b><br> <input type="text" name="direc" value="" size="50" maxlength="200" onFocus="set_bgcolor(this, '<?php echo $usr_bgc ?>')" onBlur="set_bgcolor(this, '')" onClick="">
                        </td>
                    </tr>
                    <tr bgcolor='#ffffff'>
                        <td>
                            <b><!--<font color='blue' size='+1'>*</font>-->TEL&Eacute;FONO M&Oacute;VIL:</b><br> <input type="text" name="tmovil" value="" size="13" maxlength="20" onFocus="set_bgcolor(this, '<?php echo $usr_bgc ?>')" onBlur="set_bgcolor(this, '')" onClick="">
                        </td>
                        <td>
                            <b><!--<font color='blue' size='+1'>*</font>-->TEL&Eacute;FONO FIJO :</b><br> <input type="text" name="tfijo" value="" size="13" maxlength="20" onFocus="set_bgcolor(this, '<?php echo $usr_bgc ?>')" onBlur="set_bgcolor(this, '')" onClick="">
                        </td>
                        <td>
                            <b>CORREO ELECTR&Oacute;NICO:</b><br><!--<font color='black' size='+1'>*</font>-->Principal: <input type="text" name="email" value="" size="30" maxlength="100" onFocus="set_bgcolor(this, '<?php echo $usr_bgc ?>')" onBlur="set_bgcolor(this, '')" onClick=""><br>
                            Alternativo <input type="text" name="email2" value="" size="30" maxlength="100" onFocus="set_bgcolor(this, '<?php echo $usr_bgc ?>')" onBlur="set_bgcolor(this, '')" onClick="">
                        </td>
                    </tr>
                    <?php if ($_POST['TPI'] == 1) { ?>
                        <tr>
                            <td colspan='3' align='center'>
                                <b>ESPECIALIDAD:</b><br> 
                                <SELECT title="Seleccione la especialidad" NAME="espec" size="1"  onFocus="set_bgcolor(this, '#85A3BB')" onBlur="set_bgcolor(this, '')">
                                    <OPTION  value=""><?php echo utf8_decode('Seleccione: Arqueólogo o Paleontólogo') ?></OPTION>-->
                                    <OPTION  value="A"><?php echo utf8_decode('Arqueólogo') ?></OPTION>
                                    <OPTION  value="P"><?php echo utf8_decode('Paleontólogo') ?></OPTION>
                                </SELECT>
                            </td>
                        </tr>
    <?php
} else {
    echo "<input type='hidden' name='espec' value='R'>";
};
?>
                </table>
            </td>
        </tr>
<!--		<tr>
                <td colspan='3'  align='center'><br>
                        <div id='infodigital' style="DISPLAY: ;" onClick="despliega();">
                                <img height='50' src='image/logo-RegistroCivil.png'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='Javascript:'><img style='border-radius: 3px; -moz-border-radius: 3px; border: 1px solid #0000ff;background-color: #e5f0f8; box-shadow: 3px 3px 5px #342870;' src='image/vdatoseguro.png'></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img height='50' src='image/logo-senescyt.png'>
                        </div>
                <DIV id='infod' style="DISPLAY:none; head: ;" ><br>
                        <iframe name='iinfod' frameborder='0'  height='405' width='100%' src="">
                          <p>Your browser does not support iframes.</p>
                        </iframe>
                </div>			
                </td>
        </tr>-->
        <tr>
            <td align='left' class='seccion2'>
        <center><strong> <font size='+1'><br>INFORMACI&Oacute;N ACAD&Eacute;MICA </font></strong><br>
            <p align='center'>
                <a name='sen' style='font-size:12px' class='info' href="Javascript:" onClick="url_ = url_base + post1.docid.value;abrir(url_, 'sene', ancho / 1.5, alto / 1.5, 0);">
                    <img height="50" title="Consulte sus datos en SENESCYT" alt="Consulte sus datos en SENESCYT" style="border-radius: 3px; -moz-border-radius: 3px; border: 1px solid #0000ff; background-color: #e5f0f8; box-shadow: 3px 3px 5px #342870;" src='image/logo-senescyt.png'>
                </a></p>		
            <p align='center'><strong> Nota: ingrese s&oacute;lo los t&iacute;tulos afines. 
                </strong></p>
            <table border='0' width ='100%' cellpadding='5' >
                <tr><td  align='center' bgcolor='#ffffff'  colspan='3'><b>T&Iacute;TULO  ACAD&Eacute;MICO 1</b></td></tr>
                <tr bgcolor='#d3ddfc'>
                <input type='hidden' name='fa1' value=''  >
                <td width='25%'>
                    <b>NIVEL:</b><BR>
                    <SELECT NAME="NivelT" size="1"  onFocus="set_bgcolor(this, '#85A3BB')" onBlur="set_bgcolor(this, '')">
                        <!--<OPTION  value="0">Nivel T&eacute;cnico o Tecnol&oacute;gico Superior</OPTION>-->
                        <OPTION selected value="3">Tercer Nivel</OPTION>
                        <OPTION  value="4">Cuarto Nivel</OPTION>
                    </SELECT>
                </td>
                <td width='35%'>
                    <b><!--<font color='black' size='+1'>*</font>-->T&Iacute;TULO ACAD&Eacute;MICO:</b><BR> <input type="text" name="ntitulo" value="" size="50" onFocus="set_bgcolor(this, '<?php echo $usr_bgc ?>')" onBlur="set_bgcolor(this, '')" onClick="">
                </td>
                <td width='40%'>
                    <b><!--<font color='black' size='+1'>*</font>-->INSTITUCI&OacuteN DE EDUCACI&Oacute;N SUPERIOR:</b><br> <input type="text" name="ninstitucion" value="" size="60" onFocus="set_bgcolor(this, '<?php echo $usr_bgc ?>')" onBlur="set_bgcolor(this, '')" onClick="">
                </td>
                </tr>
                <tr bgcolor='#d3ddfc'>
                    <td>
                        <b><!--<font color='black' size='+1'>*</font>-->FECHA GRADO  (aaaa/mm/dd):</b><br> <input type="text" name="ftitulo" value="" size="10" maxlength="10" onFocus="set_bgcolor(this, '<?php echo $usr_bgc ?>')" onBlur="set_bgcolor(this, '')" onClick="">
                    </td>
                    <td>
                        <b><!--<font color='black' size='+1'>*</font>-->N&Uacute;MERO DE REGISTRO EN SENESCYT:</b><br> <input type="text" name="codigo" value="" size="20" maxlength="45" onFocus="set_bgcolor(this, '<?php echo $usr_bgc ?>')" onBlur="set_bgcolor(this, '')" onClick="">
                    </td>
                    <td></td>
                </tr>
                <tr><td align='center' bgcolor='#ffffff' colspan='3'><b>T&Iacute;TULO  ACAD&Eacute;MICO 2</b></td></tr>
                <tr bgcolor='#d3ddfc'>
                    <td>
                        <b>NIVEL:</b><br> 
                        <SELECT NAME="NivelT2" size="1"  onFocus="set_bgcolor(this, '#85A3BB')" onBlur="set_bgcolor(this, '')">
                            <!--<OPTION  value="0">Nivel T&eacute;cnico o Tecnol&oacute;gico Superior</OPTION>-->
                            <OPTION selected value="3">Tercer Nivel</OPTION>
                            <OPTION  value="4">Cuarto Nivel</OPTION>
                        </SELECT>
                        <input type='hidden' name='fa2' value=''  >
                    </td>
                    <td>
                        <b><!--<font color='black' size='+1'>*</font>-->T&Iacute;TULO ACAD&Eacute;MICO:</b><br> <input type="text" name="ntitulo2" value="" size="50" onFocus="set_bgcolor(this, '<?php echo $usr_bgc ?>')" onBlur="set_bgcolor(this, '')" onClick="">
                    </td>
                    <td>
                        <b><!--<font color='black' size='+1'>*</font>-->INSTITUCI&OacuteN DE EDUCACI&Oacute;N SUPERIOR:</b><br> <input type="text" name="ninstitucion2" value="" size="60" onFocus="set_bgcolor(this, '<?php echo $usr_bgc ?>')" onBlur="set_bgcolor(this, '')" onClick="">
                    </td>
                </tr>
                <tr bgcolor='#d3ddfc'>
                    <td>
                        <b><!--<font color='black' size='+1'>*</font>-->FECHA GRADO  (aaaa/mm/dd):</b><br> <input type="text" name="ftitulo2" value="" size="10" maxlength="10" onFocus="set_bgcolor(this, '<?php echo $usr_bgc ?>')" onBlur="set_bgcolor(this, '')" onClick="">
                    </td>
                    <td>
                        <b><!--<font color='black' size='+1'>*</font>-->N&Uacute;MERO DE REGISTRO EN SENESCYT:</b><br> <input type="text" name="codigo2" value="" size="20" maxlength="45" onFocus="set_bgcolor(this, '<?php echo $usr_bgc ?>')" onBlur="set_bgcolor(this, '')" onClick="">
                    </td>
                    <td></td>
                </tr>
                <tr><td align='center' bgcolor='#ffffff' colspan='3'><b>T&Iacute;TULO  ACAD&Eacute;MICO 3</b></td></tr>
                <tr bgcolor='#d3ddfc'>
                    <td>
                        <b>NIVEL:</b><br> 
                        <SELECT NAME="NivelT3" size="1"  onFocus="set_bgcolor(this, '#85A3BB')" onBlur="set_bgcolor(this, '')">
                            <!--<OPTION  value="0">Nivel T&eacute;cnico o Tecnol&oacute;gico Superior</OPTION>-->
                            <OPTION selected value="3">Tercer Nivel</OPTION>
                            <OPTION  value="4">Cuarto Nivel</OPTION>
                        </SELECT>
                        <input type='hidden' name='fa3' value=''  >
                    </td>
                    <td>
                        <b><!--<font color='black' size='+1'>*</font>-->T&Iacute;TULO ACAD&Eacute;MICO:</b><br> <input type="text" name="ntitulo3" value="" size="50" onFocus="set_bgcolor(this, '<?php echo $usr_bgc ?>')" onBlur="set_bgcolor(this, '')" onClick="">
                    </td>
                    <td>
                        <b><!--<font color='black' size='+1'>*</font>-->INSTITUCI&OacuteN DE EDUCACI&Oacute;N SUPERIOR:</b><br> <input type="text" name="ninstitucion3" value="" size="60" onFocus="set_bgcolor(this, '<?php echo $usr_bgc ?>')" onBlur="set_bgcolor(this, '')" onClick="">
                    </td>
                </tr>
                <tr bgcolor='#d3ddfc'>
                    <td>
                        <b><!--<font color='black' size='+1'>*</font>-->FECHA GRADO  (aaaa/mm/dd):</b><br> <input type="text" name="ftitulo3" value="" size="10" maxlength="10" onFocus="set_bgcolor(this, '<?php echo $usr_bgc ?>')" onBlur="set_bgcolor(this, '')" onClick="">
                    </td>
                    <td>
                        <b><!--<font color='black' size='+1'>*</font>-->N&Uacute;MERO DE REGISTRO EN SENESCYT:</b><br> <input type="text" name="codigo3" value="" size="20" maxlength="45" onFocus="set_bgcolor(this, '<?php echo $usr_bgc ?>')" onBlur="set_bgcolor(this, '')" onClick="">
                    </td><td></td>
                </tr>
                <?php /* ?>								<!--</table>
                  <FONT style="FONT-WEIGHT: bold; FONT-SIZE: 15px;  COLOR: #000066" onclick="if(post1.fa4.value==0){expandit2('capaMenuName4',1);swap('minusb.png','moreb.png','xp4');post1.fa4.value=1;}else{expandit2('capaMenuName4',0);swap('minusb.png','moreb.png','xp4');post1.fa4.value=0;};"><a href='' class='info' onClick='return false;'><img name='xp4' src="image/moreb.png" border='0' height='13' > T&iacute;tulo </a></FONT>
                  </div>
                  </td>
                  </tr>
                  <tr>
                  <td colspan='4'>
                  <!--								<FONT style="FONT-WEIGHT: bold; FONT-SIZE: 15px;  COLOR: #000066" onclick="fa_4=expandit(this);swap('minusb.png','moreb.png','xp4');if(fa_4){post1.fa4.value=true;}else{post1.fa4.value=false;};"><a href='' onClick='return false;'><img name='xp4' src="image/moreb.png" border='0' height='13' > Registro </a></FONT>-->
                  <DIV style="DISPLAY: none; head: " id="capaMenuName4">
                  <table border='0' bgcolor='#d3fcd9'>
                  <tr >
                  <td rowspan='2'><font size='+1'></font>
                  <input type='hidden' name='fa4' value='0' >
                  </td>
                  <td>
                  <b>NIVEL T&Iacute;TULO:</b>
                  <SELECT NAME="NivelT4" size="1"  onFocus="set_bgcolor(this,'#85A3BB')" onBlur="set_bgcolor(this,'')">
                  <!--<OPTION  value="0">Nivel T&eacute;cnico o Tecnol&oacute;gico Superior</OPTION>-->
                  <OPTION selected value="3">Tercer Nivel</OPTION>
                  <OPTION  value="4">Cuarto Nivel</OPTION>
                  </SELECT>
                  </td>
                  <td>
                  <b><!--<font color='black' size='+1'>*</font>-->NOMBRE T&Iacute;TULO:</b> <input type="text" name="ntitulo4" value="" size="20" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
                  </td>
                  <td>
                  <b><!--<font color='black' size='+1'>*</font>-->INSTITUCION:</b> <input type="text" name="ninstitucion4" value="" size="20" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
                  </td>
                  </tr>
                  <tr >
                  <td>
                  <b><!--<font color='black' size='+1'>*</font>-->FECHA GRADUACION  (aaaa/mm/dd):</b> <input type="text" name="ftitulo4" value="" size="10" maxlength="10" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
                  </td>
                  <td>
                  <b><!--<font color='black' size='+1'>*</font>-->CODIGO REGISTRO SENECYT:</b> <input type="text" name="codigo4" value="" size="20" maxlength="45" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
                  </td>
                  </tr>
                  </table>
                  <FONT style="FONT-WEIGHT: bold; FONT-SIZE: 15px;  COLOR: #000066" onclick="if(post1.fa5.value==0){expandit2('capaMenuName5',1);swap('minusb.png','moreb.png','xp5');post1.fa5.value=1;}else{expandit2('capaMenuName5',0);swap('minusb.png','moreb.png','xp5');post1.fa5.value=0;};"><a href='' class='info' onClick='return false;'><img name='xp5' src="image/moreb.png" border='0' height='13' > T&iacute;tulo </a></FONT>
                  </div>
                  </td>
                  </tr>
                  <tr>
                  <td colspan='4'>
                  <!--								<FONT style="FONT-WEIGHT: bold; FONT-SIZE: 15px;  COLOR: #000066" onclick="fa_5=expandit(this);swap('minusb.png','moreb.png','xp5');if(fa_5){post1.fa5.checked=true;}else{post1.fa5.value=false;};"><a href='' onClick='return false;'><img name='xp5' src="image/moreb.png" border='0' height='13' > Registro </a></FONT>-->
                  <DIV  style="DISPLAY: none; head: " id="capaMenuName5">
                  <table border='0' bgcolor='#d3ddfc'>
                  <tr>
                  <td rowspan='2'><font size='+1'></font>
                  <input type='hidden' name='fa5' value='0' >
                  </td>
                  <td>
                  <b>NIVEL T&Iacute;TULO:</b>
                  <SELECT NAME="NivelT5" size="1"  onFocus="set_bgcolor(this,'#85A3BB')" onBlur="set_bgcolor(this,'')">
                  <!--<OPTION  value="0">Nivel T&eacute;cnico o Tecnol&oacute;gico Superior</OPTION>-->
                  <OPTION selected value="3">Tercer Nivel</OPTION>
                  <OPTION  value="4">Cuarto Nivel</OPTION>
                  </SELECT>
                  </td>
                  <td>
                  <b><!--<font color='black' size='+1'>*</font>-->NOMBRE T&Iacute;TULO:</b> <input type="text" name="ntitulo5" value="" size="20" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
                  </td>
                  <td>
                  <b><!--<font color='black' size='+1'>*</font>-->INSTITUCION:</b> <input type="text" name="ninstitucion5" value="" size="20" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
                  </td>
                  </tr>
                  <tr>
                  <td>
                  <b><!--<font color='black' size='+1'>*</font>-->FECHA GRADUACION  (aaaa/mm/dd):</b> <input type="text" name="ftitulo5" value="" size="10" maxlength="10" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
                  </td>
                  <td>
                  <b><!--<font color='black' size='+1'>*</font>-->CODIGO REGISTRO SENECYT:</b> <input type="text" name="codigo5" value="" size="20" maxlength="45" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
                  </td>
                  </tr>
                  </table>
                  </div>
                  </td>
                  </tr>
                  <tr>
                  <td colspan='4'>
                  <!--								<FONT style="FONT-WEIGHT: bold; FONT-SIZE: 15px;  COLOR: #000066" onclick="if(post1.fa6.value==0){expandit2('capaMenuName6',1);swap('minusb.png','moreb.png','xp6');post1.fa6.value=1;}else{expandit2('capaMenuName6',0);swap('minusb.png','moreb.png','xp6');post1.fa6.value=0;};><a href='' onClick='return false;'><img name='xp6' src="image/moreb.png" border='0' height='13' > T&iacute;tulo </a></FONT>-->
                  <DIV style="DISPLAY: none; head: " id="capaMenuName6">
                  <table border='0' bgcolor='#d3fcd9'>
                  <tr >
                  <td rowspan='2'><font size='+1'></font>
                  <input type='hidden' name='fa6' value='0' >
                  </td>
                  <td>
                  <b>NIVEL T&Iacute;TULO:</b>
                  <SELECT NAME="NivelT6" size="1"  onFocus="set_bgcolor(this,'#85A3BB')" onBlur="set_bgcolor(this,'')">
                  <!--<OPTION  value="0">Nivel T&eacute;cnico o Tecnol&oacute;gico Superior</OPTION>-->
                  <OPTION selected value="3">Tercer Nivel</OPTION>
                  <OPTION  value="4">Cuarto Nivel</OPTION>
                  </SELECT>
                  </td>
                  <td>
                  <b><!--<font color='black' size='+1'>*</font>-->NOMBRE T&Iacute;TULO:</b> <input type="text" name="ntitulo6" value="" size="20" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
                  </td>
                  <td>
                  <b><!--<font color='black' size='+1'>*</font>-->INSTITUCION:</b> <input type="text" name="ninstitucion6" value="" size="20" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
                  </td>
                  </tr>
                  <tr >
                  <td>
                  <b><!--<font color='black' size='+1'>*</font>-->FECHA GRADUACION  (aaaa/mm/dd):</b> <input type="text" name="ftitulo6" value="" size="10" maxlength="10" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
                  </td>
                  <td>
                  <b><!--<font color='black' size='+1'>*</font>-->CODIGO REGISTRO SENECYT:</b> <input type="text" name="codigo6" value="" size="20" maxlength="45" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
                  </td>
                  </tr>
                  </table>
                  </div>
                  </td>
                  </tr><?php */ ?>
            </table>
            </td>
            </tr>
            <tr>
                <td colspan='3'><br></td>
            </tr>
    </table>
    <table border='0' align='center' cellpadding='8'>
        <tr>
            <td align='center' class='elipse' onClick="if (validate()) {
                        post1.target = '_self';post1.action = 'post2.php';
                        post1.submit();
                    };return false;">
                <a href='JavaScript:'  >
                    INGRESAR SOLICITUD
                </a>
            </td>
        </tr>
    </table>
</form><?php /* ?>
                  <form id="finfod" target='iinfod' action="ver-infodigital.php" method="post">
                  <input type='hidden' name='vis' value='0'>
                  <input type='hidden' name='loaded' value='0'>
                  <input type='hidden' name='docid' value="<?php if (isset($docid)){echo $docid;};?>">
                  <input type="hidden" name="is_post" value='1'>
                  </form><?php */ ?>

<?php include("footer.php") ?>

</BODY>
</HTML>
