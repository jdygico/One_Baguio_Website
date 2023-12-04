<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("patients", function (Blueprint $table) {
            $table->id();
            $table->set("prefix", ["None", "Mr.", "Mrs.", "Ms."]);
            $table->string("last_name");
            $table->string("first_name")->nullable();
            $table->string("middle_name");
            $table->set("suffix", ["None", "Sr", "Jr","Others"]);
            $table->set("sex", ["Male", "Female"]);
            $table->date("birth_date");
            $table->string("birth_place")->nullable();
            $table->set("civil_status", ["Single", "Married", "Divorced", "Separated", "Widowed"])->nullable();
            $table->string("maiden_last_name")->nullable();
            $table->string("maiden_middle_name")->nullable();
            $table->set("educational_attainment", ["None", "Primary", "Secondary", "Vocational", "Tertiary"]);
            $table->set("employment_status", ["Employed", "Unemployed"])->nullable();
            $table->string("occupation");
            $table->string("monthly_income")->nullable();
            $table->set("nationality", ["Filipino", "Other"])->nullable();
            $table->string("tax_identification")->nullable();
            $table->set("religion", ["None", "Roman Catholic", "Protestant", "Christian", "Muslim", "Other"])->nullable();
            $table->set("ethnic_group", ["Tagalog", "Cebuano ", "Ilocano ", "Bicolano ", "Waray ", "Kapampangan ", "Pangasinense ","Tausug ","Ilonggo ","Maguindanaoan "])->nullable();
            $table->set("indigenous", ["Yes", "No"])->nullable();
            $table->string("number_street_name")->nullable();
            $table->enum("barangay", ["Abanao-Zandueta-Kayong-Chugum", "Alfonso Tabora", "Ambiong", "Andres Bonifacio",
            "Apugan-Loakan", "Asin Road", "Atok Trail", "Aurora Hill Proper", "Aurora Hill(North Central)",
            "Aurora Hill(South Central)", "Bagong Lipunan (Market Area)",
            "Bakakeng Central", "Bakakeng North", "Bal-Marcoville (Marcoville)", "Balsigan", "Bayan Park East",
            "Bayan Park Village", "Bayan Park West (Bayan Park)","BGH Compound","Bonifacio-Caguioa-Rimando",
            "Brookside", "Brookspoint","Cabinet Hill-Teachers Camp", "Camdas Subdivision", "Camp 7", "Camp 8",
            "Camp Allen","Campo Filipino","City Camp Central","City Camp Proper","Country Club Village","Cresencia Village Barangay",
            "Dagsian (Lower)","Dagsian(Upper)","Department of Public Services (DPS) Compound","Dizon Subdivision","Dominican Hill Mirador",
            "Dontogan","Engineers Hill","Fairview Village","Ferdinand (Happy Homes-Campo)","Fort del Pilar","Gabriela Silang","General Emilio F. Aguinaldo",
            "General Luna (Lower)","General Luna (Upper)","Gibraltar","Greenwater Village","Guisad Central","Guisad Sorong","Happy Hollow",
            "Happy Homes (Happy Homes-Lucban)","Harrison-Claudio Carantes","Hillside","Holy Ghost Extension","Holy Ghost Proper","Honeymoon (Honeymoon-Holy Ghost)",
            "Imelda R. Marcos (La Salle)","Imelda Village","Irisan","Kabayanihan","Kagitingan","Kayang Extension","Kayang-Hilltop","Kias","Legarda-Burnham-Kisad",
            "Liwanag-Loakan","Loakan Proper","Lopez Jaena","Lourdes Subdivision Extension","Lourdes Subdivision (Lower)","Lourdes Subdivision (Proper)","Lualhati",
            "Lucnab","Magsaysay Private Road","Magsaysay (Lower)","Magsaysay (Upper)","Malcolm Square-Perfecto","Manuel A. Roxas","Market Subdivision (Upper)",
            "Middle Quezon Hill Subdivision","Military Cut-off","Mines View Park","Modern Site (East)","Modern Site (West)","MRR-Queen Of Peace","New Lucban",
            "Outlook Drive","Pacdal","Padre Burgos","Padre Zamora","Palma-Urbano","Phil-Am","Pinget","Pinsao Pilot Project","Pinsao Proper","Pucsusan",
            "Puliwes","Quezon Hill Proper","Quezon Hill (Upper)","Quirino Hill (East)","Quirino Hill (Lower)","Quirino Hill (Middle)","Quirino Hill (West)",
            "Quirino-Magsaysay (Upper)","Rizal Monument Area","Rock Quarry (Lower)","Rock Quarry (Middle)","Rock Quarry (Upper)","Saint Joseph Village",
            "Salud Mitra","San Antonio Village","San Luis Village","San Roque Village","San Vicente","Sanitary Camp (South)","Sanitary Camp (North)",
            "Santa Escolastica","Santo Rosario Valley","Santo Tomas Proper","Santo Tomas School Area","Scout Barrio","Session Road Area", "Slaughter House Area",
            "SLU-SVP Housing Village","South Drive","Teodora Alonzo","Trancoville","Victoria Village"]);
            $table->set("blood_type", ["A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"])->nullable();
            $table->string("mobile")->nullable();
            $table->string("landline")->nullable();
            $table->string("email")->nullable();
            $table->string("mother_last_name")->nullable();
            $table->string("mother_first_name")->nullable();
            $table->string("mother_middle_name")->nullable();
            $table->date("mother_birth_date")->nullable();
            $table->set("dsdw_member", ["Yes", "No"]);
            $table->string("facility_household_no");
            $table->string("household_no");
            $table->set("pantawid_member", ["Yes", "No"]);
            $table->string("pantawid_member_no");
            $table->string("family_serial_no");
            $table->set("philhealth_member", ["Yes", "No"]);
            $table->set("philhealth_status", ["Active", "Inactive"]);
            $table->string("philhealth_no");
            $table->set("philhealth_category", ["Formal Economy", "Informal Economy", "OFW", "Senior Citizen","Lifetime","Sponsored","Indigent","Qualified Dependent"]);
            $table->set("pcb_member", ["Yes", "No"]);
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
        Schema::dropIfExists("patients");
    }
};
