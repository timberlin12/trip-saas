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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('logo')->nullable();          // storage path
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('zip')->nullable();
            $table->string('email')->nullable();

            // Owner details (initial owner/contact)
            $table->string('owner_name');
            $table->string('owner_email');
            $table->string('owner_mobile')->nullable();
            $table->string('owner_designation')->nullable();

            // DB connection details for tenant DB (stored encrypted)
            $table->string('db_host')->default('127.0.0.1');
            $table->string('db_port')->default('3306');
            $table->string('db_name')->unique();
            $table->string('db_username');
            $table->string('db_password')->nullable(); // will store encrypted string

            // Optional: custom domain + plan
            $table->string('domain')->nullable();
            $table->unsignedBigInteger('plan_id')->nullable();

            $table->boolean('status')->default(true);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('plan_id')->references('id')->on('pricing_plans')->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
