<template>
    <div class="form-group">
    <textarea :name="name" v-model="val">
    </textarea>
    </div>
</template>

<script>
    export default {
        name: "textbody",
        props:['val', 'input', 'name'],
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