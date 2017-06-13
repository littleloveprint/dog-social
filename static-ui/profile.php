<!-- HEAD -->
<?php require_once("library/head-utils.php");?>

<body class="sfooter">
	<div class="sfooter-content">

		<!-- HEADER AND NAVBAR -->
		<?php require_once("library/header.php");?>

		<main class="class">
			<form class="form-horizontal">
				<fieldset>

					<!-- TEXT INPUT -->

					<!-- INSERT CLOUDINARY ID HERE??? -->

					<div class="form-group">
						<label class="col-md-4 control-label" for="@Handle">@Handle</label>
						<div class="col-md-2">
							<input id="@Handle" name="@Handle" type="text" placeholder="@Handle" class="form-control input-md">
						</div>
					</div>

					<!-- TEXT INPUT -->
					<div class="form-group">
						<label class="col-md-4 control-label" for="">Email</label>
						<div class="col-md-2">
							<input id="Email" name="Email" type="text" placeholder="Email" class="form-control input-md">
						</div>
					</div>

					<!-- BUTTON -->
					<div class="form-group">
						<label class="col-md-4 control-label" for="submit"></label>
						<div class="col-md-4">
							<button id="submit" name="submit" class="btn btn-primary">Submit</button>
						</div>
					</div>
				</fieldset>
			</form>
		</main>
	</div>
</body>

























			<?php require_once("library/footer.php");?>
		</main>
	</div>
</body>