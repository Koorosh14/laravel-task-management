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
							<a href="{{ route('tasks.show', $task) }}" class="hover:text-blue-600">
								{{ $task->title }}
							</a>
						</h2>

						<div class="gap-1">
							@if ($task->is_important)
								<span class="text-red-500">★</span>
							@endif

							<span
								class="px-3 py-1 text-sm rounded-full
                              {{ $task->status === \App\TaskStatus::COMPLETED ? 'bg-green-200 text-green-800' : 'bg-gray-200 text-gray-800' }}">
								{{ $task->status->getLabel() }}
							</span>
						</div>
					</div>

					<div class="text-gray-600 mb-4">
						@if ($task->description)
							<p class="mb-2">{{ Str::limit($task->description, 100) }}</p>
						@endif

						<div class="flex items-center gap-4 text-sm">
							@if ($task->due_date)
								<div class="flex items-center">
									<svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
									</svg>
									{{ $task->due_date->format('M d, Y') }}
								</div>

								@if ($task->due_date->isPast() && $task->status !== \App\TaskStatus::COMPLETED)
									<span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-red-600/10 ring-inset">Overdue</span>
								@endif
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
