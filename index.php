<?php
get_header();
$seasons = ACF_class::getList('season');
$arrivals = ACF_class::getListWithMeta('arrival', 'arrival_season')
?>

<div id="contract_quiz">
	<div class="pt-5 pb-5">


			<template v-if="currentStep==1">
				<form action="" class="card" v-on:submit.prevent="currentStep++">
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
				<contract_quiz-footer
				v-bind:stepsquantity="stepsQuantity"
				v-bind:currentstep="currentStep"
				v-on:previoussteptrigger="currentStep--"
				></contract_quiz-footer>
				</form>				
			</template>
			
			<template v-if="currentStep==2">
				<form action="" class="card" v-on:submit.prevent="currentStep++">
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
								autocomplete="off" required>
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
				<contract_quiz-footer
				v-bind:stepsquantity="stepsQuantity"
				v-bind:currentstep="currentStep"
				v-on:previoussteptrigger="currentStep--"
				></contract_quiz-footer>
				</form>
				
			</template>

			<template v-if="currentStep==3">
				<form action="" class="card" v-on:submit.prevent="currentStep++">
					<div class="card-header">
					<h2 class="text-secondary">Выбор заезда:</h2>
				</div>
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
									autocomplete="off" required>
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
				<contract_quiz-footer
				v-bind:stepsquantity="stepsQuantity"
				v-bind:currentstep="currentStep"
				v-on:previoussteptrigger="currentStep--"
				></contract_quiz-footer>
				</form>
				
			</template>

			<template v-if="currentStep==4">
				<form action="" class="card" v-on:submit.prevent="currentStep++">
					<div class="card-header">
					<h2 class="text-secondary">Персональные данные для заполнения договора:</h2>
				</div>
				<div class="card-body">
					<div class="p-1">
						ФИО:
						<input type="text" name="customer[fio]" class="form-control" required>
					</div>
					<div class="p-1">
						<div class="d-flex flex-wrap">
							<div class="p-1">
								Дата рождения:
								<input type="date" name="customer[date]" class="form-control" required>
							</div>
							<div class="p-1">
								Email:
								<input type="email" name="customer[mail]" class="form-control" required>
							</div>
							<div class="p-1">
								Телефон:
								<input type="text" name="customer[phone]" class="form-control" required>
							</div>
							<div class="p-1">
								Серия и номер паспорта:
								<input type="text" name="customer[passport]" class="form-control" required>
							</div>
							<div class="p-1">
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
				</div>
				<contract_quiz-footer
				v-bind:stepsquantity="stepsQuantity"
				v-bind:currentstep="currentStep"
				v-on:previoussteptrigger="currentStep--"
				></contract_quiz-footer>
				</form>
				
			</template>



			<div class="p-5">
				<div class="progress" role="progressbar">
					<div class="progress-bar bg-warning" v-bind:style="rangeStyle"></div>
				</div>
			</div>
			<pre>{{arrival}}</pre>
			<pre>{{season}}</pre>

		</form>

	</div>
</div>


<pre><?php print_r($arrivals); ?></pre>

<script>
	var ContractQuiz = Vue.createApp({
		data () {
			return {
				currentStep: 1,
				stepsQuantity: 5,
				season: false,
				arrivalsList: JSON.parse('<?php echo json_encode($arrivals); ?>'),
				arrival: false,
			};
		},
		methods: {
			formValidation: function () {
				console.log('formValidation');
			}
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
		},
	});
</script>

<?php include_once 'components/contract_quiz-footer.php'; ?>


<script>
	ContractQuiz.mount('#contract_quiz');
</script>

<?php get_footer(); ?>