<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#signup-modal">Sign Up</button>

<div class="modal fade" tabindex="-1" role="dialog" id="signup-modal">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Enter your information to Sign Up for BarkParkz.com</h4>
			</div>

			<!--actual form-->
			<form #signupForm="ngForm" name="signupForm" (ngSubmit)="createSignUp();">
				<!--user's email-->
				<div class="form-group">
					<label for="atHandle" class="modal-labels">Name</label>
					<input type="text" id="atHandle" name ="atHandle" class="modal-inputs" required [(ngModel)]="signUp.profileAtHandle" #signUpAtHandle="ngModel">
				</div>
				<div class="form-group">
					<label for="email" class="modal-labels">Email:</label>
					<input type="email" id="email" name ="email" class="modal-inputs" required [(ngModel)]="signUp.profileEmail" #signUpEmail="ngModel">
				</div>
				<!--user enters password-->
				<div class="form-group">
					<label for="password" class="modal-labels">Password:</label>
					<input type="password" id="password" name="password" class="modal-inputs" required [(ngModel)]="signUp.profilePassword" #signUpPassword="ngModel">
				</div>
				<!--confirm password-->
				<div class="form-group">
					<label for="passwordConfirm" class="modal-labels">Confirm Password:</label>
					<input type="password" id="passwordConfirm" name="passwordConfirm" class="modal-inputs" required [(ngModel)]="signUp.profilePasswordConfirm" #signUpPasswordConfirm="ngModel">
				</div>
				<!--submit the information-->
				<input type="submit" name="signup" class="modal-submit" value="signup">
				<!--<div>{{status.message}}</div>-->
			</form>
		</div>
	</div>
</div>