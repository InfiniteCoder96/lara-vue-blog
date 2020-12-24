<template>
    <div>
        <h1 ref="myref">{{name}} component</h1>
    </div>
</template>

<script>
export default {
    data(){
        return{
            name: 'hooks tutorial'
        }
    },
    beforeCreate(){
        console.log(this.name);
    },
    created(){
        // call mostly initial data from it...
        console.log('data and other functions are available but not html', this.name)
    },
    mounted() {
        console.log(this.$refs.myref)
    }
}
</script>