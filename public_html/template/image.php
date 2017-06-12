<h1>Image Component</h1>
<form class="form-horizontal" name="imageUpload" (submit)="uploadImage();">
	<div class="form-group">
		<label for="postImage" class="modal-labels">Upload an image</label>
		<input type="file" name="dog" id="dog" ng2FileSelect [uploader]="uploader" />
	</div>
	<button type="submit" class="btn btn-info btn-lg"><i class="fa fa-file-image-o" aria-hidden="true"></i> Upload Image</button>
</form>