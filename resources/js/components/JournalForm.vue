<template>
    <div>
        <h1 class="mb-6">Journals -> Add New Journal for {{ this.client.name }}</h1>

        <div class="max-w-lg mx-auto">
            <div class="form-group">
                <label for="name">Date</label>
                <input type="date" id="date" class="form-control" v-model="journal.date">
            </div>
            <div class="form-group">
                <label for="email">Content</label>
                <textarea type="text" id="content" class="form-control" v-model="journal.content" />
            </div>

            <div class="text-right">
                <a :href="`/clients/${this.client.id}`" class="btn btn-default">Cancel</a>
                <button @click="storeJournal" class="btn btn-primary">Create</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'JournalForm',

    props: ['client'],

    data() {
        return {
            journal: {
                date: '',
                content: '',
            }
        }
    },

    methods: {
        storeJournal() {
            axios.post(`/clients/${this.client.id}/journals`, this.journal)
                .then((data) => {
                    window.location.href = `/clients/${this.client.id}`;
                });
        }
    }
}
</script>
