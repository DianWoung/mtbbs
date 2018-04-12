<template>
        <mavon-editor ref=md @imgAdd="$imgAdd" :value="value" @change="emitChange" style="height:100%" ></mavon-editor>
</template>
<script>
   // import {mavonEditor} from 'mavon-editor'
    export default {
        props:['value'],
        data(){
          return {
              val:'',
              host:'http://'+location.host
          }
        },
        methods: {
            // 绑定@imgAdd event
            $imgAdd(pos, $file){
                // 第一步.将图片上传到服务器.
                var formdata = new FormData();
                formdata.append('image', $file);
                axios({
                    url: this.host+'/upload_image',
                    method: 'post',
                    data: formdata,
                    headers: { 'Content-Type': 'multipart/form-data' },
                }).then((e) => {
                    if(e.status === 200){
                        this.$refs.md.$img2Url(pos, this.host+e.data.url);
                    }else{
                        alert("图片上传失败！")
                    }
                })
            },
            emitChange(value)
            {
            this.$emit('edittextbody',value)
            }
        }
    }
</script>

<style scoped>

</style>