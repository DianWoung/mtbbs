<template>
    <button @click="switcher" class="btn btn-block"  :class="{ 'btn-info':switcherInfo.status,'btn-light': switcherInfo.light }" aria-label="Left Align">
        <i class="material-icons">{{ switcherInfo.Icon }}</i> {{ switcherInfo.Msg }}
    </button>
</template>

<script>
    export default {
        name: "FollowButton",
        props:['status'],
        created(){
            this.status === 'true' ? this.switcherInfo = this.followed:this.unfollow
            this.status === 'true' ? this.switcherStatus = true:false
        },
        data () {
            return {
                switcherStatus:false,
                switcherInfo:'',
                unfollow:{
                    status:true,
                    light:false,
                    Icon: 'add',
                    Msg: '关注'
                },
                followed:{
                    status:false,
                    light:true,
                    Icon: 'indeterminate_check_box',
                    Msg: '已关注'
                }
            }
        },
        methods:{
            switcher:function () {
                if(this.switcherStatus === true){
                    this.switcherStatus = false
                    this.switcherInfo = this.unfollow
                } else {
                    this.switcherStatus = true
                    this.switcherInfo = this.followed
                }
            }
        }
    }
</script>

<style scoped>

</style>