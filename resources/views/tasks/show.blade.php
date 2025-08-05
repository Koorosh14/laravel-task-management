@extends('layouts.app')

@section('title', 'Task Details')

@section('content')
	<div class="m-4">
		<a href="{{ route('tasks.index') }}"
			class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-400 focus:shadow-outline-gray transition ease-in-out duration-150">
			<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
			</svg>
			Back to Tasks
		</a>
	</div>

	<div class="container mx-auto px-4 py-8">
		<div class="max-w-3xl mx-auto">
			<div class="bg-white rounded-lg shadow-md p-6 mb-6">
				<div class="flex items-center justify-between mb-6">
					<div>
						<h1 class="text-2xl font-bold text-gray-900">{{ $task->title }}</h1>
						<p class="mt-1 text-sm text-gray-500">Task created {{ $task->created_at->format('M d, Y') }}</p>
					</div>
					<div class="gap-1">
						@if ($task->is_important)
							<span class="text-red-500">★</span>
						@endif
						<span
							class="px-3 py-1 text-sm rounded-full
							{{ $task->status === \App\TaskStatus::COMPLETED ? 'bg-green-200 text-green-800' : 'bg-gray-200 text-gray-800' }}">
							{{ Str::headline($task->status->getLabel()) }}
						</span>
					</div>
				</div>

				<div class="space-y-4 text-gray-600">
					@if ($task->description)
						<p class="whitespace-pre-wrap">{{ $task->description }}</p>
					@else
						<p class="text-gray-500">No description provided.</p>
					@endif

					<div class="grid grid-cols-3 gap-4 text-sm">
						<div>
							<label class="font-medium">Created by:</label>
							<p>{{ $task->creator->name ?? $task->creator->email }}</p>
						</div>

						<div>
							<label class="font-medium">Last Updated:</label>
							<p>{{ $task->updated_at->diffForHumans() }}</p>
						</div>

						<div>
							<label class="font-medium">Assigned to:</label>
							@if ($task->assignee)
								<p>{{ $task->assignee->name ?? $task->assignee->email }}</p>
							@else
								<p class="text-gray-500">Unassigned</p>
							@endif
						</div>

						@if ($task->due_date)
							<div>
								<label class="font-medium">Due Date:</label>
								<p>{{ $task->due_date->format('M d, Y H:i') }}</p>
								@if ($task->due_date->isPast() && $task->status !== \App\TaskStatus::COMPLETED)
									<span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-red-600/10 ring-inset">Overdue</span>
								@endif
							</div>
						@endif
					</div>
				</div>

				@auth
					<div class="mt-6 flex justify-between">
						<div class="flex space-x-2">
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

						@if ($task->status !== \App\TaskStatus::COMPLETED)
							<form action="{{ route('tasks.update_status', $task->id) }}" method="POST" class="inline-block">
								@csrf
								@method('PATCH')

								<input type="hidden" name="status" value="{{ \App\TaskStatus::COMPLETED }}">
								<button type="submit"
									class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition ease-in-out duration-150">
									<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
										xmlns="http://www.w3.org/2000/svg">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
									</svg>
									Mark as Complete
								</button>
							</form>
						@endif
					</div>
				@endauth
			</div>
		</div>
	</div>
@endsection
