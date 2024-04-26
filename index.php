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
					<div class="text-center"><?php echo $value['post_content'];?></div>
					<div class="container">
						<div class="row">
							<template v-if="currentStep==2">
								<?php foreach ($seasons as $key1 => $value1): ?>
									<div class="col-lg-6 col-md-6 col-sm-12 col-12 pt-3">
										<input
										type="radio" class="btn-check"
										name="options-outlined"
										id="seasoncheckbox-<?php echo $value1->name; ?>"
										autocomplete="off" required>
										<label
										class="btn btn-lg btn-outline-warning w-100 pb-4"
										for="seasoncheckbox-<?php echo $value1->name; ?>">
										<?php echo $value1->name; ?>
										<?php if ($value1->guid): ?>
											<div style="background-image: url(<?php echo $value1->guid; ?>)"
												class="main-seasons-item-image pt-5">
												<small>
													<i><?php echo $value1->description; ?></i>
												</small>
											</div>
										<?php else: ?>
											<div class="main-seasons-item-image pt-5">
												<small>
													<i><?php echo $value1->description; ?></i>
												</small>
											</div>
										<?php endif ?>
									</label></div>
								<?php endforeach ?>
							</template>

						</div>
					</div>

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


<pre><?php print_r($seasons) ?></pre>
<pre><?php print_r($steps) ?></pre>

<pre><?php print_r($directions) ?></pre>
<pre><?php print_r($arrivals) ?></pre>

<?php get_footer(); ?>