Passo 1: 
Para instalar primeiro rode o seguinte comando:

1
composer require innovareti/password-policy
E depois:

1
php artisan passwordpolicy:install
Esse comando criará a tabela de politica de senha no projeto e forçará a troca de senha para usuários que possuem a senha "password", primeiro trocando a senha para uma aleatória e mandando um email para redefinição no endereço do usuário.

Passo 2: 
Dentro do projeto, no arquivo config/app.php insira o seguinte provider no array de providers:

1
    'providers' => [
2
​
3
        /*
4
         * Laravel Framework Service Providers...
5
         */
6
        PasswordPolicy\Providers\Laravel\PasswordPolicyServiceProvider::class,
7
      
8
        ...
Passo 3:
Em seguida, adicione no arquivo app/Providers/AppServiceProvider.php, dentro da função boot o seguinte código:

1
use PasswordPolicy;
2
use App\Models\User;
3
use PasswordPolicy\Observers\UserObserver;
4
use PasswordPolicy\PolicyBuilder; 
5
​
6
    public function boot()
7
    {
8
        PasswordPolicy::define('default', function (PolicyBuilder $builder) {
9
            $builder->defaultRules();
10
        });    
11
​
12
        User::observe(UserObserver::class);
13
    }
Passo 4:
Agora para utilizar a validação de senha existente no pacote, vá na classe Request desejada (Ex: UserRequest) e insira a regra "password" nas regras da senha:

1
    public function rules()
2
    {
3
        $rules = [];
4
        $rules = [
5
             'name' => 'required',
6
             'email' => 'required|email|unique:users,email,' . request()->id,
7
             'cpf' => 'required|unique:users,cpf,' . request()->id,
8
             'password' => 'password' <--
9
        ];
10
        return $rules;
11
    }
Além disso, na função messages da Request você pode adicionar a mensagem de retorno automatizada do pacote:

1
use PasswordPolicy\Policy;
2
​
3
    public function messages()
4
    {
5
        return [
6
            'required' => ':attribute é obrigatório',
7
            'unique' => ':attribute informado já está sendo utilizado',
8
            'email' => 'O e-mail deve ser válido',
9
            'password' => Policy::validationMessage() <--
10
        ];
11
    }
Essa mensagem retornara as regras de acordo com o que está definido dentro do pacote caso o usuário insira a senha incorreta.

Passo 5:
Na utilização da funcionalidade de forçar a troca de senha dos usuários a cada x tempo, é necessário adicionar o seguinte código no login do projeto:

1
use PasswordPolicy\Policy;
2
    /**
3
     * Method to authenticate User
4
     */
5
    public function auth(AuthRequest $request)
6
    {
7
    ...
8
      
9
    if(Policy::isPasswordExpired($user->id))
10
         return response()->json('Sua senha expirou! Um e-mail foi enviado no endereço '. $request->only(['email'])['email']. ' para redefinição da senha.', 401);
11
    
12
    ...
 

E no .ENV as seguintes variáveis:

1
PASSWORD_POLICY_ACTIVE=true
2
PASSWORD_POLICY_DAYS=90
A variável PASSWORD_POLICY_ACTIVE estando "true" forçará a troca de senha dos usuários a cada x dias. Esses dias são definidos pela variável PASSWORD_POLICY_DAYS.

Notas:
1 - Caso as variáveis acima não estejam no .ENV, o pacote usa como padrão 90 dias e também não deixa essa troca de senha forçada ativa. 

2 - A função "IsPasswordExpired" verificará de acordo com o ID do usuário passado se a senha deste está expirada ou não. Ela irá analisar a data da ultima vez que a senha do usuário foi atualizada. Essa data está contida na tabela que foi criada no comando de instalação (user_password_policies) e é atualizada atráves de um Observer (UserObserver) no pacote.

 
