
<html>
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
                            <label for="password" class="col-md-4 col-form-label text-md-right">Senha</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" placeholder="password" required>
                            </div>
                        </div>//como mandar info atraves de blade pro controller

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirme a Senha</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="password confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" style="background-color: #ffdf48" class="btn btn-primary">
                                    Trocar a Senha
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <p class="text-center" style="margin-top:45px;font-weight:bold;font-size:20px;color:#C44D58;">O token informado já foi utilizado.</p>
                @endif
            @elseif($page == 'failed')
                <p class="text-center" style="margin-top:45px;font-weight:bold;font-size:20px;color:#C44D58;">Ops, as senhas informadas não conferem</p>
            @else
                <p class="text-center" style="margin-top:45px;font-weight:bold;font-size:20px;color:forestgreen;">OK! A senha foi alterada com sucesso.</p>
            @endif
        </div>

    </div>
    </body>
</html>


