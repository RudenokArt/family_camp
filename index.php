<?php 
get_header(); 
$seasons = ACF_class::getSeasonsList();
$arrivals = ACF_class::getArrivalsList();
$directions = ACF_class::getDirectionsList();
$steps = ACF_class::getFormSteps();

?>
<div id="step_by_step_form">
	<form class="card" v-on:submit.prevent="currentStepInc">
		<?php foreach ($steps as $key => $value): ?>
			<template v-if="'step_'+currentStep=='<?php echo $value['post_name'] ?>'">
				<div class="card-header">
					<div class="h2 text-secondary text-center">
						<?php echo $value['post_title'] ?>
					</div>
				</div>
				<div class="card-body">
					<input type="text" required>
					<div class="text-center"><?php echo $value['post_content'] ?></div>
				</div>
			</template>
		<?php endforeach ?>		
		<div class="card-footer">
			<div class="d-flex justify-content-around">
				<div class="p-1">
					<button v-on:click="currentStep--" v-if="currentStep>1" class="btn btn-warning btn-lg text-white">
						<i class="fa fa-chevron-left" aria-hidden="true"></i>
						Назад
					</button>
					<button type="button" v-else="currentStep<1" class="btn btn-secondary btn-lg text-white" disabled>
						<i class="fa fa-chevron-left" aria-hidden="true"></i>
						Назад
					</button>
				</div>
				<div class="p-1">
					<button class="btn btn-warning btn-lg text-white">
						Далее
						<i class="fa fa-chevron-right" aria-hidden="true"></i>
					</button>
				</div>
			</div>
		</div>
	</form>
	{{currentStep}}
</div>

<script>
	var StepByStepForm = Vue.createApp({
		data () {
			return {
				currentStep: 1, 
			};
		},
		methods: {
			currentStepInc: function () {
				this.currentStep++;
			}
		},
	});
	StepByStepForm.mount('#step_by_step_form');
</script>

<pre><?php print_r($steps) ?></pre>
<pre><?php print_r($seasons) ?></pre>
<pre><?php print_r($directions) ?></pre>
<pre><?php print_r($arrivals) ?></pre>

<?php get_footer(); ?>