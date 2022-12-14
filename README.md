usefull commads 

php artisan key:generate  --generate keys
php artisan module:make-seed permissions_seed Access  (Make a seed specifing the Module as well)
php artisan passport:install   (Run after cloning the project)
php artisan passport:keys      (Generate passport keys)
php artisan module:make-request CreateRoleRequest Access     (Create Request)
php artisan module:enable Access   (Disabling a module sometimes disables all of the modules, this commad can allow you to enable them)
php artisan module:migrate-reset Business   Migrate:fresh
php artisan db:seed --class=Modules\Accounting\Database\Seeders\AccountsDatabaseSeeder
php artisan db:seed --class=RolePermissionsTableSeeder
php artisan migrate:fresh
php artisan passport:install
php artisan db:seed --class="Modules\Accounting\Database\Seeders\AccountsDatabaseSeeder"

####################################### Multi tanancy ###############################
php artisan migrate --path=database/migrations/landlord --database=landlord   (To seeda and migrate landlord)
php artisan tenants:artisan "migrate --database=tenant1 --seed"               (To Seed and migrate Tenants)
php artisan tenants:artisan "migrate:fresh --database=tenant --seed"          (To seed and fresh all tenants)
php artisan tenants:artisan "migrate --database=tenant --seed" --tenant=3     (To Migrate and seed specific tenant)
php artisan tenants:artisan "migrate:fresh --database=tenant --seed" --tenant=3     (To seed, migrate and fresh specific tenant)

#####################################################################################

php artisan tenants:artisan "migrate --database=tenant1 --seed --class='Modules\Accounting\Database\Seeders\AccountsDatabaseSeeder'"
removing a module
1. php artisan module:disable Microcredit
2. php artisan cache:clear
3. remove the dir

php artisan module:migrate Blog
php artisan module:make-migration create_posts_table Blog

Directory app/providers/AppServiceProvider.php
Schema::defaultStringLength(191);
use Illuminate\Support\Facades\Schema;
 (Fix lenght error:  Syntax error or access violation: 1071 Specified key was too long; max key length is 1000 bytes)

Errors Manual CODES: 
 x0001 - Database connection;

Duvidas
- No caso em que o devedor leva atrasa ate a proxima prestacao, o juros de mora eh aplicado sobre uma prestacao em atraso
apenas ou outra atrasa aplica-se sobre todas

1% do V.P * Nr de dias que passaram


Diariamente o sistema ira verificar se temos alguma prestacao em atraso, comparando a  data actual com a data prevista
se tiver vai somando o saldo em mora

if data prevista < data hoje && effective  payment == null
  add fees

* * * * * php /path/to/artisan schedule:run 1>> /dev/null 2>&1
OR
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1

Stuffs to do
- edit and delete deposits

Algoritimo de reembolsos
Casos
- O devedor faz pagamento em dia
- O devedor tem prestacao em atraso
- O devedor tem dinheiro a menos
- O devedor tem dinheiro a mais
- O devedor quer pagar de uma vez

Questoes
- O sistema pode aceitar pagamento inferiores ao combinado?
- O sistema pode aceitar pagamentos unicos?
- Como proceder diante de cada uma das situacoes mencionada?

proposta de procedimento

quando o devedor tem um valor inferior a prestacao + taxa + mora
simplesmente vamos depositar o valor na conta da pessoa, dai quandoo
o cliente depositar outra parcela vamos juntando ate que seja suficiente
para cobrir a prestacao

quando o devedor tem um valor superior, quitamos a prestacao e guardamos
o resto em sua conta, no dia previsto para a proxima prestacao faremos 
uma verificacao, se o saldo for suficiente faremos o pagamento

estas propostas nos permitem aceitar varias amortizacoes, no caso em que  
o cliente nao consegue cumprir as parcelas
estas regras de negocio considero mais adequadas, porem cada credor pode
ter sua propria regra de negocio