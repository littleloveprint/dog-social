<form class="form-horizontal" id="dogForm" name="dogForm" #dogForm="ngForm" (submit)="createDog();" novalidate>

	<!-- Text input-->
	<div class="form-group">
		<label class="col-md-4 control-label" for="dogAtHandle">@Handle</label>
		<div class="col-md-2">
			<input id="dogAtHandle" name="dogAtHandle" type="text" placeholder="@Handle" class="form-control input-md" [(ngModel)]="dog.dogAtHandle">

		</div>
	</div>

	<!-- Text input-->
	<div class="form-group">
		<label class="col-md-4 control-label" for="dogAge">Age</label>
		<div class="col-md-2">
			<input id="dogAge" name="dogAge" type="text" placeholder="Age" class="form-control input-md" [(ngModel)]="dog.dogAge">

		</div>
	</div>

	<!-- Text input-->
	<div class="form-group">
		<label class="col-md-4 control-label" for="dogBreed">Breed</label>
		<div class="col-md-2">
			<input id="dogBreed" name="dogBreed" type="text" placeholder="Breed" class="form-control input-md" [(ngModel)]="dog.dogBreed">

		</div>
	</div>

	<!-- Textarea -->

			<div class="form-group">
				<label class="col-md-4 control-label" for="dogBio">Bio</label>
				<div class="col-md-8">
					<input id="dogBio" name="dogBio" type="text" placeholder="Bio"
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