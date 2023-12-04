<template>
    <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isConsultOpen">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <!-- This element is to trick the browser into centering the modal contents. -->
            <!-- <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span> -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all m-10 align-middle sm:max-w-3xl sm:w-full"
                role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <form>
                    <fieldset style="margin-top: 0px;">
                        <legend>
                            <h3>Patient Information</h3>
                        </legend>
                        <div class="grid grid-cols-7 grid-flow-row gap-4 mx-2">
                            <div class="col-span-1">
                                <label for="formPatientPrefix" class="block text-gray-700 text-sm font-bold mb-2">
                                    Prefix:
                                </label>
                                <label class="block text-black text-lg font-bold mb-2">{{ patientData.prefix }}</label>
                            </div>
                            <div class="col-span-1">
                                <label for="formPatientLastName" class="block text-gray-700 text-sm font-bold mb-2">
                                    Last Name:</label>
                                <label class="block text-black text-lg font-bold mb-2">{{ patientData.last_name }}, </label>
                            </div>
                            <div class="col-span-1">
                                <label for="formPatientFirstName" class="block text-gray-700 text-sm font-bold mb-2">
                                    First Name:</label>
                                <label class="block text-black text-lg font-bold mb-2">{{ patientData.first_name }}</label>
                            </div>
                            <div class="col-span-1">
                                <label for="formPatientMiddleName" class="block text-gray-700 text-sm font-bold mb-2">
                                    Middle Name: </label>
                                <label class="block text-black text-lg font-bold mb-2">{{ patientData.middle_name }}</label>
                            </div>
                            <div class="col-span-1">
                                <label for="formPatientSuffix" class="block text-gray-700 text-sm font-bold mb-2">
                                    Suffix: </label>
                                <label class="block text-black text-lg font-bold mb-2">{{ patientData.suffix }}</label>
                            </div>
                            <div class="col-span-1">
                                <label for="formPatientSex" class="block text-gray-700 text-sm font-bold mb-2">
                                    Sex:</label>
                                <label class="block text-black text-lg font-bold mb-2">{{ patientData.sex }}</label>
                            </div>
                            <div class="col-span-1">
                                <label for="formPatientBloodType" class="block text-gray-700 text-sm font-bold mb-2">
                                    Blood Type:</label>
                                <label class="block text-black text-lg font-bold mb-2">{{ patientData.blood_type }}</label>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>
                            <h3>Consultation Form</h3>
                        </legend>
                        <div class="grid grid-cols-6 grid-flow-row gap-4 mx-2">
                            <div class="col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Chief Complaint:</label><label v-if="!hasPermission('consult edit')">{{ consult.complaint }}</label>
                                <input type="text" v-model="consult.complaint" v-if="hasPermission('consult edit')"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    placeholder="Enter chief complaint">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Nature of Visit:</label><label v-if="!hasPermission('consult edit')">{{ consult.nature }}</label>
                                <select v-model="consult.nature" v-if="hasPermission('consult edit')"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option disabled :value="null"> --Select-- </option>
                                    <option v-for="option in nature_options" v-bind:value="option">{{ option }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Purpose of Visit:</label><label v-if="!hasPermission('consult edit')">{{ consult.purpose }}</label>
                                <input type="text" v-model="consult.purpose" v-if="hasPermission('consult edit')"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    placeholder="Enter purpose of visit">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Age:</label><label v-if="!hasPermission('consult edit')">{{ consult.age }}</label>
                                <input type="text" v-model="consult.age" v-if="hasPermission('consult edit')"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    placeholder="Enter age">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Height(cm):</label><label v-if="!hasPermission('consult edit')">{{ consult.height }}</label>
                                <input type="text" v-model="consult.height" v-if="hasPermission('consult edit')"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    placeholder="Enter height">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Weight(lbs):</label><label v-if="!hasPermission('consult edit')">{{ consult.weight }}</label>
                                <input type="text" v-model="consult.weight" v-if="hasPermission('consult edit')"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    placeholder="Enter weight">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Body Mass Index:</label><label v-if="!hasPermission('consult edit')">{{ consult.BMI }}</label>
                                <input type="text" v-model="consult.BMI" v-if="hasPermission('consult edit')"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    placeholder="Enter BMI">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">BMI Category:</label><label v-if="!hasPermission('consult edit')">{{ consult.bmi_category }}</label>
                                <!-- <input type="text" v-model="consult.bmi_category"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    placeholder="Enter PhilHealth Number"> -->
                                <select v-model="consult.bmi_category" v-if="hasPermission('consult edit')"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option disabled :value="null"> --Select-- </option>
                                    <option v-for="option in BMI_options" v-bind:value="option">{{ option }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Mode of Transaction:</label><label v-if="!hasPermission('consult edit')">{{ consult.mode_of_transaction }}</label>
                                <select v-model="consult.mode_of_transaction" v-if="hasPermission('consult edit')"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option disabled :value="null"> --Select-- </option>
                                    <option v-for="option in transactions_options" v-bind:value="option">{{ option }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">
                                    Patient Consent:</label><label v-if="!hasPermission('consult edit')">{{ consult.patient_consent }}</label>
                                <input v-if="hasPermission('consult edit')" v-model="consult.patient_consent" type="radio" value="Yes">
                                <label class="ml-1 mr-4">Yes</label>
                                <input v-if="hasPermission('consult edit')" v-model="consult.patient_consent" type="radio" value="No">
                                <label for="formPatientphilhealth_member-no" class="ml-1 mr-4">No</label>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Attending Provider:</label>
                                <label class="block text-gray-700 text-sm font-bold mb-2">{{ consult.name_of_attending_provider
                                }}</label>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Consult Date and Time:</label><label v-if="!hasPermission('consult edit')">{{ moment(consult.consult_datetime).format("MMMM, D, YYYY @ hh:mm a") }}</label>
                                <Datepicker v-model="consult.consult_datetime" :enable-time-picker="true" v-if="hasPermission('consult edit')"
                                    model-type="yyyy-MM-dd HH:mm:ss" :is-24="false" :teleport="true"></Datepicker>
                            </div>
                        </div>
                    </fieldset>
                    <div class="m-4">
                        <div class="bg-gray-50 px-4 py-2 flex flex-row-reverse">
                            <span class="flex rounded-md">
                                <button @click="$emit('formclose')"
                                    class="rounded-md px-4 py-2 ml-4 bg-red-600 font-bold text-white hover:bg-red-500 text-sm">
                                    Close
                                </button>
                            </span>
                            <span class="flex rounded-md">
                                <button @click="submitForm(consult)" v-if="hasPermission('consult edit')"
                                    class="rounded-md px-4 py-2 ml-4 bg-green-600 font-bold text-white hover:bg-green-500 text-sm">
                                    Save
                                </button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { usePermission } from "@/composables/permissions";
    import moment from 'moment';
    const { hasPermission } = usePermission();
</script>

<script>
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import axios from 'axios';

export default {
    props: ['form', 'consult', 'isConsultOpen', 'id', 'patient_id', 'patientList', 'patientData'],
    components: { Datepicker },
    data() {
        return {
            nature_options: ['Diagnostic', 'Treatment', 'Follow-up', 'Preventive', 'Consultation', 'Emergency', 'Others'],
            transactions_options: ['Cash', 'Credit/Debit Card', 'Gcash', 'Bank Transfer'],
            BMI_options: ['Underweight', 'Normal Weight', 'Overweight', 'Obesity Class I', 'Obesity Class II', 'Obesity Class III'],
            patientData: null,
            patientId: null
        }
    },
    methods: {
        submitForm(consult) {
            let url = '/consults'
            if (consult.id) {
                url = '/consults/' + consult.id;
                consult._method = 'PUT';
            }
            this.$inertia.post(url, consult, {
            }).then(response => {
                console.log('Book stored successfully!');
            }).catch(error => {
                console.log(error);
            });
        }
    },
    watch: {
        patient_id: function (newVal, oldVal) {
            this.patientId = newVal;
            // call your axios get request here to update patientData
            axios.get('/api/patients')
                .then(response => {
                    const patients = response.data;
                    const patient = patients.find(patient => patient.user_id === this.patientId);
                    if (patient) {
                        this.patientData = patient;
                    } else {
                        this.patientData = 'did not work';
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
    mounted() {
        this.patientId = this.patient_id
        axios.get('/api/patients')
            .then(response => {
                const patients = response.data;

                // const patientId = this.patient_id;

                const patient = patients.find(patient => patient.user_id === this.patientId);
                if (patient) {
                    this.patientData = patient;
                } else {
                    this.patientData = 'did not work';
                }
            })
            .catch(error => {
                console.log(error);
            });
    },
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