<template>
    <div class="form-group">
    <textarea name="body" v-model="val">
    </textarea>
    </div>
</template>

<script>
    export default {
        name: "textbody",
        props:['val','input'],
        data () {
            return {
                textInput:this.input,
                textValue:this.val,
            }
        },
        created (){
            if (this.textInput !== "")
            {
                this.$emit('edittext',this.textInput)
            }
        }
    }
</script>

<style scoped>
#textbody {
   // display:none;
}
</style>