<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8" />
    <title>Nuchat</title>
    <script type="text/javascript" src="js/jquery-1.11.3min.js"></script>
    <link type="text/css" href="css/estilo1.css" rel="stylesheet" id="linkestiloa">
    <script>

    function cambioestilo(rutaEstilo){ $("#linkestiloa").attr("href", rutaEstilo); }

    function _ocultarIframe(){
        document.getElementById('nuchata').style.display = 'none';
        document.getElementById('logreg').style.display = 'block';
    }   

    function realizaProceso(valorCaja1, email, cedula, apellido, tipou, urlchat, estilo){
            var parametros = {
                    "nombre" : valorCaja1.toLowerCase(),
                    "email" : email.toLowerCase(),
                    "cedula" : cedula.toLowerCase(),
                    "apellido" : apellido.toLowerCase(),
                    "tipou" : tipou.toLowerCase(),
                    "estilo" : estilo
            };
            $.ajax({
                    data:  parametros,
                    url:   'nuchatadmin.php',
                    type:  'post',
                    beforeSend: function () {
                        document.getElementById('resultado').style.display = "none";
                        $("#resultado").html("Procesando, espere por favor...");
                    },
                    success:  function (response) {
                        document.getElementById('logreg').style.display = "none";
                        document.getElementById('nuchata').style.display = "block";
                       // $("#resultado").html(response);
                    }
            });
    }
    
    </script>
  </head>

<body oncontextmenu="return false;">
<?php 
$server = $_SERVER['SERVER_NAME'];
$urlchat = "http://".$server.":8001/nuchat/nuchatadmin.html";

if($_POST){
    $nombre = "sean";
    $cedula = "f";//rand ( 10 , 100 );
    $nomusu = $nombre.$cedula;
    $apellido = "notiene";
    $email = "notiene@email.com"; 
    $tipou = "funcionario";
    $estilo = "estilo2";

    if($_POST['nombre'] && $_POST['nombre'] != "")
    $nombre = strtolower($_POST['nombre']);

    $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_"; 
   for ($i=0; $i<strlen($nombre); $i++){ 
      if (strpos($permitidos, substr($nombre,$i,1))===false){ 
         echo $nombre . " no es válido<br>"; 
         $nombre = "anonimo";
         return false; 
      } 
   }

    if($_POST['cedula'] && $_POST['cedula'] != "")
    $cedula = $_POST['cedula'];

    for ($i=0; $i<strlen($cedula); $i++){ 
      if (strpos($permitidos, substr($cedula,$i,1))===false){ 
         echo $cedula . " no es válido<br>"; 
         $cedula = time();
         return false; 
      } 
    }

    $nomusu = $nombre.$cedula;

    if($_POST['apellido'] && $_POST['apellido'] != "")
    $apellido = $_POST['apellido'];

    if($_POST['email'] && $_POST['email'] != "")
    $email = $_POST['email']; 

    if($_POST['tipou'] && $_POST['tipou'] != "")
        $tipou = $_POST['tipou'];

    if($_POST['estilo'] && $_POST['estilo'] != "")
        $estilo = $_POST['estilo'];

   echo "<script>";
   echo " cambioestilo('css/".$estilo.".css')";
   echo "</script>";
}else{
    $nombre = "sean";
    $cedula = strtolower("F");//rand ( 10 , 100 );
    $nomusu = $nombre.$cedula;
    $apellido = "notiene";
    $email = "notiene@email.com"; 
    $tipou = "funcionario";
    $estilo = "estilo2";
}
?>

<div class="console" id="logreg">
    <div><h4 class="headertitle">Chat</h4></div>
    
        <div class="chatlog">
            
            <input type="hidden" name="caja_texto" id="nomusu" value=<?php echo strtolower($nombre) ?> /> 
            <br />
            <input type="hidden" name="caja_texto" id="email" value=<?php echo strtolower($email); ?> />
            
            <br /><br />
            <div class="btn">
                <input class="btnint" type="button" href="javascript:;" onclick="realizaProceso($('#nomusu').val(), $('#email').val(),$('#cedula').val(),$('#apellido').val(),$('#tipou').val(),$('#urlchat').val(),$('#estilo').val());return false;" 
                value="Iniciar Conversación"/>
            </div>
    
    </div>

    <input type="hidden" name="estilo" id="estilo" value=<?php echo $estilo; ?> />
    <input type="hidden" name="cedula" id="cedula" value=<?php echo strtolower($cedula); ?> />
    <input type="hidden" name="apellido" id="apellido" value=<?php echo strtolower($apellido); ?> />
    <input type="hidden" name="tipou" id="tipou" value=<?php echo $tipou; ?> />
    <input type="hidden" name="urlchat" id="urlchat" value=<?php echo $urlchat; ?> />
    
</div>
<span id="resultado"></span>
<iframe id="nuchata" width="940" height="450"  scrolling="auto" frameborder="0" 
        src="<?php echo $urlchat; ?>" name="window" style="display:none">
</iframe>
</body>
</html>