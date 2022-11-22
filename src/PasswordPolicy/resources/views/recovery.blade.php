
<html>

<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <head>
        <title>Recuperação de Senha</title>
    </head>
    <body>
    <div class="card">
        <div class="card-header">
            <h2>
                Recuperação de Senha

                <i class="fa fa-key"></i>
            </h2>
        </div>

        <div class="card-body">

            @if($page == 'recovery')
                @if(!$token_expired)
                    <form method="POST" action="{{ url('user/recoveryPolicy/' . $token) }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right center">Senha:</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" placeholder="Senha" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right" style="text-align:center">Confirme a Senha:</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirmação de senha" required>
                            </div>
                        </div>

                        <div class="center">
                            <div >
                            A senha precisa conter pelo menos:
                            </br>
                            <div class="row">
                            </div>
                            @if(isset($passwordRules['minLength']))
                                <span class="required"> * </span>
                                {{$passwordRules['minLength']}} caracteres.
                                </br>
                            @endif
                            @if(isset($passwordRules['upperCase']))
                                <span class="required"> * </span>
                                Caracteres minúsculos.
                                </br>
                            @endif
                            @if(isset($passwordRules['upperCase']))
                                <span class="required"> * </span>
                                Caracteres maiúsculos.
                                </br>
                            @endif
                            @if(isset($passwordRules['digits']))
                                <span class="required"> * </span>
                                Números.
                                </br>
                            @endif
                            @if(isset($passwordRules['specialCharacters']))
                                <span class="required"> * </span>
                                Símbolos (# $ % & ').
                            @endif
                            </div>
                        </div>
                        </br>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-3">
                                <button type="submit" class="btn btn-primary">
                                    Trocar a Senha
                                </button>
                            </div>
                        </div>

                        @if(isset($validate))
                            <span style="color:red">Atenção: {{$validate}}!</span>
                        @endif
                    </form>
                @else
                    <p class="text-center" style="font-weight:bold;font-size:20px;color:#C44D58;">O token informado já foi utilizado.</p>
                @endif
            @elseif($page == 'failed')
                <p class="text-center" style="font-weight:bold;font-size:20px;color:#C44D58;">Ops, as senhas informadas não conferem</p>
            @else
                <p class="text-center" style="font-weight:bold;font-size:20px;color:forestgreen;">OK! A senha foi alterada com sucesso.</p>
            @endif
        </div>

    </div>
    </body>

<style>
    @import url('https://fonts.googleapis.com/css?family=Raleway|Roboto');

    .card{
        width:485px;
        top:50%;
        left:50%;
        color:#444;
        transform:translate(-50%, -50%);
        position:absolute;
        vertical-align: top;
        border-radius:3px;
        background:#FFFFFF;
        font-family:'Raleway', sans-serif;
        box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16), 0 2px 10px 0 rgba(0,0,0,0.12);
    }
    .card-header {
        padding: 14px;
        background-color: #2ea2cd !important;
        color: #000;
    }
    .card-header h2{
        font-size:22px;
        text-align:center;
        margin:6px 0 6px -2px !important;
        padding:0;
    }
    .card-body{
        padding:22px;
    }
    .card-body .form-control{
        padding:10px;
        width:100%;
        margin-top:4px;
        margin-bottom:15px;
        border:1px solid #D0D0D0;
        font-family:'Raleway', sans-serif;
    }
    .card-body button{
        padding:12px;
        width:100%;
        cursor:pointer;
        margin-top:4px;
        margin-bottom:15px;
        border:none;
        border-radius:2px;
        font-size:15px;
        color:#000;
        background-color:#2ea2cd !important;
        font-family:'Raleway', sans-serif;
    }
    .card-body button:hover{
        background-color:#2ea2cd;
    }

    .text-center{
        margin:10px 0 20px -10px;
        text-align:center;
    }

    .required{
        color:red; 
        font-weight:bold    
    }

    .center{
        display: flex; 
        justify-content: center
    }

    .row>*{
        padding-right:0px
    }

</style>

</html>


