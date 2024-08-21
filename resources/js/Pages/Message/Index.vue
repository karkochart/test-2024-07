<template>
    <div>
        <h2>Message</h2>

        <div class="w-1/2 mx-auto">
            <div class="mb-5" v-if="messages.length > 0">
                <div v-for="message in messages">
                    <p>{{ message.id }}</p>
                    <p>{{ message.body }}</p>
                    <p>{{ message.created_at }}</p>
                </div>
            </div>
            <div class="mb-5">
                <input type="text" id="body"
                       v-model="body"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       placeholder="message" required/>
            </div>
            <a href="#"
               @click.prevent="store"
               class="bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">submit</a>
        </div>

    </div>
</template>
<script>
export default {
    name: 'Index',

    props: [
        'messages',
    ],

    data() {
        return {
            body: '',
        }
    },

    created() {
        window.Echo.channel('store_message')
            .listen('.store_message', res => {
                this.messages.unshift(res.message)
            });
    },

    methods: {
        store() {
            axios.post('/messages', {body: this.body})
                .then(res => {
                    this.messages.unshift(res.data)
                })
        }
    }
}
</script>

<style scoped>

</style>
