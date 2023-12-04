<template>
    <Head title="Bookings" />
    <AuthenticatedLayout>
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg m-2 p-4">
            <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert" v-if="$page.props.flash.message">
                <div class="flex">
                    <div>
                        <p class="text-sm">{{ $page.props.flash.message }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-3">
                <div></div>
                <h2 class="mt-2 font-semibold text-xl text-center">
                    Bookings
                </h2>
                <button v-if="hasRole('user')" @click="openForm()"
                    class="rounded-md px-4 py-2 mb-2 bg-green-600 font-bold text-white hover:bg-green-500 sm:text-sm sm:leading-5 max-w-fit place-self-end">New Booking</button>
            </div>

            <!-- table -->
            <table class="table-fixed w-full border" style="text-align: center;">
                <thead>
                <tr class="bg-gray-100">
                    <th class="px-2 py-2 w-20">Booking No.</th>
                    <th class="px-2 py-2">Facility</th>
                    <th class="px-2 py-2">Date and Time</th>
                    <th class="px-2 py-2">Purpose</th>
                    <th class="px-2 py-2">Name of Patient</th>
                    <th v-if="$page.props.auth.user.roles.includes('user')" class="px-4 py-2">Action</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="item in book.data">
                        <td class="px-2 py-2 border">{{ item.id }}</td>
                        <td class="px-2 py-2 border">{{ item.where }}</td>
                        <td class="px-2 py-2 border">{{ moment(item.book_date).format("MMMM, D, YYYY @ hh:mm a") }}</td>
                        <td class="px-2 py-2 border">{{ item.purpose }}</td>
                        <td class="px-2 py-2 border">{{ item.booked_by }}</td>
                        <td v-if="hasRole('user')" class="px-2 py-2 border">
                            <button
                                @click="editForm(item)"
                                class="rounded-md px-4 py-2 bg-blue-600 font-bold text-white hover:bg-blue-500 text-sm m-1">Edit</button>
                            <button
                                @click="deleteItem(item)"
                                class="rounded-md px-4 py-2 bg-red-600 font-bold text-white hover:bg-red-500 text-sm m-1">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <pagination :links="book.links"></pagination>
            <book-form :isOpen="isFormOpen" :isEdit="isFormEdit" :isView="isFormView" :isCreate="isFormCreate" :form="formObject" @formsave="saveItem" @formclose="closeModal"></book-form>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import { usePermission } from "@/composables/permissions";
import { Head } from '@inertiajs/vue3';

const { hasRole } = usePermission();
</script>

<script>

    const defaultFormObject = {
        where: null,
        book_date: null,
        purpose: null,
        status: null
    };

    import AuthenticatedLayout from './../Layouts/AuthenticatedLayout.vue';
    import Pagination from './../Components/pagination.vue';
    import BookForm from './../Components/Book/form.vue';
    import moment from 'moment';
    

    export default{
        props: ['book'],
        components: {
            AuthenticatedLayout,
            Pagination,
            BookForm,
            moment
        },
        data()
        {
            return {
                isFormOpen: false,
                isFormEdit: false,
                isFormCreate: false,
                formObject: defaultFormObject
            }
        },
        methods: {
            saveItem(item)
            {
                let url = '/books';
                if(item.id){
                    url = '/books/' + item.id;
                    item._method = 'PUT';
                }
                this.$inertia.post(url, item, {
                    onError: () => {

                    },
                    onSuccess: () => {
                        this.closeModal();
                    }
                });
            },
            closeModal()
            {
                this.isFormOpen = false;
            },
            openForm()
            {
                this.isFormOpen = true;
                this.isFormCreate = true;
                this.isFormEdit = false;
                this.formObject = Object.assign({}, defaultFormObject);
                this.$page.props.errors = {};
            },
            editForm(item)
            {
                this.isFormOpen = true;
                this.isFormEdit = !!item;
                this.isFormCreate = false;
                this.formObject = Object.assign({}, item);
                this.$page.props.errors = {};
            },
            deleteItem(item)
            {
                if(window.confirm('are you sure?')){
                    this.$inertia.post('/books/' + item.id, {
                        _method: 'DELETE'
                    });
                }
            }

        }

    }
</script>