<template>
    <div>
        <h1>We can have some data here: {{ counter }}</h1>
        <button @click="updateCounter(1)">Increase</button>
        <button @click="updateCounter(-1)">Decrease</button>

        <br/><br/>

        <div v-if="blogs.length">
            <div v-for="(blog, i) in blogs" :key="i">
                <h1>{{ blog.title }}</h1>
                <p>{{ blog.post }}</p>
            </div>
        </div>

        <br/><br/>

        <div>
            <h1 v-if="showItem">Hide and seek</h1>
            <button @click="hideAndSeek(true)">Show</button>
            <button @click="hideAndSeek(false)">Hide</button>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            counter: 0,
            blogs: [],
            showItem: false
        };
    },
    methods: {
        updateCounter(number) {
            this.counter += number;
        },
        hideAndSeek(status){
            this.showItem = status
        }
    },
    created() {
        this.counter = 100;

        // get the blog posts
        let posts = [
            { title: "blog title 1", post: "blog post", id: 1 },
            { title: "blog title 2", post: "blog post", id: 2 },
            { title: "blog title 3", post: "blog post", id: 3 },
            { title: "blog title 4", post: "blog post", id: 4 }
        ];

        this.blogs = posts;
    }
};
</script>
