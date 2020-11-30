<template>
	<div class="mb-3">
		<div class="mb-4">
			<select class="form-control" v-model="company" @change="changecompany">
				<option value="">- Select company -</option>
				<option v-for="company in companies" :value="company.id">{{ company.name }}</option>
			</select>
		</div>
		<div v-if="showbox">
			<div class="row">
				<div class="col-8">
					<div class="border p-3" style="min-height: 400px;">
						<div v-for="(item, index) in items" class="d-flex justify-content-between pt-1 pb-1 pl-1 _item text-">
							<div :class="{'font-weight-bold': item.styleboldvalue, 'font-italic': item.styleitalicvalue, 'text-gray': !item.style}">{{ item.name }}</div>
							<div>
								<span v-if="item.style" class="d-inline-block mr-4">
									<span v-if="item.stylebold" class="d-inline-block mr-2">
										<input type="checkbox" :id="'checkboxbold-' + index" v-model="checkedbold" :value="item" @change="changebold">
										<label :for="'checkboxbold-' + index">bold</label>
									</span>
									<span v-if="item.styleitalic" class="d-inline-block">
										<input type="checkbox" :id="'checkboxitalic-' + index" v-model="checkeditalic" :value="item" @change="changeitalic">
										<label :for="'checkboxitalic-' + index">italic</label>
									</span>
								</span>
								<span><button class="btn btn-sm" @click="deleteitem(index)">Delete</button></span>
							</div>
							
						</div>
					</div>
				</div>
				<div class="col-4">
					<div class="border p-3" style="min-height: 400px;">
						<div class="mb-2" v-for="eitem in empty">
							<button class="btn btn-sm btn-outline-secondary" @click="additem(eitem)">{{ eitem.name }}</button>
						</div>
						<hr class="w-25 mb-2">
						<div class="mb-2">
							<div v-for="formula in formulas" class="mb-1">
								<button class="btn btn-sm btn-outline-secondary" @click="additem(formula)">{{ 'Formula ' + formula.value + ' - ' + formula.name }}</button>
							</div>
						</div>
						<hr class="w-25 mb-2">
						<div class="mb-2">
							<div v-for="indicator in indicators" class="mb-1">
								<button class="btn btn-sm btn-outline-secondary" @click="additem(indicator)">{{ indicator.name }}</button>
							</div>							
						</div>
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
				companies: [],
				formulas: [],
				indicators: [],
				items: [],
				showbox: false,
				checkedbold: [],
				checkeditalic: [],
				empty: [
					{
						type: 'empty',
						name: 'Empty',
						value: '-',
						style: 0						
					}
				],
			}
		},		
		mounted() {
			this.getcompany()
			this.setcompany()			
		},
		methods: {
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
			changecompany: function() {
				if(!this.company) {
					this.showbox = false;
					return false;
				}
				axios.get('/get-order-data/' + this.company).then((response) => {
					this.formulas = response.data.formula;					
					this.indicators = response.data.indicator;
					this.items = response.data.order;
					this.getstartstyle();
					this.setadmincompany();
					this.showbox = true;
				});
			},
			getstartstyle: function() {
				for(var key in this.items) {
					if(this.items[key].styleboldvalue) {
						this.checkedbold.push(this.items[key]);
					}
					if(this.items[key].styleitalicvalue) {
						this.checkeditalic.push(this.items[key]);
					}
				}
			},
			additem: function(item) {
				this.items.push(item);
				this.save();				
			},
			deleteitem: function(index) {
				this.items.splice(index, 1);
				this.save();
			},
			save: function() {				
				axios.get('/order-save/' + this.company + '/' + JSON.stringify(this.items)).then((response) => {});
			},
			changebold: function() {				
				for(var key in this.items) {
					if(this.items[key].style) {
						if(this.checkedbold.indexOf(this.items[key]) !== -1) {
							this.items[key].styleboldvalue = 1;
						} else {
							this.items[key].styleboldvalue = 0;
						}
					}					
				}
				this.save();
			},
			changeitalic: function() {				
				for(var key in this.items) {
					if(this.items[key].style) {
						if(this.checkeditalic.indexOf(this.items[key]) !== -1) {
							this.items[key].styleitalicvalue = 1;
						} else {
							this.items[key].styleitalicvalue = 0;
						}
					}					
				}
				this.save();
			}
		}
	}
</script>

<style>
	._item:hover {
		background: #f1f1f1;
	}
	.text-gray {
		color: #848484;
	}
</style>