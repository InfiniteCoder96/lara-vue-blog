<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <h1>Common Component</h1>
                <p>curent count: {{$store.state.counter}}</p>

                <div>
                    <compA></compA>
                </div>
                <div>
                    <compB></compB>
                </div>
                <div>
                    <compC></compC>
                </div>

                <Button type="error" @click="changeCounter">Change counter</Button>
            </div>
        </div>
    </div>
</template>

<script>
import compA from './comA'
import compB from './comB'
import compC from './comC'

export default {
    data(){
        return {
           
        }
    },
    methods: {
        changeCounter(){
            this.$store.commit('changeCounter', 1)
        }
    },
    created(){
        
    },
    components:{
        compA,
        compB,
        compC
    }
}
</script>