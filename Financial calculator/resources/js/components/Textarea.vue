<template>
	<div>		
		<div>
			<textarea rows="5" class="form-control" :ref="'textarea'" v-model.trim="text" @input="changetext" :name="fieldname"></textarea>
		</div>
		<div class="d-flex justify-content-end"><small :class="{_red: !countertext}">{{ countertext }}</small></div>
	</div>
</template>

<script>
	export default {
		props: [
			'name',
			'datatext',
			'maxcount'
		],				
		data: function() {
			return {
				text: '',
				fieldname: '',
				currenttext: '',
				countertext: '',
				maxcounttext: ''
			}
		},		
		mounted() {
			this.fieldname = this.name
			this.maxcounttext = this.maxcount
			this.text = this.datatext
			this.currenttext = this.datatext
			this.changetext()					
		},
		methods: {			
			changetext: function() {
				var counter;
				if(this.text.length <= this.maxcounttext) {
					this.currenttext = this.text;
					counter = this.maxcounttext - this.text.length;
				} else {
					counter = 0;
				}
				this.countertext = counter;
				this.text = this.currenttext;
			},
		}
	}
</script>
