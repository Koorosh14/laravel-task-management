@extends('layouts.app')

@section('title', 'Tasks List')

@section('content')
	<div class="container mx-auto px-4 py-8">
		<h1 class="text-3xl font-bold mb-8">Task List</h1>

		{{-- Filter and Sort --}}
		<div class="mb-6 flex flex-col md:flex-row justify-between">
			<div class="filters mb-4 md:mb-0">
				<form action="{{ route('tasks.index') }}" method="get" class="flex flex-wrap gap-2">
					<div>
						<label for="filters-status" class="text-gray-600">Status</label>
						<select id="filters-status" name="status" class="py-2 px-3 border border-gray-300 rounded-md">
							<option value="">All Statuses</option>
							<option value="{{ \App\TaskStatus::PENDING }}" {{ $filters['status'] == \App\TaskStatus::PENDING->value ? 'selected' : '' }}>Pending</option>
							<option value="{{ \App\TaskStatus::IN_PROGRESS }}" {{ $filters['status'] == \App\TaskStatus::IN_PROGRESS->value ? 'selected' : '' }}>In Progress
							</option>
							<option value="{{ \App\TaskStatus::COMPLETED }}" {{ $filters['status'] == \App\TaskStatus::COMPLETED->value ? 'selected' : '' }}>Completed</option>
						</select>
					</div>

					<div>
						<label for="filters-sort" class="text-gray-600">Sort</label>
						<select id="filters-sort" name="sort" class="py-2 px-3 border border-gray-300 rounded-md">
							<option value="due_date" {{ $filters['sort'] == 'due_date' ? 'selected' : '' }}>Due Date</option>
							<option value="title" {{ $filters['sort'] == 'title' ? 'selected' : '' }}>Title</option>
							<option value="created_at" {{ $filters['sort'] == 'created_at' ? 'selected' : '' }}>Creation Date</option>
							<option value="is_important" {{ $filters['sort'] == 'is_important' ? 'selected' : '' }}>Importance</option>
						</select>
					</div>

					<div>
						<select name="sort_by" class="py-2 px-3 border border-gray-300 rounded-md">
							<option value="DESC" {{ $filters['sort_by'] == 'DESC' ? 'selected' : '' }}>Descending</option>
							<option value="ASC" {{ $filters['sort_by'] == 'ASC' ? 'selected' : '' }}>Ascending</option>
						</select>
					</div>

					<button type="submit" class="py-2 px-4 bg-blue-500 text-white rounded-md hover:bg-blue-600">
						Apply Filters
					</button>

					@if ($filters['status'] || $filters['sort'] != 'due_date' || $filters['sort_by'] != 'ASC')
						<a href="{{ route('tasks.index') }}" class="py-2 px-4 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
							Reset
						</a>
					@endif
				</form>
			</div>
		</div>

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

							@if ($task->assignee)
								<div class="flex items-center">
									<svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
									</svg>
									{{ $task->assignee->name }}
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

		@if ($tasks instanceof \Illuminate\Pagination\AbstractPaginator)
			<div class="mt-8">
				{{ $tasks->links() }}
			</div>
		@endif
	</div>
@endsection
