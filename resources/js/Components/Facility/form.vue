<template>
    <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                role="dialog" aria-modal="true" aria-labelledby="modal-headline">

                <form>
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="">
                            <div class="mb-4">
                                <label for="formFacilityName"
                                       class="block text-gray-700 text-sm font-bold mb-2">Name: </label>
                                <input type="text"
                                       v-model="form.name"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       id="formFacilityName" placeholder="Enter Name">
                                <div v-if="$page.props.errors.name" class="text-red-500">{{ $page.props.errors.name }}</div>

                            </div>
                            <div class="mb-4">
                                <label for="formFacilityLocation"
                                       class="block text-gray-700 text-sm font-bold mb-2">Address:</label>
                                <input type="text"
                                       v-model="form.address"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       id="formFacilityLocation" placeholder="Enter Address">
                                <div v-if="$page.props.errors.address" class="text-red-500">{{ $page.props.errors.address }}</div>

                            </div>
                            <div class="mb-4">
                                <label for="formFacilityType"
                                       class="block text-gray-700 text-sm font-bold mb-2">Type:</label>
                                <select id="formPatientPrefix" v-model="form.type"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option disabled :value="null"> --Select Prefix-- </option>
                                    <option v-for="option in type_options" v-bind:value="option">{{ option }}</option>
                                </select>
                                <div v-if="$page.props.errors.type" class="text-red-500">{{ $page.props.errors.type }}</div>
                            </div>

                            <div class="mb-4">
                                <label for="formFacilityServices"
                                       class="block text-gray-700 text-sm font-bold mb-2">Services:</label>
                                <input type="text"
                                       v-model="form.services"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       id="formFacilityServices" placeholder="Enter Services">
                                <div v-if="$page.props.errors.services" class="text-red-500">{{ $page.props.errors.services }}</div>

                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                          <button  type="button"
                                   v-show="!isEdit"
                                   @click="$emit('formsave', form)"
                                   class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                          >
                            Save
                          </button>
                        </span>
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                          <button  type="button"
                                   v-show="isEdit"
                                   @click="$emit('formsave', form)"
                                   class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                          >
                            Update
                          </button>
                        </span>
                        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                          <button
                              type="button"
                              @click="$emit('formclose')"
                              class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Cancel
                          </button>
                        </span>
                    </div>
                </form>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['form', 'isOpen', 'isEdit'],
        data() {
        return {
            type_options: ['Health Center', 'Hospital','Clinic','Diagnostic Center','Imaging Center','Other']
        }
    }
    }


</script>
