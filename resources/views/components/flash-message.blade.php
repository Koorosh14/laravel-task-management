@if (session('success'))
	<div id="flash-message-success" class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow" role="alert">
		{{ session('success') }}
	</div>
	<script>
		setTimeout(() => { document.getElementById('flash-message-success').style.display = 'none'; }, 5000);
	</script>
@endif

@if (session('error'))
	<div id="flash-message-error" class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow" role="alert">
		{{ session('error') }}
	</div>
	<script>
		setTimeout(() => { document.getElementById('flash-message-error').style.display = 'none'; }, 5000);
	</script>
@endif
