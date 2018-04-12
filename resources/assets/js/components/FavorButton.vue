<template>
    <div class="card card-default topic-favors text-center">
        <div class="card-body">
           <button type="button" @click="favorSwitch" class="btn btn-outline-danger" :class="{ 'active': switcherInfo.isActive }"><i class="material-icons">thumb_up</i>{{ switcherInfo.msg }}</button>
            <div class="card-text" style="margin-top: 10px">
                <span class="user-avatar" v-for="users in userList">
                    <a :href="'/users/'+users.id">
                    <img :src="users.avatar" class="img-responsive rounded-circle" width="30px" height="30px" style="padding: 1px">
                    </a>
                </span>
            </div>
      </div>
    </div>
</template>

<script>
    export default {
        name: "FavorButton",
        props:['status','uid','avatar','tid','favors'],
        created () {
            this.getFavors(this.tid);
            this.status === 'true' ? this.switcherInfo = this.favored : this.switcherInfo = this.favor
            this.status === 'true' ? this.switcherStatus = true : this.switcherStatus = false

        },
        data () {
            return {
                switcherStatus:false,
                switcherInfo:'',
                favored:{
                    isActive:true,
                    msg:'已赞'
                },
                favor:{
                    isActive:false,
                    msg:'点赞'
                },
                userList:[]

            }
        },
        methods: {
            favorSwitch(){
                if(this.switcherStatus === true){
                    this.switcherStatus = false
                    this.switcherInfo = this.favor
                    this.unfavorTopic();
                } else {
                    this.switcherStatus = true
                    this.switcherInfo = this.favored
                    this.favorTopic();
                }
            },
            favorTopic(){
                this.userList.push({
                    id: this.uid,
                    avatar: this.avatar
                });
                axios.get('/users/'+ this.uid + '/topics/' + this.tid + '/favor').then((resp)=>{
                    if (resp.data.status){
                        console.log('success');
                    }
                });
            },
            unfavorTopic(){
                this.userList.forEach((items,index)=>{
                    if(items.id == this.uid)
                    {

                       this.userList.splice(index,1);
                        axios.get('/users/'+ this.uid + '/topics/' + this.tid + '/unfavor').then((resp)=>{
                            if (resp.status){
                                console.log(resp);
                            }
                        });
                    }

                })
            },
            getFavors(id){

                axios.get('/topics/'+id+'/favors').then((resp)=>{
                    if (resp.status){
                        this.userList = resp.data;
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>