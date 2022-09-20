<?php
	require("include/header.inc.php");
	require("css/main-style.inc.php");
	require('class/mysql_table.php');
	require('css/css-func.inc.php');
	require('class/format_db_content.php');

?>
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/type.js"></SCRIPT>
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/formsm.js"></SCRIPT>
	 <SCRIPT LANGUAGE="JavaScript1.2" src="java/dinamico.js"></SCRIPT>
<BODY >
				<form name="cher" action=" " method="post" >
				<input type="hidden" name="tus">
				<input type="hidden" name="subsys">
				<input type="hidden" name="topico">
				<input type='hidden' name='TPI'>
				<input type="hidden" name="vibl" value='0'>
<a name='begin'></a>
<?php include("theader.php")?>
<table align="center" width="95%" border='0' cellspacing='0' style="border-style:solid; border: 1px solid lightgray;"  >
  <tr>
      <td align="center" align='center' class='literatura' colspan='6'><font size='+1'><b>REGISTRO Y CONSULTA DE PROFESIONALES </b> </font>
			</td>
  </tr>
  <tr valign='middle'>
			<td align="center" onMouseOver="overTD(this,'#d9dbdd');" onMouseOut="outTD(this,'');" onClick=""><a href="Javascript:"><img src='image/sorry.jpg'>
			</td>
</table>

</BODY>
</HTML>
