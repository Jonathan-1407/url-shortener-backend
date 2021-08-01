<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrlReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('url_reports', function (Blueprint $table) {
            $table->id();
            $table->json('visitor')->default('[]');
            $table->string('report_type')->default("Spam Content");
            $table->foreignId('user_id')->constrained();
            $table->foreignId('url_shortener_id')->constrained();
            $table->boolean('state')->default(0);

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
        Schema::dropIfExists('url_reports');
    }
}
