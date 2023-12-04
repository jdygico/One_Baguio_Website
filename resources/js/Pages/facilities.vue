<template>
    <Head title="Facilities" />
    <AuthenticatedLayout>
        <div class="bg-white overflow-hidden shadow-xl rounded-lg m-2 p-4">
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
                    Facilities
                </h2>
                <button @click="openForm()" v-if="hasPermission('facility create')"
                    class="rounded-md px-4 py-2 mb-2 bg-green-600 font-bold text-white hover:bg-green-500 sm:text-sm sm:leading-5 max-w-fit place-self-end">Create New Facility</button>
            </div>
            <!-- table -->
            <table class="table-fixed w-full border" style="text-align: center;" v-if="hasPermission('facility list')">
                <thead>
                <tr class="bg-gray-100">
                    <th class="px-2 py-2 w-20">No.</th>
                    <th class="px-2 py-2">Name</th>
                    <th class="px-2 py-2">Address</th>
                    <th class="px-2 py-2">Type</th>
                    <th class="px-2 py-2">Services</th>
                    <th class="px-2 py-2" v-if="hasPermission('facility edit'||'facility delete')">Action</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="item in data.data">
                        <td class="px-2 py-2 border">{{ item.id }}</td>
                        <td class="px-2 py-2 border">{{ item.name }}</td>
                        <td class="px-2 py-2 border">{{ item.address }}</td>
                        <td class="px-2 py-2 border">{{ item.type }}</td>
                        <td class="px-2 py-2 border">{{ item.services }}</td>
                        <td class="px-2 py-2 border" v-if="hasPermission('facility edit'||'facility delete')">
                            <button
                                v-if="hasPermission('facility edit')"
                                @click="openForm(item)"
                                class="rounded-md px-4 py-2 bg-blue-600 font-bold text-white hover:bg-blue-500 text-sm m-1">Edit</button>
                            <button
                                v-if="hasPermission('facility delete')"
                                @click="deleteItem(item)"
                                class="rounded-md px-4 py-2 bg-red-600 font-bold text-white hover:bg-red-500 text-sm m-1">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <pagination :links="data.links"></pagination>
            <FacilityForm :isOpen="isFormOpen" :isEdit="isFormEdit" :form="formObject" @formsave="saveItem" @formclose="closeModal"></FacilityForm>
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
        name: null, address: null, type: null, services: null
    };
    
    import AuthenticatedLayout from './../Layouts/AuthenticatedLayout.vue';
    import Pagination from './../Components/pagination.vue';
    import FacilityForm from './../Components/Facility/form.vue';

    export default{
        props: ['data'],
        components: {
            AuthenticatedLayout,
            Pagination,
            FacilityForm
        },
        data()
        {
            return {
                isFormOpen: false,
                isFormEdit: false,
                formObject: defaultFormObject
            }
        },
        methods: {
            saveItem(item)
            {
                let url = '/facilities';
                if(item.id){
                    url = '/facilities/' + item.id;
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
            openForm(item)
            {
                this.formObject.name = null;
                this.formObject.address = null;
                this.formObject.type = null;
                this.formObject.services = null;

                this.isFormOpen = true;
                this.isFormEdit = !!item;
                this.formObject = item ? Object.assign({}, item) : defaultFormObject;
                this.$page.props.errors = {};
            },
            deleteItem(item)
            {
                if(window.confirm('are you sure?')){
                    this.$inertia.post('/facilities/' + item.id, {
                        _method: 'DELETE'
                    });
                }
            }

        }

    }
</script>