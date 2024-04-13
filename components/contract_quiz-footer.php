		<div class="d-none">
			<div id="contract_quiz-footer">
				<div class="card-footer">
					<div class="d-flex justify-content-around">
						<div>
							<button
							type="button"
							v-if="currentstep>1"
							v-on:click="previoussteptrigger"
							class="btn btn-warning btn-lg text-light">
							<i class="fa fa-chevron-left" aria-hidden="true"></i>
							Назад
						</button>
					</div>
					<div>
						<button class="btn btn-outline-warning btn-lg" disabled>
							{{currentstep}} / {{stepsquantity}}
						</button>
					</div>
					<div>
						<button
						v-if="currentstep<stepsquantity"
						v-on:click="nextsteptrigger"
						class="btn btn-warning btn-lg text-light"
						>Далее <i class="fa fa-chevron-right" aria-hidden="true"></i></button>
						<button 
						v-if="currentstep==stepsquantity"
						class="btn btn-warning btn-lg text-light"
						><i class="fa fa-envelope-o" aria-hidden="true"></i> Отправить</button>
					</div>
				</div>
			</div>
		</div>

	</div>



	<script>
		ContractQuiz.component('contract_quiz-footer', {
			template: '#contract_quiz-footer',
			props: ['currentstep', 'stepsquantity'],
			methods: {
				nextsteptrigger: function () {
					$('#submit-button').trigger('click');
					this.$emit('nextsteptrigger', this.currentstep);
				},
				previoussteptrigger: function () {
					this.$emit('previoussteptrigger', this.currentstep);
				},
			}
		});
	</script>