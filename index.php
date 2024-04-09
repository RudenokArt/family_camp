<?php
get_header();
$seasons = ACF_class::getList('season');
$description = get_bloginfo('description', 'display');
?>

<div id="family_camp-contract_quiz">

	<div class="p-5">
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
					<?php foreach ($seasons as $key => $value): ?>
						<div class="p-2">
							<input
							name="season"
							value="<?php echo $value['ID']; ?>"
							v-model="season"
							type="radio"
							class="btn-check"
							id="season_<?php echo $key;?>"
							autocomplete="off"
							><label class="btn btn-outline-warning btn-lg w-100" for="season_<?php echo $key;?>">
								<b><?php echo $value['post_title'] ?></b>
								<?php if ($value['post_content']): ?>
									<br>
									<sup><i><?php echo $value['post_content']; ?></i></sup>								
								<?php endif ?>
							</label>
						</div>	
					<?php endforeach ?>
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
						заезды
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
						v-else="currentStep<stepsQuantity && stepStopAlert.show"
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


		</div>
	</div>
	<pre>{{season}}</pre>
</div>


<pre><?php print_r($seasons); ?></pre>

<script>
	Vue.createApp({
		data () {
			return {
				currentStep: 1,
				stepsQuantity: 4,
				season: false,
			};
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