<?php

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;

use App\User;

use Spatie\Permission\Models\Role;

use App\Business;

use App\Customer;

use App\Category;

use App\Unit;

use App\Account;

use App\Product;

use App\Supplier;

class CoreTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['name'=>'role-list', 'name_to_show'=>'Listar', 'model_name'=>'role'],
            ['name'=>'role-create', 'name_to_show'=>'Criar', 'model_name'=>'role'],
            ['name'=>'role-edit', 'name_to_show'=>'Editar', 'model_name'=>'role'],
            ['name'=>'role-delete', 'name_to_show'=>'Apagar', 'model_name'=>'role'],
 
            ['name'=>'product-list', 'name_to_show'=>'Listar', 'model_name'=>'product'],
            ['name'=>'product-create', 'name_to_show'=>'Criar', 'model_name'=>'product'],
            ['name'=>'product-edit', 'name_to_show'=>'Editar', 'model_name'=>'product'],
            ['name'=>'product-delete', 'name_to_show'=>'Apagar', 'model_name'=>'product'],
 
            ['name'=>'category-list', 'name_to_show'=>'Listar', 'model_name'=>'category'],
            ['name'=>'category-create', 'name_to_show'=>'Criar', 'model_name'=>'category'],
            ['name'=>'category-edit', 'name_to_show'=>'Editar', 'model_name'=>'category'],
            ['name'=>'category-delete', 'name_to_show'=>'Apagar', 'model_name'=>'category'],
 
            ['name'=>'supplier-list', 'name_to_show'=>'Listar', 'model_name'=>'supplier'],
            ['name'=>'supplier-create', 'name_to_show'=>'Criar', 'model_name'=>'supplier'],
            ['name'=>'supplier-edit', 'name_to_show'=>'Editar', 'model_name'=>'supplier'],
            ['name'=>'supplier-delete', 'name_to_show'=>'Apagar', 'model_name'=>'supplier'],
 
            ['name'=>'unit-list', 'name_to_show'=>'Listar', 'model_name'=>'unit'],
            ['name'=>'unit-create', 'name_to_show'=>'Criar', 'model_name'=>'unit'],
            ['name'=>'unit-edit', 'name_to_show'=>'Editar', 'model_name'=>'unit'],
            ['name'=>'unit-delete', 'name_to_show'=>'Apagar', 'model_name'=>'unit'],
 
            ['name'=>'bill-list', 'name_to_show'=>'Listar', 'model_name'=>'bill'],
            ['name'=>'bill-create', 'name_to_show'=>'Criar', 'model_name'=>'bill'],
            ['name'=>'bill-edit', 'name_to_show'=>'Editar', 'model_name'=>'bill'],
            ['name'=>'bill-delete', 'name_to_show'=>'Apagar', 'model_name'=>'bill'],
 
            ['name'=>'business-list', 'name_to_show'=>'Listar', 'model_name'=>'business'],
            ['name'=>'business-create', 'name_to_show'=>'Criar', 'model_name'=>'business'],
            ['name'=>'business-edit', 'name_to_show'=>'Editar', 'model_name'=>'business'],
            ['name'=>'business-delete', 'name_to_show'=>'Apagar', 'model_name'=>'business'],
 
            ['name'=>'customer-list', 'name_to_show'=>'Listar', 'model_name'=>'customer'],
            ['name'=>'customer-create', 'name_to_show'=>'Criar', 'model_name'=>'customer'],
            ['name'=>'customer-edit', 'name_to_show'=>'Editar', 'model_name'=>'customer'],
            ['name'=>'customer-delete', 'name_to_show'=>'Apagar', 'model_name'=>'customer'],

            ['name'=>'filiation-list', 'name_to_show'=>'Listar', 'model_name'=>'filiation'],
            ['name'=>'filiation-create', 'name_to_show'=>'Criar', 'model_name'=>'filiation'],
            ['name'=>'filiation-edit', 'name_to_show'=>'Editar', 'model_name'=>'filiation'],
            ['name'=>'filiation-delete', 'name_to_show'=>'Apagar', 'model_name'=>'filiation'],
 
            ['name'=>'pos-list', 'name_to_show'=>'Listar', 'model_name'=>'pos'],
            ['name'=>'pos-create', 'name_to_show'=>'Criar', 'model_name'=>'pos'],
            ['name'=>'pos-edit', 'name_to_show'=>'Editar', 'model_name'=>'pos'],
            ['name'=>'pos-delete', 'name_to_show'=>'Apagar', 'model_name'=>'pos'],
 
            ['name'=>'purchase-list', 'name_to_show'=>'Listar', 'model_name'=>'purchase'],
            ['name'=>'purchase-create', 'name_to_show'=>'Criar', 'model_name'=>'purchase'],
            ['name'=>'purchase-edit', 'name_to_show'=>'Editar', 'model_name'=>'purchase'],
            ['name'=>'purchase-delete', 'name_to_show'=>'Apagar', 'model_name'=>'purchase'],
 
            ['name'=>'stock_change-list', 'name_to_show'=>'Listar', 'model_name'=>'stock_change'],
            ['name'=>'stock_change-create', 'name_to_show'=>'Criar', 'model_name'=>'stock_change'],
            ['name'=>'stock_change-edit', 'name_to_show'=>'Editar', 'model_name'=>'stock_change'],
            ['name'=>'stock_change-delete', 'name_to_show'=>'Apagar', 'model_name'=>'stock_change'],
 
            ['name'=>'tmp_bill-list', 'name_to_show'=>'Listar', 'model_name'=>'tmp_bill'],
            ['name'=>'tmp_bill-create', 'name_to_show'=>'Criar', 'model_name'=>'tmp_bill'],
            ['name'=>'tmp_bill-edit', 'name_to_show'=>'Editar', 'model_name'=>'tmp_bill'],
            ['name'=>'tmp_bill-delete', 'name_to_show'=>'Apagar', 'model_name'=>'tmp_bill'],
 
            ['name'=>'tmp_sell_lines-list', 'name_to_show'=>'Listar', 'model_name'=>'tmp_sell_lines'],
            ['name'=>'tmp_sell_lines-create', 'name_to_show'=>'Criar', 'model_name'=>'tmp_sell_lines'],
            ['name'=>'tmp_sell_lines-edit', 'name_to_show'=>'Editar', 'model_name'=>'tmp_sell_lines'],
            ['name'=>'tmp_sell_lines-delete', 'name_to_show'=>'Apagar', 'model_name'=>'tmp_sell_lines'],
 
            ['name'=>'transaction-list', 'name_to_show'=>'Listar', 'model_name'=>'transaction'],
            ['name'=>'transaction-create', 'name_to_show'=>'Criar', 'model_name'=>'transaction'],
            ['name'=>'transaction-edit', 'name_to_show'=>'Editar', 'model_name'=>'transaction'],
            ['name'=>'transaction-delete', 'name_to_show'=>'Apagar', 'model_name'=>'transaction'],
 
            ['name'=>'transactions_payments-list', 'name_to_show'=>'Listar', 'model_name'=>'transactions_payments'],
            ['name'=>'transactions_payments-create', 'name_to_show'=>'Criar', 'model_name'=>'transactions_payments'],
            ['name'=>'transactions_payments-edit', 'name_to_show'=>'Editar', 'model_name'=>'transactions_payments'],
            ['name'=>'transactions_payments-delete', 'name_to_show'=>'Apagar', 'model_name'=>'transactions_payments'],
 
            ['name'=>'transactions_sell_lines-list', 'name_to_show'=>'Listar', 'model_name'=>'transactions_sell_lines'],
            ['name'=>'transactions_sell_lines-create', 'name_to_show'=>'Criar', 'model_name'=>'transactions_sell_lines'],
            ['name'=>'transactions_sell_lines-edit', 'name_to_show'=>'Editar', 'model_name'=>'transactions_sell_lines'],
            ['name'=>'transactions_sell_lines-delete', 'name_to_show'=>'Apagar', 'model_name'=>'transactions_sell_lines'],
 
            ['name'=>'transfer-list', 'name_to_show'=>'Listar', 'model_name'=>'transfer'],
            ['name'=>'transfer-create', 'name_to_show'=>'Criar', 'model_name'=>'transfer'],
            ['name'=>'transfer-edit', 'name_to_show'=>'Editar', 'model_name'=>'transfer'],
            ['name'=>'transfer-delete', 'name_to_show'=>'Apagar', 'model_name'=>'transfer'],
 
            ['name'=>'wastage-list', 'name_to_show'=>'Listar', 'model_name'=>'wastage'],
            ['name'=>'wastage-create', 'name_to_show'=>'Criar', 'model_name'=>'wastage'],
            ['name'=>'wastage-edit', 'name_to_show'=>'Editar', 'model_name'=>'wastage'],
            ['name'=>'wastage-delete', 'name_to_show'=>'Apagar', 'model_name'=>'wastage'],

            ['name'=>'expense-list', 'name_to_show'=>'Listar', 'model_name'=>'expense'],
            ['name'=>'expense-create', 'name_to_show'=>'Criar', 'model_name'=>'expense'],
            ['name'=>'expense-edit', 'name_to_show'=>'Editar', 'model_name'=>'expense'],
            ['name'=>'expense-delete', 'name_to_show'=>'Apagar', 'model_name'=>'expense'],

            ['name'=>'asset-list', 'name_to_show'=>'Listar', 'model_name'=>'asset'],
            ['name'=>'asset-create', 'name_to_show'=>'Criar', 'model_name'=>'asset'],
            ['name'=>'asset-edit', 'name_to_show'=>'Editar', 'model_name'=>'asset'],
            ['name'=>'asset-delete', 'name_to_show'=>'Apagar', 'model_name'=>'asset'],

            ['name'=>'divers-list', 'name_to_show'=>'Listar', 'model_name'=>'divers'],
            ['name'=>'divers-create', 'name_to_show'=>'Criar', 'model_name'=>'divers'],
            ['name'=>'divers-edit', 'name_to_show'=>'Editar', 'model_name'=>'divers'],
            ['name'=>'divers-delete', 'name_to_show'=>'Apagar', 'model_name'=>'divers'],

            ['name'=>'request-list', 'name_to_show'=>'Listar', 'model_name'=>'request'],
            ['name'=>'request-create', 'name_to_show'=>'Criar', 'model_name'=>'request'],
            ['name'=>'request-edit', 'name_to_show'=>'Editar', 'model_name'=>'request'],
            ['name'=>'request-delete', 'name_to_show'=>'Apagar', 'model_name'=>'request'],

            ['name'=>'account-list', 'name_to_show'=>'Listar', 'model_name'=>'account'],
            ['name'=>'account-create', 'name_to_show'=>'Criar', 'model_name'=>'account'],
            ['name'=>'account-edit', 'name_to_show'=>'Editar', 'model_name'=>'account'],
            ['name'=>'account-delete', 'name_to_show'=>'Apagar', 'model_name'=>'account'],

            
            ['name'=>'asset_payment-list', 'name_to_show'=>'Listar', 'model_name'=>'asset_payment'],
            ['name'=>'asset_payment-create', 'name_to_show'=>'Criar', 'model_name'=>'asset_payment'],
            ['name'=>'asset_payment-edit', 'name_to_show'=>'Editar', 'model_name'=>'asset_payment'],
            ['name'=>'asset_payment-delete', 'name_to_show'=>'Apagar', 'model_name'=>'asset_payment'],

            
            ['name'=>'assetcategory-list', 'name_to_show'=>'Listar', 'model_name'=>'assetcategory'],
            ['name'=>'assetcategory-create', 'name_to_show'=>'Criar', 'model_name'=>'assetcategory'],
            ['name'=>'assetcategory-edit', 'name_to_show'=>'Editar', 'model_name'=>'assetcategory'],
            ['name'=>'assetcategory-delete', 'name_to_show'=>'Apagar', 'model_name'=>'assetcategory'],

            
            
         ];

         
         
         foreach ($permissions as $permission) {
            Permission::create($permission);
         }


        
   
        $imageName = '1-logo.png';

        $business = Business::create([
            'business_name' => 'TTMInc',
            'phone' => '8745362672',
            'nuit' => '129988172',
            'owner_id' => '110011882800B',
            'city' => 'Matola',
            'province' => 'Maputo',
            'creation_date' => date('Y-m-d'),
            'image' => $imageName,
        ]);

            $user = User::create([
            'first_name' => 'Naruto',
            'second_name' => 'Uzumaki',
            'username' => 'Uzumaki',
            'gender' => 'M',
            'email' => 'glu@ttm.com',
            'password' => Hash::make('#ttm0000'),
        ]);

        $role = Role::create(['name' => 'Admin', 'guard_name' => 'web']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
                      
        DB::beginTransaction();
        
        $customer = Customer::create([
            'name' => 'TTMInc',
            'phone' => '8745362672',
            'nuit' => '12998172',
           // 'customer_id' => '110011882800B',
            'city' => 'Matola',
            'country' => 'Moz',
            'province' => 'Maputo',
            'date' => date('Y-m-d'),
            'business_id' => 1,
            'created_by' => 1,
        ]);

        $customer = Supplier::create([
            'name' => 'TTMInc',
            'phone' => '8745362672',
            'nuit' => '12988172',
            'city' => 'Matola',
            'province' => 'Maputo',
            'date' => date('Y-m-d'),
            'country' => 'Moz',
            'business_id' => 1,
            'created_by' => 1,
        ]);

        $category = Category::create([
            'name' => 'FOOD',
            'short_code' => 'TTM0001',
            'created_by' => 1,
            'business_id' => 1,
        ]);

        $units = Unit::create([
            'name' => 'Quilos',
            'allow_decimal' => 1,
            'short_name' => 'kg',
            'created_by' => 1,
            'business_id' => 1,
        ]);

        $business = Product::create([
            'created_by' => 1,
            'name' => 'Pao de Hamburgue',
            'sku' => 'TTM0001',
            'description' => '',
            'category_id' => 1,
            'unit_id' => 1,
            'barcode_type' =>  'code128',
            'alert_quantity' => 15,
            'affects_store' => 1, //in case true, 1 else 0
            'image' => "1-logo.png" ,
            'business_id' => 1,
        ]);



       

        DB::commit();
    }
}
