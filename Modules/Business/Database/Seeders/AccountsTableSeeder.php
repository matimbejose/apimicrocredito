<?php

namespace Modules\Business\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\Business\Entities\ClassAccount;
use Modules\Business\Entities\Account;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $account_categories = [
            ['name' => 'MEIOS CIRCULANTES FINANCEIROS', 'class_id' => 1],
            ['name' => 'INVENTÁRIOS E ACTIVOS BIOLÓGICOS', 'class_id' => 2],
            ['name' => 'INVESTIMENTOS DE CAPITAL', 'class_id' => 3],
            ['name' => 'CONTAS A RECEBER, CONTAS A PAGAR, ACRÉSCIMOS E DIFERIMENTOS', 'class_id' => 4],
            ['name' => 'CAPITAL PRÓPRIO', 'class_id' => 5],
            ['name' => 'GASTOS E PERDAS', 'class_id' => 6],
            ['name' => 'RENDIMENTOS E GANHOS', 'class_id' => 7],
            ['name' => 'RESULTADOS', 'class_id' => 8]
            
        ];

        foreach ($account_categories as $acc_cat) {
            AccountClass::create($acc_cat);
        }


        $accounts = [
            # CLASSE 1 MEIOS FINANCEIROS
            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'active', 'name'=>'Caixa', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 11, 'class_id' => 1, 'parent_id' => null ],

            ['master_parent_id' => null, 'is_account' => 1, 'type' => 'active', 'name'=>'Caixa 1', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 111, 'class_id' => 1, 'parent_id' => 11 ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'active', 'name'=>'Bancos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 12, 'class_id' => 1, 'parent_id' => null ],

            ['master_parent_id' => 1.2, 'is_account' => 1, 'type' => 'active', 'name'=>'Depósitos a ordem', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 121, 'class_id' => 1, 'parent_id' => 12 ],
            ['master_parent_id' => 1.2, 'is_account' => 1, 'type' => 'active', 'name'=>'Depósitos com pré-aviso', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 122, 'class_id' => 1, 'parent_id' => 12 ],
            ['master_parent_id' => 1.2, 'is_account' => 1, 'type' => 'active', 'name'=>'Depósitos a prazo', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 123, 'class_id' => 1, 'parent_id' => 12 ],

            # CLASSE 2 INVENTÁRIOS E ACTIVOS BIOLÓGICOS

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'active', 'name'=>'Compras', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 21, 'class_id' => 2, 'parent_id' => null ],

            ['master_parent_id' => 2.1, 'is_account' => 1, 'type' => 'active', 'name'=>'Mercadorias', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 211, 'class_id' => 2, 'parent_id' => 21 ],
            ['master_parent_id' => 2.1, 'is_account' => 0, 'type' => 'active', 'name'=>'Matérias primas, auxiliares e materiais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 212, 'class_id' => 2, 'parent_id' => 21 ],

            ['master_parent_id' => 2.1, 'is_account' => 1, 'type' => 'active', 'name'=>'Matérias primas', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 2121, 'class_id' => 2, 'parent_id' => 212 ],
            ['master_parent_id' => 2.1, 'is_account' => 1, 'type' => 'active', 'name'=>'Matérias auxiliares', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 2122, 'class_id' => 2, 'parent_id' => 212 ],
            ['master_parent_id' => 2.1, 'is_account' => 0, 'type' => 'active', 'name'=>'Materias', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 2123, 'class_id' => 2, 'parent_id' => 212 ],


            ['master_parent_id' => 2.1, 'is_account' => 1, 'type' => 'active', 'name'=>'Combustíveis e lubrificantes', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 21231, 'class_id' => 2, 'parent_id' => 2123 ],
            ['master_parent_id' => 2.1, 'is_account' => 1, 'type' => 'active', 'name'=>'Embalagens comerciais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 21232, 'class_id' => 2, 'parent_id' => 2123 ],
            ['master_parent_id' => 2.1, 'is_account' => 1, 'type' => 'active', 'name'=>'Peças e sobressalentes', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 21233, 'class_id' => 2, 'parent_id' => 2123 ],
            ['master_parent_id' => 2.1, 'is_account' => 1, 'type' => 'active', 'name'=>'Materiais diversos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 21239, 'class_id' => 2, 'parent_id' => 2123 ],

            ['master_parent_id' => 2.1, 'is_account' => 1, 'type' => 'active', 'name'=>'Devoluções de compras', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 217, 'class_id' => 2, 'parent_id' => 21 ],
            ['master_parent_id' => 2.1, 'is_account' => 1, 'type' => 'active', 'name'=>'Descontos e abatimentos em compras', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 218, 'class_id' => 2, 'parent_id' => 21 ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'active', 'name'=>'Mercadorias', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 22, 'class_id' => 2, 'parent_id' => null ],

            ['master_parent_id' => 2.2, 'is_account' => 1, 'type' => 'active', 'name'=>'Mercadorias em trânsito', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 221, 'class_id' => 2, 'parent_id' => 22 ],
            ['master_parent_id' => 2.2, 'is_account' => 1, 'type' => 'active', 'name'=>'Mercadorias em poder de terceiros, auxiliares e materiais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 222, 'class_id' => 2, 'parent_id' => 22 ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'active', 'name'=>'Produtos acabados e intermédios', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 23, 'class_id' => 2, 'parent_id' => null ],

            ['master_parent_id' => 2.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Produtos acabados em poder de terceiros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 231, 'class_id' => 2, 'parent_id' => 23 ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'active', 'name'=>'Subprodutos, desperdícios, resíduos e refugos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 24, 'class_id' => 2, 'parent_id' => null ],

            ['master_parent_id' => 2.4, 'is_account' => 1, 'type' => 'active', 'name'=>'Subprodutos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 241, 'class_id' => 2, 'parent_id' => 24 ],
            ['master_parent_id' => 2.4, 'is_account' => 1, 'type' => 'active', 'name'=>'Mercadorias em poder de terceiros, auxiliares e materiais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 242, 'class_id' => 2, 'parent_id' => 24 ],

            ['master_parent_id' => null, 'is_account' => 1, 'type' => 'active', 'name'=>'Produtos ou serviços em curso', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 25, 'class_id' => 2, 'parent_id' => null ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'active', 'name'=>'Matérias primas, auxiliares e materiais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 26, 'class_id' => 2, 'parent_id' => null ],


            ['master_parent_id' => 2.6, 'is_account' => 1, 'type' => 'active', 'name'=>'Matérias primas', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 261, 'class_id' => 2, 'parent_id' => 26 ],
            ['master_parent_id' => 2.6, 'is_account' => 1, 'type' => 'active', 'name'=>'Matérias auxiliares', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 262, 'class_id' => 2, 'parent_id' => 26 ],
            ['master_parent_id' => 2.6, 'is_account' => 0, 'type' => 'active', 'name'=>'Matérias', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 263, 'class_id' => 2, 'parent_id' => 26 ],

            ['master_parent_id' => 2.6, 'is_account' => 1, 'type' => 'active', 'name'=>'Combustíveis e lubrificantes', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 2631, 'class_id' => 2, 'parent_id' => 263 ],
            ['master_parent_id' => 2.6, 'is_account' => 1, 'type' => 'active', 'name'=>'Embalagens comerciais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 2632, 'class_id' => 2, 'parent_id' => 263 ],
            ['master_parent_id' => 2.6, 'is_account' => 1, 'type' => 'active', 'name'=>'Peças e sobressalentes', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 2633, 'class_id' => 2, 'parent_id' => 263 ],
            ['master_parent_id' => 2.6, 'is_account' => 1, 'type' => 'active', 'name'=>'Materiais diversos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 2639, 'class_id' => 2, 'parent_id' => 263 ],

            ['master_parent_id' => 2.6, 'is_account' => 1, 'type' => 'active', 'name'=>'Matérias primas, auxiliares e materiais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 264, 'class_id' => 2, 'parent_id' => 26 ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'active', 'name'=>'Activos biológicos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 27, 'class_id' => 2, 'parent_id' => null ],

            ['master_parent_id' => 2.7, 'is_account' => 1, 'type' => 'active', 'name'=>'De produção', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 271, 'class_id' => 2, 'parent_id' => 27 ],


            ['master_parent_id' => 2.7, 'is_account' => 0, 'type' => 'active', 'name'=>'Consumíveis', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 272, 'class_id' => 2, 'parent_id' => 27 ],

            ['master_parent_id' => 2.7, 'is_account' => 1, 'type' => 'active', 'name'=>'Animais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 2721, 'class_id' => 2, 'parent_id' => 272 ],
            ['master_parent_id' => 2.7, 'is_account' => 1, 'type' => 'active', 'name'=>'Plantas, auxiliares e materiais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 2722, 'class_id' => 2, 'parent_id' => 272 ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'active', 'name'=>'Regularização de Inventários', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 28, 'class_id' => 2, 'parent_id' => null ],

            ['master_parent_id' => 2.8, 'is_account' => 1, 'type' => 'active', 'name'=>'Mercadorias', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 282, 'class_id' => 2, 'parent_id' => 28 ],
            ['master_parent_id' => 2.8, 'is_account' => 1, 'type' => 'active', 'name'=>'Produtos Acabados e intermédios', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 283, 'class_id' => 2, 'parent_id' => 28 ],
            ['master_parent_id' => 2.8, 'is_account' => 1, 'type' => 'active', 'name'=>'Subprodutos, desperdícios, resíduos e refugos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 284, 'class_id' => 2, 'parent_id' => 28 ],
            ['master_parent_id' => 2.8, 'is_account' => 1, 'type' => 'active', 'name'=>'Produtos ou serviços em curso', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 285, 'class_id' => 2, 'parent_id' => 28 ],
            ['master_parent_id' => 2.8, 'is_account' => 1, 'type' => 'active', 'name'=>'Matérias primas, auxiliares e materiais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 286, 'class_id' => 2, 'parent_id' => 28 ],
            ['master_parent_id' => 2.8, 'is_account' => 1, 'type' => 'active', 'name'=>'Activos biológicos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 287, 'class_id' => 2, 'parent_id' => 28 ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'active', 'name'=>'Ajustamentos para o valor realizável líquido', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 29, 'class_id' => 2, 'parent_id' => null ],
            
            ['master_parent_id' => 2.9, 'is_account' => 1, 'type' => 'active', 'name'=>'Mercadorias', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 292, 'class_id' => 2, 'parent_id' => 29 ],
            ['master_parent_id' => 2.9, 'is_account' => 1, 'type' => 'active', 'name'=>'Produtos Acabados e intermédios', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 293, 'class_id' => 2, 'parent_id' => 29 ],
            ['master_parent_id' => 2.9, 'is_account' => 1, 'type' => 'active', 'name'=>'Subprodutos, desperdícios, resíduos e refugos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 294, 'class_id' => 2, 'parent_id' => 29 ],
            ['master_parent_id' => 2.9, 'is_account' => 1, 'type' => 'active', 'name'=>'Produtos ou serviços em curso', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 295, 'class_id' => 2, 'parent_id' => 29 ],
            ['master_parent_id' => 2.9, 'is_account' => 1, 'type' => 'active', 'name'=>'Matérias primas, auxiliares e materiais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 296, 'class_id' => 2, 'parent_id' => 29 ],
            ['master_parent_id' => 2.9, 'is_account' => 1, 'type' => 'active', 'name'=>'Activos biológicos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 297, 'class_id' => 2, 'parent_id' => 29 ],

            # Classe 3 - INVESTIMENTOS

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'active', 'name'=>'Investimentos financeiros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 31, 'class_id' => 3, 'parent_id' => null ],

            ['master_parent_id' => 3.1, 'is_account' => 1, 'type' => 'active', 'name'=>'Investimentos em subsidiárias', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 311, 'class_id' => 2, 'parent_id' => 31 ],
            ['master_parent_id' => 3.1, 'is_account' => 1, 'type' => 'active', 'name'=>'Investimentos associadas', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 312, 'class_id' => 2, 'parent_id' => 31 ],
            ['master_parent_id' => 3.1, 'is_account' => 1, 'type' => 'active', 'name'=>'Outros Investimentos financeiros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 313, 'class_id' => 2, 'parent_id' => 31 ],

            ['master_parent_id' => 3.2, 'is_account' => 0, 'type' => 'active', 'name'=>'Activos tangíveis', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 32, 'class_id' => 3, 'parent_id' => null ],

            ['master_parent_id' => 3.2, 'is_account' => 0, 'type' => 'active', 'name'=>'Construções', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 321, 'class_id' => 3, 'parent_id' => 32 ],

            ['master_parent_id' => 3.2, 'is_account' => 1, 'type' => 'active', 'name'=>'Edifícios industriais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 3211, 'class_id' => 2, 'parent_id' => 321 ],
            ['master_parent_id' => 3.2, 'is_account' => 1, 'type' => 'active', 'name'=>'Edifícios administrativos e comerciais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 3212, 'class_id' => 2, 'parent_id' => 321 ],
            ['master_parent_id' => 3.2, 'is_account' => 1, 'type' => 'active', 'name'=>'Edifícios para habitação e outros fins sociais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 3213, 'class_id' => 2, 'parent_id' => 321 ],
            ['master_parent_id' => 3.2, 'is_account' => 1, 'type' => 'active', 'name'=>'Vias de comunicação e construções afins', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 3216, 'class_id' => 2, 'parent_id' => 321 ],

            ['master_parent_id' => 3.2, 'is_account' => 1, 'type' => 'active', 'name'=>'Equipamento básico', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 322, 'class_id' => 3, 'parent_id' => 32 ],

            ['master_parent_id' => 3.2, 'is_account' => 1, 'type' => 'active', 'name'=>'Mobiliário e equipamento administrativo social', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 323, 'class_id' => 3, 'parent_id' => 32 ],

            ['master_parent_id' => 3.2, 'is_account' => 1, 'type' => 'active', 'name'=>'Equipamento de transporte', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 324, 'class_id' => 3, 'parent_id' => 32 ],

            ['master_parent_id' => 3.2, 'is_account' => 1, 'type' => 'active', 'name'=>'Taras e vasilhame', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 325, 'class_id' => 3, 'parent_id' => 32 ],

            ['master_parent_id' => 3.2, 'is_account' => 1, 'type' => 'active', 'name'=>'Ferramentas e utensílios', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 326, 'class_id' => 3, 'parent_id' => 32 ],

            ['master_parent_id' => 3.2, 'is_account' => 1, 'type' => 'active', 'name'=>'Outros activos tangíveis', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 329, 'class_id' => 3, 'parent_id' => 32 ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'active', 'name'=>'Activos intangíveis', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 33, 'class_id' => 3, 'parent_id' => null ],

            ['master_parent_id' => 3.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Despesas de desenvolvimento', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 331, 'class_id' => 3, 'parent_id' => 33 ],
            ['master_parent_id' => 3.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Propriedade industrial e outros direitos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 332, 'class_id' => 3, 'parent_id' => 33 ],
            ['master_parent_id' => 3.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Trespasse', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 333, 'class_id' => 3, 'parent_id' => 33 ],
            ['master_parent_id' => 3.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Encargos de constituição ou de expansão', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 334, 'class_id' => 3, 'parent_id' => 33 ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'active', 'name'=>'Investimentos em curso', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 34, 'class_id' => 3, 'parent_id' => null ],

            ['master_parent_id' => 3.4, 'is_account' => 1, 'type' => 'active', 'name'=>'Activos tangíveis', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 342, 'class_id' => 3, 'parent_id' => 34 ],
            ['master_parent_id' => 3.4, 'is_account' => 1, 'type' => 'active', 'name'=>'Activos intangíveis', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 343, 'class_id' => 3, 'parent_id' => 34 ],

            ['master_parent_id' => null, 'is_account' => 1, 'type' => 'active', 'name'=>'Activos tangíveis de investimento', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 36, 'class_id' => 3, 'parent_id' => null ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'passive', 'name'=>'Amortizações acumuladas', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 38, 'class_id' => 3, 'parent_id' => null ],

            ['master_parent_id' => 3.8, 'is_account' => 1, 'type' => 'passive', 'name'=>'Activos tangíveis', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 382, 'class_id' => 3, 'parent_id' => 38 ],
            ['master_parent_id' => 3.8, 'is_account' => 1, 'type' => 'passive', 'name'=>'Activos intangíveis', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 383, 'class_id' => 383, 'parent_id' => 38 ],
            ['master_parent_id' => 3.8, 'is_account' => 1, 'type' => 'passive', 'name'=>'Activos tangíveis de investimento', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 386, 'class_id' => 3, 'parent_id' => 38 ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'active', 'name'=>'Ajustamento de investimentos financeiros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 39, 'class_id' => 3, 'parent_id' => null ],

            ['master_parent_id' => 3.9, 'is_account' => 1, 'type' => 'active', 'name'=>'Investimentos financeiros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 391, 'class_id' => 3, 'parent_id' => 39 ],

            # CLASSE 4 – CONTAS A RECEBER, CONTAS A PAGAR, ACRÉSCIMOS E DIFERIMENTOS

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'active', 'name'=>'Clientes', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 41, 'class_id' => 4, 'parent_id' => null ],

            ['master_parent_id' => 4.1, 'is_account' => 1, 'type' => 'active', 'name'=>'Clientes c/c', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 411, 'class_id' => 4, 'parent_id' => 41 ],
            ['master_parent_id' => 4.1, 'is_account' => 1, 'type' => 'active', 'name'=>'Clientes Títulos a receber', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 412, 'class_id' => 4, 'parent_id' => 41 ],
            ['master_parent_id' => 4.1, 'is_account' => 1, 'type' => 'active', 'name'=>'Clientes de cobrança duvidosa', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 418, 'class_id' => 4, 'parent_id' => 41 ],
            ['master_parent_id' => 4.1, 'is_account' => 1, 'type' => 'active', 'name'=>'Adiantamentos de clientes', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 419, 'class_id' => 4, 'parent_id' => 41 ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'passive', 'name'=>'Fornecedores', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 42, 'class_id' => 4, 'parent_id' => null ],

            ['master_parent_id' => 4.2, 'is_account' => 1, 'type' => 'passive', 'name'=>'Fornecedores c/c', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 421, 'class_id' => 4, 'parent_id' => 42 ],
            ['master_parent_id' => 4.2, 'is_account' => 1, 'type' => 'passive', 'name'=>'Fornecedores - Títulos a pagar', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 422, 'class_id' => 4, 'parent_id' => 42 ],
            ['master_parent_id' => 4.2, 'is_account' => 1, 'type' => 'passive', 'name'=>'Adiantamentos a fornecedores', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 429, 'class_id' => 4, 'parent_id' => 42 ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'passive', 'name'=>'Empréstimos obtidos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 43, 'class_id' => 4, 'parent_id' => null ],

            ['master_parent_id' => 4.3, 'is_account' => 0, 'type' => 'passive', 'name'=>'Empréstimos bancários', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 431, 'class_id' => 4, 'parent_id' => 43 ],

            ['master_parent_id' => 4.3, 'is_account' => 1, 'type' => 'passive', 'name'=>'Empréstimos de curto prazo', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4311, 'class_id' => 4, 'parent_id' => 431 ],
            ['master_parent_id' => 4.3, 'is_account' => 1, 'type' => 'passive', 'name'=>'Empréstimos de médio e longo prazo', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4312, 'class_id' => 4, 'parent_id' => 431 ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'passive', 'name'=>'Estado', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 44, 'class_id' => 4, 'parent_id' => null ],

            ['master_parent_id' => 4.4, 'is_account' => 0, 'type' => 'active', 'name'=>'Imposto sobre rendimentos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 441, 'class_id' => 4, 'parent_id' => 44 ],

            ['master_parent_id' => 4.4, 'is_account' => 1, 'type' => 'active', 'name'=>'Estimativa de imposto', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4411, 'class_id' => 4, 'parent_id' => 441 ],
            ['master_parent_id' => 4.4, 'is_account' => 1, 'type' => 'active', 'name'=>'Pagamento por conta - Títulos a pagar', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4412, 'class_id' => 4, 'parent_id' => 441 ],
            ['master_parent_id' => 4.4, 'is_account' => 1, 'type' => 'active', 'name'=>'Pagamento especial por conta', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4413, 'class_id' => 4, 'parent_id' => 441 ],

            ['master_parent_id' => 4.4, 'is_account' => 0, 'type' => 'passive', 'name'=>'Impostos retidos na fonte', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 442, 'class_id' => 4, 'parent_id' => 44 ],

            ['master_parent_id' => 4.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'Rendimentos de trabalho dependente', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4421, 'class_id' => 4, 'parent_id' => 442 ],
            ['master_parent_id' => 4.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'Rendimentos profissionais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4422, 'class_id' => 4, 'parent_id' => 442 ],
            ['master_parent_id' => 4.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'Rendimentos de capitais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4423, 'class_id' => 4, 'parent_id' => 442 ],
            ['master_parent_id' => 4.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'Rendimentos prediais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4424, 'class_id' => 4, 'parent_id' => 442 ],
            ['master_parent_id' => 4.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'Outros rendimentos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4425, 'class_id' => 4, 'parent_id' => 442 ],

            ['master_parent_id' => 4.4, 'is_account' => 0, 'type' => 'passive', 'name'=>'Imposto sobre o valor acrescentado', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 443, 'class_id' => 4, 'parent_id' => 44 ],

            ['master_parent_id' => 4.4, 'is_account' => 0, 'type' => 'active', 'name'=>'IVA suportado', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4431, 'class_id' => 4, 'parent_id' => 443 ],

            ['master_parent_id' => 4.4, 'is_account' => 1, 'type' => 'active', 'name'=>'Inventários', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 44311, 'class_id' => 4, 'parent_id' => 4431 ],
            ['master_parent_id' => 4.4, 'is_account' => 1, 'type' => 'active', 'name'=>'Activos tangíveis e intangíveis', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 44312, 'class_id' => 4, 'parent_id' => 4431 ],
            ['master_parent_id' => 4.4, 'is_account' => 1, 'type' => 'active', 'name'=>'Outros bens e serviços', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 44313, 'class_id' => 4, 'parent_id' => 4431 ],

            ['master_parent_id' => 4.4, 'is_account' => 0, 'type' => 'active', 'name'=>'IVA dedutível', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4432, 'class_id' => 4, 'parent_id' => 443 ],

            ['master_parent_id' => 4.4, 'is_account' => 1, 'type' => 'active', 'name'=>'Inventários', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 44321, 'class_id' => 4, 'parent_id' => 4432 ],
            ['master_parent_id' => 4.4, 'is_account' => 1, 'type' => 'active', 'name'=>'Activos tangíveis e intangíveis', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 44322, 'class_id' => 4, 'parent_id' => 4432 ],
            ['master_parent_id' => 4.4, 'is_account' => 1, 'type' => 'active', 'name'=>'Outros bens e serviços', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 44323, 'class_id' => 4, 'parent_id' => 4432 ],

            ['master_parent_id' => 4.4, 'is_account' => 0, 'type' => 'passive', 'name'=>'IVA liquidado', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4433, 'class_id' => 4, 'parent_id' => 443 ],

            ['master_parent_id' => 4.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'Operações gerais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 44331, 'class_id' => 4, 'parent_id' => 4433 ],
            ['master_parent_id' => 4.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'Autoconsumos e operações gratuitas', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 44332, 'class_id' => 4, 'parent_id' => 4433 ],
            ['master_parent_id' => 4.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'Operações especiais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 44333, 'class_id' => 4, 'parent_id' => 4433 ],

            ['master_parent_id' => 4.4, 'is_account' => 0, 'type' => 'passive', 'name'=>'IVA regularizações', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4434, 'class_id' => 4, 'parent_id' => 443 ],

            ['master_parent_id' => 4.4, 'is_account' => 1, 'type' => 'active', 'name'=>'Mensais a favor do sujeito passivo', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 44341, 'class_id' => 4, 'parent_id' => 4434 ],
            ['master_parent_id' => 4.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'Mensais a favor do Estado', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 44342, 'class_id' => 4, 'parent_id' => 4434 ],
            ['master_parent_id' => 4.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'Anuais por cálculo do pro rata definitivo', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 44343, 'class_id' => 4, 'parent_id' => 4434 ],

            ['master_parent_id' => 4.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'IVA apuramento', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4435, 'class_id' => 4, 'parent_id' => 443 ],

            ['master_parent_id' => 4.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'IVA liquidações oficiosas', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4436, 'class_id' => 4, 'parent_id' => 443 ],

            ['master_parent_id' => 4.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'IVA a pagar', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4437, 'class_id' => 4, 'parent_id' => 443 ],

            ['master_parent_id' => 4.4, 'is_account' => 1, 'type' => 'active', 'name'=>'IVA a recuperar', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4438, 'class_id' => 4, 'parent_id' => 443 ],

            ['master_parent_id' => 4.4, 'is_account' => 1, 'type' => 'active', 'name'=>'IVA reembolsos pedidos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4439, 'class_id' => 4, 'parent_id' => 443 ],

            ['master_parent_id' => 4.4, 'is_account' => 0, 'type' => 'passive', 'name'=>'Restantes impostos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 444, 'class_id' => 4, 'parent_id' => 44 ],

            ['master_parent_id' => 4.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'Imposto de selo', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4441, 'class_id' => 4, 'parent_id' => 444 ],
            ['master_parent_id' => 4.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'Impostos autárquicos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4442, 'class_id' => 4, 'parent_id' => 444 ],

            ['master_parent_id' => 4.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'Rectificações de impostos, contribuições e outros tributos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 445, 'class_id' => 4, 'parent_id' => 44 ],

            ['master_parent_id' => 4.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'Contribuições para a INSS', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 449, 'class_id' => 4, 'parent_id' => 44 ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'active', 'name'=>'Outros devedores', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 45, 'class_id' => 4, 'parent_id' => null ],

            ['master_parent_id' => 4.5, 'is_account' => 0, 'type' => 'active', 'name'=>'Pessoal', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 451, 'class_id' => 4, 'parent_id' => 45 ],

            ['master_parent_id' => 4.5, 'is_account' => 1, 'type' => 'active', 'name'=>'Adiantamentos aos órgãos sociais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4511, 'class_id' => 4, 'parent_id' => 451 ],
            ['master_parent_id' => 4.5, 'is_account' => 1, 'type' => 'active', 'name'=>'Adiantamentos aos trabalhadores', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4512, 'class_id' => 4, 'parent_id' => 451 ],
            ['master_parent_id' => 4.5, 'is_account' => 1, 'type' => 'active', 'name'=>'Outras operações com órgãos sociais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4518, 'class_id' => 4, 'parent_id' => 451 ],
            ['master_parent_id' => 4.5, 'is_account' => 1, 'type' => 'active', 'name'=>'Outras operações com trabalhadores', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4519, 'class_id' => 4, 'parent_id' => 451 ],

            ['master_parent_id' => 4.5, 'is_account' => 0, 'type' => 'active', 'name'=>'Subscritores de capital', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 452, 'class_id' => 4, 'parent_id' => 45 ],

            ['master_parent_id' => 4.5, 'is_account' => 1, 'type' => 'active', 'name'=>'Estado e outras Entidades públicas', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4521, 'class_id' => 4, 'parent_id' => 452 ],
            ['master_parent_id' => 4.5, 'is_account' => 1, 'type' => 'active', 'name'=>'Entidades privadas', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4522, 'class_id' => 4, 'parent_id' => 452 ],
            ['master_parent_id' => 4.5, 'is_account' => 1, 'type' => 'active', 'name'=>'Outras entidades', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4529, 'class_id' => 4, 'parent_id' => 452 ],

            ['master_parent_id' => 4.5, 'is_account' => 0, 'type' => 'active', 'name'=>'Devedores-sócios, accionistas ou proprietários', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 454, 'class_id' => 4, 'parent_id' => 45 ],

            ['master_parent_id' => 4.5, 'is_account' => 1, 'type' => 'active', 'name'=>'Empréstimos concedidos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4541, 'class_id' => 4, 'parent_id' => 454 ],
            ['master_parent_id' => 4.5, 'is_account' => 1, 'type' => 'active', 'name'=>'Adiantamentos por conta de lucros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4542, 'class_id' => 4, 'parent_id' => 454 ],
            ['master_parent_id' => 4.5, 'is_account' => 1, 'type' => 'active', 'name'=>'Resultados atribuídos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4543, 'class_id' => 4, 'parent_id' => 454 ],
            ['master_parent_id' => 4.5, 'is_account' => 1, 'type' => 'active', 'name'=>'Lucros disponíveis', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4544, 'class_id' => 4, 'parent_id' => 454 ],
            ['master_parent_id' => 4.5, 'is_account' => 1, 'type' => 'active', 'name'=>'Outras operações', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4549, 'class_id' => 4, 'parent_id' => 454 ],

            ['master_parent_id' => 4.5, 'is_account' => 0, 'type' => 'active', 'name'=>'Subsídios a receber', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 455, 'class_id' => 4, 'parent_id' => 45 ],

            ['master_parent_id' => 4.5, 'is_account' => 1, 'type' => 'active', 'name'=>'Estado e Outros Organismos Públicos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4551, 'class_id' => 4, 'parent_id' => 455 ],
            ['master_parent_id' => 4.5, 'is_account' => 1, 'type' => 'active', 'name'=>'Entidades privadas', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4552, 'class_id' => 4, 'parent_id' => 455 ],

            ['master_parent_id' => 4.5, 'is_account' => 1, 'type' => 'active', 'name'=>'Devedores diversos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 459, 'class_id' => 4, 'parent_id' => 45 ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'passive', 'name'=>'Outros credores', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 46, 'class_id' => 4, 'parent_id' => null ],

            ['master_parent_id' => 4.6, 'is_account' => 0, 'type' => 'passive', 'name'=>'Fornecedores de investimentos de capital', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 461, 'class_id' => 4, 'parent_id' => 46 ],

            ['master_parent_id' => 4.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'Fornecedores de investimentos de capital c/c', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4611, 'class_id' => 4, 'parent_id' => 461 ],
            ['master_parent_id' => 4.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'Fornecedores de investimentos de capital - Títulos a pagar', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4612, 'class_id' => 4, 'parent_id' => 461 ],
            ['master_parent_id' => 4.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'Resultados atribuídos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4613, 'class_id' => 4, 'parent_id' => 461 ],
            ['master_parent_id' => 4.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'Fornecedores de investimentos de capital - Adiantamentos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4614, 'class_id' => 4, 'parent_id' => 461 ],
            ['master_parent_id' => 4.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'Fornecedores de investimentos de capital - Locação Financeira', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4619, 'class_id' => 4, 'parent_id' => 461 ],

            ['master_parent_id' => 4.6, 'is_account' => 0, 'type' => 'passive', 'name'=>'Pessoal', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 462, 'class_id' => 4, 'parent_id' => 46 ],

            ['master_parent_id' => 4.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'Remunerações a pagar aos órgãos sociais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4621, 'class_id' => 4, 'parent_id' => 462 ],
            ['master_parent_id' => 4.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'Remunerações a pagar aos trabalhadores - Títulos a pagar', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4622, 'class_id' => 4, 'parent_id' => 462 ],
            ['master_parent_id' => 4.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'Outras operações com os órgão sociais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4628, 'class_id' => 4, 'parent_id' => 462 ],
            ['master_parent_id' => 4.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'Outras operações com os trabalhadores', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4629, 'class_id' => 4, 'parent_id' => 462 ],

            ['master_parent_id' => 4.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'Sindicatos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 463, 'class_id' => 4, 'parent_id' => 46 ],

            ['master_parent_id' => 4.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'Consultores, assessores e intermediários', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 466, 'class_id' => 4, 'parent_id' => 46 ],

            ['master_parent_id' => 4.6, 'is_account' => 0, 'type' => 'passive', 'name'=>'Credores - sócios, accionistas ou proprietários', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 467, 'class_id' => 4, 'parent_id' => 46 ],

            ['master_parent_id' => 4.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'Empréstimos obtidos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4671, 'class_id' => 4, 'parent_id' => 467 ],
            ['master_parent_id' => 4.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'Resultados atribuídos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4673, 'class_id' => 4, 'parent_id' => 467 ],
            ['master_parent_id' => 4.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'Lucros disponíveis', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4674, 'class_id' => 4, 'parent_id' => 467 ],
           
            ['master_parent_id' => 4.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'Credores diversos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 469, 'class_id' => 4, 'parent_id' => 46 ],

            ['master_parent_id' => 4.7, 'is_account' => 0, 'type' => 'passive', 'name'=>'Ajustamentos de contas a receber', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 47, 'class_id' => 4, 'parent_id' => null ],

            ['master_parent_id' => 4.7, 'is_account' => 1, 'type' => 'passive', 'name'=>'Clientes', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 471, 'class_id' => 4, 'parent_id' => 47 ],
            ['master_parent_id' => 4.7, 'is_account' => 1, 'type' => 'passive', 'name'=>'Outros devedores', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 472, 'class_id' => 4, 'parent_id' => 47 ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'passive', 'name'=>'Provisões', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 48, 'class_id' => 4, 'parent_id' => null ],

            ['master_parent_id' => 4.8, 'is_account' => 1, 'type' => 'passive', 'name'=>'Processos judiciais em curso', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 481, 'class_id' => 4, 'parent_id' => 48 ],
            ['master_parent_id' => 4.8, 'is_account' => 1, 'type' => 'passive', 'name'=>'Acidentes no trabalho e doenças profissionais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 482, 'class_id' => 4, 'parent_id' => 48 ],
            ['master_parent_id' => 4.8, 'is_account' => 1, 'type' => 'passive', 'name'=>'Impostos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 483, 'class_id' => 4, 'parent_id' => 48 ],
            ['master_parent_id' => 4.8, 'is_account' => 1, 'type' => 'passive', 'name'=>'Reestruturação de negócios', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 484, 'class_id' => 4, 'parent_id' => 48 ],
            ['master_parent_id' => 4.8, 'is_account' => 1, 'type' => 'passive', 'name'=>'Contratos onerosos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 485, 'class_id' => 4, 'parent_id' => 48 ],
            ['master_parent_id' => 4.8, 'is_account' => 1, 'type' => 'passive', 'name'=>'Garantias a clientes', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 486, 'class_id' => 4, 'parent_id' => 48 ],
            ['master_parent_id' => 4.8, 'is_account' => 1, 'type' => 'passive', 'name'=>'Perdas em contratos de construção', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 487, 'class_id' => 4, 'parent_id' => 48 ],
            ['master_parent_id' => 4.8, 'is_account' => 1, 'type' => 'passive', 'name'=>'Outras provisões', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 489, 'class_id' => 4, 'parent_id' => 48 ],

            ['master_parent_id' => null,'is_account' => 0, 'type' => 'passive', 'name'=>'Acréscimos e diferimentos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 49, 'class_id' => 4, 'parent_id' => null ],

            ['master_parent_id' => 4.9, 'is_account' => 0, 'type' => 'active', 'name'=>'Acréscimos de gastos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 491, 'class_id' => 4, 'parent_id' => 49 ],

            ['master_parent_id' => 4.9, 'is_account' => 1, 'type' => 'active', 'name'=>'Juros a pagar', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4911, 'class_id' => 4, 'parent_id' => 491 ],
            ['master_parent_id' => 4.9, 'is_account' => 1, 'type' => 'active', 'name'=>'Remunerações a pagar', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4912, 'class_id' => 4, 'parent_id' => 491 ],
            ['master_parent_id' => 4.9, 'is_account' => 1, 'type' => 'active', 'name'=>'Outros acréscimos de gastos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4919, 'class_id' => 4, 'parent_id' => 491 ],

            ['master_parent_id' => 4.9, 'is_account' => 0, 'type' => 'passive', 'name'=>'Rendimentos diferidos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 492, 'class_id' => 4, 'parent_id' => 49 ],

            ['master_parent_id' => 4.9, 'is_account' => 1, 'type' => 'passive', 'name'=>'Réditos de contratos de construção', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4923, 'class_id' => 4, 'parent_id' => 492 ],
            ['master_parent_id' => 4.9, 'is_account' => 1, 'type' => 'passive', 'name'=>'Subsídio para investimentos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4924, 'class_id' => 4, 'parent_id' => 492 ],
            ['master_parent_id' => 4.9, 'is_account' => 1, 'type' => 'passive', 'name'=>'Outros rendimentos diferidos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4929, 'class_id' => 4, 'parent_id' => 492 ],

            ['master_parent_id' => 4.9, 'is_account' => 0, 'type' => 'passive', 'name'=>'Acréscimos de rendimentos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 493, 'class_id' => 4, 'parent_id' => 49 ],

            ['master_parent_id' => 4.9, 'is_account' => 1, 'type' => 'passive', 'name'=>'Juros a receber', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4931, 'class_id' => 4, 'parent_id' => 493 ],
            ['master_parent_id' => 4.9, 'is_account' => 1, 'type' => 'passive', 'name'=>'Rédito de contratos de construção', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4933, 'class_id' => 4, 'parent_id' => 493 ],
            ['master_parent_id' => 4.9, 'is_account' => 1, 'type' => 'active', 'name'=>'Outros acréscimos de rendimentos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 4939, 'class_id' => 4, 'parent_id' => 493 ],
            ['master_parent_id' => 4.9, 'is_account' => 0, 'type' => 'passive', 'name'=>'Gastos diferidos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 494, 'class_id' => 4, 'parent_id' => 49 ],


            # CLASSE 5 – CAPITAL PRÓPRIO
            ['master_parent_id' => null, 'is_account' => 1, 'type' => 'passive', 'name'=>'Capital', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 51, 'class_id' => 5, 'parent_id' => null ],
           
            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'passive', 'name'=>'Acções ou quotas próprias', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 52, 'class_id' => 5, 'parent_id' => null ],

            ['master_parent_id' => 5.2, 'is_account' => 1, 'type' => 'passive', 'name'=>'Valor nominal', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 521, 'class_id' => 5, 'parent_id' => 52 ],
            ['master_parent_id' => 5.2, 'is_account' => 1, 'type' => 'passive', 'name'=>'Descontos e prémios', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 522, 'class_id' => 5, 'parent_id' => 52 ],

            ['master_parent_id' => null,'is_account' => 1, 'type' => 'passive', 'name'=>'Prestações suplementares', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 53, 'class_id' => 5, 'parent_id' => null ],
            ['master_parent_id' => null,'is_account' => 1, 'type' => 'passive', 'name'=>'Prémios de emissão de acções ou quotas', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 54, 'class_id' => 5, 'parent_id' => null ],
            ['master_parent_id' => null,'is_account' => 0, 'type' => 'passive', 'name'=>'Reservas', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 55, 'class_id' => 5, 'parent_id' => null ],

            ['master_parent_id' => 5.5, 'is_account' => 1, 'type' => 'passive', 'name'=>'Reservas legais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 551, 'class_id' => 5, 'parent_id' => 55 ],
            ['master_parent_id' => 5.5, 'is_account' => 1, 'type' => 'passive', 'name'=>'Reservas estatutárias', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 552, 'class_id' => 5, 'parent_id' => 55 ],
            ['master_parent_id' => 5.5, 'is_account' => 1, 'type' => 'passive', 'name'=>'Reservas livres', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 553, 'class_id' => 5, 'parent_id' => 55 ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'passive', 'name'=>'Excedente de revalorização de activos tangíveis e intangíveis', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 56, 'class_id' => 5, 'parent_id' => null ],

            ['master_parent_id' => 5.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'Revalorizações legais ', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 561, 'class_id' => 5, 'parent_id' => 56 ],
            ['master_parent_id' => 5.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'Outros excedentes', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 562, 'class_id' => 5, 'parent_id' => 56 ],

            ['master_parent_id' => null, 'is_account' => 1, 'type' => 'passive', 'name'=>'Outras variações no capital próprio', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 58, 'class_id' => 5, 'parent_id' => null ],
            ['master_parent_id' => null, 'is_account' => 1, 'type' => 'passive', 'name'=>'Resultados transitados', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 59, 'class_id' => 5, 'parent_id' => null ],
  
            ['master_parent_id' => 5.9, 'is_account' => 1, 'type' => 'passive', 'name'=>'Resultado do período', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 591, 'class_id' => 5, 'parent_id' => 59 ],
            ['master_parent_id' => 5.9, 'is_account' => 1, 'type' => 'passive', 'name'=>'Resultados Acumulados', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 592, 'class_id' => 5, 'parent_id' => 59 ],

            # CLASSE 6 - GASTOS E PERDAS

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'active', 'name'=>'Custos dos inventários', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 61, 'class_id' => 6, 'parent_id' => null ],

            ['master_parent_id' => 6.1, 'is_account' => 0, 'type' => 'active', 'name'=>'Custos dos inventários vendidos ou consumidos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 611, 'class_id' => 6, 'parent_id' => 61 ],

            ['master_parent_id' => 6.1, 'is_account' => 1, 'type' => 'active', 'name'=>'De mercadorias', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6112, 'class_id' => 6, 'parent_id' => 611 ],
            ['master_parent_id' => 6.1, 'is_account' => 0, 'type' => 'active', 'name'=>'De matérias primas, auxiliares e materiais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6116, 'class_id' => 6, 'parent_id' => 611 ],
  
            ['master_parent_id' => 6.1, 'is_account' => 1, 'type' => 'active', 'name'=>'Matérias primas', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 61161, 'class_id' => 6, 'parent_id' => 6116 ],
            ['master_parent_id' => 6.1, 'is_account' => 1, 'type' => 'active', 'name'=>'Matérias auxiliares', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 61162, 'class_id' => 6, 'parent_id' => 6116 ],
            ['master_parent_id' => 6.1, 'is_account' => 1, 'type' => 'active', 'name'=>'Materiais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 61163, 'class_id' => 6, 'parent_id' => 6116 ],

            ['master_parent_id' => 6.1, 'is_account' => 1, 'type' => 'active', 'name'=>'Activos biológicos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6117, 'class_id' => 6, 'parent_id' => 611 ],

            ['master_parent_id' => 6.1, 'is_account' => 0, 'type' => 'active', 'name'=>'Variação da produção', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 612, 'class_id' => 6, 'parent_id' => 61 ],

            ['master_parent_id' => 6.1, 'is_account' => 1, 'type' => 'active', 'name'=>'Produtos acabados e intermédios', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6121, 'class_id' => 6, 'parent_id' => 612 ],
            ['master_parent_id' => 6.1, 'is_account' => 1, 'type' => 'active', 'name'=>'Subprodutos, desperdícios, resíduos e refugos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6122, 'class_id' => 6, 'parent_id' => 612 ],
            ['master_parent_id' => 6.1, 'is_account' => 1, 'type' => 'active', 'name'=>'Produtos e serviços em curso', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6123, 'class_id' => 6, 'parent_id' => 612 ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'active', 'name'=>'Gastos com o pessoal', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 62, 'class_id' => 6, 'parent_id' => null ],

            ['master_parent_id' => 6.2, 'is_account' => 1, 'type' => 'active', 'name'=>'Remunerações dos órgãos sociais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 621, 'class_id' => 6, 'parent_id' => 62 ],
            ['master_parent_id' => 6.2, 'is_account' => 1, 'type' => 'active', 'name'=>'Remunerações dos trabalhadores', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 622, 'class_id' => 6, 'parent_id' => 62 ],
            ['master_parent_id' => 6.2, 'is_account' => 1, 'type' => 'active', 'name'=>'Encargos sobre remunerações', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 623, 'class_id' => 6, 'parent_id' => 62 ],
            ['master_parent_id' => 6.2, 'is_account' => 0, 'type' => 'active', 'name'=>'Ajudas de custo', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 625, 'class_id' => 6, 'parent_id' => 62 ],

            ['master_parent_id' => 6.2, 'is_account' => 1, 'type' => 'active', 'name'=>'Ajudas de custo tributáveis', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6251, 'class_id' => 6, 'parent_id' => 625 ],
            ['master_parent_id' => 6.2, 'is_account' => 1, 'type' => 'active', 'name'=>'Ajudas de custo não tributáveis', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6252, 'class_id' => 6, 'parent_id' => 625 ],

            ['master_parent_id' => 6.2, 'is_account' => 0, 'type' => 'active', 'name'=>'Indeminizações', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 626, 'class_id' => 6, 'parent_id' => 62 ],

            ['master_parent_id' => 6.2, 'is_account' => 1, 'type' => 'active', 'name'=>'Indeminizações - Risco Segurável', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6261, 'class_id' => 6, 'parent_id' => 626 ],
            ['master_parent_id' => 6.2, 'is_account' => 1, 'type' => 'active', 'name'=>'Indeminizações - Outras ', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6262, 'class_id' => 6, 'parent_id' => 626 ],

            ['master_parent_id' => 6.2, 'is_account' => 1, 'type' => 'active', 'name'=>'Seguros de acidentes no trabalho e doenças profissionais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 627, 'class_id' => 6, 'parent_id' => 62 ],
           
            ['master_parent_id' => 6.2, 'is_account' => 1, 'type' => 'active', 'name'=>'Gastos de acção social', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 628, 'class_id' => 6, 'parent_id' => 62 ],

            ['master_parent_id' => 6.2, 'is_account' => 1, 'type' => 'active', 'name'=>'Outros gastos com pessoal', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 629, 'class_id' => 6, 'parent_id' => 62 ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'active', 'name'=>'Fornecimentos e serviços de terceiros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 63, 'class_id' => 6, 'parent_id' => null ],

            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Subcontratos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 631, 'class_id' => 6, 'parent_id' => 63 ],
            ['master_parent_id' => 6.3, 'is_account' => 0, 'type' => 'active', 'name'=>'Fornecimentos e serviços', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 632, 'class_id' => 6, 'parent_id' => 63 ],

            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Água', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 63211, 'class_id' => 6, 'parent_id' => 632 ],
            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Electricidade', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 63212, 'class_id' => 6, 'parent_id' => 632 ],
            ['master_parent_id' => 6.3, 'is_account' => 0, 'type' => 'active', 'name'=>'Combustíveis', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 63213, 'class_id' => 6, 'parent_id' => 632 ],

            ['master_parent_id' => 6.3, 'is_account' => 0, 'type' => 'active', 'name'=>'Gasóleo', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 632131, 'class_id' => 6, 'parent_id' => 63213 ],

            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Gasóleo - Viaturas ligeiras de passageiros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6321311, 'class_id' => 6, 'parent_id' => 632131 ],
            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Gasóleo - Outros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6321312, 'class_id' => 6, 'parent_id' => 632131 ],

            ['master_parent_id' => 6.3, 'is_account' => 0, 'type' => 'active', 'name'=>'Restantes combustíveis', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 632132, 'class_id' => 6, 'parent_id' => 632 ],

            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Restantes combustíveis - Viaturas Ligeiras de Passageiros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6321321, 'class_id' => 6, 'parent_id' => 632132 ],
            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Restantes combustíveis - Outros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6321322, 'class_id' => 6, 'parent_id' => 632132 ],

            ['master_parent_id' => 6.3, 'is_account' => 0, 'type' => 'active', 'name'=>'Lubrificantes', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 632133, 'class_id' => 6, 'parent_id' => 63213 ],

            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Lubrificantes - Viaturas ligeiras de passageiros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6321331, 'class_id' => 6, 'parent_id' => 632133 ],
            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Lubrificantes - Outros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6321332, 'class_id' => 6, 'parent_id' => 632133 ],

            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Ferramentas e utensílios de desgaste rápido', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 63214, 'class_id' => 6, 'parent_id' => 632 ],

            ['master_parent_id' => 6.3, 'is_account' => 0, 'type' => 'active', 'name'=>'Material de manutenção e reparação', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 63215, 'class_id' => 6, 'parent_id' => 632 ],

            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Material de manutenção e reparação - Viaturas ligeiras de passageiros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 632151, 'class_id' => 6, 'parent_id' => 63215 ],
            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Material de manutenção e reparação - Outros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 632152, 'class_id' => 6, 'parent_id' => 63215 ],


            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Material de escritório', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 63216, 'class_id' => 6, 'parent_id' => 632 ],
         
            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Livros e documentação técnica', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 63217, 'class_id' => 6, 'parent_id' => 632 ],

            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Artigos para oferta', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 63218, 'class_id' => 6, 'parent_id' => 632 ],

            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Manutenção e reparação', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 63221, 'class_id' => 6, 'parent_id' => 632 ],
           
            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Transporte de carga', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 63222, 'class_id' => 6, 'parent_id' => 632 ],

            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Transporte de pessoal', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 63223, 'class_id' => 6, 'parent_id' => 632 ],

            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Comunicações', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 63224, 'class_id' => 6, 'parent_id' => 632 ],
         
            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Honorários', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 63225, 'class_id' => 6, 'parent_id' => 632 ],

            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Comissões a intermediários', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 63226, 'class_id' => 6, 'parent_id' => 632 ],

            ['master_parent_id' => 6.3, 'is_account' => 0, 'type' => 'active', 'name'=>'Publicidade e propaganda', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 63227, 'class_id' => 6, 'parent_id' => 632 ],

            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Publicidade e propaganda - Campanhas publicitárias', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 632271, 'class_id' => 6, 'parent_id' => 63227 ],
            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Publicidade e propaganda - Outros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 632272, 'class_id' => 6, 'parent_id' => 63227 ],

            ['master_parent_id' => 6.3, 'is_account' => 0, 'type' => 'active', 'name'=>'Deslocações e estadias', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 63228, 'class_id' => 6, 'parent_id' => 632 ],

            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Deslocações e estadias - Em serviço', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 632281, 'class_id' => 6, 'parent_id' => 63228 ],
            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Deslocações e estadias - Outras deslocações', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 632282, 'class_id' => 6, 'parent_id' => 63228 ],

            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Despesas de representação', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 63229, 'class_id' => 6, 'parent_id' => 632 ],

            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Contecioso e notariado', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 63231, 'class_id' => 6, 'parent_id' => 632 ],

            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Rendas e alugueres', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 63232, 'class_id' => 6, 'parent_id' => 632 ],

            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Rendas e alugueres - Locação financeira', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 632321, 'class_id' => 6, 'parent_id' => 63232 ],

            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Seguros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 63233, 'class_id' => 6, 'parent_id' => 632 ],
            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Royalties', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 63234, 'class_id' => 6, 'parent_id' => 632 ],
            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Limpeza, higiene e conforto', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 63235, 'class_id' => 6, 'parent_id' => 632 ],
            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Vigilância e segurança', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 63236, 'class_id' => 6, 'parent_id' => 632 ],
            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Trabalhos especializados', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 63237, 'class_id' => 6, 'parent_id' => 632 ],
            ['master_parent_id' => 6.3, 'is_account' => 1, 'type' => 'active', 'name'=>'Outros fornecimentos e serviços', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 63299, 'class_id' => 6, 'parent_id' => 632 ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'active', 'name'=>'Ajustamentos do período', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 64, 'class_id' => 6, 'parent_id' => null ],

            ['master_parent_id' => 6.4, 'is_account' => 1, 'type' => 'active', 'name'=>'Ajustamentos de inventários para o valor realizável líquido', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 641, 'class_id' => 6, 'parent_id' => 64 ],
            ['master_parent_id' => 6.4, 'is_account' => 1, 'type' => 'active', 'name'=>'Investimentos financeiros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 642, 'class_id' => 6, 'parent_id' => 64 ],
            ['master_parent_id' => 6.4, 'is_account' => 1, 'type' => 'active', 'name'=>'Activos tangíveis de investimento', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 643, 'class_id' => 6, 'parent_id' => 64 ],
            ['master_parent_id' => 6.4, 'is_account' => 1, 'type' => 'active', 'name'=>'Contas a receber', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 644, 'class_id' => 6, 'parent_id' => 64 ],

            ['master_parent_id' => 6.4, 'is_account' => 1, 'type' => 'active', 'name'=>'Contas a receber - ajustamentos dentro dos limites fiscais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6441, 'class_id' => 6, 'parent_id' => 644 ],
            ['master_parent_id' => 6.4, 'is_account' => 1, 'type' => 'active', 'name'=>'Contas a receber - ajustamentos para além dos limites fiscais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6442, 'class_id' => 6, 'parent_id' => 644 ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'active', 'name'=>'Amortizações do período', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 65, 'class_id' => 6, 'parent_id' => null ],

            ['master_parent_id' => 6.5, 'is_account' => 1, 'type' => 'active', 'name'=>'Activos tangíveis', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 651, 'class_id' => 6, 'parent_id' => 65 ],
            ['master_parent_id' => 6.5, 'is_account' => 1, 'type' => 'active', 'name'=>'Activos intangíveis', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 652, 'class_id' => 6, 'parent_id' => 65 ],
            ['master_parent_id' => 6.5, 'is_account' => 1, 'type' => 'active', 'name'=>'Activos tangíveis de investimentos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 653, 'class_id' => 6, 'parent_id' => 65 ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'active', 'name'=>'Provisões do período', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 66, 'class_id' => 6, 'parent_id' => null ],

            ['master_parent_id' => 6.6, 'is_account' => 1, 'type' => 'active', 'name'=>'Processos judiciais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 661, 'class_id' => 6, 'parent_id' => 66 ],
            ['master_parent_id' => 6.6, 'is_account' => 1, 'type' => 'active', 'name'=>'Acidentes no trabalho e doenças profissionais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 662, 'class_id' => 6, 'parent_id' => 66 ],
            ['master_parent_id' => 6.6, 'is_account' => 1, 'type' => 'active', 'name'=>'Impostos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 663, 'class_id' => 6, 'parent_id' => 66 ],
            ['master_parent_id' => 6.6, 'is_account' => 1, 'type' => 'active', 'name'=>'Reestruturação de negócios', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 664, 'class_id' => 6, 'parent_id' => 66 ],
            ['master_parent_id' => 6.6, 'is_account' => 1, 'type' => 'active', 'name'=>'Contratos onerosos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 665, 'class_id' => 6, 'parent_id' => 66 ],
            ['master_parent_id' => 6.6, 'is_account' => 1, 'type' => 'active', 'name'=>'Garantias a clientes', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 666, 'class_id' => 6, 'parent_id' => 66 ],
            ['master_parent_id' => 6.6, 'is_account' => 1, 'type' => 'active', 'name'=>'Perdas em contratos de construção', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 667, 'class_id' => 6, 'parent_id' => 66 ],
            ['master_parent_id' => 6.6, 'is_account' => 1, 'type' => 'active', 'name'=>'Outras provisões', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 669, 'class_id' => 6, 'parent_id' => 66 ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'active', 'name'=>'Outros gastos e perdas operacionais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 68, 'class_id' => 6, 'parent_id' => null ],

            ['master_parent_id' => 6.8, 'is_account' => 1, 'type' => 'active', 'name'=>'Despesas de investigação e pesquisa', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 681, 'class_id' => 6, 'parent_id' => 68 ],
            ['master_parent_id' => 6.8, 'is_account' => 0, 'type' => 'active', 'name'=>'Impostos e taxas', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 682, 'class_id' => 6, 'parent_id' => 68 ],

            ['master_parent_id' => 6.8, 'is_account' => 1, 'type' => 'active', 'name'=>'Direitos aduaneiros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6821, 'class_id' => 6, 'parent_id' => 682 ],
            ['master_parent_id' => 6.8, 'is_account' => 1, 'type' => 'active', 'name'=>'Imposto sobre o Valor Acrescentado', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6822, 'class_id' => 6, 'parent_id' => 682 ],
            ['master_parent_id' => 6.8, 'is_account' => 1, 'type' => 'active', 'name'=>'Imposto de selo', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6823, 'class_id' => 6, 'parent_id' => 682 ],
            ['master_parent_id' => 6.8, 'is_account' => 1, 'type' => 'active', 'name'=>'Impostos sobre veículos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6824, 'class_id' => 6, 'parent_id' => 682 ],
            ['master_parent_id' => 6.8, 'is_account' => 1, 'type' => 'active', 'name'=>'Impostos autárquicos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6825, 'class_id' => 6, 'parent_id' => 682 ],

            ['master_parent_id' => 6.8, 'is_account' => 0, 'type' => 'active', 'name'=>'Perdas em investimentos de capital', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 683, 'class_id' => 6, 'parent_id' => 68 ],

            ['master_parent_id' => 6.8, 'is_account' => 1, 'type' => 'active', 'name'=>'Alienação', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6831, 'class_id' => 6, 'parent_id' => 683 ],
            ['master_parent_id' => 6.8, 'is_account' => 1, 'type' => 'active', 'name'=>'Abates', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6832, 'class_id' => 6, 'parent_id' => 683 ],
            ['master_parent_id' => 6.8, 'is_account' => 1, 'type' => 'active', 'name'=>'Sinistros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6833, 'class_id' => 6, 'parent_id' => 683 ],

            ['master_parent_id' => 6.8, 'is_account' => 0, 'type' => 'active', 'name'=>'Perdas em inventários e activos biológicos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 684, 'class_id' => 6, 'parent_id' => 68 ],

            ['master_parent_id' => 6.8, 'is_account' => 1, 'type' => 'active', 'name'=>'Sinistros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6841, 'class_id' => 6, 'parent_id' => 684 ],
            ['master_parent_id' => 6.8, 'is_account' => 1, 'type' => 'active', 'name'=>'Quebras', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6842, 'class_id' => 6, 'parent_id' => 684 ],
            ['master_parent_id' => 6.8, 'is_account' => 1, 'type' => 'active', 'name'=>'Outras', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6849, 'class_id' => 6, 'parent_id' => 684 ],

            ['master_parent_id' => 6.8, 'is_account' => 0, 'type' => 'active', 'name'=>'Outros gastos operacionais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 689, 'class_id' => 6, 'parent_id' => 68 ],

            ['master_parent_id' => 6.8, 'is_account' => 1, 'type' => 'active', 'name'=>'Quotizações', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6891, 'class_id' => 6, 'parent_id' => 689 ],
            ['master_parent_id' => 6.8, 'is_account' => 1, 'type' => 'active', 'name'=>'Despesas confidenciais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6892, 'class_id' => 6, 'parent_id' => 689 ],
            ['master_parent_id' => 6.8, 'is_account' => 1, 'type' => 'active', 'name'=>'Ofertas e amostras de inventários', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6893, 'class_id' => 6, 'parent_id' => 689 ],
            ['master_parent_id' => 6.8, 'is_account' => 1, 'type' => 'active', 'name'=>'Programas de responsabilidades social', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6894, 'class_id' => 6, 'parent_id' => 689 ],
            ['master_parent_id' => 6.8, 'is_account' => 0, 'type' => 'active', 'name'=>'Donativos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6895, 'class_id' => 6, 'parent_id' => 689 ],

            ['master_parent_id' => 6.8, 'is_account' => 1, 'type' => 'active', 'name'=>'Donativos ao Estado', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 68951, 'class_id' => 6, 'parent_id' => 6895 ],
            ['master_parent_id' => 6.8, 'is_account' => 1, 'type' => 'active', 'name'=>'Outros donativos no âmbito do Mecenato', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 68952, 'class_id' => 6, 'parent_id' => 6895 ],

            ['master_parent_id' => 6.8, 'is_account' => 1, 'type' => 'active', 'name'=>'Multas e penalidades', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6896, 'class_id' => 6, 'parent_id' => 689 ],
            ['master_parent_id' => 6.8, 'is_account' => 1, 'type' => 'active', 'name'=>'Outros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6899, 'class_id' => 6, 'parent_id' => 689 ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'active', 'name'=>'Gastos e perdas financeiros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 69, 'class_id' => 6, 'parent_id' => null ],

            ['master_parent_id' => 6.9, 'is_account' => 0, 'type' => 'active', 'name'=>'Juros suportados', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 691, 'class_id' => 6, 'parent_id' => 69 ],

            ['master_parent_id' => 6.9, 'is_account' => 1, 'type' => 'active', 'name'=>'Empréstimos bancários', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6911, 'class_id' => 6, 'parent_id' => 691 ],
            ['master_parent_id' => 6.9, 'is_account' => 1, 'type' => 'active', 'name'=>'Empréstimos de sócios, accionistas ou proprietários', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6913, 'class_id' => 6, 'parent_id' => 691 ],
            ['master_parent_id' => 6.9, 'is_account' => 1, 'type' => 'active', 'name'=>'Outros empréstimos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6914, 'class_id' => 6, 'parent_id' => 691 ],
            ['master_parent_id' => 6.9, 'is_account' => 1, 'type' => 'active', 'name'=>'Descontos de títulos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6915, 'class_id' => 6, 'parent_id' => 691 ],
            ['master_parent_id' => 6.9, 'is_account' => 0, 'type' => 'active', 'name'=>'Juros de mora e compensatórios', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6916, 'class_id' => 6, 'parent_id' => 691 ],

            ['master_parent_id' => 6.9, 'is_account' => 1, 'type' => 'active', 'name'=>'Juros de mora', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 69161, 'class_id' => 6, 'parent_id' => 6916 ],
            ['master_parent_id' => 6.9, 'is_account' => 1, 'type' => 'active', 'name'=>'Juros compensatórios', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 69162, 'class_id' => 6, 'parent_id' => 6916 ],

            ['master_parent_id' => 6.9, 'is_account' => 1, 'type' => 'active', 'name'=>'Outros Juros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6919, 'class_id' => 6, 'parent_id' => 691 ],

            ['master_parent_id' => 6.9, 'is_account' => 0, 'type' => 'active', 'name'=>'Diferenças de câmbios desfavoráveis', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 694, 'class_id' => 6, 'parent_id' => 69 ],

            ['master_parent_id' => 6.9, 'is_account' => 1, 'type' => 'active', 'name'=>'Realizadas', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6941, 'class_id' => 6, 'parent_id' => 694 ],
            ['master_parent_id' => 6.9, 'is_account' => 1, 'type' => 'active', 'name'=>'Não Realizadas', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6942, 'class_id' => 6, 'parent_id' => 694 ],

            ['master_parent_id' => 6.9, 'is_account' => 1, 'type' => 'active', 'name'=>'Descontos de pronto pagamento concedidos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 695, 'class_id' => 6, 'parent_id' => 69 ],
            ['master_parent_id' => 6.9, 'is_account' => 0, 'type' => 'active', 'name'=>'Outros gastos e perdas financeiros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 698, 'class_id' => 6, 'parent_id' => 69 ],

            ['master_parent_id' => 6.9, 'is_account' => 1, 'type' => 'active', 'name'=>'Serviços bancários', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6981, 'class_id' => 6, 'parent_id' => 698 ],
            ['master_parent_id' => 6.9, 'is_account' => 1, 'type' => 'active', 'name'=>'Diversos não especificados', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 6989, 'class_id' => 6, 'parent_id' => 698 ],


            # CLASSE 7 - RENDIMENTOS E GANHOS

            ['master_parent_id' => null,'is_account' => 0, 'type' => 'passive', 'name'=>'Vendas', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 71, 'class_id' => 7, 'parent_id' => null ],

            ['master_parent_id' => 7.1, 'is_account' => 1, 'type' => 'passive', 'name'=>'Mercadorias', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 711, 'class_id' => 7, 'parent_id' => 71 ],
            ['master_parent_id' => 7.1, 'is_account' => 1, 'type' => 'passive', 'name'=>'Produtos acabados e intermédios', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 712, 'class_id' => 7, 'parent_id' => 71 ],
            ['master_parent_id' => 7.1, 'is_account' => 1, 'type' => 'passive', 'name'=>'Subprodutos, desperdícios, resíduos e refugos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 713, 'class_id' => 7, 'parent_id' => 71 ],
            ['master_parent_id' => 7.1, 'is_account' => 1, 'type' => 'passive', 'name'=>'Activos biológicos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 714, 'class_id' => 7, 'parent_id' => 71 ],
            ['master_parent_id' => 7.1, 'is_account' => 1, 'type' => 'passive', 'name'=>'IVA das vendas com imposto incluído', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 715, 'class_id' => 7, 'parent_id' => 71 ],
            ['master_parent_id' => 7.1, 'is_account' => 1, 'type' => 'passive', 'name'=>'Devolução de vendas', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 716, 'class_id' => 7, 'parent_id' => 71 ],
            ['master_parent_id' => 7.1, 'is_account' => 1, 'type' => 'passive', 'name'=>'Descontos e abatimentos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 717, 'class_id' => 7, 'parent_id' => 71 ],

            ['master_parent_id' => null,'is_account' => 0, 'type' => 'passive', 'name'=>'Prestação de serviços', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 72, 'class_id' => 7, 'parent_id' => null ],

            ['master_parent_id' => 7.2, 'is_account' => 1, 'type' => 'passive', 'name'=>'IVA da prestação de serviços com imposto incluído', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 721, 'class_id' => 71, 'parent_id' => 72 ],
            ['master_parent_id' => 7.2, 'is_account' => 1, 'type' => 'passive', 'name'=>'Descontos e abatimentos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 726, 'class_id' => 71, 'parent_id' => 72 ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'passive', 'name'=>'Investimentos realizados pela própria empresa', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 73, 'class_id' => 7, 'parent_id' => null ],

            ['master_parent_id' => 7.3, 'is_account' => 1, 'type' => 'passive', 'name'=>'Investimentos financeiros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 731, 'class_id' => 7, 'parent_id' => 73 ],
            ['master_parent_id' => 7.3, 'is_account' => 1, 'type' => 'passive', 'name'=>'Activos tangíveis', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 732, 'class_id' => 7, 'parent_id' => 73 ],
            ['master_parent_id' => 7.3, 'is_account' => 1, 'type' => 'passive', 'name'=>'Activos intangíveis', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 733, 'class_id' => 7, 'parent_id' => 73 ],
            ['master_parent_id' => 7.3, 'is_account' => 1, 'type' => 'passive', 'name'=>'Investimentos em curso', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 734, 'class_id' => 7, 'parent_id' => 73 ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'passive', 'name'=>'Reversões do período', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 74, 'class_id' => 7, 'parent_id' => null ],

            ['master_parent_id' => 7.4, 'is_account' => 0, 'type' => 'passive', 'name'=>'De ajustamentos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 741, 'class_id' => 7, 'parent_id' => 74 ],

            ['master_parent_id' => 7.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'Ajustamentos de inventários para o valor realizável líquido', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7411, 'class_id' => 7, 'parent_id' => 741 ],
            ['master_parent_id' => 7.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'Investimentos financeiros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7412, 'class_id' => 7, 'parent_id' => 741 ],
            ['master_parent_id' => 7.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'Activos tangíveis de investimento', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7413, 'class_id' => 7, 'parent_id' => 741 ],
            ['master_parent_id' => 7.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'Contas a receber', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7414, 'class_id' => 7, 'parent_id' => 741 ],

            ['master_parent_id' => 7.4, 'is_account' => 0, 'type' => 'passive', 'name'=>'De amortizações', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 742, 'class_id' => 7, 'parent_id' => 74 ],

            ['master_parent_id' => 7.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'Activos tangíveis', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7421, 'class_id' => 7, 'parent_id' => 742 ],
            ['master_parent_id' => 7.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'Activos intangíveis', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7422, 'class_id' => 7, 'parent_id' => 742 ],
            ['master_parent_id' => 7.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'Activos tangíveis de investimentos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7423, 'class_id' => 7, 'parent_id' => 742 ],

            ['master_parent_id' => 7.4, 'is_account' => 0, 'type' => 'passive', 'name'=>'De provisões', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 743, 'class_id' => 7, 'parent_id' => 74 ],

            ['master_parent_id' => 7.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'Processos judiciais em curso', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7431, 'class_id' => 7, 'parent_id' => 743 ],
            ['master_parent_id' => 7.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'Acidentes no trabalho e doenças profissionais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7432, 'class_id' => 7, 'parent_id' => 743 ],
            ['master_parent_id' => 7.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'Impostos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7433, 'class_id' => 7, 'parent_id' => 743 ],
            ['master_parent_id' => 7.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'Reestruturação de negócios', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7434, 'class_id' => 7, 'parent_id' => 743 ],
            ['master_parent_id' => 7.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'Contratos onerosos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7435, 'class_id' => 7, 'parent_id' => 743 ],
            ['master_parent_id' => 7.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'Garantias a clientes', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7436, 'class_id' => 7, 'parent_id' => 743 ],
            ['master_parent_id' => 7.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'Perdas em contratos de construção', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7437, 'class_id' => 7, 'parent_id' => 743 ],
            ['master_parent_id' => 7.4, 'is_account' => 1, 'type' => 'passive', 'name'=>'Outras provisões', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7438, 'class_id' => 7, 'parent_id' => 743 ],

            ['master_parent_id' => null, 'is_account' => 1, 'type' => 'passive', 'name'=>'Rendimentos suplementares', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 75, 'class_id' => 7, 'parent_id' => null ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'passive', 'name'=>'Outros rendimentos e ganhos operacionais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 76, 'class_id' => 7, 'parent_id' => null ],

            ['master_parent_id' => 7.6, 'is_account' => 0, 'type' => 'passive', 'name'=>'Subsídios para investimentos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 761, 'class_id' => 7, 'parent_id' => 76 ],

            ['master_parent_id' => 7.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'Do Estado e outros organismos públicos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7611, 'class_id' => 7, 'parent_id' => 761 ],
            ['master_parent_id' => 7.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'De outras entidades', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7619, 'class_id' => 7, 'parent_id' => 761 ],

            ['master_parent_id' => 7.6, 'is_account' => 0, 'type' => 'passive', 'name'=>'Subsídios à exploração', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 762, 'class_id' => 7, 'parent_id' => 76 ],

            ['master_parent_id' => 7.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'Do Estado e outras entidades públicas', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7621, 'class_id' => 7, 'parent_id' => 762 ],
            ['master_parent_id' => 7.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'De outras entidades', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7629, 'class_id' => 7, 'parent_id' => 762 ],

            ['master_parent_id' => 7.6, 'is_account' => 0, 'type' => 'passive', 'name'=>'Ganhos em investimentos de capital', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 763, 'class_id' => 7, 'parent_id' => 76 ],

            ['master_parent_id' => 7.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'Alienação', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7631, 'class_id' => 7, 'parent_id' => 763 ],
            ['master_parent_id' => 7.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'Sinistros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7632, 'class_id' => 7, 'parent_id' => 763 ],

            ['master_parent_id' => 7.6, 'is_account' => 0, 'type' => 'passive', 'name'=>'Ganhos em inventários e activos biológicos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 764, 'class_id' => 7, 'parent_id' => 76 ],

            ['master_parent_id' => 7.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'Sinistros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7641, 'class_id' => 7, 'parent_id' => 764 ],
            ['master_parent_id' => 7.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'Sobras', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7642, 'class_id' => 7, 'parent_id' => 764 ],
            ['master_parent_id' => 7.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'Outros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7649, 'class_id' => 7, 'parent_id' => 764 ],

            ['master_parent_id' => 7.6, 'is_account' => 0, 'type' => 'passive', 'name'=>'Outros rendimentos alheios ao valor acrescentado', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 769, 'class_id' => 7, 'parent_id' => 76 ],

            ['master_parent_id' => 7.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'Restituição de impostos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7691, 'class_id' => 7, 'parent_id' => 769 ],
            ['master_parent_id' => 7.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'Benefícios e penalidades contratuais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7692, 'class_id' => 7, 'parent_id' => 769 ],
            ['master_parent_id' => 7.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'Excesso de estimativa para impostos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7693, 'class_id' => 7, 'parent_id' => 769 ],
            ['master_parent_id' => 7.6, 'is_account' => 1, 'type' => 'passive', 'name'=>'Outros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7699, 'class_id' => 7, 'parent_id' => 769 ],

            ['master_parent_id' => null, 'is_account' => 0, 'type' => 'passive', 'name'=>'Rendimentos e ganhos financeiros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 78, 'class_id' => 7, 'parent_id' => null ],

            ['master_parent_id' => 7.8, 'is_account' => 0, 'type' => 'passive', 'name'=>'Juros obtidos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 781, 'class_id' => 7, 'parent_id' => 78 ],

            ['master_parent_id' => 7.8, 'is_account' => 1, 'type' => 'passive', 'name'=>'Depósitos bancários', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7811, 'class_id' => 7, 'parent_id' => 781 ],
            ['master_parent_id' => 7.8, 'is_account' => 1, 'type' => 'passive', 'name'=>'Empréstimos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7812, 'class_id' => 7, 'parent_id' => 781 ],
            ['master_parent_id' => 7.8, 'is_account' => 1, 'type' => 'passive', 'name'=>'Outras aplicações de tesouraria', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7814, 'class_id' => 7, 'parent_id' => 781 ],
            ['master_parent_id' => 7.8, 'is_account' => 1, 'type' => 'passive', 'name'=>'Outros juros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7819, 'class_id' => 7, 'parent_id' => 781 ],

            ['master_parent_id' => 7.8, 'is_account' => 1, 'type' => 'passive', 'name'=>'Rendimentos de activos tangíveis de investimentos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 782, 'class_id' => 7, 'parent_id' => 78 ],

            ['master_parent_id' => 7.8, 'is_account' => 1, 'type' => 'passive', 'name'=>'Rendimentos de instrumentos financeiros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 783, 'class_id' => 7, 'parent_id' => 78 ],

            ['master_parent_id' => 7.8, 'is_account' => 0, 'type' => 'passive', 'name'=>'Diferenças de câmbios favoráveis', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 784, 'class_id' => 7, 'parent_id' => 78 ],

            ['master_parent_id' => 7.8, 'is_account' => 1, 'type' => 'passive', 'name'=>'Realizadas', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7841, 'class_id' => 7, 'parent_id' => 784 ],
            ['master_parent_id' => 7.8, 'is_account' => 1, 'type' => 'passive', 'name'=>'Não realizadas', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 7842, 'class_id' => 7, 'parent_id' => 784 ],

            ['master_parent_id' => 7.8, 'is_account' => 1, 'type' => 'passive', 'name'=>'Descontos de pronto pagamento obtidos', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 785, 'class_id' => 7, 'parent_id' => 78 ],

            ['master_parent_id' => 7.8, 'is_account' => 1, 'type' => 'passive', 'name'=>'outros rendimentos e ganhos financeiros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 789, 'class_id' => 7, 'parent_id' => 78 ],

            # CLASSE 8 - RESULTADOS

            ['master_parent_id' => null, 'is_account' => 1, 'type' => 'passive', 'name'=>'Resultados operacionais', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 81, 'class_id' => 8, 'parent_id' => null ],
            ['master_parent_id' => null, 'is_account' => 1, 'type' => 'passive', 'name'=>'Resultados financeiros', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 82, 'class_id' => 8, 'parent_id' => null ],
            ['master_parent_id' => null, 'is_account' => 1, 'type' => 'passive', 'name'=>'Resultados correntes', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 83, 'class_id' => 8, 'parent_id' => null ],
            ['master_parent_id' => null, 'is_account' => 1, 'type' => 'passive', 'name'=>'Imposto sobre o rendimento', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 85, 'class_id' => 8, 'parent_id' => null ],
            ['master_parent_id' => null, 'is_account' => 1, 'type' => 'passive', 'name'=>'Resultados líquidos do período', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 88, 'class_id' => 8, 'parent_id' => null ],
            ['master_parent_id' => null, 'is_account' => 1, 'type' => 'passive', 'name'=>'Dividendos antecipados', 'initial_balance' => 0, 'account_number' => null, 'uuid' => 89, 'class_id' => 8, 'parent_id' => null ],


            



        ];
        DB::beginTransaction();
            foreach ($accounts as $acc) {
                Account::create($acc);
            }

            $accs = Account::select('id', 'uuid', 'parent_id')->get();
            foreach ($accs as $acc) {

                $var = str_split($acc->uuid,1);
                $var2 = $acc->parent_id == null ? null : str_split($acc->parent_id,1);
                $uuid = '';
                $parent_id = '';
                foreach($var as $v) {
    
                    if ( $uuid != '' ) {
                        $uuid = $uuid.'.'.$v;
                    } else {
                        $uuid = $v;
                    }        
                }

                if ($var2 != null) {
                    foreach($var2 as $va) {

                        if ( $parent_id != '' ) {
                            $parent_id = $parent_id.'.'.$va;
                        } else {
                            $parent_id = $va;
                        }        
                    }
                } else {
                    $parent_id = null;
                }


                Account::where('id', $acc->id)->update(['uuid'=>$uuid, 'parent_id'=>$parent_id]);
            }

        DB::commit();
    }
}

