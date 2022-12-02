# Passo 1: 
Para instalar primeiro rode o seguinte comando:

```php
composer require innovareti/password-policy
```
# Passo 2: 
Dentro do projeto, no arquivo config/app.php insira o seguinte provider no array de providers:

```php
    'providers' => [
        /*
         * Laravel Framework Service Providers...
         */
        PasswordPolicy\Providers\Laravel\PasswordPolicyServiceProvider::class,
    
        ...
```
E depois rode o comando:

```php
php artisan passwordpolicy:install
```

Esse comando criará a tabela de politica de senha no projeto e forçará a troca de senha para usuários que possuem a senha "password", primeiro trocando a senha para uma aleatória e mandando um email para redefinição no endereço do usuário.

# Passo 3:
Em seguida, adicione no arquivo app/Providers/AppServiceProvider.php, dentro da função boot o seguinte código:

```php
use PasswordPolicy;
use App\Models\User;
use PasswordPolicy\Observers\UserObserver;
use PasswordPolicy\PolicyBuilder; 
    public function boot()
    {
        PasswordPolicy::define('default', function (PolicyBuilder $builder) {
            $builder->defaultRules();
        });    
        User::observe(UserObserver::class);
    }
```
# Passo 4:
Agora para utilizar a validação de senha existente no pacote, vá na classe Request desejada (Ex: UserRequest) e insira a regra "password" nas regras da senha:
```php
    public function rules()
    {
        $rules = [];
        $rules = [
             'name' => 'required',
             'email' => 'required|email|unique:users,email,' . request()->id,
             'cpf' => 'required|unique:users,cpf,' . request()->id,
             'password' => 'password' <--
        ];
        return $rules;
    }
```

Além disso, na função messages da Request você pode adicionar a mensagem de retorno automatizada do pacote:

```php
use PasswordPolicy\Policy;
    public function messages()
    {
        return [
            'required' => ':attribute é obrigatório',
            'unique' => ':attribute informado já está sendo utilizado',
            'email' => 'O e-mail deve ser válido',
            'password' => Policy::validationMessage() //<--
        ];
    }
```

Essa mensagem retornara as regras de acordo com o que está definido dentro do pacote caso o usuário insira a senha incorreta.

# Passo 5:
Na utilização da funcionalidade de forçar a troca de senha dos usuários a cada x tempo, é necessário adicionar o seguinte código no login do projeto:

```php
use PasswordPolicy\Policy;
    /**
     * Method to authenticate User
     */
    public function auth(AuthRequest $request)
    {
    ...
    
    if(Policy::isPasswordExpired($user->id))
         return response()->json('Sua senha expirou! Um e-mail foi enviado no endereço '. $request->only(['email'])['email']. ' para redefinição da senha.', 401);  
    ...
```

E no .ENV as seguintes variáveis:

```php
PASSWORD_POLICY_ACTIVE=true
PASSWORD_POLICY_DAYS=90
```
A variável PASSWORD_POLICY_ACTIVE estando "true" forçará a troca de senha dos usuários a cada x dias. Esses dias são definidos pela variável PASSWORD_POLICY_DAYS.

# Notas:
1 - Caso as variáveis acima não estejam no .ENV, o pacote usa como padrão 90 dias e também não deixa essa troca de senha forçada ativa. 

2 - A função "IsPasswordExpired" verificará de acordo com o ID do usuário passado se a senha deste está expirada ou não. Ela irá analisar a data da ultima vez que a senha do usuário foi atualizada. Essa data está contida na tabela que foi criada no comando de instalação (user_password_policies) e é atualizada atráves de um Observer (UserObserver) no pacote.

 
