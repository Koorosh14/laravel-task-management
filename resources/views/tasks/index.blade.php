@extends('layouts.app')

@section('title', 'Tasks List')

@section('content')
	<div class="flex justify-between items-center mb-8 max-md:flex-col max-md:gap-2">
		<h1 class="text-3xl font-bold">Task List</h1>

		{{-- Search form --}}
		<form action="{{ route('tasks.index') }}" method="get" class="flex md:mx-4 w-full md:w-auto">
			<input type="text" name="search" placeholder="Search tasks..."
				class="px-4 py-2 border border-gray-300 rounded-l-md w-full md:w-64" value="{{ $filters['search'] }}">
			<button type="submit" class="flex items-center bg-blue-500 text-white px-4 py-2 rounded-r-md hover:bg-blue-600">
				<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
						d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
				</svg>
				Search
			</button>
		</form>

		<a href="{{ route('tasks.create') }}"
			class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-800 transition ease-in-out duration-150">
			<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
			</svg>
			Add Task
		</a>
	</div>

	<div class="container mx-auto px-4 py-8">
		{{-- Filter and Sort --}}
		<div class="mb-6 flex flex-col md:flex-row justify-between">
			<div class="filters mb-4 md:mb-0 w-full">
				<form action="{{ route('tasks.index') }}" method="get" class="flex flex-wrap gap-4 w-full">
					<div class="flex-1 min-w-[180px]">
						<label for="filters-status" class="text-gray-600 block mb-1">Status</label>
						<select id="filters-status" name="status" class="py-2 px-3 border border-gray-300 rounded-md w-full">
							<option value="">All Statuses</option>
							<option value="{{ \App\TaskStatus::PENDING }}" {{ $filters['status'] == \App\TaskStatus::PENDING->value ? 'selected' : '' }}>Pending</option>
							<option value="{{ \App\TaskStatus::IN_PROGRESS }}" {{ $filters['status'] == \App\TaskStatus::IN_PROGRESS->value ? 'selected' : '' }}>In Progress</option>
							<option value="{{ \App\TaskStatus::COMPLETED }}" {{ $filters['status'] == \App\TaskStatus::COMPLETED->value ? 'selected' : '' }}>Completed</option>
						</select>
					</div>

					<div class="flex-1 min-w-[180px]">
						<label for="filters-sort" class="text-gray-600 block mb-1">Sort</label>
						<select id="filters-sort" name="sort" class="py-2 px-3 border border-gray-300 rounded-md w-full">
							<option value="due_date" {{ $filters['sort'] == 'due_date' ? 'selected' : '' }}>Due Date</option>
							<option value="title" {{ $filters['sort'] == 'title' ? 'selected' : '' }}>Title</option>
							<option value="created_at" {{ $filters['sort'] == 'created_at' ? 'selected' : '' }}>Creation Date</option>
							<option value="is_important" {{ $filters['sort'] == 'is_important' ? 'selected' : '' }}>Importance</option>
						</select>
					</div>

					<div class="flex-1 min-w-[140px]">
						<label for="filters-sort-by" class="text-gray-600 block mb-1">Order</label>
						<select id="filters-sort-by" name="sort_by" class="py-2 px-3 border border-gray-300 rounded-md w-full">
							<option value="DESC" {{ $filters['sort_by'] == 'DESC' ? 'selected' : '' }}>Descending</option>
							<option value="ASC" {{ $filters['sort_by'] == 'ASC' ? 'selected' : '' }}>Ascending</option>
						</select>
					</div>

					<div class="flex items-end gap-2">
						<button type="submit"
							class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
							Filter
						</button>

						@if ($filters['status'] || $filters['sort'] != 'due_date' || $filters['sort_by'] != 'ASC')
							<a href="{{ route('tasks.index') }}"
								class="ml-2 inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-400 focus:shadow-outline-gray transition ease-in-out duration-150">
								Clear
							</a>
						@endif
					</div>
				</form>
			</div>
		</div>

		{{-- Tasks --}}
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
						@else
							<p class="text-gray-500 mb-2">No description provided.</p>
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

							<div class="flex items-center">
								<svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
										d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
								</svg>
								@if ($task->assignee)
									<span>{{ $task->assignee->name ?? $task->assignee->email }}</span>
								@else
									<span class="text-gray-500">Unassigned</span>
								@endif
							</div>
						</div>
					</div>

					<div class="d-flex gap-1">
						<a href="{{ route('tasks.edit', $task->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
							<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
								</path>
							</svg>
							Edit
						</a>

						<form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline-block">
							@csrf
							@method('DELETE')

							<button type="submit" onclick="return confirm('Are you sure you want to delete this task? This action cannot be undone!')"
								class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition ease-in-out duration-150">
								<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
									xmlns="http://www.w3.org/2000/svg">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
										d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
									</path>
								</svg>
								Delete
							</button>
						</form>
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
				{{ $tasks->appends(request()->except('page'))->links() }}
			</div>
		@endif
	</div>
@endsection
