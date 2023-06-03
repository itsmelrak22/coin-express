<template>
  <div>
    <app-toolbar :toolbar="toolbar"></app-toolbar>



    <!-- Dialogs -->
	<v-dialog v-model="dialogStore" max-width="800" persistent>
		<v-form id="Store" ref="Store" @submit.prevent="Store">
			<v-card>
				<v-card-title>
					<span class="headline"> PLANNER BASIC INFO </span>
					<v-spacer></v-spacer>
				</v-card-title>
				<v-card-text>
					<v-container>
						<v-row>
							<template>
								<v-col cols="12">

								</v-col>
							</template>
						</v-row>
					</v-container>
				</v-card-text>
				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn  small text  type="submit"> Save </v-btn>
					<v-btn  small text  @click="dialogStore = false"> Close </v-btn>
				</v-card-actions>
			</v-card>
		</v-form>
	</v-dialog>

	<v-dialog v-model="dialogUpdate" max-width="800" persistent>
		<v-form id="Update" ref="Update" @submit.prevent="Update">
			<v-card>
				<v-card-title>
					<span class="headline"> PLANNER BASIC INFO </span>
					<v-spacer></v-spacer>
				</v-card-title>
				<v-card-text>
					<v-container>
						<v-row>
							<template>
								<v-col cols="12">

								</v-col>
							</template>
						</v-row>
					</v-container>
				</v-card-text>
				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn  small text  type="submit"> Save </v-btn>
					<v-btn  small text  @click="dialogUpdate = false"> Close </v-btn>
				</v-card-actions>
			</v-card>
		</v-form>
	</v-dialog>
	
	<app-buttons  
		@toggleDialogStore="toggleDialogStore" 
		:floatButtons="floatButtons"
	> 
	</app-buttons>
	

    <app-footer></app-footer>    
  </div>
</template>

<script>
import { mapState } from 'vuex'
import ToolbarMenu from '../../modules/ToolbarMenu.vue';
import Footer from '../../modules/Footer.vue';
import FloatingButtons from '../../modules/FloatingButtons.vue';

export default {
    components: {
        'app-toolbar': ToolbarMenu,
		'app-buttons': FloatingButtons,
        'app-footer': Footer
    },

    data(){
      return {
		toolbar: {
			title: 'ENTRACE DOOR',
			view: false,
			back: true,
			filter: false,
			master: false,
		},

		floatButtons:{
			add: true,
			update: false,
			delete: false
		},

		//temp data storage
		tempData: {},
		dialogStore: false,
		dialogUpdate: false,
		dialogDelete: false
	}
    },

    computed: {
        ...mapState([
            'viewMode',
            'rules'
        ])
    },

	methods: {
		toggleDialogStore(val){
			this.dialogStore = val;
		},

		toggleUpdateDialog(item){
			if(item){
				this.tempData = {...item};
				this.dialogUpdate = true;
			}else{
				this.dialogUpdate = false;
			}
		},

	}

}
</script>

<style>

</style>