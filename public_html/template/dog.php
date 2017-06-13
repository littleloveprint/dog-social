<form class="form-horizontal" id="createDog" name="createDog" #createDog="ngForm" (submit)="createDog();">

	<!-- Text input-->
	<div class="form-group">
		<label class="col-md-4 control-label" for="@Handle">@Handle</label>
		<div class="col-md-2">
			<input id="dogAtHandle" name="@Handle" type="text" placeholder="@Handle" class="form-control input-md" [(ngModel)]="createDog.dogAtHandle">

		</div>
	</div>

	<!-- Text input-->
	<div class="form-group">
		<label class="col-md-4 control-label" for="Age">Age</label>
		<div class="col-md-2">
			<input id="dogAge" name="Age" type="text" placeholder="Age" class="form-control input-md" [(ngModel)]="createDog.dogAge">

		</div>
	</div>

	<!-- Text input-->
	<div class="form-group">
		<label class="col-md-4 control-label" for="Breed">Breed</label>
		<div class="col-md-2">
			<input id="dogBreed" name="Breed" type="text" placeholder="Breed" class="form-control input-md" [(ngModel)]="createDog.dogBreed">

		</div>
	</div>

	<!-- Textarea -->
	<div class="form-group">
		<label class="col-md-4 control-label" for="bio">Bio</label>
		<div class="col-md-4">
			<textarea class="form-control" id="dogBio" name="Bio" [(ngModel)]="createDog.dogBio"></textarea>
		</div>
	</div>
	<!-- Button -->
	<div class="form-group">
		<label class="col-md-4 control-label" for="submit"></label>
		<div class="col-md-4">
			<button name="submit" type="submit" class="btn btn-primary">Submit</button>
		</div>
	</div>
</form>