<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->nullable()->after('name');
            }

            if (! Schema::hasColumn('users', 'reset_password_code_hash')) {
                $table->string('reset_password_code_hash')->nullable()->after('password');
            }

            if (! Schema::hasColumn('users', 'reset_password_code_expires_at')) {
                $table->timestamp('reset_password_code_expires_at')->nullable()->after('reset_password_code_hash');
            }

            if (! Schema::hasColumn('users', 'reset_password_code_sent_at')) {
                $table->timestamp('reset_password_code_sent_at')->nullable()->after('reset_password_code_expires_at');
            }

            if (! Schema::hasColumn('users', 'reset_password_code_attempts')) {
                $table->unsignedTinyInteger('reset_password_code_attempts')->default(0)->after('reset_password_code_sent_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'reset_password_code_attempts')) {
                $table->dropColumn('reset_password_code_attempts');
            }

            if (Schema::hasColumn('users', 'reset_password_code_sent_at')) {
                $table->dropColumn('reset_password_code_sent_at');
            }

            if (Schema::hasColumn('users', 'reset_password_code_expires_at')) {
                $table->dropColumn('reset_password_code_expires_at');
            }

            if (Schema::hasColumn('users', 'reset_password_code_hash')) {
                $table->dropColumn('reset_password_code_hash');
            }

            if (Schema::hasColumn('users', 'username')) {
                $table->dropColumn('username');
            }
        });
    }
};
