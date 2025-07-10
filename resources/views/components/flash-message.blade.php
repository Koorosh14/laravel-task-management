@props(['type'])

@if (session($type))
	<div id="flash-message-{{ $type }}"
		{{ $attributes->merge(['class' => 'mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow']) }}
		role="alert" x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show">
		{{ session($type) }}
	</div>
@endif
