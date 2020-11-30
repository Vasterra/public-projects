<template>
	<div class="mb-5">

		<input type="hidden" :value="companyData">
						
		<div v-if="datashow">
			<div v-if="userforecasts.length" class="mb-4">
				<div class="d-flex align-items-center">
					<h5 class="h5 _red">Shared Forecasts</h5>
					<span v-if="userforecasts.length > mincountforecasts" class="d-flex justify-content-center align-items-center wrap_buttonshow" @click="btnforecastsshow"><span class="d-block buttonshow" :class="{_rotatereverse: openforecasts}">&raquo;</span></span>
				</div>
				<div :style="{maxHeight: maxheightforecasts + paddingforecasts*2 + 'px', paddingTop: paddingforecasts + 'px', paddingBottom: paddingforecasts + 'px'}" class="box_forecasts bg-white border pl-3">
					<table>
						<tbody>
							<tr v-for="forecast in userforecasts" :class="{'font-weight-bold': forecast.stylebold}" :style="{height: heightforecast + 'px'}">
								<td><a class="_link" @click="getforecast(forecast.user_id)">{{ forecast.forecast_overview }}</a></td>
								<td><span class="d-inline-block pl-3 pr-3">{{ forecast.user_name }}</span></td>
								<td><small class="font-italic" :class="{'font-weight-bold': forecast.stylebold}">{{ forecast.forecast_date }}</small></td>
							</tr>							
						</tbody>
					</table>				
				</div>
			</div>
			<div class="mb-3">
				<h5 class="h5 _red">Forecast Overview</h5>
				<div>
					<textarea rows="5" class="form-control" :readonly="readonlyoverview ? true : false" :ref="'overview'" v-model.trim="textoverview" @input="changeoverview"></textarea>
				</div>
				<div class="d-flex justify-content-end"><small :class="{_red: !countoverview}">{{ countoverview }}</small></div>
			</div>
			<div v-if="!isadmin" class="mb-3">
				<button v-if="createforecastshow" class="btn btn-outline-danger" @click="createforecast">Create a new Forecast</button>
				<span v-if="alertcreateshow" class="d-inline-block ml-3">Only authorized users can create a forecast. <a href="/login" class="_link">Login</a> or <a href="/register" class="_link">Register</a>.</span>
				<div v-if="stepsshow">
					Steps to create a Forecast:<br>
					1. Write your review of the Forecast<br>
					2. Enter your values into the Forecast table<br>
					3. Click the Share Your Forecast button
				</div>
			</div>
		
			<a name="tableforecast"></a>
			<div v-if="levelzeroshow" class="d-flex justify-content-end mb-2">
				<a class="_link" @click="levelzero">Set initial values</a>
			</div>
			<div class="table-responsive mb-3">				
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
			<div v-if="saveforecastshow" class="mb-4 pt-3">
				<button class="btn btn-outline-danger" @click="saveforecast">Share Your Forecast</button>
				<button class="btn btn-outline-secondary" @click="cancelforecast">Cancel</button>
			</div>
			<div v-if="alertsaveforecastshow" class="mb-4">
				<span>Your Forecast has been successfully added! You can edit your Forecast in your <a href="/office" class="_link">personal office</a>.</span>
			</div>

			<div class="comments pt-3" :ref="'commentstart'">
				<div class="mb-3">
					<h5 class="h5 d-inline-block _red">Comments on {{ companyname }}</h5>
					<span class="d-inline-block mr-2 ml-2 pr-2 pl-2 border-right border-left">{{ comments.length }} comments</span>
					<a v-if="userid" class="_link d-inline-block" @click="btnaddcomment">Add a comment</a>
				</div>
				
				<div v-if="comments.length" :style="{maxHeight: maxheightcomments + 'px'}" style="overflow: auto;" class="bg-white border pt-3 pl-3 pb-3 pr-1 mb-4" :ref="'boxcomments'">
					<div v-for="(comment, index) in comments" class="mb-3 pb-3 border-bottom" :style="{marginLeft: offsetreply * comment.level + 'px'}">
						<div><span class="font-weight-bold">{{ comment.user_name }}</span><small class="d-inline-block ml-2 pl-2 border-left font-italic">{{ comment.date }}</small></div>
						
						<div v-if="!comment.save_forecast" class="pt-3 pb-3">{{ comment.comment }}</div>
						<div v-if="comment.save_forecast" class="pt-3 pb-3">Check out my new forecast <a href="#tableforecast" class="_link" @click="getforecast(comment.save_forecast_user)">here</a>.</div>
						<div v-if="comment.reply">
							<div>
								<textarea class="form-control" rows="5" placeholder="Your Reply..." v-model.trim="userreply" @input="changereply"></textarea>
							</div>
							<div class="d-flex justify-content-end"><small :class="{_red: !countreply}">{{ countreply }}</small></div>
						</div>
						<div v-if="comment.level < maxlevelreply">
							<a class="_link" @click="postreply(comment.user_id, comment.id, index)">Post a Reply</a>
							<span v-if="comment.alertreplyshow" class="d-inline-block ml-3">Only authorized users can leave comments. <a href="/login" class="_link">Login</a> or <a href="/register" class="_link">Register</a>.</span>
						</div>
					</div>
				</div>
				<div v-if="userid" class="mb-1">
					<div>
						<textarea class="form-control" rows="5" placeholder="Your Comment..." v-model.trim="usercomment" :ref="'fieldcomment'" @input="changecomment"></textarea>
					</div>				
					<div class="d-flex justify-content-end"><small :class="{_red: !countcomment}">{{ countcomment }}</small></div>
				</div>
				<div class="mb-3">
					<button class="btn btn-outline-danger" @click="postcomment(0)">Post a Comment</button>
					<span v-if="alertcommentshow" class="d-inline-block ml-3">Only authorized users can leave comments. <a href="/login" class="_link">Login</a> or <a href="/register" class="_link">Register</a>.</span>
				</div>
				
			</div>

		</div>
	</div>
</template>

<script>    
	export default {
		props: [
			'maxoverview',
			'maxcomment'
		],
		data: function() {
			return {				
				company: '',								
				tabledata: [],
				datashow: false,
				alertcreateshow: false,
				createforecastshow: true,
				stepsshow: false,
				saveforecastshow: false,
				alertsaveforecastshow: false,
				levelzeroshow: true,
				textoverview: '',
				textoverviewdefault: 'Type an overview explaining your forecast here.',
				readonlyoverview: true,
				countoverview: '',
				maxcountoverview: 2500,				
				countcomment: '',
				maxcountcomment: 1000,
				countreply: '',
				maxcountreply: 1000,
				userforecasts: [],
				username: '',
				userid: '',
				userrole: '',
				isadmin: false,
				maxheightforecasts: 0,
				paddingforecasts: 8,
				heightforecast: 28,
				mincountforecasts: 3,
				maxcountforecasts: 10,
				openforecasts: false,
				companyname: '',
				alertcommentshow: false,
				usercomment: '',
				comments: [],
				commentreply: [],
				userreply: '',
				offsetreply: 30,
				maxlevelreply: 5,
				maxheightcomments: 600
			}
		},		
		mounted() {
			this.maxcountoverview = this.maxoverview
			this.maxcountcomment = this.maxcomment
			this.maxcountreply = this.maxcomment
			this.maxheightforecasts = this.heightforecast * this.mincountforecasts
			this.currentuser()
		},
		computed: {
			companyData() {
				var dataCompany = this.$store.getters.getCompany;
			    this.changecompanydata(dataCompany);
			    this.companyname = dataCompany.name;				
				return dataCompany;				
			}
		},
		methods: {			
			changecompanydata: function(companyData) {
				this.company = companyData.id;
				if(this.company > 0) {
					if(localStorage.getItem('company')) {						
						this.changecompany(0);
					} else {
						this.changecompany(1);
					}					
				}
			},
			currentuser: function() {
				axios.get('/home-current-user/').then((response) => {					
					this.username = response.data.name;
					this.userid = response.data.id;
					this.userrole = response.data.role;
					if(this.userrole == 'admin') {
						this.isadmin = true;
					}					
				});
			},
			zero: function() {
				this.textoverview = this.textoverviewdefault;
				this.alertsaveforecastshow = false;
				this.saveforecastshow = false;								
				this.textoverview = this.textoverviewdefault;
				this.readonlyoverview = true;
				this.countoverview = '';
				this.stepsshow = false;
				this.createforecastshow = true;				
			},
			zeroforecasts: function() {
				for(var key in this.userforecasts) {
					this.userforecasts[key]['stylebold'] = 0;
				}
			},			
			changecompany: function(change) {							
				if(change == 1) {
					this.levelzero();
				} else {
					this.gettable();
				}
				this.getforecasts();
				this.zero();				
				this.alertsaveforecastshow = false;
				this.levelzeroshow = true;				
				this.startcomments();
			},
			gettable: function() {				
				axios.get('/home-get-table/' + this.company).then((response) => {
					this.tabledata = response.data;
					this.datashow = true;
				});
			},
			inputdata: function(indicator, year, periodicity, period, value) {				
				var idata = {};
				idata.indicator = indicator;
				idata.year = year;
				idata.periodicity = periodicity;
				idata.period = period;
				idata.value = value;
				axios.get('/home-change-table/' + JSON.stringify(idata) + '/' + this.company).then((response) => {
					this.tabledata = response.data;
					this.datashow = true;
				});				
			},
			levelzero: function() {
				axios.get('/home-zero-table/' + this.company).then((response) => {
					this.tabledata = response.data;
					this.datashow = true;
				});
			},			
			createforecast: function() {								
				if(!this.userid) {
					this.alertcreateshow = true;						
				} else {
					this.readonlyoverview = false;
					this.textoverview = '';
					this.$refs['overview'].focus();
					this.countoverview = this.maxcountoverview;					
					this.createforecastshow = false;
					this.stepsshow = true;				
					this.saveforecastshow = true;				
					this.alertsaveforecastshow = false;
					this.zeroforecasts();
					this.gettable();
					this.levelzeroshow = true;
				}
				
			},
			checkcountletters: function(maxcount, currenttext) {
				var result = {};
				var counttext = maxcount - currenttext.length;
				if(currenttext.length > maxcount) {
					currenttext = localStorage.getItem('textarea');
					counttext = 0;
				} else {					
					localStorage.setItem('textarea', currenttext);
				}
				result.counttext = counttext; 
				result.text = currenttext; 
				return result;
			},
			changeoverview: function() {
				var result = this.checkcountletters(this.maxcountoverview, this.textoverview);
				this.countoverview = result.counttext;
				this.textoverview = result.text;
			},
			changecomment: function() {
				var result = this.checkcountletters(this.maxcountcomment, this.usercomment);
				this.countcomment = result.counttext;
				this.usercomment = result.text;
			},
			changereply: function() {
				var result = this.checkcountletters(this.maxcountreply, this.userreply);
				this.countreply = result.counttext;
				this.userreply = result.text;
			},
			saveforecast: function() {
				if(this.textoverview == '') {
					alert('Write your review of the Forecast');
					this.$refs['overview'].focus();
					return false;
				}
				var text = this.textoverview.replace(/(\r\n|\r|\n)/g, '<br>');
				axios.get('/home-save-forecast/' + text + '/' + this.company).then((response) => {
					this.getforecasts();
					this.levelzero();
					this.zero();
					this.alertsaveforecastshow = true;
					this.getcomments();
				});
			},
			cancelforecast: function() {
				this.changecompany(1);
			},
			getforecasts: function() {
				if(!this.company) {					
					return false;
				}
				axios.get('/home-forecasts/' + this.company).then((response) => {
					this.userforecasts = response.data;
				});
			},
			getforecast: function(user) {
				this.zero();
				this.textoverview = '';				
				axios.get('/home-forecast/' + user + '/' + this.company).then((response) => {
					this.tabledata = response.data.table;
					this.textoverview = response.data.overview.replace(/(<br>)/g, '\n');
					for(var key in this.userforecasts) {
						if(this.userforecasts[key]['user_id'] == user) {
							this.userforecasts[key]['stylebold'] = 1;
						} else {
							this.userforecasts[key]['stylebold'] = 0;
						}
					}
					this.levelzeroshow = false;														
				});
			},
			btnforecastsshow: function() {
				if(!this.openforecasts) {
					this.maxheightforecasts = this.heightforecast * this.maxcountforecasts;
					this.openforecasts = true;
				} else {
					this.maxheightforecasts = this.heightforecast * this.mincountforecasts;
					this.openforecasts = false;
				}				
			},
			btnaddcomment: function() {
				this.$refs['fieldcomment'].focus();
				this.$refs['fieldcomment'].scrollIntoView();
			},
			startcomments: function() {				
				this.getcomments();
			},
			getcomments: function() {
				axios.get('/home-comments/' + this.company).then((response) => {					
					this.comments = response.data;
					this.countcomment = this.maxcountcomment;					
				});
			},
			postcomment: function(parent, textsave = '', reply = 0) {				
				if(!this.userid) {
					this.alertcommentshow = true;
				} else {
					if(this.usercomment != '' || textsave != '') {
						var text;
						if(this.usercomment != '') {
							text = this.usercomment.replace(/(\r\n|\r|\n)/g, ' ');
						} else {
							text = textsave.replace(/(\r\n|\r|\n)/g, ' ');
						}
						axios.get('/home-add-comment/' + text + '/' + parent + '/' + this.company).then((response) => {
							this.getcomments();
							if(reply) {
								this.userreply = '';								
							} else {
								this.usercomment = '';								
								if(this.comments.length) {
									this.$refs['commentstart'].scrollIntoView();							
									this.$refs['boxcomments'].scrollTop = 0;
								}																
							}							
						});
					}
				}
			},
			postreply: function(user, comment, index) {				
				if(!this.userid || this.userid == '') {
					for(var key in this.comments) {
						if(this.comments[key]['id'] == comment) {
							this.comments[key]['alertreplyshow'] = 1;
						} else {
							this.comments[key]['alertreplyshow'] = 0;
						}					
					}					
				} else {
					if(this.userreply == '') {
						for(var key in this.comments) {
							if(this.comments[key]['id'] == comment) {
								this.comments[key]['reply'] = 1;
							} else {
								this.comments[key]['reply'] = 0;
							}					
						}
						this.countreply = this.maxcountreply;
						this.userreply = '';
						localStorage.setItem('replyindex', index);
					} else {						
						if(index == localStorage.getItem('replyindex')) {
							this.postcomment(comment, this.userreply, 1);
						} else {
							this.userreply = '';
							this.postreply(user, comment, index);
						}
					}
				}				
			}			
		}
	}
</script>

<style>	
	.box_forecasts {
		overflow: auto;
		transition: 0.5s;
	}
	.wrap_buttonshow {
		height: 32px;
		width: 42px;
		cursor: pointer;
	}
	.buttonshow {		
		font-size: 32px;
		font-weight: 400;
		line-height: 1;		
		transform: rotate(90deg);
		height: 42px;
		transition: 0.5s;
	}
	.buttonshow._rotatereverse {
		transform: rotate(-90deg);
	}
	.wrapselectcompany {
		position: relative;		
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
		box-shadow: 0 15px 15px #ccc;
	}
	.btnselectcompany {
		transform: rotate(90deg);
		font-size: 32px;
		line-height: 1;		
	}
</style>
