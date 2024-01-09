<?php

namespace Database\Seeders;

use App\Http\Controllers\Setting\UserManagementSystemController;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = UserManagementSystemController::adminMenuList();

        foreach ($data['admin_menu'] as $admin_menus) {
            // dd($admin_menus);
            foreach ($admin_menus['child'] as $child){
                //  dd($child);
                if($child['dname'] != ""){
                    foreach ($child['action'] as $module_act){
                        $name = $child['name'].'-'.$module_act;
                        if(!Permission::where('name',$name)->exists()){
                            $createPermission =  new Permission();
                            $createPermission->name = $name;
                            $createPermission->display_name = $child['dname'];
                            $createPermission->description = ucfirst($module_act);
                            $createPermission->save();
                        }
                    }
                }else{
                    //  dd($child);
                    foreach ($child['sub_child'] as $subchild){
                        foreach ($subchild['action'] as $module_act) {
                            $name = $subchild['name'].'-'.$module_act;
                            if(!Permission::where('name',$name)->exists()){
                                $createPermission =  new Permission();
                                $createPermission->name = $name;
                                $createPermission->display_name = $subchild['dname'];
                                $createPermission->description = ucfirst($module_act);
                                $createPermission->save();
                            }
                        }
                    }
                }
            }
        }

        $permissions = Permission::pluck('id')->toArray();
        $user = User::where('email','admin@gmail.com')->first();
        $user->detachPermissions($permissions);
        $user->attachPermissions($permissions);
    }
}
