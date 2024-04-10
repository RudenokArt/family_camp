<?php
get_header();
$seasons = ACF_class::getList('season');
$arrivals = ACF_class::getListWithMeta('arrival', 'arrival_season')
?>

<div id="family_camp-contract_quiz">

	<div class="pt-5 pb-5">
		<div class="card">

			<template v-if="currentStep==1">
				<div class="card-header">
					<h2 class="text-secondary">Регистрация и подписание договора</h2>
				</div>
				<div class="card-body">
					<div class="alert alert-warning text-center">
						<div class="h4 text-secondary">
							Заполнение займет 5 мин. Подготовьте свой паспорт.
						</div>
					</div>				
				</div>
			</template>
			
			<template v-if="currentStep==2">
				<div class="card-header">
					<h2 class="text-secondary">Выбор сезона:</h2>
				</div>
				<div class="card-body">
					<div class="row">
						<?php foreach ($seasons as $key => $value): ?>
							<div class="col-lg-4 col-md-6 col-sm-6 col-12 p-1">
								<input
								name="season"
								value="<?php echo $value['ID']; ?>"
								v-model="season"
								type="radio"
								class="btn-check"
								id="season_<?php echo $key;?>"
								autocomplete="off">
								<label
								for="season_<?php echo $key;?>"
								class="btn btn-outline-warning btn-lg w-100 h-100"
								>
								<?php if (isset($value['image'])): ?>
									<img width="200" src="<?php echo $value['image'] ?>" alt="">
								<?php else: ?>
									<span class="h1 text-warning">
										<i class="fa fa-picture-o" aria-hidden="true"></i>
									</span>
								<?php endif ?>
								<br>
								<b><?php echo $value['post_title'] ?></b>
								<?php if ($value['post_content']): ?>
									<br>
									<sup class="text-secondary"><i><?php echo $value['post_content']; ?></i></sup>								
								<?php endif ?>
							</label></div>	
						<?php endforeach ?>	
					</div>
				</div>
			</template>

			<template v-if="currentStep==3">
				<div class="card-header">
					<h2 class="text-secondary">Выбор заезда:</h2>
				</div>
				<template v-if="stepStopAlert.show">
					<div class="p-5">
						<div class="alert alert-danger text-center">
							{{stepStopAlert.text}}
						</div>
					</div>					
				</template>
				<template v-if="!stepStopAlert.show">
					<div class="card-body">
						<div class="row">
							<template v-for="(item, index) in arrivalsList">
								<template v-if="item.season==season">
									<div class="col-lg-6 col-md-6 col-sm-12 col-12 p-1">
										<input
										v-bind:name="arrival"
										v-bind:value="item.ID"
										v-model="arrival"
										type="radio"
										class="btn-check"
										v-bind:id="'arrival_'+index"
										autocomplete="off">
										<label
										v-bind:for="'arrival_'+index"
										class="btn btn-outline-warning btn-lg w-100 h-100"
										>
										<div class="d-flex">
											<div class="w-25">
												<img v-if="item.image" width="100" v-bind:src="item.image" alt="">
												<span v-else="!item.image" class="h1">
													<i class="fa fa-picture-o" aria-hidden="true"></i>
												</span>
											</div>
											<div>
												<b>{{item.post_title}}</b>
												<br>
												<sup class="text-secondary"><i>{{item.post_content}}</i></sup>
											</div>
										</div>
									</label></div>	
								</template>

							</template>
						</div>
					</div>
				</div>
			</template>
		</template>


		<div class="card-footer">
			<div class="d-flex justify-content-around">
				<div>
					<button v-if="currentStep>1" v-on:click="currentStep--" class="btn btn-warning btn-lg text-light">
						<i class="fa fa-chevron-left" aria-hidden="true"></i>
						Назад
					</button>
				</div>
				<div>
					<button class="btn btn-outline-warning btn-lg" disabled>
						{{currentStep}} / {{stepsQuantity}}
					</button>
				</div>
				<div>
					<button 
					v-if="currentStep<stepsQuantity && !stepStopAlert.show"
					v-on:click="currentStep++"
					class="btn btn-warning btn-lg text-light"
					>Далее <i class="fa fa-chevron-right" aria-hidden="true"></i></button>
					<button 
					v-if="currentStep<stepsQuantity && stepStopAlert.show"
					class="btn btn-secondary btn-lg text-light"
					disabled
					>Далее <i class="fa fa-chevron-right" aria-hidden="true"></i></button>
					<button 
					v-if="currentStep==stepsQuantity"
					class="btn btn-warning btn-lg text-light"
					><i class="fa fa-envelope-o" aria-hidden="true"></i> Отправить</button>
				</div>
			</div>
		</div>

		<div class="p-5">
			<div class="progress" role="progressbar">
				<div class="progress-bar bg-warning" v-bind:style="rangeStyle"></div>
			</div>			
		</div>
		<pre>{{arrival}}</pre>
		<pre>{{season}}</pre>
	</div>
</div>
</div>


<pre><?php print_r($arrivals); ?></pre>

<script>
	Vue.createApp({
		data () {
			return {
				currentStep: 1,
				stepsQuantity: 4,
				season: false,
				arrivalsList: JSON.parse('<?php echo json_encode($arrivals); ?>'),
				arrival: false,
			};
		},

		watch: {
			season: function () {
				this.arrival = false;
			}
		},

		computed: {
			rangeStyle: function () {
				var width = this.currentStep / this.stepsQuantity * 100;
				width = width.toFixed(0);
				return 'width: ' + width + '%';
			},
			stepStopAlert: function () {
				var re = {
					show: false,
					text: '',
				};
				if (this.currentStep == 3 && !this.season	) {
					re.show = true;
					re.text = 'Не выбран сезон!'
				}

				return re;
			}
		},
	}).mount('#family_camp-contract_quiz');
</script>

<?php get_footer(); ?>