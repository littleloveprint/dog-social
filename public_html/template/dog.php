<navbar></navbar>

<div class="container">
	<div class="row">
		<div class="col-sm-6 col-md-4">
			<h3>Add a Dog&nbsp;<i class="fa fa-paw"></i></h3>
			<form id="dogForm" name="dogForm" #dogForm="ngForm" (submit)="createDog();" novalidate>

				<!-- Text input-->
				<div class="form-group">
					<label class="control-label" for="dogAtHandle">@Handle</label>
					<input id="dogAtHandle" name="dogAtHandle" type="text" placeholder="@Handle" class="form-control input-md" [(ngModel)]="dog.dogAtHandle">
				</div>

				<!-- Text input-->
				<div class="form-group">
					<label class="control-label" for="dogAge">Age</label>
					<input id="dogAge" name="dogAge" type="text" placeholder="Age" class="form-control input-md" [(ngModel)]="dog.dogAge">
				</div>

				<!-- Text input-->
				<div class="form-group">
					<label class="control-label" for="dogBreed">Breed</label>
					<input id="dogBreed" name="dogBreed" type="text" placeholder="Breed" class="form-control input-md" [(ngModel)]="dog.dogBreed">
				</div>

				<!-- Textarea -->

				<div class="form-group">
					<label class="control-label" for="dogBio">Bio</label>
					<input id="dogBio" name="dogBio" type="text" placeholder="Bio"
							 class="form-control input-md" [(ngModel)]="dog.dogBio">
				</div>
				<!-- Button -->
				<div class="form-group">
					<label class="control-label" for="submit"></label>
					<button name="submit" type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>

			<div *ngIf="status !== null" class="alert alert-dismissible" [ngClass]="status.type" role="alert">                                                                 <button type="button" class="close" aria-label="Close" (click)="status = null;"><span aria-hidden="true">&times;</span></button>
				{{ status.message }}
			</div>
		</div><!--/.col-md-4-->
		<div class="col-sm-6 col-md-8">
			<h3>Here be your dogs....</h3>
		</div>
	</div><!--/.row-->
</div>