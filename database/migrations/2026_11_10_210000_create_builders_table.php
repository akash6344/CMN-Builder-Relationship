<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('builders', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('owner_name');
            $table->string('company_name');
            $table->string('city')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('gst')->nullable();
            $table->string('rera')->nullable();
            $table->string('pan')->nullable();
            $table->string('subscription')->default('Starter');
            $table->string('status')->default('Active');
            $table->string('manager')->default('Anita Rao');
            $table->unsignedInteger('projects_count')->default(0);
            $table->decimal('revenue_lakhs', 10, 2)->default(0);
            $table->unsignedTinyInteger('trust_score')->default(80);
            $table->decimal('rating', 3, 1)->default(4.5);
            $table->string('kyc_status')->default('Pending');
            $table->unsignedInteger('support_tickets')->default(0);
            $table->boolean('featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('builders');
    }
};
