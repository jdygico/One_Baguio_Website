<template>
    <Head title="Patients"></Head>
    <AuthenticatedLayout>
        <div>
            <div class="bg-white overflow-hidden shadow-xl rounded-lg m-2 p-4">
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert" v-if="$page.props.flash.message">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ $page.props.flash.message }}</p>
                        </div>
                    </div>
                </div>

                <h2 class="py-2 font-semibold text-xl text-center">
                    Patients
                </h2>

                <table class="table-fixed w-full border" style="text-align: center;" v-if="hasPermission('patient list')">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-2 py-2 w-20">ID</th>
                            <th class="px-2 py-2 w-20">Prefix</th>
                            <th class="px-2 py-2">Full Name</th>
                            <th class="px-2 py-2 w-20">Suffix</th>
                            <th class="px-2 py-2 w-20">Sex</th>
                            <th class="px-2 py-2">Mobile Number</th>
                            <th class="px-2 py-2" v-if="hasPermission('patient view')">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="patient in data.data">
                            <td class="px-2 py-2 border">{{ patient.user_id }}</td>
                            <td class="px-2 py-2 border">{{ patient.prefix }}</td>
                            <td class="px-2 py-2 border">{{ patient.last_name}}, {{ patient.first_name}}</td>
                            <td class="px-2 py-2 border">{{ patient.suffix }}</td>
                            <td class="px-2 py-2 border">{{ patient.sex }}</td>
                            <td class="px-2 py-2 border">{{ patient.mobile }}</td>
                            <td class="px-2 py-2 border" v-if="hasPermission('patient view')">
                                <button @click="viewPatient(patient)"
                                class="rounded-md px-4 py-2 bg-green-600 font-bold text-white hover:bg-green-500 text-sm m-1">
                                View</button></td>
                        </tr>
                    </tbody>
                </table>
                <pagination :links="data.links"></pagination>
                <PatientForm :isView="isView" :form="formObject" @formclose="closeForm"></PatientForm>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
    import { Head } from '@inertiajs/vue3';
    import AuthenticatedLayout from './../Layouts/AuthenticatedLayout.vue';
    import Pagination from './../Components/pagination.vue';
    import PatientForm from './../Components/Patient/form.vue';
    import { usePermission } from "@/composables/permissions";

    const { hasPermission } = usePermission();
</script>

<script>
    export default{
        props: ['data'],
        data()
        {
            return {
                isView: false,
                formObject: null,
            }
        },
        methods: {
            closeForm()
            {
                this.isView = false;
            },
            viewPatient(patient)
            {
                this.isView = true;
                this.formObject = patient;
                this.$page.props.errors = {};
            },
        }
    }
</script>