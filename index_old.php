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
				</div>
				<contract_quiz-footer
				v-bind:stepsquantity="stepsQuantity"
				v-bind:currentstep="currentStep"
				v-on:previoussteptrigger="currentStep--"
				></contract_quiz-footer>
			</form>
		</template>

		<template v-if="currentStep==5">
			<form action="" class="card" v-on:submit.prevent="currentStep++">
				<div class="card-header">
					<h2 class="text-secondary">Список отдыхающих:</h2>
				</div>
				<div class="card-body">

					<template v-for="(item, index) in touristsQuantityArr">
						<div class="row pt-1" v-if="touristsQuantity>=item">
							<div class="col-lg-8 col-md-8 col-sm-12 col-12">
								{{item}}) ФИО:
								<input type="text" class="form-control" required>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 col-12">
								Дата рождения:
								<input type="date" class="form-control" required>
							</div>
						</div>
					</template>
					<div class="p-1 d-flex justify-content-around">
						<button v-on:click="touristsQuantityAdd" type="button" class="btn btn-outline-success">
							<i class="fa fa-plus" aria-hidden="true"></i>
						</button>
						<button 
						v-if="touristsQuantity>1"
						v-on:click="touristsQuantityDec"
						type="button"
						class="btn btn-outline-danger">
						<i class="fa fa-minus" aria-hidden="true"></i></button>
					</div>
				</div>
				<contract_quiz-footer
				v-bind:stepsquantity="stepsQuantity"
				v-bind:currentstep="currentStep"
				v-on:previoussteptrigger="currentStep--"
				></contract_quiz-footer>
			</form>				
		</template>

	</form>

	<div class="p-5">
		<div class="progress" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
			<div class="progress-bar bg-warning" v-bind:style="progressStyle"></div>
		</div>
	</div>

</div>
</div>



<script>
	var ContractQuiz = Vue.createApp({
		data () {
			return {
				currentStep: 1,
				stepsQuantity: 5,
				season: false,
				arrivalsList: JSON.parse('<?php echo json_encode($arrivals); ?>'),
				arrival: false,
				touristsQuantity: 1,
			};
		},
		methods: {
			formValidation: function () {
				console.log('formValidation');
			},
			touristsQuantityAdd: function () {
				if (this.touristsQuantity < 10) {
					this.touristsQuantity++;
				}
			},
			touristsQuantityDec: function () {
				if (this.touristsQuantity > 1) {
					this.touristsQuantity--;
				}
			},
		},

		watch: {
			season: function () {
				this.arrival = false;
			}
		},

		computed: {
			progressStyle: function () {
				var re = (this.currentStep) / this.stepsQuantity * 100;
				re = re.toFixed(0);
				re = 'width: ' + re + '%';
				return re;
			},

			touristsQuantityArr: function () {
				var arr = [];
				for (var i = 0; i < 10; i++) {
					arr[i] = i + 1;
				}
				return arr;
			},
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