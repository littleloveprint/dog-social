<div class="parks-wrap">
	<navbar></navbar>

	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<form class="form-inline">
					<div class="form-group">
						<label class="control-label" for="search">Search Parks</label>
						<input type="text" name="search" id="search" class="form-control"
								 placeholder="Search for parks in ABQ...">
					</div>
					<button type="submit" class="btn btn-default"><i class="fa fa-search fa-lg"></i></button>
				</form>
				<br>
			</div><!--/.col-md-6-->
		</div><!--/.row-->

		<agm-map [latitude]="lat" [longitude]="lng">
			<agm-marker [latitude]="lat" [longitude]="lng">

			</agm-marker>
		</agm-map>

		<br>

		<! -- <div class="well well-sm">
			<div *ngFor="let park of parks" class="h4">
				Park Name&nbsp; {{ park.parkName }}
			</div>
	</div>
</div>