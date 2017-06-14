<div class="park-wrap">
	<navbar></navbar>

	<div class="container">
		<h3>Park Name</h3>

		<agm-map [latitude]="lat" [longitude]="lng">
			<agm-marker [latitude]="lat" [longitude]="lng">

			</agm-marker>
		</agm-map>
	</div>
</div>