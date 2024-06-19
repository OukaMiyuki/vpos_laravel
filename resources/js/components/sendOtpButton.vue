<template>
    <div>
        <form @submit="formSubmit">
            <button v-if="show" type="submit" class="btn btn-success" style="width:100%;">Apply</button>
        </form>
    </div>
</template>

<script>
    export default{
        mounted() {
            console.log('Component Mounted!')
        },
        data(){
            return {
                'show': true
            }
        }
    }
</script>