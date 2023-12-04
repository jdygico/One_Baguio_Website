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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string("where");
            $table->datetime("book_date");
            $table->set("purpose",["Symptomatic ","Routine ","Follow-up","Consultation","Preoperative","Postoperative","Urgent","Others"]);
            $table->set("status", ["Not Arrived", "Waiting", "Consulting", "Finished"])->default("Not Arrived");
            $table->string("booked_by");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
