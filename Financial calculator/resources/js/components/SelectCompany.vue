<template>
	<div class="wrapselectcompany wrapselectcompany_home">
		<div class="d-flex justify-content-between border pt-2 pb-1 pr-2 pl-3 fieldselectcompany" :class="{_openlistcompany: listcompanyshow}" @click="clickselectcompany">
			<span>{{ selectedcompany }}</span>
			<span class="btnselectcompany">&rsaquo;</span>
		</div>
		<div v-if="listcompanyshow" class="pt-2 pb-4 pr-3 pl-3 listcompany bg-white border border-top-0" :class="{_openlistcompany: listcompanyshow}">
			<div class="mb-3 w-50">
				<input type="text" :placeholder="searchplaceholder" class="form-control" v-model.trim="searchcompany" @input="changesearchcompany">
			</div>
			<div class="mb-2 list_company">
				<div v-if="!companies.length" class="font-italic">{{ nofoundsearch }}</div>
				<div v-if="companies.length" class="row">
					<div v-for="company in companies" class="col-4 mb-1">
						<a class="_link" @click="selectcompany(company)">{{ company.name }}</a>
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
				sharedstate: '',
				zerocompany: '- Select company -',
				searchplaceholder: 'Search... Three or more characters...',
				nofoundsearch: 'Nothing found.',
				selectedcompany: '',
				searchcompany: '',
				listcompanyshow: false,
				minsearchletter: 3,
				companies: []
			}
		},		
		mounted() {
			this.getcompany()
			this.selectedcompany = this.zerocompany			
		},
		methods: {			
			clickselectcompany: function() {
				if(this.listcompanyshow) {
					this.listcompanyshow = false;
				} else {
					this.listcompanyshow = true;
				}
			},
			selectcompany: function(company) {
				this.setcompanystore(company);
				this.selectedcompany = company.name;
				this.listcompanyshow = false;
				localStorage.setItem('company', JSON.stringify(company));
			},
			setcompanystore: function(company) {
				this.$store.dispatch('homeDataCompany', company);
			},
			changesearchcompany: function() {				
				if(this.searchcompany.length >= this.minsearchletter) {
					this.getcompanysearch();					
				} else {
					this.getcompany();
				}
			},
			getcompanysearch: function() {
				axios.get('/get-search-companies/' + this.searchcompany).then((response) => {
					this.companies = response.data;
				});
			},
			getcompany: function() {
				axios.get('/get-companies/').then((response) => {
					this.companies = response.data;
					if(localStorage.getItem('company')) {
						var com = JSON.parse(localStorage.getItem('company'));
						this.company = com.id;
						this.selectedcompany = com.name;
						this.setcompanystore(com);						
					}
				});
			},
		}
	}
</script>

<style>		
	.wrapselectcompany {
		position: relative;
		background-color: #fff;		
	}
	.listcompany {
		position: absolute;
		top: 96%;
		left: 0;
		right: 0;
		z-index: 999;		
	}
	.fieldselectcompany {		
		border-radius: 3px;
	}
	.fieldselectcompany:hover {		
		cursor: pointer;
	}
	.list_company {
		max-height: 380px;
		overflow-y: auto;
		overflow-x: hidden;
	}
	._openlistcompany {
		box-shadow: 0 15px 15px #ddd;
	}
	.btnselectcompany {
		transform: rotate(90deg);
		font-size: 32px;
		line-height: 1;		
	}
</style>