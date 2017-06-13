<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#signin-modal">Sign In</button>

<div class="modal fade" tabindex="-1" role="dialog" id="signin-modal">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Enter your email and password to login</h4>
			</div>
			<div class="logo">
				<img src="/public_html/img/BarkParkzTransparent.png" alt="Welcome to Bark Parkz!">
			</div>

			<!--actual form-->
			<form #signInForm="ngForm" name="signInForm" id="signInForm"
					(ngSubmit)="signIn();">

				<!--user's email-->
				<div class="form-group">
					<label for="signin-email" class="modal-labels">Email:</label>
					<input type="email" name="signin-email" id="signin-email" required [(ngModel)]="signin.profileEmail" #profileEmail="ngModel" class="modal-inputs">
				</div>

				<!--user's password-->
				<div class="form-group">
					<label for="signin-password" class="modal-labels">Password:</label>
					<input type="password" id="signin-password" name="signin-password" required [(ngModel)]="signin.profilePassword" #profilePassword="ngModel" class="modal-inputs">
				</div>

				<!--submit the information-->
				<div class="form-group" id="signin-final-formgroup">
					<button type="submit" id="submit" [disabled]="signInForm.invalid" class="modal-submit">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>