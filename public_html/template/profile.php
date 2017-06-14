<body>
	<div class="dog-wrap">
		<navbar></navbar>

<div class="container">
	<div class="row">
		<div class="col-md-offset-2 col-md-4">

			<!-- INSERT CLOUDINARY ID HERE??? -->
			<p id="profile-handle"> Welcome Back To Bark Parkz {{ profile.profileAtHandle }}</p>
		</div>

		<form class="form-horizontal" id="createProfile" name="createProfile" #createProfile="ngForm" (submit)="createProfile"();>

			<!-- TEXT INPUT -->
			<div class="form-group">
				<label class="col-md-4 control-label sr-only" for="@Handle">@Handle</label>
				<div class="col-md-2">
					<input id="@Handle" name="@Handle" type="text" placeholder="@Handle" class="form-control input-md" [(ngModel)]="profile.profileAtHandle">
				</div>
			</div>

			<!-- TEXT INPUT -->
			<div class="form-group">
				<label class="col-md-4 control-label" for="">Email</label>
				<div class="col-md-2">
					<input id="Email" name="Email" type="text" placeholder="Email" class="form-control input-md" [(ngModel)]="profile.profileEmail">
				</div>
			</div>

			<!-- BUTTONS -->
			<div class="form-group">
				<label class="control-label" for="updateProfile"></label>
				<button name="submit" type="submit" class="btn btn-primary">UPDATE PROFILE</button>
			</div>
		</form>
	</div>
</div>

		<!-- MORE TEXT -->
		<div *ngIf="status !== null" class="alert alert-dismissible" [ngClass]="status.type" role="alert">

			<button type="button" class="close" aria-label="Close" (click)="status = null;"><span aria-hidden="true">&times;</span></button>

						{{ status.message }}
					</div>
				</div><!--/.col-md-4-->
				<div class="col-sm-6 col-md-8">
					<img class="img-circle img-responsive" src="../img/LeaDoggy.jpg" alt="Profile Image">

					<!-- PROFILE NAV BUTTONS -->
					<div class="form-group">
						<label class="control-label" for="viewParks"></label>
						<button name="submit" type="button" class="btn btn-primary">PARKS</button>
					</div>
</body>