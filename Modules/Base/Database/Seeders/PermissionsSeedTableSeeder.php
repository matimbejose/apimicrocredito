<?php

namespace Modules\Base\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\Base\Entities\Permission;

class PermissionsSeedTableSeeder extends Seeder
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
            ['name'=>'role-view', 'name_to_show'=>'Listar', 'model_name'=>'role'],
            ['name'=>'role-create', 'name_to_show'=>'Criar', 'model_name'=>'role'],
            ['name'=>'role-edit', 'name_to_show'=>'Editar', 'model_name'=>'role'],
            ['name'=>'role-delete', 'name_to_show'=>'Apagar', 'model_name'=>'role'],
 
            ['name'=>'product-view', 'name_to_show'=>'Listar', 'model_name'=>'product'],
            ['name'=>'product-create', 'name_to_show'=>'Criar', 'model_name'=>'product'],
            ['name'=>'product-edit', 'name_to_show'=>'Editar', 'model_name'=>'product'],
            ['name'=>'product-delete', 'name_to_show'=>'Apagar', 'model_name'=>'product'],
 
            ['name'=>'category-view', 'name_to_show'=>'Listar', 'model_name'=>'category'],
            ['name'=>'category-create', 'name_to_show'=>'Criar', 'model_name'=>'category'],
            ['name'=>'category-edit', 'name_to_show'=>'Editar', 'model_name'=>'category'],
            ['name'=>'category-delete', 'name_to_show'=>'Apagar', 'model_name'=>'category'],
 
            ['name'=>'supplier-view', 'name_to_show'=>'Listar', 'model_name'=>'supplier'],
            ['name'=>'supplier-create', 'name_to_show'=>'Criar', 'model_name'=>'supplier'],
            ['name'=>'supplier-edit', 'name_to_show'=>'Editar', 'model_name'=>'supplier'],
            ['name'=>'supplier-delete', 'name_to_show'=>'Apagar', 'model_name'=>'supplier'],
 
            ['name'=>'unit-view', 'name_to_show'=>'Listar', 'model_name'=>'unit'],
            ['name'=>'unit-create', 'name_to_show'=>'Criar', 'model_name'=>'unit'],
            ['name'=>'unit-edit', 'name_to_show'=>'Editar', 'model_name'=>'unit'],
            ['name'=>'unit-delete', 'name_to_show'=>'Apagar', 'model_name'=>'unit'],
 
            ['name'=>'bill-view', 'name_to_show'=>'Listar', 'model_name'=>'bill'],
            ['name'=>'bill-create', 'name_to_show'=>'Criar', 'model_name'=>'bill'],
            ['name'=>'bill-edit', 'name_to_show'=>'Editar', 'model_name'=>'bill'],
            ['name'=>'bill-delete', 'name_to_show'=>'Apagar', 'model_name'=>'bill'],
 
            ['name'=>'business-view', 'name_to_show'=>'Listar', 'model_name'=>'business'],
            ['name'=>'business-create', 'name_to_show'=>'Criar', 'model_name'=>'business'],
            ['name'=>'business-edit', 'name_to_show'=>'Editar', 'model_name'=>'business'],
            ['name'=>'business-delete', 'name_to_show'=>'Apagar', 'model_name'=>'business'],
 
            ['name'=>'customer-view', 'name_to_show'=>'Listar', 'model_name'=>'customer'],
            ['name'=>'customer-create', 'name_to_show'=>'Criar', 'model_name'=>'customer'],
            ['name'=>'customer-edit', 'name_to_show'=>'Editar', 'model_name'=>'customer'],
            ['name'=>'customer-delete', 'name_to_show'=>'Apagar', 'model_name'=>'customer'],

            ['name'=>'filiation-view', 'name_to_show'=>'Listar', 'model_name'=>'filiation'],
            ['name'=>'filiation-create', 'name_to_show'=>'Criar', 'model_name'=>'filiation'],
            ['name'=>'filiation-edit', 'name_to_show'=>'Editar', 'model_name'=>'filiation'],
            ['name'=>'filiation-delete', 'name_to_show'=>'Apagar', 'model_name'=>'filiation'],
 
            ['name'=>'pos-view', 'name_to_show'=>'Listar', 'model_name'=>'pos'],
            ['name'=>'pos-create', 'name_to_show'=>'Criar', 'model_name'=>'pos'],
            ['name'=>'pos-edit', 'name_to_show'=>'Editar', 'model_name'=>'pos'],
            ['name'=>'pos-delete', 'name_to_show'=>'Apagar', 'model_name'=>'pos'],
 
            ['name'=>'purchase-view', 'name_to_show'=>'Listar', 'model_name'=>'purchase'],
            ['name'=>'purchase-create', 'name_to_show'=>'Criar', 'model_name'=>'purchase'],
            ['name'=>'purchase-edit', 'name_to_show'=>'Editar', 'model_name'=>'purchase'],
            ['name'=>'purchase-delete', 'name_to_show'=>'Apagar', 'model_name'=>'purchase'],
 
            ['name'=>'stock_change-view', 'name_to_show'=>'Listar', 'model_name'=>'stock_change'],
            ['name'=>'stock_change-create', 'name_to_show'=>'Criar', 'model_name'=>'stock_change'],
            ['name'=>'stock_change-edit', 'name_to_show'=>'Editar', 'model_name'=>'stock_change'],
            ['name'=>'stock_change-delete', 'name_to_show'=>'Apagar', 'model_name'=>'stock_change'],
 
            ['name'=>'tmp_bill-view', 'name_to_show'=>'Listar', 'model_name'=>'tmp_bill'],
            ['name'=>'tmp_bill-create', 'name_to_show'=>'Criar', 'model_name'=>'tmp_bill'],
            ['name'=>'tmp_bill-edit', 'name_to_show'=>'Editar', 'model_name'=>'tmp_bill'],
            ['name'=>'tmp_bill-delete', 'name_to_show'=>'Apagar', 'model_name'=>'tmp_bill'],
 
            ['name'=>'tmp_sell_lines-view', 'name_to_show'=>'Listar', 'model_name'=>'tmp_sell_lines'],
            ['name'=>'tmp_sell_lines-create', 'name_to_show'=>'Criar', 'model_name'=>'tmp_sell_lines'],
            ['name'=>'tmp_sell_lines-edit', 'name_to_show'=>'Editar', 'model_name'=>'tmp_sell_lines'],
            ['name'=>'tmp_sell_lines-delete', 'name_to_show'=>'Apagar', 'model_name'=>'tmp_sell_lines'],
 
            ['name'=>'transaction-view', 'name_to_show'=>'Listar', 'model_name'=>'transaction'],
            ['name'=>'transaction-create', 'name_to_show'=>'Criar', 'model_name'=>'transaction'],
            ['name'=>'transaction-edit', 'name_to_show'=>'Editar', 'model_name'=>'transaction'],
            ['name'=>'transaction-delete', 'name_to_show'=>'Apagar', 'model_name'=>'transaction'],
 
            ['name'=>'transactions_payments-view', 'name_to_show'=>'Listar', 'model_name'=>'transactions_payments'],
            ['name'=>'transactions_payments-create', 'name_to_show'=>'Criar', 'model_name'=>'transactions_payments'],
            ['name'=>'transactions_payments-edit', 'name_to_show'=>'Editar', 'model_name'=>'transactions_payments'],
            ['name'=>'transactions_payments-delete', 'name_to_show'=>'Apagar', 'model_name'=>'transactions_payments'],
 
            ['name'=>'transactions_sell_lines-view', 'name_to_show'=>'Listar', 'model_name'=>'transactions_sell_lines'],
            ['name'=>'transactions_sell_lines-create', 'name_to_show'=>'Criar', 'model_name'=>'transactions_sell_lines'],
            ['name'=>'transactions_sell_lines-edit', 'name_to_show'=>'Editar', 'model_name'=>'transactions_sell_lines'],
            ['name'=>'transactions_sell_lines-delete', 'name_to_show'=>'Apagar', 'model_name'=>'transactions_sell_lines'],
 
            ['name'=>'transfer-view', 'name_to_show'=>'Listar', 'model_name'=>'transfer'],
            ['name'=>'transfer-create', 'name_to_show'=>'Criar', 'model_name'=>'transfer'],
            ['name'=>'transfer-edit', 'name_to_show'=>'Editar', 'model_name'=>'transfer'],
            ['name'=>'transfer-delete', 'name_to_show'=>'Apagar', 'model_name'=>'transfer'],
 
            ['name'=>'wastage-view', 'name_to_show'=>'Listar', 'model_name'=>'wastage'],
            ['name'=>'wastage-create', 'name_to_show'=>'Criar', 'model_name'=>'wastage'],
            ['name'=>'wastage-edit', 'name_to_show'=>'Editar', 'model_name'=>'wastage'],
            ['name'=>'wastage-delete', 'name_to_show'=>'Apagar', 'model_name'=>'wastage'],

            ['name'=>'expense-view', 'name_to_show'=>'Listar', 'model_name'=>'expense'],
            ['name'=>'expense-create', 'name_to_show'=>'Criar', 'model_name'=>'expense'],
            ['name'=>'expense-edit', 'name_to_show'=>'Editar', 'model_name'=>'expense'],
            ['name'=>'expense-delete', 'name_to_show'=>'Apagar', 'model_name'=>'expense'],

            ['name'=>'asset-view', 'name_to_show'=>'Listar', 'model_name'=>'asset'],
            ['name'=>'asset-create', 'name_to_show'=>'Criar', 'model_name'=>'asset'],
            ['name'=>'asset-edit', 'name_to_show'=>'Editar', 'model_name'=>'asset'],
            ['name'=>'asset-delete', 'name_to_show'=>'Apagar', 'model_name'=>'asset'],

            ['name'=>'divers-view', 'name_to_show'=>'Listar', 'model_name'=>'divers'],
            ['name'=>'divers-create', 'name_to_show'=>'Criar', 'model_name'=>'divers'],
            ['name'=>'divers-edit', 'name_to_show'=>'Editar', 'model_name'=>'divers'],
            ['name'=>'divers-delete', 'name_to_show'=>'Apagar', 'model_name'=>'divers'],

            ['name'=>'request-view', 'name_to_show'=>'Listar', 'model_name'=>'request'],
            ['name'=>'request-create', 'name_to_show'=>'Criar', 'model_name'=>'request'],
            ['name'=>'request-edit', 'name_to_show'=>'Editar', 'model_name'=>'request'],
            ['name'=>'request-delete', 'name_to_show'=>'Apagar', 'model_name'=>'request'],

            ['name'=>'account-view', 'name_to_show'=>'Listar', 'model_name'=>'account'],
            ['name'=>'account-create', 'name_to_show'=>'Criar', 'model_name'=>'account'],
            ['name'=>'account-edit', 'name_to_show'=>'Editar', 'model_name'=>'account'],
            ['name'=>'account-delete', 'name_to_show'=>'Apagar', 'model_name'=>'account'],

            
            ['name'=>'asset_payment-view', 'name_to_show'=>'Listar', 'model_name'=>'asset_payment'],
            ['name'=>'asset_payment-create', 'name_to_show'=>'Criar', 'model_name'=>'asset_payment'],
            ['name'=>'asset_payment-edit', 'name_to_show'=>'Editar', 'model_name'=>'asset_payment'],
            ['name'=>'asset_payment-delete', 'name_to_show'=>'Apagar', 'model_name'=>'asset_payment'],

            
            ['name'=>'assetcategory-view', 'name_to_show'=>'Listar', 'model_name'=>'assetcategory'],
            ['name'=>'assetcategory-create', 'name_to_show'=>'Criar', 'model_name'=>'assetcategory'],
            ['name'=>'assetcategory-edit', 'name_to_show'=>'Editar', 'model_name'=>'assetcategory'],
            ['name'=>'assetcategory-delete', 'name_to_show'=>'Apagar', 'model_name'=>'assetcategory'],

            
            
         ];

         
         
         foreach ($permissions as $permission) {
            Permission::create($permission);
         }
    }
}
