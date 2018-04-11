<template>
    <button @click="switcher" class="btn btn-block"  :class="{ 'btn-info':switcherInfo.status,'btn-light': switcherInfo.light }" aria-label="Left Align">
        <i class="material-icons">{{ switcherInfo.Icon }}</i> {{ switcherInfo.Msg }}
    </button>
</template>

<script>
    export default {
        name: "FollowButton",
        props:['status','id'],
        created(){
            this.status === 'true' ? this.switcherInfo = this.followed : this.switcherInfo = this.unfollow
            this.status === 'true' ? this.switcherStatus = true : this.switcherStatus = false
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
                    this.unfollowUser();
                } else {
                    this.switcherStatus = true
                    this.switcherInfo = this.followed
                    this.followUser();
                }
            },
            followUser:function () {
                axios.get('/follow/user?flower_id='+this.id).then((resp)=>{
                    if (resp.data.status){
                        console.log('success');
                    }
                });
            },
            unfollowUser:function () {
                axios.get('/unfollow/user?flower_id='+this.id).then((resp)=>{
                    if (resp.data.status){
                        console.log('success');
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>