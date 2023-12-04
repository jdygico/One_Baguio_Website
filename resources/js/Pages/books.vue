<template>
    <Head title="Bookings" />
    <AuthenticatedLayout>
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg m-2 p-4">
            <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
                role="alert" v-if="$page.props.flash.message">
                <div class="flex">
                    <div>
                        <p class="text-sm">{{ $page.props.flash.message }}</p>
                    </div>
                </div>
            </div>
            <div>
                <div></div>
                <h2 class="py-2 font-semibold text-lg text-center">
                    Bookings for today: {{ currentDateTime }}
                </h2>
            </div>
            <!-- <div class="grid grid-cols-3">
                <div></div>
                <label class="py-2 font-bold text-xl text-center">{{ currentDateTime }}</label>
            </div> -->



            <!-- table -->

            <div style="margin-top: 30px;">
                <label class="py-2 font-semibold text-lg text-left">
                    Not Arrived:
                </label>
                <table class="table-fixed w-full border" style="text-align: center; margin-top: 10px;"
                    v-if="hasPermission('book list')">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-2 py-2 w-20">Booking No.</th>
                            <th class="px-2 py-2">Facility</th>
                            <th class="px-2 py-2">Date and Time</th>
                            <th class="px-2 py-2">Purpose</th>
                            <th class="px-2 py-2">Name of Patient</th>
                            <th class="px-2 py-2">Status</th>
                            <th class="px-2 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in bookNotArrived.data">
                            <td class="px-2 py-2 border">{{ item.id }}</td>
                            <td class="px-2 py-2 border">{{ item.where }}</td>
                            <td class="px-2 py-2 border">{{ moment(item.book_date).format("MMMM, D, YYYY @ hh:mm a") }}</td>
                            <td class="px-2 py-2 border">{{ item.purpose }}</td>
                            <td class="px-2 py-2 border">{{ item.booked_by }}</td>
                            <td class="px-2 py-2 border">{{ item.status }}</td>
                            <td class="px-2 py-2 border">
                                <button @click="viewForm(item)" v-if="hasPermission('book view')"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View</button>
                                <button @click="viewConsultForm(item)" v-if="hasPermission('consult view')"
                                    class="rounded-md px-4 py-2 bg-yellow-600 font-bold text-white hover:bg-yellow-500 text-sm m-1">Consultation
                                    Form</button>
                            </td>
                        </tr>
                    </tbody>
                    <tr v-if="bookNotArrived.data.length === 0">
                        <td class="font-semibold text-lg text-red-500" colspan="7">No bookings</td>
                    </tr>
                </table>
                <pagination :links="bookNotArrived.links"></pagination>
            </div>
            <div style="margin-top: 30px;">
                <label class="py-2 font-semibold text-lg text-left text-orange-500">
                    Waiting:
                </label>
                <table class="table-fixed w-full border" style="text-align: center;"
                    v-if="hasPermission('book list')">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-2 py-2 w-20">Booking No.</th>
                            <th class="px-2 py-2">Facility</th>
                            <th class="px-2 py-2">Date and Time</th>
                            <th class="px-2 py-2">Purpose</th>
                            <th class="px-2 py-2">Name of Patient</th>
                            <th class="px-2 py-2">Status</th>
                            <th class="px-2 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in bookWaiting.data">
                            <td class="px-2 py-2 border">{{ item.id }}</td>
                            <td class="px-2 py-2 border">{{ item.where }}</td>
                            <td class="px-2 py-2 border">{{ moment(item.book_date).format("MMMM, D, YYYY @ hh:mm a") }}</td>
                            <td class="px-2 py-2 border">{{ item.purpose }}</td>
                            <td class="px-2 py-2 border">{{ item.booked_by }}</td>
                            <td class="px-2 py-2 border">{{ item.status }}</td>
                            <td class="px-2 py-2 border">
                                <button @click="viewForm(item)" v-if="hasPermission('book view')"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View</button>
                                <button @click="viewConsultForm(item)" v-if="hasPermission('consult view')"
                                    class="rounded-md px-4 py-2 bg-yellow-600 font-bold text-white hover:bg-yellow-500 text-sm m-1">Consultation
                                    Form</button>
                            </td>
                        </tr>
                    </tbody>
                    <tr v-if="bookWaiting.data.length === 0">
                        <td class="font-semibold text-lg text-red-500" colspan="7">No bookings</td>
                    </tr>
                </table>
                <pagination :links="bookWaiting.links"></pagination>
            </div>
            <div style="margin-top: 30px;">
                <label class="py-2 font-semibold text-lg text-left text-yellow-500">
                    Consulting:
                </label>
                <table class="table-fixed w-full border" style="text-align: center;"
                    v-if="hasPermission('book list')">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-2 py-2 w-20">Booking No.</th>
                            <th class="px-2 py-2">Facility</th>
                            <th class="px-2 py-2">Date and Time</th>
                            <th class="px-2 py-2">Purpose</th>
                            <th class="px-2 py-2">Name of Patient</th>
                            <th class="px-2 py-2">Status</th>
                            <th class="px-2 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in bookConsulting.data">
                            <td class="px-2 py-2 border">{{ item.id }}</td>
                            <td class="px-2 py-2 border">{{ item.where }}</td>
                            <td class="px-2 py-2 border">{{ moment(item.book_date).format("MMMM, D, YYYY @ hh:mm a") }}</td>
                            <td class="px-2 py-2 border">{{ item.purpose }}</td>
                            <td class="px-2 py-2 border">{{ item.booked_by }}</td>
                            <td class="px-2 py-2 border">{{ item.status }}</td>
                            <td class="px-2 py-2 border">
                                <button @click="viewForm(item)" v-if="hasPermission('book view')"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View</button>
                                <button @click="viewConsultForm(item)" v-if="hasPermission('consult view')"
                                    class="rounded-md px-4 py-2 bg-yellow-600 font-bold text-white hover:bg-yellow-500 text-sm m-1">Consultation
                                    Form</button>
                            </td>
                        </tr>
                    </tbody>
                    <tr v-if="bookConsulting.data.length === 0">
                        <td class="font-semibold text-lg text-red-500" colspan="7">No bookings</td>
                    </tr>
                </table>
                <pagination :links="bookConsulting.links"></pagination>
            </div>
            <div style="margin-top: 30px;">
                <label class="py-2 font-semibold text-lg text-left text-green-500">
                    Finished:
                </label>
                <table class="table-fixed w-full border" style="text-align: center;"
                    v-if="hasPermission('book list')">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-2 py-2 w-20">Booking No.</th>
                            <th class="px-2 py-2">Facility</th>
                            <th class="px-2 py-2">Date and Time</th>
                            <th class="px-2 py-2">Purpose</th>
                            <th class="px-2 py-2">Name of Patient</th>
                            <th class="px-2 py-2">Status</th>
                            <th class="px-2 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in bookFinished.data">
                            <td class="px-2 py-2 border">{{ item.id }}</td>
                            <td class="px-2 py-2 border">{{ item.where }}</td>
                            <td class="px-2 py-2 border">{{ moment(item.book_date).format("MMMM, D, YYYY @ hh:mm a") }}</td>
                            <td class="px-2 py-2 border">{{ item.purpose }}</td>
                            <td class="px-2 py-2 border">{{ item.booked_by }}</td>
                            <td class="px-2 py-2 border">{{ item.status }}</td>
                            <td class="px-2 py-2 border">
                                <button @click="viewForm(item)" v-if="hasPermission('book view')"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View</button>
                                <button @click="viewConsultForm(item)" v-if="hasPermission('consult view')"
                                    class="rounded-md px-4 py-2 bg-yellow-600 font-bold text-white hover:bg-yellow-500 text-sm m-1" >Consultation
                                    Form</button>
                            </td>
                        </tr>
                    </tbody>
                    <tr v-if="bookFinished.data.length === 0">
                        <td class="font-semibold text-lg text-red-500" colspan="7">No bookings</td>
                    </tr>
                </table>
                <pagination :links="bookFinished.links"></pagination>
            </div>

            
            <book-form :isOpen="isFormOpen" :isEdit="isFormEdit" :isView="isFormView" :isCreate="isFormCreate"
                :form="formObject" @formsave="saveItem" @formclose="closeModal"></book-form>
            <consult-form :id="consultId" :patient_id="patientId" :form="formObject" :consult="formConsult"
                :isConsultOpen="isConsultFormOpen" @formsave="saveConsult" @formclose="closeModal"></consult-form>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import { usePermission } from "@/composables/permissions";
import { Head } from '@inertiajs/vue3';

const { hasPermission } = usePermission();
</script>

<script>

const defaultFormObject = {
    where: null,
    book_date: null,
    purpose: null,
    status: null,
};


const defaultConsultObject = {
    nature: null,
    purpose: null,
    consult_datetime: null,
    age: null,
    mode_of_transaction: null,
    height: null,
    weight: null,
    BMI: null,
    bmi_category: null,
    name_of_attending_provider: null,
    complaint: null,
    patient_consent: null,
};

import AuthenticatedLayout from './../Layouts/AuthenticatedLayout.vue';
import Pagination from './../Components/pagination.vue';
import BookForm from './../Components/Book/form.vue';
import ConsultForm from './../Components/Consult/form.vue';
import moment from 'moment';

export default {
    props: ['bookNotArrived', 'bookWaiting', 'bookConsulting', 'bookFinished', 'consult'],
    components: {
        AuthenticatedLayout,
        Pagination,
        BookForm,
        moment,
        ConsultForm
    },
    data() {
        return {
            isFormOpen: false,
            isFormEdit: false,
            isFormView: false,
            isFormCreate: false,
            isConsultFormOpen: false,
            formObject: defaultFormObject,
            formConsult: defaultConsultObject,
            consultId: null,
            patientId: null,
            consult: [this.consult],
            currentDateTime: "",
        }
    },
    methods: {
        saveItem(item) {
            let url = '/books';
            if (item.id) {
                url = '/books/' + item.id;
                item._method = 'PUT';
            }
            this.$inertia.post(url, item, {
                onError: () => {
                    console.log(error);
                },
                onSuccess: () => {
                    this.closeModal();
                }
            });
        },
        closeModal() {
            this.isFormOpen = false;
            this.isFormEdit = false;
            this.isFormView = false;
            this.isFormCreate = false;
            this.isConsultFormOpen = false;
        },
        openForm() {
            this.isFormOpen = true;
            this.isFormCreate = true;
            this.formObject = Object.assign({}, defaultFormObject);
            this.$page.props.errors = {};
        },
        viewForm(item) {
            this.openForm();
            this.isFormView = true;
            this.isFormCreate = false;
            this.formObject = Object.assign({}, item);
        },
        deleteItem(item) {
            if (window.confirm('are you sure?')) {
                this.$inertia.post('/books/' + item.id, {
                    _method: 'DELETE'
                });
            }
        },
        viewConsultForm(item) {
            this.isConsultFormOpen = true;
            this.formObject = Object.assign({}, item);
            this.formConsult = this.consult.filter(consult => consult.book_id === item.id).reduce((obj, consult) => {
                obj = consult;
                return obj
            }, {});
            this.consultId = item.id;
            this.patientId = item.user_id;
        }
    },
    created() {
        setInterval(() => {
            const options = {
                year: "numeric",
                month: "long",
                day: "numeric",
                hour: "numeric",
                minute: "numeric",
                hour12: true,
            }
            this.currentDateTime = new Date().toLocaleString("en-US", options);
        }, 1000);
    },
}
</script>