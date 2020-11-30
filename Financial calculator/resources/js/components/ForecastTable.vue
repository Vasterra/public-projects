<template>
	<div>
		<h5 class="h6" :class="{_red: elementshow}">Forecast Table</h5>
		<div v-if="elementshow" class="d-flex justify-content-end mb-2">
			<a class="_link" @click="levelzero">Set initial values</a>
		</div>
		<div class="table-responsive mb-5">
			<table class="table">
				<tbody>
					<tr v-for="tr in tabledata">
						<td v-for="td in tr" :class="{'bg-light': td.year}">
							<span v-if="td.show">
								<span v-if="td.year">
									<span class="d-block">{{ td.yearvalue }}</span>
									<small v-if="td.periodvalue" class="d-block">{{ td.periodvalue }}</small>
									<span>{{ td.currency }}</span>, <span>{{ td.units }}</span>
								</span>
								<span v-if="td.indicator">
									<span>{{ td.indicatorname }}</span>
								</span>
								<span v-if="td.formula">
									<span :class="{'font-weight-bold': td.styleboldvalue, 'font-italic': td.styleitalicvalue}">{{ td.formulaname }}</span>
								</span>
								<span v-if="td.input">
									<input type="number" step="0.1" :value="td.inputvalue" :readonly="td.readonly ? true : false" class="form-control" style="width: 100px;" @input="inputdata(td.indicatorvalue, td.yearvalue, td.periodicity, td.period, $event.target.value)">
								</span>
								<span v-if="td.formularesult">
									<span :class="{'font-weight-bold': td.styleboldvalue, 'font-italic': td.styleitalicvalue}">{{ td.formularesult }}</span>
								</span>
							</span>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div v-if="elementshow" class="mb-3 d-flex justify-content-end align-items-center">
			<span v-if="alertsaveforecastshow" class="d-inline-block mr-4 text-success">{{ textsuccess }}</span>
			<button class="btn btn-success" @click="saveforecast">Save</button>			
		</div>
	</div>
</template>

<script>    
	export default {
		props: [
			'companyid',
			'userid',
			'type',
			'forecastid'
		],
		data: function() {
			return {
				id: '',	
				company: '',	
				user: '',
				usertype: '',
				tabledata: [],
				textsuccess: 'Data saved successfully.',
				alertsaveforecastshow: false,											
				elementshow: true,											
			}
		},		
		mounted() {
			this.company = this.companyid
			this.user = this.userid
			this.id = this.forecastid
			this.usertype = this.type
			this.elementvisible()			
			this.gettable()
		},
		methods: {
			elementvisible: function() {
				if(this.usertype == 'admin') {
					this.elementshow = false;
				}
			},		
			gettable: function() {
				axios.get('/office-table-forecast/' + this.company + '/' + this.user).then((response) => {
					this.tabledata = response.data;
				});
			},
			inputdata: function(indicator, year, periodicity, period, value) {				
				var idata = {};
				idata.indicator = indicator;
				idata.year = year;
				idata.periodicity = periodicity;
				idata.period = period;
				idata.value = value;
				axios.get('/office-change-table-forecast/' + JSON.stringify(idata) + '/' + this.company).then((response) => {
					this.tabledata = response.data;					
				});				
			},
			levelzero: function() {
				axios.get('/office-zero-table-forecast/' + this.company).then((response) => {
					this.tabledata = response.data;					
				});
			},
			saveforecast: function() {
				axios.get('/office-update-table-forecast/' + this.company).then((response) => {					
					this.alertsaveforecastshow = true;
					setTimeout(() => {
						this.alertsaveforecastshow = false;
					}, 4000);
				});
			}

		}
	}
</script>
