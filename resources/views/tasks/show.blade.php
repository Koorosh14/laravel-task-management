@extends('layouts.app')

@section('title', 'Task Details')

@section('content')
	<div class="m-4">
		<a href="{{ route('tasks.index') }}" class="inline-flex items-center border border-blue-200 px-3 py-1.5 rounded-md text-blue-400 hover:bg-blue-50">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18">
				</path>
			</svg>
			<span class="ml-1 font-bold">Back to Tasks</span>
		</a>
	</div>

	<div class="container mx-auto px-4 py-8">
		<div class="max-w-3xl mx-auto">
			<div class="bg-white rounded-lg shadow-md p-6 mb-6">
				<div class="flex items-center justify-between mb-6">
					<h1 class="text-3xl font-bold">{{ $task->title }}</h1>
					<span
						class="px-3 py-1 text-sm rounded-full
                          {{ $task->status === \App\TaskStatus::COMPLETED ? 'bg-green-200 text-green-800' : 'bg-gray-200 text-gray-800' }}">
						{{ Str::headline($task->status->getLabel()) }}
					</span>
				</div>

				<div class="space-y-4 text-gray-600">
					@if ($task->description)
						<p class="whitespace-pre-wrap">{{ $task->description }}</p>
					@endif

					<div class="grid grid-cols-3 gap-4 text-sm">
						<div>
							<label class="font-medium">Created by:</label>
							<p>{{ $task->creator->name }}</p>
						</div>

						@if ($task->assignee)
							<div>
								<label class="font-medium">Assigned to:</label>
								<p>{{ $task->assignee->name }}</p>
							</div>
						@endif

						@if ($task->due_date)
							<div>
								<label class="font-medium">Due Date:</label>
								<p>{{ $task->due_date->format('M d, Y H:i') }}</p>
							</div>
						@endif
					</div>
				</div>

				<div class="flex space-x-2 mt-5">
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
		</div>
	</div>
@endsection
