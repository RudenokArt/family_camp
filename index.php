<?php 
get_header(); 
$seasons = ACF_class::getSeasonsList();
$arrivals = ACF_class::getArrivalsList();
$directions = ACF_class::getDirectionsList();
$steps = ACF_class::getFormSteps();

?>
<div id="step_by_step_form">
	<form class="card mt-5" v-on:submit.prevent="currentStepNext">
		<div class="card-header">
			<?php foreach ($steps as $key => $value): ?>
				<template v-if="'step_'+currentStep=='<?php echo $value['post_name'] ?>'">
					<div class="h2 text-secondary text-center">
						<?php echo $value['post_title'] ?>
					</div>
				</template>
			<?php endforeach ?>
		</div>
		<div class="card-body">

			<?php foreach ($steps as $key => $value): ?>
				<template v-if="'step_'+currentStep=='<?php echo $value['post_name'] ?>'">
					<div class="text-center"><?php echo $value['post_content'];?></div>
				</template>
			<?php endforeach ?>

			<div class="container">
				<div class="row justify-content-center">
					<template v-if="currentStep==2">
						<?php foreach ($seasons as $key1 => $value): ?>
							<div class="col-lg-5 col-md-6 col-sm-12 col-12 pt-3">
								<input
								value="<?php echo $value->term_id ?>"
								v-model="season"
								type="radio" class="btn-check"
								name="season"
								id="seasonradio-<?php echo $value->term_id; ?>"
								autocomplete="off" required>
								<label
								for="seasonradio-<?php echo $value->term_id; ?>"
								class="btn btn-lg btn-outline-warning w-100 pb-4">
								<?php if ($value->guid): ?>
									<?php echo $value->name; ?>
									<div
									style="background-image: url(<?php echo $value->guid; ?>)"
									class="main-seasons-item-image pt-5">
									<small>
										<i><?php echo $value->description; ?></i>
									</small>
								</div>
							<?php else: ?>
								<div class="main-seasons-item-image pt-5">
									<?php echo $value->name; ?>
									<small>
										<i><?php echo $value->description; ?></i>
									</small>
								</div>
								<?php endif ?></label>
							</div>
						<?php endforeach ?>		
					</template>

					<template v-if="currentStep==3">
						<div class="row justify-content-center">
							<div class="col-lg-6 col-md-9 col-sm-12 col-12">
								<?php foreach ($directions as $key => $value): ?>
									<div class="p-1">
										<input 
										value="<?php echo $value['term_id']; ?>"
										v-model="direction"
										type="radio"
										class="btn-check"
										name="direction"
										id="directionradio-<?php echo $value['term_id']; ?>"
										autocomplete="off" required>
										<label
										for="directionradio-<?php echo $value['term_id']; ?>"
										class="btn btn-lg btn-outline-warning w-100">
										<div class="row">
											<div class="col-lg-3 col-md-3 col-sm-12 col-12">
												<?php if ($value['image']): ?>
													<img src="<?php echo $value['image'] ?>" class="w-100" alt="">
												<?php else: ?>
													<div class="p-5"></div>
												<?php endif ?>
											</div>
											<div class="col-lg-9 col-md-9 col-sm-12 col-12">
												<?php echo $value['name']; ?>
												<br>
												<small><i><?php echo $value['description']; ?></i></small>
											</div>
										</div></label>
									</div>
								<?php endforeach ?>
							</div>							
						</div>						
					</template>

					<template v-if="currentStep==4">
						<div class="row justify-content-center">
							<div class="col-lg-6 col-md-9 col-sm-12 col-12">
								<?php foreach ($arrivals as $key => $value): ?>
									<div class="p-1">
										<input 
										value="<?php echo $value['ID']; ?>"
										v-model="arrival"
										type="radio"
										class="btn-check"
										name="arrival"
										id="directionradio-<?php echo $value['ID']; ?>"
										autocomplete="off" required>
										<label
										for="directionradio-<?php echo $value['ID']; ?>"
										class="btn btn-lg btn-outline-warning w-100">
										<div><?php echo $value['post_title']; ?></div>
										<small><i><?php echo $value['post_content']; ?></i></small>
									</label>
								</div>
							<?php endforeach ?>
						</div>							
					</div>						
				</template>

				<template v-if="currentStep==5">

					<div class="p-1">
						ФИО:
						<input type="text" name="customer[fio]" class="form-control" required>
					</div>
					<div class="p-1">
						<div class="row">
							<div class="pt-1 col-lg-6 col-md-6 col-sm-12 col-12">
								Дата рождения:
								<input type="date" name="customer[date]" class="form-control" required>
							</div>
							<div class="pt-1 col-lg-6 col-md-6 col-sm-12 col-12">
								Email:
								<input type="email" name="customer[mail]" class="form-control" required>
							</div>
							<div class="pt-1 col-lg-6 col-md-6 col-sm-12 col-12">
								Телефон:
								<input type="text" name="customer[phone]" class="form-control" required>
							</div>
							<div class="pt-1 col-lg-6 col-md-6 col-sm-12 col-12">
								Серия и номер паспорта:
								<input type="text" name="customer[passport]" class="form-control" required>
							</div>
							<div class="pt-1 col-lg-6 col-md-6 col-sm-12 col-12">
								Стоимость программы: 
								<br>
								<i>(Сумму укажите из Расчета, который вам прислали ранее)</i>
								<input type="number" name="customer[price]" class="form-control" required>
							</div>
						</div>
					</div>
					<div class="p-1">
						Адрес:
						<input type="text" name="customer[address]" class="form-control" required>
					</div>
					
				</template>

			</div>
		</div>
	</div>

	<div class="card-footer">
		<div class="d-flex justify-content-around">
			<div class="p-1">
				<button v-on:click="currentStepBack" type="button" 
				v-if="currentStep>1" class="btn btn-warning btn-lg text-white">
				<i class="fa fa-chevron-left" aria-hidden="true"></i>
				Назад
			</button>
			<div></div>
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
step: {{currentStep}}; season: {{season}}; direction: {{direction}} arrival: {{arrival}}
</div>

<script>
	var StepByStepForm = Vue.createApp({
		data () {
			return {
				currentStep: 1,
				season: false,
				direction: false,
				arrival: false,
			};
		},
		methods: {
			currentStepBack: function () {
				console.log(this.currentStep);
				this.currentStep = Number(this.currentStep) - 1;
				console.log(this.currentStep);
			},
			currentStepNext: function () {
				this.currentStep = Number(this.currentStep) + 1;
			}
		},
	});
	StepByStepForm.mount('#step_by_step_form');
</script>


<pre><?php print_r($arrivals) ?></pre>
<pre><?php print_r($directions) ?></pre>
<pre><?php print_r($seasons) ?></pre>
<pre><?php print_r($steps) ?></pre>

<?php get_footer(); ?>