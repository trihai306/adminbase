<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToPermissionsTable extends Migration
{
    public function up()
    {
        $tableNames = config('permission.table_names');

        Schema::table($tableNames['roles'], function (Blueprint $table) {
            $table->string('display_name')->after('guard_name');
            $table->boolean('is_system')->default(false)->after('display_name');
        });
    }

    public function down()
    {
        $tableNames = config('permission.table_names');

        Schema::table($tableNames['roles'], function (Blueprint $table) {
            $table->dropColumn([
                'display_name',
                'is_system'
            ]);
        });
    }
}
