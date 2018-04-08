<template>
</template>

<script>
    export default {
        name: "MsgBox",
        props:['type','message'],
        created(){
            this.info(this.type, this.message);
        },
        methods: {
            info: function (type, msg) {
                switch (type) {
                    case 'success':
                        toastr.success(msg);
                        break;
                    case 'info':
                        toastr.info(msg);
                        break;
                    case 'warning':
                        toastr.warning(msg);
                        break;
                    case 'error':
                        toastr.error(msg);
                        break;
                    default:
                        toastr.error(msg);

                }

            },
        },
    }
</script>