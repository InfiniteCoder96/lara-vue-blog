export default{
    data(){
        return{

        }
    },
    methods: {
        async callApi(method, url, dataObj){
            try {
                return await axios({
                    method: method,
                    url: url,
                    data: dataObj
                })
            }
            catch (e){
                return e.response;
            }
            
        },
        info (nodesc, title="Info") {
            this.$Notice.info({
                title: title,
                desc: nodesc
            });
        },
        success (nodesc, title="success") {
            this.$Notice.success({
                title: title,
                desc: nodesc
            });
        },
        warning (nodesc, title="warning") {
            this.$Notice.warning({
                title: title,
                desc: nodesc
            });
        },
        error (nodesc, title="error") {
            this.$Notice.error({
                title: title,
                desc: nodesc
            });
        },
        genError (nodesc="Something went wrong! Please try again.", title="error") {
            this.$Notice.error({
                title: title,
                desc: nodesc
            });
        }

    }
}