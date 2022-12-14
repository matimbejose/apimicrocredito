<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /** 
     * The policy mappings for the application. 
     * 
     * @var
     * array 
     */
    protected $policies = [
        'Modules\Base\Entities\Role' => 'Modules\Base\Policies\RolePolicy',
        'Modules\Base\Entities\User' => 'Modules\Base\Policies\UserPolicy',
        'Modules\Customers\Entities\Customer' => 'Modules\Customers\Policies\CustomerPolicy',
        'Modules\Managers\Entities\Manager' => 'Modules\Managers\Policies\ManagerPolicy',
        'Modules\Loans\Entities\CreditType' => 'Modules\Loans\Policies\CreditTypePolicy',
        'Modules\Loans\Entities\Loan' => 'Modules\Loans\Policies\LoanPolicy',
        'Modules\Loans\Entities\LoanTransaction' => 'Modules\Loans\Policies\LoanTransactionPolicy',
        'Modules\Business\Entities\Business' => 'Modules\Business\Policies\BusinessPolicy',
    ];
    /** 
     * Register any authentication / authorization services. 
     * 
     * @return void 
     */
    public function boot()
    {
        $this->registerPolicies();

        if (!$this->app->routesAreCached()) {
            Passport::routes();
            Passport::tokensExpireIn(now()->addDay());
            Passport::refreshTokensExpireIn(now()->addDay());
        }
    }
}