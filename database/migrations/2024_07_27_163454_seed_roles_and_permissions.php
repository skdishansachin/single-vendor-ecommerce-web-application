<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Create the 'admin' role
        $adminRole = Role::create(['name' => 'admin']);

        // Create the 'customer' role
        $customerRole = Role::create(['name' => 'customer']);

        // Create the 'product' role and its permissions
        $productRole = Role::create(['name' => 'product']);
        $createProductsPermission = Permission::create(['name' => 'create products']);
        $deleteProductsPermission = Permission::create(['name' => 'delete products']);
        $updateProductsPermission = Permission::create(['name' => 'update products']);
        $updateProductPricePermission = Permission::create(['name' => 'update products prices']); // Not assigned to the user model
        $viewProductsPermission = Permission::create(['name' => 'view products']);
        $createCollectionsPermission = Permission::create(['name' => 'create collections']);
        $deleteCollectionsPermission = Permission::create(['name' => 'delete collections']);
        $updateCollectionsPermission = Permission::create(['name' => 'update collections']);
        $viewCollectionsPermission = Permission::create(['name' => 'view collections']);

        $productRole->givePermissionTo($createProductsPermission);
        $productRole->givePermissionTo($deleteProductsPermission);
        $productRole->givePermissionTo($updateProductsPermission);
        $productRole->givePermissionTo($viewProductsPermission);
        $productRole->givePermissionTo($createCollectionsPermission);
        $productRole->givePermissionTo($deleteCollectionsPermission);
        $productRole->givePermissionTo($updateCollectionsPermission);
        $productRole->givePermissionTo($viewCollectionsPermission);

        // Create the 'order' role and its permissions
        $orderRole = Role::create(['name' => 'order']);
        $createOrdersPermission = Permission::create(['name' => 'create orders']);
        $deleteOrdersPermission = Permission::create(['name' => 'delete orders']);
        $updateOrdersPermission = Permission::create(['name' => 'update orders']);
        $viewOrdersPermission = Permission::create(['name' => 'view orders']);
        $createShippingsPermission = Permission::create(['name' => 'create shippings']);
        $deleteShippingsPermission = Permission::create(['name' => 'delete shippings']);
        $viewShippingsPermission = Permission::create(['name' => 'view shippings']);
        $updateShippingsPermission = Permission::create(['name' => 'update shippings']);

        $orderRole->givePermissionTo($createOrdersPermission);
        $orderRole->givePermissionTo($deleteOrdersPermission);
        $orderRole->givePermissionTo($updateOrdersPermission);
        $orderRole->givePermissionTo($viewOrdersPermission);
        $orderRole->givePermissionTo($createShippingsPermission);
        $orderRole->givePermissionTo($deleteShippingsPermission);
        $orderRole->givePermissionTo($viewShippingsPermission);
        $orderRole->givePermissionTo($updateShippingsPermission);

        // Create the 'user' role and its permissions
        $userRole = Role::create(['name' => 'user']);
        $viewUsersPermission = Permission::create(['name' => 'view users']);
        $updateUsersPermission = Permission::create(['name' => 'update users']);
        $deleteUsersPermission = Permission::create(['name' => 'delete users']);
        $updateUsersAccessPermission = Permission::create(['name' => 'update users access']);

        $userRole->givePermissionTo($deleteUsersPermission);
        $userRole->givePermissionTo($updateUsersPermission);
        $userRole->givePermissionTo($viewUsersPermission);

        $invitationRole = Role::create(['name' => 'invitation']);
        $createInvitationsPermission = Permission::create(['name' => 'create invitations']);
        $deleteInvitationsPermission = Permission::create(['name' => 'delete invitations']);
        $viewInvitationsPermission = Permission::create(['name' => 'view invitations']);
        $updateInvitationsPermission = Permission::create(['name' => 'update invitations']);

        $invitationRole->givePermissionTo($createInvitationsPermission);
        $invitationRole->givePermissionTo($deleteInvitationsPermission);
        $invitationRole->givePermissionTo($viewInvitationsPermission);
        $invitationRole->givePermissionTo($updateInvitationsPermission);
    }

    public function down(): void
    {
        Role::truncate();
    }
};
