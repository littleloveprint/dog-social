<div class="image-wrap">

	<navbar></navbar>

	<div class="container">
		<h2>Upload An Image</h2>
		<form name="imageUpload" (submit)="uploadImage();">
			<div class="form-group">
				<label for="postImage" class="sr-only">Upload an image</label>
				<input type="file" name="dog" id="dog" ng2FileSelect [uploader]="uploader" />
			</div>
			<button type="submit" class="btn btn-info btn-lg"><i class="fa fa-file-image-o" aria-hidden="true"></i> Upload Image</button>
		</form>
		<p class="h5">Cloudinary Public Id: {{ cloudinaryPublicId }}</p>
	</div>
</div>