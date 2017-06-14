<div class="dog-wrap">
	<navbar></navbar>

	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<h1>Welcome to Bark Parkz! <button class="btn btn-info pull-right" role="button" data-toggle="collapse" href="#updateProfile" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-plus"></i>&nbsp;Update Profile</button></h1>
				<hr>
			</div>
		</div><!--/.row-->
		<div class="row">
			<div class="col-sm-6">
				<img src="https://www.fillmurray.com/200/300" alt="fill murray" class="img-responsive thumbnail">
				<div><span class="well well-sm">@handle</span></div>
			</div><!--/.col-sm-6-->
			<div class="col-sm-6">
				<div class="collapse" id="updateProfile">
					<div class="panel panel-default">
						<div class="panel-body">
							<form novalidate>
								<div class="form-group">
									<label for="name" class=" control-label">@handle</label>
									<input id="@Handle" name="@Handle" type="text" placeholder="@Handle" class="form-control input-md"
											 [(ngModel)]="profile.profileAtHandle">
								</div>

								<div class="form-group">
									<label for="SignUp" class=" control-label">Handle</label>
									<input type="text" class="form-control" id="SignUp"
											 placeholder="profileAtHandle" [(ngModel)]="profile.profileAtHandle"
											 #profileAtHandle="ngModel">
								</div>

								<div class="form-group">
									<label for="SignUp3" class=" control-label">Email</label>
									<input id="Email" name="Email" type="text" placeholder="Email" class="form-control input-md"
											 [(ngModel)]="profile.profileEmail">
								</div>

								<div class="form-group">
									<button type="submit" class="btn btn-info">Update Profile</button>
								</div>
							</form>
						</div><!--/.panel-body-->
					</div><!--/.profile-->
				</div><!--/.collapse-->
			</div><!--/.col-sm-6-->
		</div><!--/.row-->
	</div><!--/.container-->
</div>