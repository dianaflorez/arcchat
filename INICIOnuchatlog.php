<!DOCTYPE html>
<html>
  <head>
    <title>Nuchat</title>
    
  </head>

<body>

<form action="nuchatadminlog.php" id="formulario" method="POST">
     
     Nombre de usuario:
     <input type="text" name="nombre" id="nombre" value="sean" form="formulario" /> 
<br />
     Email <input type="text" name="email" id="email" value="notiene@email.com"  form="formulario"/>
    <br /> 
    <input type="text" name="estilo" id="estilo" value="estilo1" form="formulario" />
    <br />
    <input type="text" name="cedula" id="cedula" value="00"  form="formulario" />
    <br />
    <input type="text" name="apellido" id="apellido" value="Florez" form="formulario"  />
    <br />
    <input type="text" name="tipou" id="tipou" value="funcionario"  form="formulario" />
    <br />
    <input type="hidden" name="urlchat" id="urlchat" value="nourl" form="formulario" />
    <br />
    
    <input type="submit" value="Administrador">
    <input type="submit" formaction="nuchatuserlog.php" value="Usuario">
</form>

</body>
</html>