<template>
    <v-container>
        <div>
            <v-simple-table>
                <thead>
                    <tr>
                        <th>Serial No.</th>
                        <th>Order Number</th>
                        <th>User ID</th>
                        <th>User Account</th>
                        <th>Type</th>
                        <th>Ammount Deposit</th>
                        <th>Deposit Screenshot</th>
                        <th>State</th>
                        <th>Payment Methods</th>
                        <th>Purchase Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item , i) in deposit" :key="i">
                        <td>{{  item.id }}</td>
                        <td>{{  item.OrderNumber }}</td>
                        <td>{{  item.UserID }}</td>
                        <td>{{  item.UserAccount }}</td>
                        <td>{{  item.Type }}</td>
                        <td>{{  item.Amount }}</td>
                        <td></td>
                        <td>{{  item.State }}</td>
                        <td>{{  item.Methods }}</td>
                        <td>{{  item.created_at.slice(0,10) }}</td>
                        <td v-if="item.State == 'Process Completed' || item.State == 'Cancelled Order Admin' || item.State == 'Cancelled Order Client' || item.State == 'Paid'">
                          
                        </td>
                        <td v-else>
                            <v-btn  x-small @click="ConfirmPayment(item)"> 
                                Cofirm Payment
                            </v-btn>
                            <v-btn @click="cancelorder(item)" x-small>
                                Cancel Payment
                            </v-btn>
                        </td>
                    </tr>
                </tbody>
            </v-simple-table>
        </div>
    </v-container>
</template>

<script>

import axios from "axios";
export default {
    data:()=>({
        deposit : {},
        // State : undefined
        amount : {},
        total : undefined,
    }),

    created(){
        this.getdata()
        this.getUserdata()
    },

    methods:{
       

    ConfirmPayment(item){
        console.log(item)
        for(let i=0; i<this.amount.length; i++){
            if(item.UserID == this.amount[i].id){
                if(this.amount[i].Asset == null){
                    console.log('wlang pera')
                    axios.post(`/api/RechargeDetails/update2`,item).then((res)=>{
                    if(res.data){
                axios.post(`/api/user/update/${item.UserID}`,item).then((res)=>{
                    if(res.data){
                    console.log('pasok')
                    this.getdata()
                    }
                })
                    }
                })
                }else{
                    console.log('dadagdagan')
                    this.total = parseInt(this.amount[i].Asset) + parseInt(item.Amount)
                console.log('Asset',this.total );

                axios.post(`/api/RechargeDetails/update2`,item).then((res)=>{
                    if(res.data){
                axios.post(`/api/user/update2/${item.UserID}`,{Amount:this.total}).then((res)=>{
                    if(res.data){
                    console.log('pasok')
                    this.getdata()
                    }
                })
                    }
                })
                }
                
            }
        }
    },
        getdata(){
        axios.get(`/api/RechargeDetailsAdmin`).then((res) => {
            this.deposit = res.data;
            
            // this.amount = res.data.amount;
            console.log('getdata',this.deposit );
        });
        },
        getUserdata(){
            axios.get(`/api/AccountInfo`).then((res) => {
            this.amount = res.data;
            
            // this.amount = res.data.amount;
           
        });
        },
        cancelorder(item){
            console.log(item)
            axios.post(`api/CancelOrderAdmin/update`,item).then((res)=>{
                if(res.data){
                    alert('Order canceled')
                    this.getdata()
                }
            })
        }
    },
    
}
</script>

<style>

</style>