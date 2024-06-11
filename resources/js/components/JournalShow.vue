<template>
    <div>
        <h1 class="mb-6">{{ client.name }}'s journal entry</h1>

        <div class="flex">
            <div class="w-1/3 mr-5">
                <div class="w-full bg-white rounded p-4">
                    <table>
                        <tbody>
                            <tr>
                                <th class="text-gray-600 pr-3">Date</th>
                                <td>{{ journal.date }}</td>
                            </tr>
                            <tr>
                                <th class="text-gray-600 pr-3">Content</th>
                                <td>{{ journal.content }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: 'JournalShow',

    props: ['client', 'journal'],
}
</script>
