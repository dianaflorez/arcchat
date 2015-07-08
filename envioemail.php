<!DOCTYPE html>
<html>
  <head>
    <title>Nuchat</title>
    
  </head>

<body>

<?php 
//Verificar los datos concatenar por seguridad
//$nomusuario = $_POST['nombre'];
//$idconversation = $_POST['cedula'];
  
  $strCnx = "host=localhost port=5432 dbname=openfire2 user=postgres password=control";
  $cnx = pg_connect($strCnx) or die ("Error de conexion. ". pg_last_error());
  echo "Conexion exitosa<br>";

  $fecha = new DateTime();
  

  $sql = "  SELECT tojid, body FROM ofconparticipant p, ofconversation c, ofmessagearchive m 
            WHERE   p.conversationid = c.conversationid AND 
                    p.conversationid = m.conversationid AND 
                    m.conversationid = c.conversationid 
            AND barejid='usudiana@localhost'
            --AND c.conversationid = 1379
            ORDER BY c.conversationid,sentdate"

  $conversation = pg_query($cnx, $sql);

  $sw = 0;
  $msg = "";
  while ($row = pg_fetch_row($conversation)) {
        if($sw == 0){
            $funcionario = $row[0];
            $sw = 1;
        }

        $msg = $msg.'--------'.$row[1];
  }
  
  if($msg){
      $mensaje = wordwrap($msg,  70, "<br />\n");    
      echo $mensaje;
  }

//Close connect 
pg_close($cnx);

  //usuarios funcionarios
  //nombre usuario (lo obtengo de arriba)
  //clave si no es anonimo
  




$texto ="Hola como estas";
$texto = str_replace("\n.", "\n..", $texto);

// El mensaje
$mensaje = "Linea 1\r\nLinea 2\r\nLinea 3 Linea 1\r\nLinea 2\r\nLinea 3  Linea 1\r\nLinea 2\r\nLinea 3 ";

// Si cualquier línea es más larga de 70 caracteres, se debería usar wordwrap()



// Enviarlo
//mail('dianaflorezbravo@gmail.com', 'Mi título', $mensaje);

?>

</body>
</html>