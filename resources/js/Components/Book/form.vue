<template>
    <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                role="dialog" aria-modal="true" aria-labelledby="modal-headline">

                <form>
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="">
                            <div class="mb-4">
                                <label for="formBookBookedBy" class="block text-gray-700 text-sm font-bold mb-2">Booked by: {{ form.booked_by }}</label>
                                <div v-if="$page.props.errors.book_date" class="text-red-500">{{
                                    $page.props.errors.book_date }}</div>
                            </div>
                            <div class="mb-4">
                                <label for="formBookFacility" class="block text-gray-700 text-sm font-bold mb-2">Facility:
                                </label>
                                <select v-model="form.where" :disabled=isView
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="formBookFacility">
                                    <option disabled :value="null"> --Select Facility-- </option>
                                    <option v-for="facility in facilities"
                                        v-bind:value="facility.name + ', ' + facility.address">{{ facility.name }}, {{
                                            facility.address }}</option>
                                </select>
                                <div v-if="$page.props.errors.facility" class="text-red-500">{{ $page.props.errors.facility
                                }}</div>
                            </div>
                            <div class="mb-4">
                                <label for="formBookDate" class="block text-gray-700 text-sm font-bold mb-2">Date and
                                    Time:</label>
                                <Datepicker :disabled=isView v-model="form.book_date" :enable-time-picker="true"
                                    model-type="yyyy-MM-dd HH:mm:ss" :is-24="false" :teleport="true"></Datepicker>
                                <div v-if="$page.props.errors.book_date" class="text-red-500">{{
                                    $page.props.errors.book_date }}</div>
                            </div>                            
                            <div class="mb-4" >
                                <label for="formBookPurpose"
                                    class="block text-gray-700 text-sm font-bold mb-2">Purpose:</label>
                                <select id="formstatus" v-model="form.purpose" :disabled=isView
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="Symptomatic" selected>Symptomatic</option>
                                    <option value="Routine">Routine</option>
                                    <option value="Follow-up">Follow-up</option>
                                    <option value="Consultation">Consultation</option>
                                    <option value="Preoperative">Preoperative</option>
                                    <option value="Postoperative">Postoperative</option>
                                    <option value="Urgent">Urgent</option>
                                    <option value="Others">Others</option>
                                </select>
                                    <div v-if="$page.props.errors.purpose" class="text-red-500">{{$page.props.errors.purpose }}</div>
                            </div>
                            <div class="mb-4" v-if="!isOpen||isView">
                                <label for="formBookStatus"
                                    class="block text-gray-700 text-sm font-bold mb-2">Status:</label><label v-if="!hasPermission('book status')">{{ form.status }}</label>
                                <select id="formstatus" v-model="form.status" v-if="hasPermission('book status')"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="Not Arrived" selected>Not Arrived</option>
                                    <option value="Waiting">Waiting</option>
                                    <option value="Consulting">Consulting</option>
                                    <option value="Finished">Finished</option>
                                </select>
                                <div v-if="$page.props.errors.Status" class="text-red-500">{{ $page.props.errors.Status }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <button type="button" v-show="isCreate" @click="$emit('formsave', form)"
                                class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                Save
                            </button>
                        </span>
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <button type="button" v-show="isEdit" @click="$emit('formsave', form)"
                                class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                Update
                            </button>
                        </span>
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <button type="button" @click="$emit('formsave', form)" v-show="isView"
                                class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                Change Status
                            </button>
                        </span>
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <button type="button" @click="$emit('formclose')" v-show="isEdit || isCreate"
                                class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                Cancel
                            </button>
                        </span>
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <button type="button" @click="$emit('formclose')" v-show="isView"
                                class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                Close
                            </button>
                        </span>
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
import '@vuepic/vue-datepicker/dist/main.css';
import axios from 'axios';

export default {
    props: ['form', 'isOpen', 'isEdit', 'isView', 'isCreate'],
    components: { Datepicker },
    data() {
        return {
            facilities: []
        };
    },
    mounted() {
        axios.get('/api/facilities')
            .then(response => {
                this.facilities = response.data;
            })
            .catch(error => {
                console.log(error);
            });
    },
}
</script>
