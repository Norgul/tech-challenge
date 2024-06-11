<template>
    <div>
        <h1 class="mb-6">Clients -> {{ client.name }}</h1>

        <div class="flex">
            <div class="w-1/3 mr-5">
                <div class="w-full bg-white rounded p-4">
                    <h2>Client Info</h2>
                    <table>
                        <tbody>
                            <tr>
                                <th class="text-gray-600 pr-3">Name</th>
                                <td>{{ client.name }}</td>
                            </tr>
                            <tr>
                                <th class="text-gray-600 pr-3">Email</th>
                                <td>{{ client.email }}</td>
                            </tr>
                            <tr>
                                <th class="text-gray-600 pr-3">Phone</th>
                                <td>{{ client.phone }}</td>
                            </tr>
                            <tr>
                                <th class="text-gray-600 pr-3">Address</th>
                                <td>{{ client.address }}<br/>{{ client.postcode + ' ' + client.city }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="w-2/3">
                <div>
                    <button class="btn"
                            :class="{'btn-primary': currentTab === 'bookings', 'btn-default': currentTab !== 'bookings'}"
                            @click="switchTab('bookings')">Bookings
                    </button>
                    <button class="btn"
                            :class="{'btn-primary': currentTab === 'journals', 'btn-default': currentTab !== 'journals'}"
                            @click="switchTab('journals')">Journals
                    </button>
                </div>

                <!-- Bookings -->
                <div class="bg-white rounded p-4" v-if="currentTab === 'bookings'">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>List of client bookings</h3>

                        <div>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ selectedFilter }}
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                    <button class="dropdown-item" type="button" @click="setFilter('All bookings')">
                                        All bookings
                                    </button>
                                    <button class="dropdown-item" type="button" @click="setFilter('Future bookings only')">
                                        Future bookings only
                                    </button>
                                    <button class="dropdown-item" type="button" @click="setFilter('Past bookings only')">
                                        Past bookings only
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <template v-if="client.bookings && client.bookings.length > 0">
                        <table>
                            <thead>
                            <tr>
                                <th>Time</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="booking in filteredBookings" :key="booking.id">
                                    <td>{{ formatDate(booking.start, booking.end) }}</td>
                                    <td>{{ booking.notes }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" @click="deleteBooking(booking)">Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </template>

                    <template v-else>
                        <p class="text-center">The client has no bookings.</p>
                    </template>

                </div>

                <!-- Journals -->
                <div class="bg-white rounded p-4" v-if="currentTab === 'journals'">
                    <h3 class="mb-3">List of client journals</h3>

                    <p>(BONUS) TODO: implement this feature</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import moment from "moment";

export default {
    name: 'ClientShow',

    props: ['client'],

    data() {
        return {
            currentTab: 'bookings',
            selectedFilter: 'All bookings',
        }
    },

    computed: {
        filteredBookings() {
            const now = moment();

            if (this.selectedFilter === 'Future bookings only') {
                return this.client.bookings.filter(booking => moment(booking.start).isAfter(now));
            } else if (this.selectedFilter === 'Past bookings only') {
                return this.client.bookings.filter(booking => moment(booking.end).isBefore(now));
            }

            return this.client.bookings;
        }
    },

    methods: {
        switchTab(newTab) {
            this.currentTab = newTab;
        },

        deleteBooking(booking) {
            axios.delete(`/bookings/${booking.id}`);
        },

        formatDate(start, end) {
            const startDate = moment(start);
            const endDate = moment(end);

            const dateFormat = 'dddd DD MMMM YYYY';
            const timeFormat = 'HH:mm';

            const formattedDate = startDate.format(dateFormat);
            const startTime = startDate.format(timeFormat);
            const endTime = endDate.format(timeFormat);

            return `${formattedDate}, ${startTime} to ${endTime}`;
        },

        setFilter(filter) {
            this.selectedFilter = filter;
        },
    }
}
</script>
