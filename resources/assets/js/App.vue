<template>
    <div class="app-container">
        <router-view></router-view>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                active: 0
            }
        }
    }
</script>