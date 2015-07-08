<?php 
//Verificar los datos concatenar por seguridad
$nombre = $_POST['nombre'];
$cedula = $_POST['cedula'];
$nomusu = $nombre; //$nombre.$cedula;
$apellido = $_POST['apellido'];
$namefull = $nombre." ".$apellido; 
$email = $_POST['email']; 
$tipou = $_POST['tipou'];
$estilo = $_POST['estilo'];

  /*include("xmpp.php");

  //username = user without domain, "user" and not "user@server" - home is the resource
  $conn = new XMPPHP_XMPP('localhost', 5222, 'admin', 'admin','resource');
  // Enables TLS - enabled by default, call before connect()!
  $conn->useEncryption(true);
  $conn->connect();
  $conn->processUntil('session_start');
  //$conn->message('someguy@someserver.net', 'This is a test message!');
  $conn->disconnect();
*/
 //Necesitamos la librería Stomp.php que hemos bajado 
  include("Stomp.php"); 
  //Creamos un objeto Stomp, conectandonos al servidor que va a  escuchar el Stomp 
  $con = new Stomp('tcp://localhost:61613');
  $con->connect(); //Hacemos la conexión 
  
  $server = $_SERVER['SERVER_NAME'];
  
  if($server == "localhost")
    $strCnx = "host=localhost port=5432 dbname=openfire3 user=postgres password=control";
  else 
    $strCnx = "host=localhost port=5432 dbname=openfire user=postgres password=siticol";
  
  $cnx = pg_connect($strCnx) or die ("Error de conexion. ". pg_last_error());
  //echo "Conexion exitosa<br>";

  if($server == "localhost")
    $enc = "e06457e5419d388bac1cab824dd1459a7fae266ae43aa4d43cb2d7c950703d250e856ab79704f491"; 
  else
    $enc = "704436641ab052854085ae2b5051dbbf715f8ddc033a0c887088a8d30222b596e78cf41025efadc8"; 

  $fecha = new DateTime();
  $fecha= $fecha->getTimestamp();
  //MODIFICAR 000 al final no esta bien 
  $fecha = (str_pad($fecha, 12, '0', STR_PAD_LEFT))."000";
  
# Ejecutando la Consulta
if ( $nomusu && $tipou == "funcionario" ) {
  //Verificar si el usuario existe
  $username = "";
  $datosusu = pg_query($cnx,"SELECT username,usutype FROM ofuser WHERE username='".$nomusu."'");
  while ($row = pg_fetch_row($datosusu)) {
        $username = $row[0];
        $tipou = $row[1];
  }
  
  if(!$username){
    //Add user new
    $sql = "INSERT INTO ofuser(
              username, plainpassword, encryptedpassword, name, email, creationdate, modificationdate, usutype)
            VALUES ('" . pg_escape_string($nomusu) . "', 'nuchata','".$enc."','" . pg_escape_string($nomusu) . "',
                    '" . pg_escape_string($email) . "', '".$fecha."', '".$fecha."','".$tipou."')"; 
    $result = pg_query($cnx, $sql);

    //Log de creation user
    //ct msgid
    $ct = pg_query($cnx,"SELECT max(msgid) as ctmid from ofsecurityauditlog");
    $ctid = pg_fetch_result($ct, 0, 'ctmid');
    $ctid = $ctid + 1;
    
    $details ="name = ".$nomusu.", email = ".$email.", dsf.com, admin = false";
    $sql2 = "INSERT INTO ofsecurityauditlog(
              msgid, username, entrystamp, summary, node, details)
      VALUES (".$ctid.", 'web', '".$fecha."', 'created new user".$nomusu."', 'David-PC','".$details."' )";
    $result = pg_query($cnx, $sql2);
  
    if (!$result) {
        echo "Query: Un error ha occurido.\n";
        exit;
    }
  }

  //Funcionarios
  $funcionarios = pg_query($cnx, "SELECT username FROM ofuser WHERE usutype='funcionario'");
  $userf = "";
  while ($row = pg_fetch_row($funcionarios)) {
      $userf = $row[0]."/".$userf;
  }

  
}

//Close connect 
pg_close($cnx);

  //usuarios funcionarios
  //nombre usuario (lo obtengo de arriba)
  //clave si no es anonimo
  $clavepsw = "nuchatwelcome1";

  $datos = $nomusu."=".$clavepsw."=".$estilo."=".$userf;
  if($tipou != "funcionario" ){
    echo "Usted no es administrador";
    echo "<script type='text/javascript'>";
    echo "document.getElementById('nuchata').style.display = 'none'";
    echo "</script>";
    
  }else{
    $con->send("/topic/numbers", $datos); 
    $con->disconnect(); //Desconectamos 
  }
?>