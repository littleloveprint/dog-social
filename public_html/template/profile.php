<div class="fullscreen-bg">
			<img src="" alt="Background Image">
		</div>

<div class="container">
	<div class="row">
		<div class="col-md-offset-2 col-md-4">

			<!-- INSERT CLOUDINARY ID HERE??? -->
			<p id="profile-handle"> Welcome Back To Bark Parkz {{ profile.profileAtHandle }}</p>
		</div>

		<form class="form-horizontal" id="createProfile" name="createProfile" #createProfile="ngForm" (submit)="createProfile">

			<!-- TEXT INPUT -->
			<div class="form-group">
				<label class="col-md-4 control-label sr-only" for="@Handle">@Handle</label>
				<div class="col-md-2">
					<input id="@Handle" name="@Handle" type="text" placeholder="@Handle" class="form-control input-md" [(ngModel)]="createProfile.profileAtHandle">
				</div>
			</div>

			<!-- TEXT INPUT -->
			<div class="form-group">
				<label class="col-md-4 control-label" for="">Email</label>
				<div class="col-md-2">
					<input id="Email" name="Email" type="text" placeholder="Email" class="form-control input-md" [(ngModel)]="createProfile.profileEmail">
				</div>
			</div>

			<button name="submit"  type="submit" class="btn btn-primary">Submit</button>
		</form>
	</div>
</div>