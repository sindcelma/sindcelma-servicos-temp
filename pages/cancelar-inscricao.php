<?php 
    $req = request(['req', 'email']);
    $email = $req->vars['email'];
    if(!$email) _error();
?>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php _url("/css/cancelar-inscricao.css"); ?>">
    <title>Cancelar Inscrição</title>
</head>
<body>
    <div class="container">
        <div class="row border-bottom">
            <div class="col-12">
                <img style="width:250px;" class="mx-auto d-block p-4" src="<?php _url("/images/logo.png"); ?>" alt="">
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <img src="<?php _url("/images/ic-unsubscribe.png"); ?>" class="mx-auto d-block mt-3" alt="">
            </div>
            <div class="col-12">
                <h3 class="text-center pt-3">Você realmente quer 
cancelar sua inscrição?</h3>
            </div>
            <div class="col-12">
                <p class="text-center"><b> confirme seu email abaixo e diga-nos o motivo</b></p>
            </div>
            <div class="col-12 col-lg-8  mx-auto">
                <span class="h5 p-4 mx-auto d-block rounded bg-white shadow text-center"><?php echo $email; ?></span>
            </div>
        </div>
    </div>
    <script>

    </script>
</body>
</html>