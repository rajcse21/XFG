<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />		
        <title><?php echo config_item('SITE_NAME'); ?> - Contact Us</title>
    </head>
    <body>
        <div style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;">			<table width="100%" border="0" cellspacing="0" cellpadding="0">				<tr>					<td align="center">&nbsp;</td>				</tr>			</table>			<table width="100%" border="0" cellspacing="0" cellpadding="2">				<tr>					<td style="color:#000000; vertical-align:top; width:50%"><b>Contact Form  </b><br /> <i>Dated: <?php echo $DATE_CURRENT; ?></i></td>				</tr>			</table><br />			<p>Dear Admin,</p>			<p><b><?php echo $NAME; ?></b> has submitted Contact Form at <?php echo $SITE_URL; ?>.</p>			<p>			Name: <?php echo $NAME;?><br/>			Email: <?php echo $EMAIL;?><br/>			Subject: <?php echo $SUBJECT;?><br/>			Message: <?php echo $MESSAGE;?>			</p>			<br />		</div>
    </body>
</html>