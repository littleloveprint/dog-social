<div class="modal fade" tabindex="-1" role="dialog" id="checkIn-modal">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Check your dog into this Park</h4>
			</div>

			<!--actual form-->
			<form #checkInForm="ngForm" name="checkInForm" (ngSubmit)="createCheckIn();">
				<!--dogs at handle-->
				<div class="form-group">
					<label for="atHandle" class="modal-labels">Dog</label>
					<input type="text" id="atHandle" name ="atHandle" class="form-horizontal well" required [(ngModel)]="checkIn.dogId" #checkInDogId="ngModel">
				</div>
				<!--submit the information-->
				<input type="submit" name="checkIn" class="modal-submit" value="checkIn">
				<!--<div>{{status.message}}</div>-->
			</form>
		</div>
	</div>
</div>