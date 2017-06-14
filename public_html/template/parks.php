<div class="parks-wrap">
	<navbar></navbar>

	<div class="container">
		<form class="form-horizontal">
			<h3>Search Parks</h3>
			<div class="wrap">
				<div class="search">
					<input type="text" class="searchTerm" placeholder="Search for parks in ABQ">
					<button type="submit" class="searchButton">
						<i class="fa fa-search"></i>
					</button>
				</div>
			</div>
		</form>

		<agm-map [latitude]="lat" [longitude]="lng">
			<agm-marker [latitude]="lat" [longitude]="lng">

			</agm-marker>
		</agm-map>
	</div>
</div>