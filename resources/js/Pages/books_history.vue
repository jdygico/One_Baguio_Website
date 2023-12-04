<template>
    <Head title="Dashboard"></Head>
    <AuthenticatedLayout>
        <div class="bg-white overflow-hidden shadow-xl rounded-lg m-2 p-4">

            <div class="flex flex-row mb-4">
                <label class="p-2">From: </label>
                <Datepicker class="max-w-fit mr-4" v-model="date_from" :enable-time-picker="true" model-type="yyyy-MM-dd"
                    :teleport="true"></Datepicker>
                <label class="p-2">To: </label>
                <Datepicker class="max-w-fit mr-4" v-model="date_to" :enable-time-picker="true" model-type="yyyy-MM-dd"
                    :teleport="true"></Datepicker>
                <label class="p-2 font-semibold">Total Bookings: {{ filter_date.length }}</label>
                <button
                class="rounded-md  px-4 py-2 mb-2 bg-green-600 font-bold text-white hover:bg-green-500 sm:text-sm sm:leading-5 max-w-fit ml-auto"
                    @click="sortByDateLatest">Sort by Latest Date
                </button>
                <button class="rounded-md ml-4 px-4 py-2 mb-2 bg-green-600 font-bold text-white hover:bg-green-500 sm:text-sm sm:leading-5 max-w-fit"
                    @click="sortByDateOldest">Sort by Oldest Date</button>
            </div>
            <table class="table-fixed w-full border" style="text-align: center;">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 w-20">Booking No.</th>
                        <th class="px-4 py-2">Facility</th>
                        <th class="px-4 py-2">Date and Time</th>
                        <th class="px-4 py-2">Purpose</th>
                        <th class="px-2 py-2">Name of Patient</th>
                        <th class="px-2 py-2">Status</th>
                        <th class="px-2 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="book in filter_date">
                        <td class="px-4 py-2 border">{{ book.id }}</td>
                        <td class="px-4 py-2 border">{{ book.where }}</td>
                        <td class="px-4 py-2 border">{{ moment(book.book_date).format("MMMM, D, YYYY @ hh:mm a") }}</td>
                        <td class="px-4 py-2 border">{{ book.purpose }}</td>
                        <td class="px-2 py-2 border">{{ book.booked_by }}</td>
                        <td class="px-2 py-2 border">{{ book.status }}</td>
                        <td class="px-2 py-2 border">
                            <button @click="viewForm(book)" v-if="hasPermission('book view')"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View</button>
                            <button @click="viewConsultForm(book)" v-if="hasPermission('consult view')"
                                class="rounded-md px-4 py-2 bg-yellow-600 font-bold text-white hover:bg-yellow-500 text-sm m-1">Consultation
                                Form</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <book-form :isOpen="isFormOpen" :isEdit="isFormEdit" :isView="isFormView" :isCreate="isFormCreate"
                :form="formObject" @formsave="saveItem" @formclose="closeModal"></book-form>
            <consult-form :id="consultId" :patient_id="patientId" :form="formObject" :consult="formConsult"
                :isConsultOpen="isConsultFormOpen" @formsave="saveConsult" @formclose="closeModal"></consult-form>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from './../Components/pagination.vue';
import BookForm from './../Components/Book/form.vue';
import ConsultForm from './../Components/Consult/form.vue';
import { Head } from '@inertiajs/vue3';
import { usePermission } from "@/composables/permissions";

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

import Datepicker from '@vuepic/vue-datepicker';
import moment from 'moment';

export default {
    props: ['books'],
    components: { Datepicker, moment},
    data() {
        return {
            books: [this.books],
            date_from: null,
            date_to: null,
            sortedData: [],
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
        };
    },
    computed: {
        filter_date() {
            if ((this.date_from == null) && (this.date_to == null)) {
                return this.books;
            } else if (this.date_from == null) {
                var date_to = new Date(this.date_to);
                return this.books.filter(function (book) {
                    var book_date = new Date(book.book_date);
                    return (book_date <= date_to)
                });
            } else if (this.date_to == null) {
                var date_from = new Date(this.date_from);
                return this.books.filter(function (book) {
                    var book_date = new Date(book.book_date);
                    return (book_date >= date_from)
                })
            } else {
                var date_from = new Date(this.date_from);
                var date_to = new Date(this.date_to);
                return this.books.filter(function (book) {
                    var book_date = new Date(book.book_date);
                    return (book_date >= date_from && book_date <= date_to);
                });
            }
        },
        unsortedData() {
            return this.books;
        },
    },
    methods: {
        sortByDateLatest() {
            this.sortedData = this.unsortedData.sort((a, b) => {
                return new Date(b.book_date) - new Date(a.book_date);
            });
        },
        sortByDateOldest() {
            this.sortedData = this.unsortedData.sort((a, b) => {
                return new Date(a.book_date) - new Date(b.book_date);
            });
        },
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
    }
}
</script>