<?php

if($_POST){
    header('Location:inicio.php');
}
?>


<!doctype html>
<html lang="en">

<head>
    <title>Administrador del Sitio Web</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

   

    <div class="container">
        <div class="row">

            <div class="col-md-4">
                
            </div>
        
            <div class="col-md-4">
            <br />
            <br />
            <br />

                <div class="card">
                    <div class="card-header">
                        Login
                    </div>
                    
                    <div class="card-body">
                        <!--FORMULARIO-->
                        <form action="" method="POST">
                            <div class = "form-group">
                                <label for="usuario">Usuario</label>
                                <input type="text" class="form-control" name="usuario" id="usuario" aria-describedby="usuario" placeholder="Ingrese usuario">
                            </div>
                            
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Ingrese contraseña">
                            </div>
                                                        
                            <button type="submit" class="btn btn-primary">Ingresar</button>
                        </form>
                        
                        login

                    </div>
                    
                </div>
                
            </div>
            
        </div>
    </div>
    
</body>

</html>

