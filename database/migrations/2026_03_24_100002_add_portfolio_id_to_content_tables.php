<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'personal_infos',
            'user_profile_links',
            'educations',
            'services',
            'skills',
            'work_experiences',
            'projects',
            'ar_models',
        ];

        foreach ($tables as $tableName) {
            if (!Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (!Schema::hasColumn($tableName, 'portfolio_id')) {
                    $table->foreignId('portfolio_id')->nullable()->after('user_id')->constrained('portfolios')->nullOnDelete();
                }
            });
        }

        if (Schema::hasTable('personal_infos')) {
            Schema::table('personal_infos', function (Blueprint $table) {
                $table->dropUnique(['email']);
            });
        }
    }

    public function down(): void
    {
        $tables = [
            'personal_infos',
            'user_profile_links',
            'educations',
            'services',
            'skills',
            'work_experiences',
            'projects',
            'ar_models',
        ];

        foreach ($tables as $tableName) {
            if (!Schema::hasTable($tableName) || !Schema::hasColumn($tableName, 'portfolio_id')) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) {
                $table->dropConstrainedForeignId('portfolio_id');
            });
        }

        if (Schema::hasTable('personal_infos')) {
            Schema::table('personal_infos', function (Blueprint $table) {
                $table->unique('email');
            });
        }
    }
};
