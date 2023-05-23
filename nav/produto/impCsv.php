<!DOCTYPE html>
<html>
    <head>
        <title> Importar Planilha CSV</title>
        <meta charset="utf-8">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    </head>

    <body class="container" style="margin-top: 10%;">
        <div class="bg-light p-4 rounded">
            <h2>Upload CSV</h2>
                <form action="importar.php" method="post" enctype="multipart/form-data">
                    
                    <div class="m-3">
                        <label><input type="file" name="file"> </label>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">Enviar</button>
                    <a class="btn btn-sm btn-danger" href="index.php">Voltar</a>
                </form>
        </div>
                

      <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
   
    </body>
</html>