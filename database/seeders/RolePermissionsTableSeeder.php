<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\Base\Entities\Permission;

use Modules\Base\Entities\Role;

use Modules\Base\Entities\User;

use Modules\Business\Entities\Business;

use Modules\Business\Entities\Currency;
use Modules\Business\Entities\Document;

class RolePermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");

        $permissions = [
            ['name' => 'dashboard-view', 'name_to_show' => 'Visualizar dashboard', 'model_name' => 'dashboard'],

            ['name' => 'setting-view', 'name_to_show' => 'Visualizar configurações', 'model_name' => 'settings'],
            ['name' => 'setting-edit', 'name_to_show' => 'Editar configurações', 'model_name' => 'settings'],

            ['name' => 'role-view', 'name_to_show' => 'Listar Funções', 'model_name' => 'role'],
            ['name' => 'role-create', 'name_to_show' => 'Criar Funções', 'model_name' => 'role'],
            ['name' => 'role-edit', 'name_to_show' => 'Editar Funções', 'model_name' => 'role'],
            ['name' => 'role-delete', 'name_to_show' => 'Apagar Funções', 'model_name' => 'role'],

            ['name' => 'user-view', 'name_to_show' => 'Listar Utilizador', 'model_name' => 'user'],
            ['name' => 'user-create', 'name_to_show' => 'Criar Utilizador', 'model_name' => 'user'],
            ['name' => 'user-edit', 'name_to_show' => 'Editar Utilizador', 'model_name' => 'user'],
            ['name' => 'user-delete', 'name_to_show' => 'Apagar Utilizador', 'model_name' => 'user'],

            ['name' => 'business-view', 'name_to_show' => 'Listar Sucursal', 'model_name' => 'business'],
            ['name' => 'business-create', 'name_to_show' => 'Criar Sucursal', 'model_name' => 'business'],
            ['name' => 'business-edit', 'name_to_show' => 'Editar Sucursal', 'model_name' => 'business'],
            ['name' => 'business-delete', 'name_to_show' => 'Apagar Sucursal', 'model_name' => 'business'],

            ['name' => 'customer-view', 'name_to_show' => 'Listar membros', 'model_name' => 'customer'],
            ['name' => 'customer-create', 'name_to_show' => 'Criar membros', 'model_name' => 'customer'],
            ['name' => 'customer-edit', 'name_to_show' => 'Editar membros', 'model_name' => 'customer'],
            ['name' => 'customer-delete', 'name_to_show' => 'Apagar membros', 'model_name' => 'customer'],

            ['name' => 'loan_transaction-view', 'name_to_show' => 'Listar Transações', 'model_name' => 'loan_transaction'],
            ['name' => 'loan_transaction-create', 'name_to_show' => 'Criar Transações', 'model_name' => 'loan_transaction'],
            ['name' => 'loan_transaction-edit', 'name_to_show' => 'Editar Transações', 'model_name' => 'loan_transaction'],
            ['name' => 'loan_transaction-delete', 'name_to_show' => 'Apagar Transações', 'model_name' => 'loan_transaction'],

            ['name' => 'loan-view', 'name_to_show' => 'Listar empréstimos', 'model_name' => 'loan'],
            ['name' => 'loan-create', 'name_to_show' => 'Criar empréstimos', 'model_name' => 'loan'],
            ['name' => 'loan-edit', 'name_to_show' => 'Editar empréstimos', 'model_name' => 'loan'],
            ['name' => 'loan-delete', 'name_to_show' => 'Apagar empréstimos', 'model_name' => 'loan'],
            ['name' => 'loan-simulate', 'name_to_show' => 'Simular empréstimos', 'model_name' => 'loan'],
            ['name' => 'loan-disburse', 'name_to_show' => 'Desembolsar empréstimos', 'model_name' => 'loan'],
            ['name' => 'loan-restruct', 'name_to_show' => 'Restruturar empréstimos', 'model_name' => 'loan'],
            ['name' => 'loan-approve', 'name_to_show' => 'Aprovar empréstimos', 'model_name' => 'loan'],
            ['name' => 'loan-close', 'name_to_show' => 'Abater empréstimos', 'model_name' => 'loan'],

            ['name' => 'account-view', 'name_to_show' => 'Listar Conta', 'model_name' => 'account'],
            ['name' => 'account-create', 'name_to_show' => 'Criar Conta', 'model_name' => 'account'],
            ['name' => 'account-edit', 'name_to_show' => 'Editar Conta', 'model_name' => 'account'],
            ['name' => 'account-delete', 'name_to_show' => 'Apagar Conta', 'model_name' => 'account'],

            ['name' => 'manager-view', 'name_to_show' => 'Listar gestores', 'model_name' => 'manager'],
            ['name' => 'manager-create', 'name_to_show' => 'Criar gestores', 'model_name' => 'manager'],
            ['name' => 'manager-edit', 'name_to_show' => 'Editar gestores', 'model_name' => 'manager'],
            ['name' => 'manager-delete', 'name_to_show' => 'Apagar gestores', 'model_name' => 'manager'],

            ['name' => 'warranty-view', 'name_to_show' => 'Listar garantias', 'model_name' => 'warranty'],
            ['name' => 'warranty-create', 'name_to_show' => 'Criar garantias', 'model_name' => 'warranty'],
            ['name' => 'warranty-edit', 'name_to_show' => 'Editar garantias', 'model_name' => 'warranty'],
            ['name' => 'warranty-delete', 'name_to_show' => 'Apagar garantias', 'model_name' => 'warranty'],

            ['name' => 'credit_type-view', 'name_to_show' => 'Listar tipos de crédito', 'model_name' => 'credit_type'],
            ['name' => 'credit_type-create', 'name_to_show' => 'Criar tipos de crédito', 'model_name' => 'credit_type'],
            ['name' => 'credit_type-edit', 'name_to_show' => 'Editar tipos de crédito', 'model_name' => 'credit_type'],
            ['name' => 'credit_type-delete', 'name_to_show' => 'Apagar tipos de crédito', 'model_name' => 'credit_type'],

            ['name' => 'document-view', 'name_to_show' => 'Listar contractos', 'model_name' => 'documents'],
            ['name' => 'document-create', 'name_to_show' => 'Criar contractos', 'model_name' => 'documents'],
            ['name' => 'document-edit', 'name_to_show' => 'Editar contractos', 'model_name' => 'documents'],
            ['name' => 'document-delete', 'name_to_show' => 'Apagar contractos', 'model_name' => 'documents'],

        ];



        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        $permissions = Permission::all();

        $role = Role::create(['name' => 'SA', 'guard_name' => 'api']);


        foreach (Permission::all() as $permission) {
            $roles = Role::where('id', $role->id)->pluck('id');
            $permission->roles()->attach($roles);
        }

        $user = User::create([
            "username" => "admin",
            "surname" => "TTM",
            "email" => "admin@admin.com",
            "password" => bcrypt('admin2k22'),
            "first_name" => "Glu",
            "type" => "sa"
        ]);

        $user->createToken('simplexApp')->accessToken;

        $currency = Currency::create([
            'country' => 'Mozambique',
            'currency' => 'MT',
            'symbol' => 'MT',
            'code' => 'MT',
            'thousand_separator' => ' ',
            'decimal_separator' => '.',
        ]);

        $business = Business::create([
            'business_name' => 'TTMInc',
            'phone' => '8745362672',
            'nuit' => '129988172',
            'owner_id' => '110011882800B',
            'city' => 'Matola',
            'address' => 'Maputo, Coop',
            'email' => 'info@truetech.co.mz',
            'currency_id' => $currency->id,
            'province' => 'Maputo',
            'start_date' => date('Y-m-d'),
            'billing_type' => 'fixed',
            'charges_fee' => 5,
            'acc_clients' => '4.1.1',
            'acc_charges' => '7.6.9.9.0.0.1',
            'acc_advances' => '4.1.9',
            'acc_increases' => '4.9.1.1',
            'acc_finantial_looses' => '6.9.8',
            'acc_finantial_incomes' => '7.8.1.2',
        ]);

        $users = User::find($user->id);
        $users->assignBusiness(Business::find($business->id));

        $users->assignRole(Role::find($role->id));

        // $permissions = Permission::pluck('id','id')->all();

        Document::create([
            'description' => 'Contracto Padrão',
            'created_by' => $user->id,
            'content' => '<p>CONTRACTO DE FINANCIAMENTO</p><p>I – CLÁUSULAS PARTICULARES</p><p>São partes no presente contrato:</p><p>Primeira: CAPITAL MICROCREDITO, E. I., certificada pela Conservatória de Registo de Entidades legais com o nr. 101776530, sita no Bairro de Laulane, Rua da Beira, nr. 1108, Cidade de Maputo, doravante designada por CREDORA, representada pela senhora Penaldina Olávio Agostinho Massangaie, na qualidade de Diretora Geral.</p><p><br></p><p>Segundo: {{nome}} de {{idade}} anos de idade, Moçambicano (a) Residente na Cidade de {{cidade}} Bairro/Avenida {{endereco}} Portador do Bilhete de Identidade nr. {{id}} emitido pela Direção Nacional de Identificação Civil, titular do NUIT {{nuit}}, doravante designado por DEVEDOR.</p><p><br></p><p>1. CONTRACTO Nr.</p><p><br></p><p>2. FINALIDADE: O presente contrato tem por objecto a concessão de um empréstimo pela CREDORA ao DEVEDOR, com a finalidade de {{obejctive}}.</p><p><br></p><p>3. MONTANTE: A CREDORA concede ao DEVEDOR um empréstimo no montante de {{total}}, o qual o DEVEDOR se confessa nessa qualidade e fica obrigado a restituir à CREDORA.</p><p><br></p><p>4. MODALIDADE: Reembolso em Rendas Fixas.</p><p><br></p><p>5. PRAZO: O presente empréstimo será concedido pelo período de {{maturidade}} meses, contados a partir da data em que se celebrar o presente contracto, findo o qual o capital concedido e respectivos juros deverão estar totalmente amortizados.</p><p><br></p><p><br></p><p>A CAPITAL MICROCRÉDITO, E.I., CONCEDE AO CLIENTE, OU SEJA, A PESSOA QUE SE BENEFICIA DO CRÉDITO E QUE DELA SE CONFESSA DEVEDORA UM FINANCIAMENTO QUE SE REGERÁ PELAS SEGUINTES CLÁUSULAS PARTICULARES E PELAS CONDIÇÕES GERAIS E ESPECIAIS ADIANTE PREVISTAS, QUE AS PARTES DECLARAM ACEITAR PARA TODOS EFEITOS LEGAIS.</p><p><br></p><p>II – CONDIÇÕES GERAIS</p><p><br></p><p>Cláusula 1ª (Entrada em vigor)</p><p>O presente contrato passa a vigorar a partir da assinatura do mesmo.</p><p><br></p><p>Cláusula 2ª (Taxa de Juro)</p><p>Para o efeito deste empréstimo, a taxa de juro a ser aplicada será de {{taxa}} % a.m. (trinta por cento, aplicação mensal).</p><p><br></p><p>&nbsp;&nbsp;Clausula 3ª (Contagem de Juros)</p><p>Serão contados e debitados juros sobre o capital em divida, verificando-se o primeiro vencimento, após a assinatura do presente contracto.</p><p><br></p><p>Cláusula 4ª (Mora)</p><p>No caso do DEVEDOR efectuar quaisquer das prestações a que está obrigado, após o prazo estabelecido sujeita-se a pagar uma multa que corresponde a taxa de juros de mora de {{mora}}% (Um por Cento) ao dia, sobre o capital total em mora incluindo juros não pagos.</p><p><br></p><p><br></p><p>Cláusula 5ª (Obrigações do CREDOR)</p><p>A CREDORA obriga-se a conceder o crédito nos termos e condições devidamente fixadas no presente contracto num prazo de 48 horas úteis, após a celebração do mesmo.</p><p><br></p><p><br></p><p><br></p><p>Cláusula 6ª (Obrigações do DEVEDOR)</p><p>O DEVEDOR obriga-se a:</p><p>(i)&nbsp;&nbsp;&nbsp;Pagar integralmente as prestações devidas, até ao cumprimento total das obrigações a que se encontra adstrito nos termos do presente contracto.</p><p>(ii)&nbsp;&nbsp;&nbsp;A presentar à CREDORA os comprovativos de pagamento das prestações num prazo não superior a 24 horas após efetivação do pagamento.&nbsp;</p><p><br></p><p>Cláusula 7ª (Incumprimento)</p><p>O não cumprimento pelo DEVEDOR de quaisquer obrigações assumidos neste contrato, dará à CREDORA o direito de considerar imediatamente vencido o empréstimo concedido, e posterior exigibilidade do pagamento da totalidade da divida, incluindo juros contractuais, juros de mora e outras obrigações emergentes do contracto ora celebrado.</p><p><br></p><p><br></p><p>III – CONDIÇÕES ESPECIAIS</p><p>Cláusula 8ª (Amortização)</p><p>O empréstimo concedido é amortizado durante {{maturidade}} meses, com prestação de {{total_mensal}} a depositar na conta bancária nr. 1038064241002 do Standard Bank (NIB – 0003 010308064241002 37) em nome de Penaldina Olávio Agostinho Massangaie ou pelo m-Pesa (84 115 2534), estando incluso neste montante o capital e o juro correspondente.</p><p><br></p><p>Cláusula 9ª (Despesas)</p><p>Sobre o montante do crédito concedido incide uma comissão de 5% (cinco por cento) de despesas administrativas, relativas à organização do processo, no valor de {{encargos}},00Mt. A ser cobrado no acto da assinatura do contracto ou por retenção na fonte, na altura do desembolso do financiamento.</p><p><br></p><p>Cláusula 10ª (Garantias)</p><p>(i)&nbsp;&nbsp;&nbsp;Para assegurar o reembolso integral do capital, juros e despesas em virtude do empréstimo concedido, a CREDORA constituirá como garantias a seu favor, os seguintes bens: {{garantias}} e os respectivos comprovativos da propriedade dos mesmos pelo DEVEDOR, constantes da declaração de garantia patrimonial anexa a este contracto, assim como outras que venham a ser constituídas sempre que mostrar-se necessário.</p><p>(ii)&nbsp;&nbsp;&nbsp;Notificado, o DEVEDOR obriga-se nos termos do presente contracto, a entrega voluntária dos bens constituídos como garantia e sua substituição no caso de esgotamento ou fraude.</p><p><br></p><p>Cláusula 11ª (Alteração das cláusulas contractuais)</p><p>A CREDORA reserva-se ao direito de alterar unilateralmente algumas cláusulas do presente contracto, havendo necessidade, mas notificando antes o devedor sobre a pretensão, ou ainda nos casos de falência ou insolvência (comprovada judicialmente) ou de falta de cumprimento pelo DEVEDOR de qualquer das obrigações assumidas neste contracto, bem como a penhora ou qualquer intervenção judicial que possam afectar as garantias enunciadas no presente contracto.</p><p><br></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cláusula 12ª (Resolução de conflitos)</p><p>Os conflitos resultantes da interpretação e /ou execução do presente contracto serão resolvidos por consenso entre as partes e, prevalecendo o litígio, pelo Tribunal competente.</p><p>E por estarem de acordo com todas as disposições nelas consignadas, as partes assinam este instrumento particular.</p><p><br></p><p>Maputo aos,______ de ___________de________</p><p><br></p><p>O presente contracto foi feito em 2 (dois) exemplares, de igual fé, teor e valor, destinando-se um à CREDORA e o duplicado ao DEVEDOR.</p><p><br></p><p>A CREDORA</p><p><br></p><p>Penaldina Olávio Agostinho Massangaie</p><p><br></p><p>O DEVEDOR</p><p><br></p><p>(Assinar como assinou no BI (Bilhete de Identidade)</p><p><br></p><p>O Avalista</p><p><br></p><p>(Assinar como assinou no BI (Bilhete de Identidade)</p><p><br></p><p>O gestor de Credito</p>'
        ]);
    }
}