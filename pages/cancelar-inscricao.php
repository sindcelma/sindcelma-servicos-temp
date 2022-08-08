<?php 

    $req = request(['req', 'hash', 'email']);
    $email = $req->vars['email'];
    $hash  = $req->vars['hash'];

    $hashc = hash('sha256', $email.config('salt'));
    if($hashc != $hash) return false;
    $query = _query("SELECT ativo FROM mailing WHERE `hash_id` = '$hash' AND email = '$email'");
    $status = $query->rowCount() > 0;

    if(!$email || !$hash || !$status) _error();

    $ativo = $query->fetchAssoc()['ativo'] == 1; 

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
<div id="loading" class="loading d-none">Loading&#8230;</div>
<div id="alert" class="alert alert-danger text-center d-none" role="alert"></div>
    <div class="container">
        <div class="row border-bottom">
            <div class="col-12">
                <img style="width:250px;" class="mx-auto d-block p-4" src="<?php _url("/images/logo.png"); ?>" alt="">
            </div>
        </div>
        <div id="content">
        <?php if($ativo){ ?>
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
                <div class="col-12 col-lg-6 pt-3 mx-auto">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Este conteúdo não é para mim" id="notforme1">
                                <label class="form-check-label" for="notforme1">
                                    Este conteúdo não é para mim.
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Vocês enviam muitos e-mails" id="notforme2">
                                <label class="form-check-label" for="notforme2">
                                    Vocês enviam muitos e-mails.
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Está indo para caixa de spam" id="notforme3">
                                <label class="form-check-label" for="notforme3">
                                    Está indo para caixa de spam.
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="Outros motivos" id="notforme4">
                                <label class="form-check-label" for="notforme4">
                                    Outros motivos.
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button id="salvar" class="btn btn-success mx-auto d-block mt-3">SALVAR PREFERENCIAS</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="row">
                <div class="col-12">
                    <h3 class="text-center pt-3">O e-mail abaixo está descadastrado!</h3>
                    <div class="col-12 col-lg-8  mx-auto">
                        <span class="h5 p-4 mx-auto d-block rounded bg-white shadow text-center"><?php echo $email; ?></span>
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>
    <script>
        
        const alert = document.querySelector("#alert");
        const loading = document.querySelector("#loading");
        const content = document.querySelector("#content");

        const template = `<div class="row">
                <div class="col-12">
                    <h3 class="text-center pt-3">O e-mail abaixo está descadastrado!</h3>
                    <div class="col-12 col-lg-8  mx-auto">
                        <span class="h5 p-4 mx-auto d-block rounded bg-white shadow text-center"><?php echo $email; ?></span>
                    </div>
                </div>
            </div>`;

        const showAlert = frase => {
            alert.innerText = frase
            alert.classList.remove('d-none');
        }

        const showLoading = (status = true) => {
            if(status)
                loading.classList.remove('d-none');
            else
                loading.classList.add('d-none');
        }

        document.querySelector("#salvar").addEventListener("click", e => {
            const motivos = []
            for (let i = 1; i < 5; i++) {
                const element = document.querySelector("#notforme"+i);
                if(element.checked) motivos.push(element.value)
            }
            if(motivos.length == 0) {
                showAlert("Por favor, escolha pelo menos 1 motivo para descadastrar o e-mail")
                return;
            }
            showLoading()
            fetch("<?php _url("/api/mailing/descadastrar_email"); ?>", {
                method: "POST",
                body: JSON.stringify({
                    motivos:motivos,
                    email:"<?php echo $email; ?>",
                    hash: "<?php echo $hash; ?>"
                })
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(js) {
                showLoading(false)
                if(js.code !== 200){
                    showAlert(js.response)
                } else {
                    content.innerHTML = template
                }
                
                console.log(js);
            });

            alert.classList.add('d-none');
            
        })

        

    </script>
    <style>
        /* Absolute Center Spinner */
        .loading {
            position: fixed;
            z-index: 999;
            height: 2em;
            width: 2em;
            overflow: show;
            margin: auto;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
        }

        /* Transparent Overlay */
        .loading:before {
            content: '';
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0, .8));
            background: -webkit-radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0,.8));
        }

        /* :not(:required) hides these rules from IE9 and below */
        .loading:not(:required) {
            /* hide "loading..." text */
            font: 0/0 a;
            color: transparent;
            text-shadow: none;
            background-color: transparent;
            border: 0;
        }

        .loading:not(:required):after {
            content: '';
            display: block;
            font-size: 10px;
            width: 1em;
            height: 1em;
            margin-top: -0.5em;
            -webkit-animation: spinner 150ms infinite linear;
            -moz-animation: spinner 150ms infinite linear;
            -ms-animation: spinner 150ms infinite linear;
            -o-animation: spinner 150ms infinite linear;
            animation: spinner 150ms infinite linear;
            border-radius: 0.5em;
            -webkit-box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
            box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
        }

        /* Animation */

        @-webkit-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @-moz-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @-o-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
    </style>
</body>
</html>