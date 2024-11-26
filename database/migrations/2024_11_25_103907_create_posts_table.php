<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeRoleEnumToVarchar extends Migration
{
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            // Change the column type from enum to varchar (with a suitable length)
            $table->string('role', 255)->change();
        });
    }

    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            // Revert back to enum type if needed
            $table->enum('role', ['Admin', 'Donor', 'User'])->change();
        });
    }
}
