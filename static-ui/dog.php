<!-- HEAD -->
<?php require_once("library/head-utils.php");?>

<body>



		<!-- HEADER AND NAVBAR -->
		<?php require_once("library/header.php");?>

		<main class="class">
			<form class="form-horizontal">
				<fieldset>

					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-4 control-label" for="@Handle">@Handle</label>
						<div class="col-md-4">
							<input id="@Handle" name="@Handle" type="text" placeholder="@Handle" class="form-control input-md">

						</div>
					</div>

					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-4 control-label" for="Age">Age</label>
						<div class="col-md-2">
							<input id="Age" name="Age" type="text" placeholder="Age" class="form-control input-md">

						</div>
					</div>

					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-4 control-label" for="Breed">Breed</label>
						<div class="col-md-4">
							<input id="Breed" name="Breed" type="text" placeholder="Breed" class="form-control input-md">

						</div>
					</div>

					<!-- Textarea -->
					<div class="form-group">
						<label class="col-md-4 control-label" for="bio">Bio</label>
						<div class="col-md-4">
							<textarea class="form-control" id="bio" name="bio"></textarea>
						</div>
						<!-- Button -->
						<div class="form-group">
							<label class="col-md-4 control-label" for="submit"></label>
							<div class="col-md-4">
								<button id="submit" name="submit" class="btn btn-primary">Submit</button>
							</div>
					</div>





		</main>

</body>