<?php

use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use App\Role;
use App\Permission;

class EntrustSetupTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        // Create table for storing roles
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating roles to users (Many-to-Many)
        Schema::create('role_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                    ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'role_id']);
        });

        // Create table for storing permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create('permission_role', function (Blueprint $table) {
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('permission_id')->references('id')->on('permissions')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                    ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);
        });

        $userRole = new Role();
        $userRole->name = 'user';
        $userRole->display_name = 'User'; // optional
        $userRole->description = 'User'; // optional
        $userRole->save();

        $adminRole = new Role();
        $adminRole->name = 'admin';
        $adminRole->display_name = 'User Administrator'; // optional
        $adminRole->description = 'User is allowed to manage and edit other users'; // optional
        $adminRole->save();

        $searchQuestion = new Permission();
        $searchQuestion->name = 'search-question';
        $searchQuestion->display_name = 'Search questions';
        $searchQuestion->description = 'Search questions';
        $searchQuestion->save();
        
        $adminRole->attachPermission($searchQuestion);
        $userRole->attachPermission($searchQuestion);
        
        $user = User::create([
                    'name' => 'admin',
                    'email' => 'ivanchenko.andriy@gmail.com',
                    'password' => Hash::make('admin')
        ]);
        $user->save();
        $user->attachRole($adminRole);
        
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('permission_role');
        Schema::drop('permissions');
        Schema::drop('role_user');
        Schema::drop('roles');
    }

}
