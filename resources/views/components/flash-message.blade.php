@if (session('success'))
	<div id="flash-message-success" class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow"
		role="alert" x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show">
		{{ session('success') }}
	</div>
@endif

@if (session('error'))
	<div id="flash-message-error" class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow"
		role="alert" x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show">
		{{ session('error') }}
	</div>
@endif
