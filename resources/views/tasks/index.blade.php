@extends('layouts.app')

@section('title', 'Tasks List')

@section('content')
	<div class="container mx-auto px-4 py-8">
		<h1 class="text-3xl font-bold mb-8">Task List</h1>

		<div class="grid gap-6">
			@forelse ($tasks as $task)
				<div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
					<div class="flex items-center justify-between mb-4">
						<h2 class="text-xl font-semibold">
							{{ $task->title }}
						</h2>
					</div>

					<div class="text-gray-600 mb-4">
						@if ($task->description)
							<p class="mb-2">{{ $task->description }}</p>
						@endif

						<div class="flex items-center gap-4 text-sm">
							@if ($task->due_date)
								<div class="flex items-center">
									{{ $task->due_date->format('M d, Y') }}
								</div>
							@endif

						</div>
					</div>
				</div>
			@empty
				<div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-500">
					No tasks found
				</div>
			@endforelse
		</div>

	</div>
@endsection
