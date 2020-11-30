<template>
    <div v-if="!check" class="d-inline-block pl-2 pr-2 pt-1 pb-1 bg-light">
        <small class="d-inline-block text-success">New!</small>
        <small class="d-inline-block ml-3 text-success"><a class="_link" @click="accept">Accept forecast</a></small>
    </div>
</template>

<script>
	export default {
		props: [
			'checked',
			'forecastid'
		],				
		data: function() {
			return {
				check: 1,
			}
		},		
		mounted() {
			this.check = this.checked * 1;
		},
		methods: {			
			accept: function() {
				axios.get('/accept-forecast/' + this.forecastid).then((response) => {
					this.check = 1;
				});
			},
		}
	}
</script>
