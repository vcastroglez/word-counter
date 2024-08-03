<div class="component">
	<div wire:loading.remove class="row full-height child-shrink justify-content-center align-items-center align-content-center">
		<div class="text-center">
			<span class="fs-huge fw-bold"><< {{$current->word}} >></span>
		</div>
		<div class="text-center mb-5">
			<span>Frequency: {{$frequency}}%</span>
		</div>
		<div class="flex-grow-1 mb-5 description">
			{!! $current->description  !!}
		</div>
		<div class="row justify-content-between">
			<div class="col text-center">
				<button class="btn btn-info" wire:click="generateDescription" id="generate">Generate description</button>
			</div>
			<div class="col text-center">
				<button class="btn btn-warning" wire:click="next" id="next">Next</button>
			</div>
		</div>
	</div>
	<div wire:loading class="text-center full-height full-width justify-content-center align-items-center align-content-center fs-huge">
		Loading
	</div>
</div>
