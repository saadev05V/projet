<?php

// database/migrations/YYYY_MM_DD_HHMMSS_create_project_user_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_user', function (Blueprint $table) {
            // Ensure correct types for foreign keys (unsignedBigInteger for 'id' primary keys)
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Make the combination of project_id and user_id unique
            $table->primary(['project_id', 'user_id']);

            $table->timestamps(); // Optional, but good for tracking when a user was added to a project
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_user');
    }
};