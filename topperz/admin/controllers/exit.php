<?php
		addLog('',-1,0);
		/*$_SESSION['hash']='';
		$_SESSION['admin_name']='';
		$_SESSION['admin']=NULL;*/
        session_destroy();
echo "<body style=\"background: url(\"_layout/images/back-pattern.png\") repeat scroll 0 0 rgba(0, 0, 0, 0);\"><img src=\"img/exit.jpg\" border=\"0\"/><br />
<strong style=\"font-family:arial;font-size:21px;\">Выход произведен!</strong>
		<script>setTimeout('document.location=\'login.php\'',1000);</script>
        </body>";
?>
