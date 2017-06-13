<form class="form-horizontal" id="createDog" name="createDog" #createDog="ngForm" (submit)="createDog();"
		xmlns="http://www.w3.org/1999/html">

	<!-- Text input-->
	<div class="form-group">
		<label class="col-md-4 control-label" for="@Handle">@Handle</label>
		<div class="col-md-2">
			<input id="dogAtHandle" name="@Handle" type="text" placeholder="@Handle" class="form-control input-md" [(ngModel)]="dog.dogAtHandle">

		</div>
	</div>

	<!-- Text input-->
	<div class="form-group">
		<label class="col-md-4 control-label" for="Age">Age</label>
		<div class="col-md-2">
			<input id="dogAge" name="Age" type="text" placeholder="Age" class="form-control input-md" [(ngModel)]="dog.dogAge">

		</div>
	</div>

	<!-- Text input-->
	<div class="form-group">
		<label class="col-md-4 control-label" for="Breed">Breed</label>
		<div class="col-md-2">
			<input id="dogBreed" name="Breed" type="text" placeholder="Breed" class="form-control input-md" [(ngModel)]="dog.dogBreed">

		</div>
	</div>

	<!-- Textarea -->

			<div class="form-group">
				<label class="col-md-4 control-label" for="dogBio">Bio</label>
				<div class="col-md-8">
					<input id="dogBio" name="Bio" type="text" placeholder="Bio"
							 class="form-control input-md" [(ngModel)]="dog.dogBio">

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

<div *ngIf="status !== null" class="alert alert-dismissible" [ngClass]="status.type" role="alert">                                                                 <button type="button" class="close" aria-label="Close" (click)="status = null;"><span aria-hidden="true">&times;</span></button>
	{{ status.message }}
</div>