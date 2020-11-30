<template>
	<div class="mb-4" v-if="startshow">
		<h3 class="h3 mb-3">{{ companystart.titles.indicators }}</h3>				
		<div class="mb-4">
			<div v-for="indicator in companystart.indicators" class="form-check mb-2">
			  <input name="indicators[]" type="checkbox" :id="'indicator-'+indicator.id" class="form-check-input"  :value="indicator.id" v-model="checkindicators" @change="savehide">
			  <label class="form-check-label" :for="'indicator-'+indicator.id">{{ indicator.name }}</label>
			</div>
		</div>		

		<div class="row mb-4">
			<div class="col-4">
				<label for="periodicity">{{ companystart.titles.periodicity }}</label>
				<select name="periodicity" @change="period" id="periodicity" class="form-control" v-model="periodicity">
				<option v-for="option_periodicity in companystart.periodicity" :value="option_periodicity.number" >{{ option_periodicity.name }}</option>
				</select>
			</div>
			<div class="col-4">
				<div class="form-group">
					<label class="d-block">{{ companystart.titles.start }}</label>
					<select name="yearstart" id="years_start" class="form-control" v-model="yearstart" @change="savehide">
						<option v-for="year_start in companystart.yearsstart" :value="year_start" >{{ year_start }}</option>
					</select>
				</div>
				<div class="form-group" v-if="period_items">
					<select name="periodstart" id="period_start" class="form-control" v-model="periodstart" @change="savehide">
						<option v-for="(period, index) in period_items" :value="index">{{ period }}</option>
					</select>
				</div>
			</div>
			<div class="col-4">
				<div class="form-group">
					<label class="d-block">{{ companystart.titles.end }}</label>
					<select name="yearend" id="years_end" class="form-control" v-model="yearend" @change="savehide">
						<option v-for="year_end in companystart.yearsend" :value="year_end">{{ year_end }}</option>
					</select>
				</div>
				<div class="form-group" v-if="period_items">
					<select name="periodend" id="period_end" class="form-control" v-model="periodend" @change="savehide">
						<option v-for="(period, index) in period_items" :value="index">{{ period }}</option>
					</select>
				</div>
			</div>
		</div>

		<div class="d-flex justify-content-end">
			<span @click="clickgettable" class="btn btn-secondary">{{ companystart.titles.btntable }}</span>
		</div>
		
		<div class="pt-4" v-if="tableshow">
			<table class="table">
				<tbody>
					<tr v-for="tr in table">
						<td v-for="td in tr">
							<span v-if="td.year" class="d-block text-center">
								<span>{{ td.year_value }}</span>
								<span v-if="td.period"><br><small>{{ td.period_value }}</small></span>
							</span>
							<span v-if="td.indicator">{{ td.indicator_name }}</span>
							<span v-if="td.input">
								<input type="number" step="0.01" :value="td.input_value" class="form-control form-control-sm" :name="'tabledata[' + td.indicator_id + '][' + td.year_value + '][' + td.periodicity_id + '][' + td.period_id + ']'">
							</span>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="pt-2 pb-2" v-if="saveshow">
		    <button type="submit" class="btn btn-success">Save data</button>
		</div>

	</div>
</template>

<script>
	export default {
		props: [
			'companyid'
		],		
		data: function() {
			return {
				startshow: false,
				tableshow: false,
				saveshow: false,
				companystart: [],
				checkindicators: [],
				periodicity: 12,
				yearstart: 0,
				yearend: 0,
				periodstart: 0,
				periodend: 0,
				period_items: 0,
				table: [],				
			}
		},
		mounted() {
			this.start()
			this.setadmincompany()			
		},
		methods: {
			setadmincompany: function() {
				localStorage.setItem('admin_company_id', this.companyid)
			},		
			savehide: function() {
				this.saveshow = false;
			},			
			start: function() {
				axios.get('/get-addcompany-start/').then((response) => {					
					this.companystart = response.data;
					this.yearstart = response.data.yearstart;
					this.yearend = response.data.yearend;
					this.startshow = true;
					axios.get('/get-start-data/').then((response) => {						
						var startdata = response.data;
						if(startdata != '') {							
							if(typeof(startdata.checkindicators) == 'string') {
								this.checkindicators = JSON.parse(startdata.checkindicators);
							} else {
								this.checkindicators = startdata.checkindicators;
							}	
							this.periodicity = startdata.periodicity ? startdata.periodicity : this.periodicity;
							this.yearstart = startdata.yearstart ? startdata.yearstart : this.yearstart;
							this.yearend = startdata.yearend ? startdata.yearend : this.yearend;
							this.period();
							this.periodstart = startdata.periodstart ? startdata.periodstart : this.periodstart;
							this.periodend = startdata.periodend ? startdata.periodend : this.periodend;
							this.gettable();
						}
					});
					
				});
			},
			period: function() {
				this.periodstart = 0;
				this.periodend = 0;
				this.savehide();								
				axios.get('/get-period/' + this.periodicity).then((response) => {						
					this.period_items = response.data;
				});
			},
			clickgettable: function() {
				if(!this.checkindicators.length) {
					alert('!! Select forecast data !!');
					return false;
				} else {
					this.gettable();
				}				
			},
			gettable: function() {
				if(!this.checkindicators.length) {
					return false;
				}				
				var _data = {};				
				_data.checkindicators = this.checkindicators;
				_data.periodicity = this.periodicity;
				_data.yearstart = this.yearstart;
				_data.yearend = this.yearend;
				_data.periodstart = this.periodstart;
				_data.periodend = this.periodend;							

				axios.get('/get-addcompany-table/' + JSON.stringify(_data)).then((response) => {					
					this.tableshow = true;
					this.saveshow = true;
					this.table = response.data;										
				});
			}
		}
	}
</script>