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
        Schema::create('consults', function (Blueprint $table) {
            $table->id();
            $table->set("nature",["Diagnostic","Treatment","Follow-up","Preventive","Consultation","Emergency","Others"])->nullable();
            $table->string("purpose")->nullable();
            $table->datetime("consult_datetime")->nullable();
            $table->string("age")->nullable();
            $table->set("mode_of_transaction",["Cash","Credit/Debit Card","Gcash","Bank Transfer"])->nullable();
            $table->string("height")->nullable();
            $table->string("weight")->nullable();
            $table->string("BMI")->nullable();
            $table->string("bmi_category")->nullable();
            $table->string("name_of_attending_provider")->nullable();
            $table->string("complaint")->nullable();
            $table->set("patient_consent",["Yes","No"])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consults');
    }
};
