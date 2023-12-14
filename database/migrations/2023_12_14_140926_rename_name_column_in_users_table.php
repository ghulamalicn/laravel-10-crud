<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the 'username' column already exists
        if (!Schema::hasColumn('users', 'user_name')) {
            // Add the new 'username' column
            Schema::table('users', function (Blueprint $table) {
                $table->string('user_name')->after('id')->nullable();
            });

            // Copy data from 'name' to 'username'
            DB::table('users')->update(['user_name' => DB::raw('name')]);

            // Make 'username' column not nullable
            Schema::table('users', function (Blueprint $table) {
                $table->string('user_name')->nullable(false)->change();
            });

            // Drop the old 'name' column
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       // Check if the 'name' column already exists
       if (!Schema::hasColumn('users', 'name')) {
            // Add the old 'name' column
            Schema::table('users', function (Blueprint $table) {
                $table->string('name')->after('id')->nullable();
            });

            // Copy data from 'username' to 'name'
            DB::table('users')->update(['name' => DB::raw('user_name')]);

            // Make 'name' column not nullable
            Schema::table('users', function (Blueprint $table) {
                $table->string('name')->nullable(false)->change();
            });

            // Drop the old 'username' column
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('user_name');
            });
        }
    }
};
