<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('law_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('api_service_id')
                ->index()
                ->constrained()
                ->onDelete('cascade');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->jsonb('config')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('law_services');
    }
};
