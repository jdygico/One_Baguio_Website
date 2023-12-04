<template>
    <Head title="Dashboard"></Head>
    <AuthenticatedLayout>
        <div class="grid grid-cols-3">
            <div class="overflow-hidden shadow-xl rounded-lg m-2 p-4 grid grid-flow-row auto-rows-min gap-4">
                <div class="flex">
                    <label class="flex-1 self-center font-bold">Purpose of Booking</label>
                    <select class="flex-initial rounded text-sm h-min" v-model="purpose_filter">
                        <option selected value="Today">Today</option>
                        <option value="Last7">Last 7 days</option>
                        <option value="Last30">Last 30 days</option>
                    </select>
                </div>
                <div class="grid auto-rows-min gap-1">
                    <div v-for="item in bookscountbypurpose" class="flex">
                        <label class="flex-1">{{ item.purpose }}</label>
                        <label>{{ item.count }}</label>
                    </div>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-xl rounded-lg m-2 p-4 grid grid-flow-row auto-rows-min gap-4">
                <div class="flex">
                    <label class="flex-1 self-center font-bold">Nature of Visit</label>
                    <select class="flex-initial rounded text-sm h-min" v-model="nature_filter">
                        <option selected value="Today">Today</option>
                        <option value="Last7">Last 7 days</option>
                        <option value="Last30">Last 30 days</option>
                    </select>
                </div>
                <div class="grid auto-rows-min gap-1">
                    <div v-for="item in consultscountbynature" class="flex">
                        <label class="flex-1">{{ item.nature }}</label>
                        <label>{{ item.count }}</label>
                    </div>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-xl rounded-lg m-2 p-4 grid grid-flow-row auto-rows-min gap-4">
                <div class="flex">
                    <label class="flex-1 self-center font-bold">Top 5 Chief Complaints</label>
                    <select class="flex-initial rounded text-sm h-min" v-model="complaint_filter">
                        <option selected value="Today">Today</option>
                        <option value="Last7">Last 7 days</option>
                        <option value="Last30">Last 30 days</option>
                    </select>
                </div>
                <div class="grid auto-rows-min gap-1">
                    <div v-for="item in consultscountbycomplaint.slice(0,5)" class="flex">
                        <label class="flex-1">{{ item.complaint }}</label>
                        <label>{{ item.count }}</label>
                    </div>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-xl rounded-lg m-2 p-4 grid grid-flow-row auto-rows-min gap-4">
                <div class="flex">
                    <label class="flex-1 self-center font-bold">Age Groups of Consultations</label>
                    <select class="flex-initial rounded text-sm h-min" v-model="age_filter">
                        <option selected value="Today">Today</option>
                        <option value="Last7">Last 7 days</option>
                        <option value="Last30">Last 30 days</option>
                    </select>
                </div>
                <div class="grid auto-rows-min gap-1">
                    <div v-for="(count, group) in consultscountbyagegroup" class="flex">
                        <label class="flex-1">{{ group }}</label>
                        <label>{{ count }}</label>
                    </div>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-xl rounded-lg m-2 p-4 grid grid-flow-row auto-rows-min gap-4">
                <div class="flex">
                    <label class="flex-1 self-center font-bold">Top 5 Most Bookings per Barangay</label>
                    <select class="flex-initial rounded text-sm h-min" v-model="booksperbrgy_filter">
                        <option selected value="Today">Today</option>
                        <option value="Last7">Last 7 days</option>
                        <option value="Last30">Last 30 days</option>
                    </select>
                </div>
                <div class="grid auto-rows-min gap-1">
                    <div v-for="item in bookscountbybrgy.slice(0,5)" class="flex">
                        <label class="flex-1">{{ item.patient_barangay }}</label>
                        <label>{{ item.count }}</label>
                    </div>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-xl rounded-lg m-2 p-4 grid grid-flow-row auto-rows-min gap-4">
                <div class="flex">
                    <label class="flex-1 self-center font-bold">Total Bookings</label>
                    <select class="flex-initial rounded text-sm h-min" v-model="totalbooks_filter">
                        <option selected value="Today">Today</option>
                        <option value="Last7">Last 7 days</option>
                        <option value="Last30">Last 30 days</option>
                    </select>
                </div>
                <label class="text-center text-7xl">{{ totalbooks }}</label>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<script>
import axios from 'axios';
import Datepicker from '@vuepic/vue-datepicker';
import moment from 'moment';

export default{
    components: { Datepicker, moment },
    data() {
        return {
            booksMonthly:[],
            consultsMonthly:[],
            purpose_filter: "Today",
            nature_filter: "Today",
            complaint_filter: "Today",
            age_filter: "Today",
            booksperbrgy_filter: "Today",
            totalbooks_filter: "Today",
            date_from: null,
            date_to: null
        };
    },
    mounted() {
        axios.get('/api/booksMonthly')
            .then(response => {
                this.booksMonthly = response.data;
            })
            .catch(error => {
                console.log(error);
            });
        axios.get('/api/consultsMonthly')
            .then(response => {
                this.consultsMonthly = response.data;
            })
            .catch(error => {
                console.log(error);
            });
    },
    computed: {
        bookscountbypurpose() {
            var subbooks = this.booksMonthly;
            if (this.purpose_filter == 'Today') {
                const date = new Date();
                let day = date.getDate();
                subbooks = this.booksMonthly.filter(function(book) {
                    var book_date = new Date(book.book_date);
                    return (book_date.getDate() == day)
                });
            } else if (this.purpose_filter == 'Last7') {
                const date = new Date();
                let week = date.getDate()-7;
                subbooks = this.booksMonthly.filter(function(book) {
                    var book_date = new Date(book.book_date);
                    return (book_date.getDate() >= week)
                });
            }
            const purposeCount = subbooks.reduce((acc, cur) => {
                const existingObjectIndex = acc.findIndex(obj => obj.purpose === cur.purpose);
                if (existingObjectIndex === -1) {
                    acc.push({ purpose: cur.purpose, count: 1 });
                } else {
                    acc[existingObjectIndex].count++;
                }
                return acc;
            }, []);
            const sorted = purposeCount.sort((a, b) => {
                if (a.count === b.count) {
                    if (a.purpose > b.purpose) {
                        return 1;
                    } else if (a.purpose < b.purpose) {
                        return -1;
                    } else {
                        return 0;
                    }
                } else {
                    return b.count - a.count;
                }
            });
            return sorted;
        },
        consultscountbynature() {
            var subconsults = this.consultsMonthly;
            if (this.nature_filter == 'Today') {
                const date = new Date();
                let day = date.getDate();
                subconsults = this.consultsMonthly.filter(function(consult) {
                    var consult_datetime = new Date(consult.consult_datetime);
                    return (consult_datetime.getDate() == day)
                });
            } else if (this.nature_filter == 'Last7') {
                const date = new Date();
                let week = date.getDate()-7;
                subconsults = this.consultsMonthly.filter(function(consult) {
                    var consult_datetime = new Date(consult.consult_datetime);
                    return (consult_datetime.getDate() >= week)
                });
            }
            const natureCount = subconsults.reduce((acc, cur) => {
                const existingObjectIndex = acc.findIndex(obj => obj.nature === cur.nature);
                if (existingObjectIndex === -1) {
                    acc.push({ nature: cur.nature, count: 1 });
                } else {
                    acc[existingObjectIndex].count++;
                }
                return acc;
            }, []);
            const sorted = natureCount.sort((a, b) => {
                if (a.count === b.count) {
                    if (a.nature > b.nature) {
                        return 1;
                    } else if (a.nature < b.nature) {
                        return -1;
                    } else {
                        return 0;
                    }
                } else {
                    return b.count - a.count;
                }
            });
            return sorted;
        },
        consultscountbycomplaint() {
            var subconsults = this.consultsMonthly;
            if (this.complaint_filter == 'Today') {
                const date = new Date();
                let day = date.getDate();
                subconsults = this.consultsMonthly.filter(function(consult) {
                    var consult_datetime = new Date(consult.consult_datetime);
                    return (consult_datetime.getDate() == day)
                });
            } else if (this.complaint_filter == 'Last7') {
                const date = new Date();
                let week = date.getDate()-7;
                subconsults = this.consultsMonthly.filter(function(consult) {
                    var consult_datetime = new Date(consult.consult_datetime);
                    return (consult_datetime.getDate() >= week)
                });
            }
            const complaintCount = subconsults.reduce((acc, cur) => {
                const existingObjectIndex = acc.findIndex(obj => obj.complaint === cur.complaint);
                if (existingObjectIndex === -1) {
                    acc.push({ complaint: cur.complaint, count: 1 });
                } else {
                    acc[existingObjectIndex].count++;
                }
                return acc;
            }, []);
            const sorted = complaintCount.sort((a, b) => {
                if (a.count === b.count) {
                    if (a.complaint > b.complaint) {
                        return 1;
                    } else if (a.complaint < b.complaint) {
                        return -1;
                    } else {
                        return 0;
                    }
                } else {
                    return b.count - a.count;
                }
            });
            return sorted;
        },
        consultscountbyagegroup() {
            var subconsults = this.consultsMonthly;
            if (this.age_filter == 'Today') {
                const date = new Date();
                let day = date.getDate();
                subconsults = this.consultsMonthly.filter(function(consult) {
                    var consult_datetime = new Date(consult.consult_datetime);
                    return (consult_datetime.getDate() == day)
                });
            } else if (this.age_filter == 'Last7') {
                const date = new Date();
                let week = date.getDate()-7;
                subconsults = this.consultsMonthly.filter(function(consult) {
                    var consult_datetime = new Date(consult.consult_datetime);
                    return (consult_datetime.getDate() >= week)
                });
            }
            const agegroupCount = {
                '0 - 14': 0,
                '15 - 24': 0,
                '25 - 59': 0,
                '>= 60': 0
            };
            for (const i of subconsults) {
                if (i.age <= 14) {
                    agegroupCount['0 - 14']++;
                } else if (i.age <= 24) {
                    agegroupCount['15 - 24']++;
                } else if (i.age <= 59) {
                    agegroupCount['25 - 59']++;
                } else {
                    agegroupCount['>= 60']++;
                }
            }
            return agegroupCount;
        },
        bookscountbybrgy() {
            var subbooks = this.booksMonthly;
            if (this.booksperbrgy_filter == 'Today') {
                const date = new Date();
                let day = date.getDate();
                subbooks = this.booksMonthly.filter(function(book) {
                    var book_date = new Date(book.book_date);
                    return (book_date.getDate() == day)
                });
            } else if (this.booksperbrgy_filter == 'Last7') {
                const date = new Date();
                let week = date.getDate()-7;
                subbooks = this.booksMonthly.filter(function(book) {
                    var book_date = new Date(book.book_date);
                    return (book_date.getDate() >= week)
                });
            }
            const booksbrgyCount = subbooks.reduce((acc, cur) => {
                const existingObjectIndex = acc.findIndex(obj => obj.patient_barangay === cur.patient_barangay);
                if (existingObjectIndex === -1) {
                    acc.push({ patient_barangay: cur.patient_barangay, count: 1 });
                } else {
                    acc[existingObjectIndex].count++;
                }
                return acc;
            }, []);
            const sorted = booksbrgyCount.sort((a, b) => {
                if (a.count === b.count) {
                    if (a.patient_barangay > b.patient_barangay) {
                        return 1;
                    } else if (a.patient_barangay < b.patient_barangay) {
                        return -1;
                    } else {
                        return 0;
                    }
                } else {
                    return b.count - a.count;
                }
            });
            return sorted;
        },
        totalbooks() {
            var subbooks = this.booksMonthly;
            if (this.totalbooks_filter == 'Today') {
                const date = new Date();
                let day = date.getDate();
                subbooks = this.booksMonthly.filter(function(book) {
                    var book_date = new Date(book.book_date);
                    return (book_date.getDate() == day)
                });
            } else if (this.totalbooks_filter == 'Last7') {
                const date = new Date();
                let week = date.getDate()-7;
                subbooks = this.booksMonthly.filter(function(book) {
                    var book_date = new Date(book.book_date);
                    return (book_date.getDate() >= week)
                });
            }
            return subbooks.length;
        }
    }
}
</script>