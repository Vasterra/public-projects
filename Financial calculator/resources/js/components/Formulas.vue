<template>
	<div class="mb-3">		
		<div class="mb-4">
			<select class="form-control" v-model="company" @change="changecompany">
				<option value="">- Select company -</option>
				<option v-for="company in companies" :value="company.id">{{ company.name }}</option>
			</select>
		</div>
		<div class="row mb-5" v-if="showData">
			<div class="col-6">
				<h5 class="h5">Forecact data</h5>				
				<table>
					<tbody>
						<tr v-for="indicator in indicators">
							<td>
								<span>{{ indicator.name }}</span>
							</td>
							<td>
								<span class="d-inline-block ml-3">
									<button class="btn btn-sm" @click="copyindicator(indicator.id)">Copy</button>
								</span>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-3">
				<h5 class="h5">Formulas</h5>
				<div class="mb-1" v-for="(fitem,index) in countformulas">
					<span class="d-inline-block"> Formula {{ index + 1 }}</span>
					<span class="d-inline-block ml-3">
						<button class="btn btn-sm" @click="copyf(index + 1)">Copy</button>
					</span>
				</div>
			</div>
			<div class="col-3">
				<h5 class="h5">Signs</h5>
				<div class="mb-2" v-for="sign in signs">
					<span class="d-inline-block pt-1 pb-1 border font-weight-bold text-center" style="width: 36px;">{{ sign.sign }}</span>
					<span class="d-inline-block ml-3">
						<button class="btn btn-sm" @click="copysign(sign.name)">Copy</button>
					</span>
				</div>
			</div>
		</div>		
		<div class="pb-3" v-if="showData">
			<div v-for="(item, index) in countformulas" class="mb-5" :class="{selectforedit: selectitems[index]}">				
				<div class="d-flex justify-content-between align-items-end mb-2">
					<div class="w-50">
						<h5 class="h5 d-inline-block mr-3">Formula {{ index + 1 }}</h5>
						<input type="text" class="form-control form-control w-50 d-inline-block" :value="names[index + 1]" placeholder="Name formula" @change="inputname(index + 1, $event.target.value)">
					</div>
					<div>
						<button class="btn btn-sm" @click="selectforedit(index)">Select for editing</button>
					</div>
				</div>			
				<div class="p-2 border bg-white" style="min-height: 40px;">
					<span v-for="item in formuladata[index+1]" class="d-inline-block pl-1 pr-1 mr-1 bg-light border">
						<span v-if="item.sign">{{ item.value }}</span>
						<span v-if="item.indicator">{{ item.value }}</span>
						<span v-if="item.f">{{ item.value }}</span>
					</span>
				</div>
				<div class="d-flex justify-content-between">
					<div class="pt-1">
						<input type="checkbox" :value="index + 1" :id="'check-pr-' + (index + 1)" @change="checkpercent" v-model="checkedpercent">
						<label :for="'check-pr-' + (index + 1)">Percentage result</label>
					</div>
					<div>
						<button class="btn btn-sm" @click="pasteformula(index+1)">Paste</button>
						<button class="btn btn-sm" @click="copyformula(index+1)">Copy</button>
						<button class="btn btn-sm" @click="deleteitem(index+1)">Delete last</button>
					</div>					
				</div>
			</div>
		</div>					
	</div>
</template> 

<script>
	export default {		
		data: function() {
			return {
				company: '',							
				signs: [],
				countformulas: 7,
				companies: [],
				indicators: [],
				formuladata: [],
				names: [],				
				checkedpercent: [],				
				showData: false,
				selectitems: [],
			}
		},		
		mounted() {
			this.getcompany()
			this.setcompany()
			this.setselectitems()						
		},
		methods: {
			setselectitems: function(value = null) {
				for (var i = 0; i < this.countformulas; i++) {					
					this.selectitems[i] = 0;					
				}
				if(value !== null) {
					this.selectitems[value] = 1;
				} 				
				console.log(this.selectitems);
			},
			setadmincompany: function() {
				localStorage.setItem('admin_company_id', this.company)
			},
			setcompany: function() {
				if(localStorage.getItem('admin_company_id')) {
					this.company = localStorage.getItem('admin_company_id');
					this.changecompany();
				}
			},		
			getcompany: function() {
				axios.get('/get-companies/').then((response) => {					
					this.companies = response.data;
				});
			},
			getsigns: function() {
				axios.get('/get-signs/').then((response) => {					
					this.signs = response.data;
				});
			},
			getindicator: function() {				 
				axios.get('/get-company-indicator/' + this.company).then((response) => {
					this.indicators = response.data;					
				});
			},
			getformuladata: function() {								
				axios.get('/get-formula/' + this.company).then((response) => {
					this.formuladata = response.data;					
				});
			},
			changecompany: function() {
				if(!this.company) {
					this.showData = false;
					return false;
				}
				this.getindicator();
				this.getsigns();
				this.getformuladata();
				this.getnames();
				this.getpercent();
				this.setadmincompany();
				this.setselectitems();
				this.showData = true;
			},
			copysign: function(name) {
				var storageData = {};				
				storageData.type = 'sign';
				storageData.data = name;
				localStorage.setItem('copydata', JSON.stringify(storageData));				
			},
			copyindicator: function(id) {
				var storageData = {};				
				storageData.type = 'indicator';
				storageData.data = id;
				localStorage.setItem('copydata', JSON.stringify(storageData));				
			},
			copyformula: function(formula) {				
				var storageData = {};				
				storageData.type = 'formula';
				storageData.company = this.company;
				storageData.formula = formula;
				localStorage.setItem('copydata', JSON.stringify(storageData));				
			},
			copyf: function(id) {
				var storageData = {};				
				storageData.type = 'f';				
				storageData.data = id;
				localStorage.setItem('copydata', JSON.stringify(storageData));
			},
			pasteformula: function(formula) {
				var copydata = localStorage.getItem('copydata');
				if(!copydata) {
					return false;
				}
				console.log(this.company);								
				axios.get('/get-paste-data/' + this.company + '/' + formula + '/' + copydata).then((response) => {					
					this.getformuladata();
				});
			},
			deleteitem: function(formula) {
				axios.get('/delete-item/' + this.company + '/' + formula).then((response) => {
					this.getformuladata();
				});
			},
			getnames: function() {
				axios.get('/get-names/' + this.company).then((response) => {
					this.names = response.data;
				});
			},
			inputname: function(formula, name) {				
				if(name == '') { 
					name = '*_*_*';					
				};
				axios.get('/set-name/' + this.company + '/' + formula + '/' + name).then((response) => {
					this.getnames();					
				});					
			},
			checkpercent: function() {
				var checked = JSON.stringify(this.checkedpercent);				
				axios.get('/set-percent/' + this.company + '/' + checked).then((response) => {
					// this.getpercent();
				});
			},
			getpercent: function() {
				axios.get('/get-percent/' + this.company).then((response) => {
					this.checkedpercent = response.data;
				});
			},
			selectforedit: function(index) {
				this.setselectitems(index);				
				var countitems = this.countformulas;
				this.countformulas = countitems + 1;
				this.countformulas = countitems;
			}	
			
		}
	}
</script>

<style>
	.selectforedit {
		background-color: #FFFDDC;
		padding-left: 10px;
		padding-right: 10px;
		padding-top: 10px;
		margin-left: -10px;
		margin-right: -10px;
		margin-top: -10px;
	}
</style>