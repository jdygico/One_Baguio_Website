<template>
    <AuthenticatedLayout>
        <div class="bg-gray-50 px-4 py-2 grid grid-cols-2 auto-cols-min">
            <span class="py-1">
                <label class="text-red-500 text-md italic" v-if="$page.props.errors.patient">Please fill up all required fields.</label>
                <label class="text-red-500 text-md italic" v-show="isEdit" >Please put N/A for not applicable.</label>
            </span>
            <span class="place-self-end flex rounded-md" v-if="hasRole('user')">
                <button @click="editDetails()" v-show="!isEdit"
                    class="rounded-md px-4 py-2 ml-4 bg-green-600 font-bold text-white hover:bg-green-500 text-sm">
                    Edit
                </button>
                <button @click="saveDetails(patient_instance)" v-show="isEdit"
                    class="rounded-md px-4 py-2 ml-4 bg-green-600 font-bold text-white hover:bg-green-500 text-sm">
                    Save
                </button>
                <button @click="stopEdit()" v-show="isEdit"
                    class="rounded-md px-4 py-2 ml-4 bg-red-600 font-bold text-white hover:bg-red-500 text-sm">
                    Cancel
                </button>
            </span>
        </div>

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
                                <label for="formPatientBirthDate"
                                    class="block text-gray-700 text-sm font-bold mb-2"><span class="text-red-500">*</span> Birth Date:</label>
                                <Datepicker
                                    v-model="patient_instance.birth_date" :enable-time-picker="false"
                                    model-type="yyyy-MM-dd" :is-24="false" :disabled=!isEdit>
                                </Datepicker>
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientBirthPlace"
                                    class="block text-gray-700 text-sm font-bold mb-2">Birth Place:</label>
                                <input type="text" v-model="patient_instance.birth_place"
                                    :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="formPatientBirthPlace" placeholder="Enter Birth Place">
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientCivilStatus"
                                    class="block text-gray-700 text-sm font-bold mb-2">Civil Status:</label>
                                <select id="formPatientCivilStatus"
                                    v-model="patient_instance.civil_status" :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option disabled :value="null"> --Select Civil Status-- </option>
                                    <option v-for="option in civil_status_options" v-bind:value="option">{{ option }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientMaidenLastName"
                                    class="block text-gray-700 text-sm font-bold mb-2">Maiden Last Name:</label>
                                <input type="text" v-model="patient_instance.maiden_last_name"
                                    :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="formMaidenLastName" placeholder="Enter Maiden Last Name">
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientMaidenMiddleName"
                                    class="block text-gray-700 text-sm font-bold mb-2">Maiden Middle Name:</label>
                                <input type="text" v-model="patient_instance.maiden_middle_name"
                                    :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="formPatientMaidenMiddleName" placeholder="Enter Maiden Middle Name">
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientEducationalAttainment"
                                    class="block text-gray-700 text-sm font-bold mb-2"><span class="text-red-500">*</span> Educational Attainment:</label>
                                <select id="formPatientEducationalAttainment"
                                    v-model="patient_instance.educational_attainment" :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option disabled :value="null"> --Select Educational Attainment-- </option>
                                    <option v-for="option in educational_attainment_options" v-bind:value="option">{{
                                        option }}</option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientEmploymentStatus"
                                    class="block text-gray-700 text-sm font-bold mb-2">Employment Status:</label>
                                <select id="formPatientEmploymentStatus"
                                    v-model="patient_instance.employment_status" :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option disabled :value="null"> --Select Employment Status-- </option>
                                    <option v-for="option in employment_status_options" v-bind:value="option">{{ option
                                    }}</option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientOccupation"
                                    class="block text-gray-700 text-sm font-bold mb-2"><span class="text-red-500">*</span> Occupation:</label>
                                <input type="text" v-model="patient_instance.occupation"
                                    :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="formPatientOccupation" placeholder="Specify Occupation">
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientMonthlyIncome"
                                    class="block text-gray-700 text-sm font-bold mb-2">Monthly Income:</label>
                                <input type="text" v-model="patient_instance.monthly_income"
                                    :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="formPatientMonthlyIncome" placeholder="Enter Monthly Income">
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientNationality"
                                    class="block text-gray-700 text-sm font-bold mb-2">Nationality:</label>
                                <select id="formPatientNationality"
                                    v-model="patient_instance.nationality" :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option disabled :value="null"> --Select Nationality-- </option>
                                    <option v-for="option in nationality_options" v-bind:value="option">{{ option }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientTaxIdentification"
                                    class="block text-gray-700 text-sm font-bold mb-2">Tax Identification No.:</label>
                                <input type="text" v-model="patient_instance.tax_identification"
                                    :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="formPatientTaxIdentification" placeholder="Enter Tax Identification No.">
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientReligion"
                                    class="block text-gray-700 text-sm font-bold mb-2">Religion:</label>
                                <select id="formPatientReligion"
                                    v-model="patient_instance.religion" :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option disabled :value="null"> --Select Religion-- </option>
                                    <option v-for="option in religion_options" v-bind:value="option">{{ option }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientEthnicGroup"
                                    class="block text-gray-700 text-sm font-bold mb-2">Ethnic Group:</label>
                                <select id="formPatientEthnicGroup"
                                    v-model="patient_instance.ethnic_group" :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option disabled :value="null"> --Select Ethnic Group-- </option>
                                    <option v-for="option in ethnic_group_options" v-bind:value="option">{{ option }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientIndigenous"
                                    class="block text-gray-700 text-sm font-bold mb-2">Indigenous:</label>
                                <input type="radio" id="formPatientIndigenous-yes" value="Yes" v-model="patient_instance.indigenous" :disabled=!isEdit>
                                <label for="formPatientIndigenous-yes" class="ml-1 mr-4">Yes</label>
                                <input type="radio" id="formPatientIndigenous-no" value="No" v-model="patient_instance.indigenous" :disabled=!isEdit>
                                <label for="formPatientIndigenous-no" class="ml-1 mr-4">No</label>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>
                            <h3>Contact Information</h3>
                        </legend>
                        <div class="grid grid-cols-12 grid-flow-row gap-4 mx-2">
                            <div class="col-span-3">
                                <label for="formPatientNumberStreetName"
                                    class="block text-gray-700 text-sm font-bold mb-2">Number / Street Name:</label>
                                <input type="text" v-model="patient_instance.number_street_name"
                                    :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="formPatientNumberStreetName" placeholder="Enter Number / Street Name">
                            </div>
                            <div class="col-span-3">
                                <label for="formPatientBarangay"
                                    class="block text-gray-700 text-sm font-bold mb-2"><span class="text-red-500">*</span> Barangay:</label>
                                <select id="formPatientBarangay"
                                    v-model="patient_instance.barangay" :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option disabled :value="null"> --Select Barangay-- </option>
                                    <option v-for="option in barangay_options" v-bind:value="option">{{ option }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientMobile"
                                    class="block text-gray-700 text-sm font-bold mb-2">Mobile:</label>
                                <input type="text" v-model="patient_instance.mobile"
                                    :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="formPatientMobile" placeholder="Enter Mobile">
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientLandline"
                                    class="block text-gray-700 text-sm font-bold mb-2">Landline:</label>
                                <input type="text" v-model="patient_instance.landline"
                                    :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="formPatientLandline" placeholder="Enter Landline">
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientEmail"
                                    class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                                <input type="text" v-model="patient_instance.email"
                                    :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="formPatientEmail" placeholder="Enter Email">
                            </div>
                            <div>
                                <label for="formPatientBloodType"
                                    class="block text-gray-700 text-sm font-bold mb-2">Blood Type:</label>
                                <select id="formPatientBloodType"
                                    v-model="patient_instance.blood_type" :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option disabled :value="null"> --Select Blood Type-- </option>
                                    <option v-for="option in blood_type_options" v-bind:value="option">{{ option }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientMotherLastName"
                                    class="block text-gray-700 text-sm font-bold mb-2">Mother"s Last Name:</label>
                                <input type="text" v-model="patient_instance.mother_last_name"
                                    :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="formPatientLastName" placeholder="Enter Mother's Last Name">
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientMotherFirstName"
                                    class="block text-gray-700 text-sm font-bold mb-2">Mother"s First Name:</label>
                                <input type="text" v-model="patient_instance.mother_first_name"
                                    :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="formPatientMotherFirstName" placeholder="Enter Mother's First Name">
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientMotherMiddleName"
                                    class="block text-gray-700 text-sm font-bold mb-2">Mother"s Middle Name:</label>
                                <input type="text" v-model="patient_instance.mother_middle_name"
                                    :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="formPatientMotherMiddleName" placeholder="Enter Mother's Middle Name">
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientMotherBirthDate"
                                    class="block text-gray-700 text-sm font-bold mb-2">Mother"s Birth Date:</label>
                                <Datepicker
                                    v-model="patient_instance.mother_birth_date" :enable-time-picker="false"
                                    model-type="yyyy-MM-dd" :is-24="false" :disabled=!isEdit>
                                </Datepicker>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>
                            <h3>Facility-Assigned Information</h3>
                        </legend>
                        <div class="grid grid-cols-12 grid-flow-row gap-4 mx-2">
                            <div class="col-span-2">
                                <label for="formPatientDSWDMember"
                                    class="block text-gray-700 text-sm font-bold mb-2"><span class="text-red-500">*</span> DSDW NHTS Member:</label>
                                <input type="radio" id="formPatientDSWD-yes" value="Yes" v-model="patient_instance.dsdw_member" :disabled=!isEdit>
                                <label for="formPatientDSWD-yes" class="ml-1 mr-4">Yes</label>
                                <input type="radio" id="formPatientDSDW-no" value="No" v-model="patient_instance.dsdw_member" :disabled=!isEdit>
                                <label for="formPatientDSDW-no" class="ml-1 mr-4">No</label>
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientfacility_household_no"
                                    class="block text-gray-700 text-sm font-bold mb-2"><span class="text-red-500">*</span> Facility Household
                                    Number:</label>
                                <input type="text"
                                    v-model="patient_instance.facility_household_no" :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="formPatientfacility_household_no" placeholder="Enter Facility Household Number">
                            </div>
                            <div class="col-span-2">
                                <label for="formPatienthousehold_no"
                                    class="block text-gray-700 text-sm font-bold mb-2"><span class="text-red-500">*</span> Household Number:</label>
                                <input type="text" v-model="patient_instance.household_no"
                                    :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="formPatienthousehold_no" placeholder="Enter Household Number">
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientpantawid_member"
                                    class="block text-gray-700 text-sm font-bold mb-2"><span class="text-red-500">*</span> PantawidPamilya Member:</label>
                                <input type="radio" id="formPatientpantawid_member-yes" value="Yes" v-model="patient_instance.pantawid_member" :disabled=!isEdit>
                                <label for="formPatientpantawid_member-yes" class="ml-1 mr-4">Yes</label>
                                <input type="radio" id="formPatientpantawid_member-no" value="No" v-model="patient_instance.pantawid_member" :disabled=!isEdit>
                                <label for="formPatientpantawid_member-no" class="ml-1 mr-4">No</label>
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientpantawid_member_no"
                                    class="block text-gray-700 text-sm font-bold mb-2"><span class="text-red-500">*</span> PantawidPamilya Number:</label>
                                <input type="text" v-model="patient_instance.pantawid_member_no"
                                    :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="formPatientpantawid_member_no" placeholder="Enter PantawidPamilya Number">
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientfamily_serial_no"
                                    class="block text-gray-700 text-sm font-bold mb-2"><span class="text-red-500">*</span> Family Serial Number:</label>
                                <input type="text" v-model="patient_instance.family_serial_no"
                                    :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="formPatientfamily_serial_no" placeholder="Enter Family Serial Number">
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientphilhealth_member"
                                    class="block text-gray-700 text-sm font-bold mb-2"><span class="text-red-500">*</span> PhilHealth Member:</label>
                                <input type="radio" id="formPatientphilhealth_member-yes" value="Yes" v-model="patient_instance.philhealth_member" :disabled=!isEdit>
                                <label for="formPatientphilhealth_member-yes" class="ml-1 mr-4">Yes</label>
                                <input type="radio" id="formPatientDSDW-no" value="No" v-model="patient_instance.philhealth_member" :disabled=!isEdit>
                                <label for="formPatientphilhealth_member-no" class="ml-1 mr-4">No</label>
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientphilhealth_status"
                                    class="block text-gray-700 text-sm font-bold mb-2"><span class="text-red-500">*</span> PhilHealth Status:</label>
                                <input type="radio" id="formPatientphilhealth_status-Active" value="Active" v-model="patient_instance.philhealth_status" :disabled=!isEdit>
                                <label for="formPatientphilhealth_status-Active" class="ml-1 mr-4">Active</label>
                                <input type="radio" id="formPatientDSDW-Inactive" value="Inactive" v-model="patient_instance.philhealth_status" :disabled=!isEdit>
                                <label for="formPatientphilhealth_status-Inactive" class="ml-1 mr-4">Inactive</label>
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientphilhealth_no"
                                    class="block text-gray-700 text-sm font-bold mb-2"><span class="text-red-500">*</span> PhilHealth Number:</label>
                                <input type="text" v-model="patient_instance.philhealth_no"
                                    :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="formPatientphilhealth_no" placeholder="Enter PhilHealth Number">
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientphilhealth_category"
                                    class="block text-gray-700 text-sm font-bold mb-2"><span class="text-red-500">*</span> PhilHealth Category:</label>
                                <select id="formPatientphilhealth_category"
                                    v-model="patient_instance.philhealth_category" :disabled=!isEdit
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option disabled :value="null"> --Select Category-- </option>
                                    <option v-for="option in philhealth_category" v-bind:value="option">{{ option }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label for="formPatientpcb_member"
                                    class="block text-gray-700 text-sm font-bold mb-2"><span class="text-red-500">*</span> PCD Member:</label>
                                <input type="radio" id="formPatientpcb_member-yes" value="Yes" v-model="patient_instance.pcb_member" :disabled=!isEdit>
                                <label for="formPatientpcb_member-yes" class="ml-1 mr-4">Yes</label>
                                <input type="radio" id="formPatientDSDW-no" value="No" v-model="patient_instance.pcb_member" :disabled=!isEdit>
                                <label for="formPatientpcb_member-no" class="ml-1 mr-4">No</label>
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
import { usePermission } from '@/composables/permissions';
const { hasRole } = usePermission();
</script>

<script>
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

export default {
    props: ['patient'],
    components: { Datepicker },
    data() {
        return {
            isEdit: false,
            patient_instance: Object.assign({}, this.patient),
            prefix_options: ['None', 'Mr.', 'Mrs.', 'Ms.'],
            suffix_options: ['None', 'Sr', 'Jr', 'Others'],
            educational_attainment_options: ['None', 'Primary', 'Secondary', 'Vocational', 'Tertiary'],
            civil_status_options: ['Single', 'Married', 'Divorced', 'Separated'],
            employment_status_options: ['Employed', 'Unemployed'],
            nationality_options: ['Filipino', 'Other'],
            religion_options: ['None', 'Roman Catholic', 'Protestant', 'Christian', 'Muslim', 'Other'],
            ethnic_group_options: ['Tagalog', 'Cebuano ', 'Ilocano ', 'Bicolano ', 'Waray ', 'Kapampangan ', 'Pangasinense ','Tausug ','Ilonggo ','Maguindanaoan '],
            barangay_options: ['Abanao-Zandueta-Kayong-Chugum', 'Alfonso Tabora', 'Ambiong', 'Andres Bonifacio',
            'Apugan-Loakan', 'Asin Road', 'Atok Trail', 'Aurora Hill Proper', 'Aurora Hill(North Central)',
            'Aurora Hill(South Central)', 'Bagong Lipunan (Market Area)',
            'Bakakeng Central', 'Bakakeng North', 'Bal-Marcoville (Marcoville)', 'Balsigan', 'Bayan Park East',
            'Bayan Park Village', 'Bayan Park West (Bayan Park)','BGH Compound','Bonifacio-Caguioa-Rimando',
            'Brookside', 'Brookspoint','Cabinet Hill-Teachers Camp', 'Camdas Subdivision', 'Camp 7', 'Camp 8',
            'Camp Allen','Campo Filipino','City Camp Central','City Camp Proper','Country Club Village','Cresencia Village Barangay',
            'Dagsian (Lower)','Dagsian(Upper)','Department of Public Services (DPS) Compound','Dizon Subdivision','Dominican Hill Mirador',
            'Dontogan','Engineers Hill','Fairview Village','Ferdinand (Happy Homes-Campo)','Fort del Pilar','Gabriela Silang','General Emilio F. Aguinaldo',
            'General Luna (Lower)','General Luna (Upper)','Gibraltar','Greenwater Village','Guisad Central','Guisad Sorong','Happy Hollow',
            'Happy Homes (Happy Homes-Lucban)','Harrison-Claudio Carantes','Hillside','Holy Ghost Extension','Holy Ghost Proper','Honeymoon (Honeymoon-Holy Ghost)',
            'Imelda R. Marcos (La Salle)','Imelda Village','Irisan','Kabayanihan','Kagitingan','Kayang Extension','Kayang-Hilltop','Kias','Legarda-Burnham-Kisad',
            'Liwanag-Loakan','Loakan Proper','Lopez Jaena','Lourdes Subdivision Extension','Lourdes Subdivision (Lower)','Lourdes Subdivision (Proper)','Lualhati',
            'Lucnab','Magsaysay Private Road','Magsaysay (Lower)','Magsaysay (Upper)','Malcolm Square-Perfecto','Manuel A. Roxas','Market Subdivision (Upper)',
            'Middle Quezon Hill Subdivision','Military Cut-off','Mines View Park','Modern Site (East)','Modern Site (West)','MRR-Queen Of Peace','New Lucban',
            'Outlook Drive','Pacdal','Padre Burgos','Padre Zamora','Palma-Urbano','Phil-Am','Pinget','Pinsao Pilot Project','Pinsao Proper','Pucsusan',
            'Puliwes','Quezon Hill Proper','Quezon Hill (Upper)','Quirino Hill (East)','Quirino Hill (Lower)','Quirino Hill (Middle)','Quirino Hill (West)',
            'Quirino-Magsaysay (Upper)','Rizal Monument Area','Rock Quarry (Lower)','Rock Quarry (Middle)','Rock Quarry (Upper)','Saint Joseph Village',
            'Salud Mitra','San Antonio Village','San Luis Village','San Roque Village','San Vicente','Sanitary Camp (South)','Sanitary Camp (North)',
            'Santa Escolastica','Santo Rosario Valley','Santo Tomas Proper','Santo Tomas School Area','Scout Barrio','Session Road Area', 'Slaughter House Area',
            'SLU-SVP Housing Village','South Drive','Teodora Alonzo','Trancoville','Victoria Village'],
            blood_type_options: ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'],
            philhealth_category: ['Formal Economy', 'Informal Economy', 'OFW', 'Senior Citizen', 'Lifetime', 'Sponsored', 'Indigent', 'Qualified Dependent']
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