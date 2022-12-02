<?php namespace PasswordPolicy\Providers\Laravel;

use PasswordPolicy\PolicyBuilder;
use PasswordPolicy\PolicyManager;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use PasswordPolicy\Providers\Laravel\Facade;
use PasswordPolicy\Console\InstallPasswordPolicyPackage;

/**
 * Class PasswordPolicyServiceProvider
 *
 * @package PasswordPolicy\Providers\Laravel
 */
class PasswordPolicyServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerManager();
        $this->registerBuilder();
        $this->registerFacade();
        $this->defineDefaultPolicy();
    }

    /**
     * Boot the service provider
     *
     * @return void
     */
    public function boot()
    {
        $this->configureValidationRule();
        
        $this->loadMigrationsFrom(__DIR__ . '/../../../../database/migrations');        
        
        $this->commands([
            InstallPasswordPolicyPackage::class,
        ]);

        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'passwordpolicy');   

        $this->loadRoutesFrom(__DIR__.'/../../../../routes/web.php');
    }

    /**
     * Register the policy manager within the Laravel container
     *
     * @return void
     */
    protected function registerManager()
    {
        $this->app->singleton(PolicyManager::class);
    }

    /**
     * Register policy builder
     *
     * @return void
     */
    protected function registerBuilder()
    {
        $this->app->bind(PolicyBuilder::class);
    }

    /**
     * Configure custom Laravel validation rule
     *
     * @return void
     */
    protected function configureValidationRule()
    {
        $this->app['validator']->extend('password_default_policy', PasswordValidator::class . '@validate');
    }

    /**
     * Register password policy facade
     *
     * @return void
     */
    protected function registerFacade()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('PasswordPolicy', Facade::class);
    }

    /**
     * Define the default password policy
     *
     * @return void
     */
    protected function defineDefaultPolicy()
    {
        $defaultPolicy = $this->defaultPolicy($this->app->make(PolicyBuilder::class));

        if ($defaultPolicy instanceof PolicyBuilder) {
            $defaultPolicy = $defaultPolicy->getPolicy();
        }

        $this->app->make(PolicyManager::class)->define('default', $defaultPolicy);
    }

    /**
     * Build the default policy instance
     *
     * @param PolicyBuilder $builder
     *
     * @return \PasswordPolicy\Policy
     */
    protected function defaultPolicy(PolicyBuilder $builder)
    {
        return $builder->getPolicy();
    }
}
