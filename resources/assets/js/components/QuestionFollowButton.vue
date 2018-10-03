<template>
    <button
            class="btn btn-default"
            v-bind:class="{'btn-success' : followed}"
            v-text="text"
            v-on:click="follow">
    </button>
</template>

<script>
    export default {
        props:['question'],
        mounted() {
            axios.post('/api/question/follow_status',{'question':this.question}).then(response => {
                // console.log(response.data)
                this.followed = response.data.followed
            })
        },
        data() {
            return {
                followed: false
            }
        },
        computed: {
            text() {
                return this.followed ? '已关注' : '关注该问题'
            }
        },
        methods:{
            follow() {
                axios.post('/api/question/follow',{'question':this.question},{
                    'Authorization': 'Bearer ' + document.head.querySelector('meta[name="apiToken"]').content,
                    }
                ).then(response => {
                    this.followed = response.data.followed
                })
            }
        }
    }
</script>