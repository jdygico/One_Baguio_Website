<template>
    <AuthenticatedLayout>
        <body>
            <div class="main-block">
                <form action="/">
                    <fieldset style="margin-top: 0px;">
                        <legend>
                            <h3>Personal Information</h3>
                        </legend>
                        <div class="grid grid-cols-12 grid-flow-row gap-4 mx-2">
                            <div>
                                <label for="formPatientPrefix" class="block text-gray-700 text-sm font-bold mb-2"><span class="text-red-500">*</span> Prefix:
                                </label>
                                <select id="formPatientPrefix" v-model="patient_instance.prefix"
                                    :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option disabled :value="null"> --Select Prefix-- </option>
                                    <option v-for="option in prefix_options" v-bind:value="option">{{ option }}</option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientLastName" class="block text-gray-700 text-sm font-bold mb-2"><span class="text-red-500">*</span> Last
                                    Name:</label>
                                <input type="text" v-model="patient_instance.last_name"
                                    :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="formPatientLastName" placeholder="Enter Last Name">
                            </div>
                            <div class="col-span-3">
                                <label for="formPatientFirstName" class="block text-gray-700 text-sm font-bold mb-2">First
                                    Name:</label>
                                <input type="text" v-model="patient_instance.first_name"
                                    :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="formPatientFirstName">
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientMiddleName" class="block text-gray-700 text-sm font-bold mb-2"><span class="text-red-500">*</span> Middle
                                    Name:</label>
                                <input type="text" v-model="patient_instance.middle_name"
                                    :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="formPatientMiddleName" placeholder="Enter Middle Name">
                            </div>
                            <div>
                                <label for="formPatientSuffix"
                                    class="block text-gray-700 text-sm font-bold mb-2"><span class="text-red-500">*</span> Suffix:</label>
                                <select id="formPatientSuffix" v-model="patient_instance.suffix"
                                    :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option disabled :value="null"> --Select Suffix-- </option>
                                    <option v-for="option in suffix_options" v-bind:value="option">{{ option }}</option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientSex" class="block text-gray-700 text-sm font-bold mb-2"><span class="text-red-500">*</span> Sex:</label>
                                <input type="radio" id="formPatientSex-male" value="Male" v-model="patient_instance.sex" :disabled=!isEdit>
                                <label for="formPatientSex-male" class="ml-1 mr-4">Male</label>
                                <input type="radio" id="formPatientSex-female" value="Female" v-model="patient_instance.sex" :disabled=!isEdit>
                                <label for="formPatientSex-female" class="ml-1 mr-4">Female</label>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>
                            <h3>Related Information</h3>
                        </legend>
                        <div class="grid grid-cols-12 grid-flow-row gap-4 mx-2">
                            <div class="col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Nature of Visit:</label>
                                <select 
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <!-- <option disabled :value="null"> --Select Category-- </option> -->
                                    <option v-for="option in nature_options" v-bind:value="option">{{ option }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Purpose of Visit:</label>
                                <input type="text" 
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    placeholder="Enter PhilHealth Number">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Consult Date and Time:</label>
                                <Datepicker :enable-time-picker="true" 
                                    model-type="yyyy-MM-dd HH:mm:ss" :is-24="false" :teleport="true"></Datepicker>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Age:</label>
                                <input type="text" 
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    placeholder="Enter PhilHealth Number">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Height:</label>
                                <input type="text" 
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    placeholder="Enter PhilHealth Number">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Weight:</label>
                                <input type="text" 
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    placeholder="Enter PhilHealth Number">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Body Mass Index:</label>
                                <input type="text" 
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    placeholder="Enter PhilHealth Number">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">BMI Category:</label>
                                <input type="text"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    placeholder="Enter PhilHealth Number">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Attending Provider:</label>
                                <input type="text" 
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    placeholder="Enter PhilHealth Number">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Chief Complaint:</label>
                                <input type="text" 
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    placeholder="Enter PhilHealth Number">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Mode of Transaction:</label>
                                <select 
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option disabled :value="null"> --Select-- </option>
                                    <option v-for="option in transactions_options" v-bind:value="option">{{ option }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">
                                    Patient Consent:</label>
                                <input  type="radio" value="Yes">
                                <label class="ml-1 mr-4">Yes</label>
                                <input  type="radio" value="No">
                                <label for="formPatientphilhealth_member-no" class="ml-1 mr-4">No</label>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </body>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from './../Layouts/AuthenticatedLayout.vue';
import { usePermission } from "@/composables/permissions";
const { hasRole } = usePermission();
</script>

<script>
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

export default {
    props: ['patient','book','consult'],
    components: { Datepicker },
    data() {
        return {
            isEdit: false,
            patient_instance: Object.assign({}, this.patient),
            prefix_options: ['None', 'Dr'],
            suffix_options: ['None', 'Sr', 'Jr'],
            educational_attainment_options: ['None', 'Primary', 'Secondary', 'Vocational', 'Tertiary'],
            civil_status_options: ['Single', 'Married', 'Divorced', 'Separated'],
            employment_status_options: ['Employed', 'Unemployed'],
            nationality_options: ['Filipino', 'Other'],
            religion_options: ['None', 'Roman Catholic', 'Protestant', 'Christian', 'Muslim', 'Other'],
            ethnic_group_options: ['A', 'B'],
            barangay_options: ["Abanao-Zandueta-Kayong-Chugum", "Alfonso Tabora", "Ambiong", "Andres Bonifacio",
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
            "SLU-SVP Housing Village","South Drive","Teodora Alonzo","Trancoville","Victoria Village"],
            blood_type_options: ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'],
            philhealth_category: ['Formal Economy', 'Informal Economy', 'OFW', 'Senior Citizen', 'Lifetime', 'Sponsored', 'Indigent', 'Qualified Dependent'],
            nature_options: ['Diagnostic', 'Treatment', 'Follow-up', 'Preventive', 'Consultation', 'Emergency', 'Others'],
            transactions_options: ['Cash', 'Credit/Debit Card', 'Gcash', 'Bank Transfer']
        }
    },
    methods: {
        editDetails() {
            this.isEdit = true;
        },
        saveDetails(patient_instance) {
            let url = '/patients';
            if (patient_instance.id) {
                url = '/patients/' + patient_instance.id;
                patient_instance._method = 'PUT';
            }
            this.$inertia.post(url, patient_instance, {
                onError: (error) => {
                    console.log(error);
                },
                onSuccess: () => {
                    this.stopEdit();
                }
            });
        },
        stopEdit() {
            this.patient_instance = Object.assign({}, this.patient);
            this.$page.props.errors = {};
            this.isEdit = false;
        }
    }
}
</script>

<style>
h3 {
    margin: 12px 0;
    color: #8ebf42;
}

fieldset {
    border: none;
    border-top: 1px solid #8ebf42;
    margin-top: 10px;
}
</style>