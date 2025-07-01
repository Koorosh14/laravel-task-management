@extends('layouts.app')

@section('title', 'Edit Task - ' . $task->title)

@section('content')
	<div class="bg-white shadow overflow-hidden sm:rounded-lg">
		<div class="px-4 py-5 sm:px-6 flex justify-between items-center">
			<div>
				<h1 class="text-2xl font-bold text-gray-900">Edit Task</h1>
			</div>
			<div>
				<a href="{{ route('tasks.show', $task->id) }}"
					class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-400 focus:shadow-outline-gray transition ease-in-out duration-150">
					<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
						</path>
					</svg>
					View Task
				</a>
			</div>
		</div>

		<div class="border-t border-gray-200">
			<form action="{{ route('tasks.update', $task->id) }}" method="POST" class="px-4 py-5 sm:p-6">
				@csrf
				@method('PUT')

				{{-- Title --}}
				<div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 mb-6">
					<div class="sm:col-span-6">
						<label for="title" class="block text-sm font-medium text-gray-700">
							Task Title *
						</label>
						<div class="mt-1">
							<input type="text" name="title" id="title" value="{{ old('title', $task->title) }}" required
								class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('title') border-red-300 @enderror"
								placeholder="Enter task title">
						</div>
						@error('title')
							<p class="mt-2 text-sm text-red-600">{{ $message }}</p>
						@enderror
					</div>
				</div>

				{{-- Description --}}
				<div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 mb-6">
					<div class="sm:col-span-6">
						<label for="description" class="block text-sm font-medium text-gray-700">
							Description
						</label>
						<div class="mt-1">
							<textarea id="description" name="description" rows="4"
								class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('description') border-red-300 @enderror"
								placeholder="Describe the task in detail">{{ old('description', $task->description) }}</textarea>
						</div>
						@error('description')
							<p class="mt-2 text-sm text-red-600">{{ $message }}</p>
						@enderror
					</div>
				</div>

				{{-- Status, Due Date and Importance Row --}}
				<div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-3 mb-6">
					{{-- Status --}}
					<div>
						<label for="status" class="block text-sm font-medium text-gray-700">
							Status
						</label>
						<div class="mt-1">
							<select id="status" name="status"
								class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('status') border-red-300 @enderror">
								<option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>Pending</option>
								<option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>In Progress
								</option>
								<option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Completed</option>
							</select>
						</div>
						@error('status')
							<p class="mt-2 text-sm text-red-600">{{ $message }}</p>
						@enderror
					</div>

					{{-- Due Date --}}
					<div>
						<label for="due_date" class="block text-sm font-medium text-gray-700">
							Due Date
						</label>
						<div class="mt-1">
							<input type="date" name="due_date" id="due_date"
								value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : '') }}"
								class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('due_date') border-red-300 @enderror">
						</div>
						@error('due_date')
							<p class="mt-2 text-sm text-red-600">{{ $message }}</p>
						@enderror
					</div>

					{{-- Importance --}}
					<div>
						<label for="is_important" class="block text-sm font-medium text-gray-700">
							Is important?
						</label>
						<div class="mt-1">
							<input type="checkbox" id="is_important" name="is_important" @checked(old('is_important', $task->is_important)) />
						</div>
						@error('is_important')
							<p class="mt-2 text-sm text-red-600">{{ $message }}</p>
						@enderror
					</div>
				</div>

				{{-- Timestamps --}}
				<div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2 mb-6">
					<div class="bg-gray-50 px-4 py-3 rounded-md">
						<div class="text-sm font-medium text-gray-700">Created</div>
						<div class="text-sm text-gray-500">{{ $task->created_at->format('F d, Y \a\t g:i A') }}</div>
					</div>
					<div class="bg-gray-50 px-4 py-3 rounded-md">
						<div class="text-sm font-medium text-gray-700">Last Updated</div>
						<div class="text-sm text-gray-500">{{ $task->updated_at->format('F d, Y \a\t g:i A') }}</div>
					</div>
				</div>

				{{-- Form Actions --}}
				<div class="pt-5 border-t border-gray-200">
					<div class="flex justify-between">
						<div class="flex space-x-3">
							<a href="{{ route('tasks.show', $task->id) }}"
								class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
								Cancel
							</a>
							<a href="{{ route('tasks.index') }}"
								class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
								Back to List
							</a>
						</div>
						<div class="flex space-x-3">
							{{-- Update Button --}}
							<button type="submit"
								class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
								<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
									xmlns="http://www.w3.org/2000/svg">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
								</svg>
								Update Task
							</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

	{{-- Help Section --}}
	<div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-md p-4">
		<div class="flex">
			<div class="flex-shrink-0">
				<svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
					xmlns="http://www.w3.org/2000/svg">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
						d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.996-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
					</path>
				</svg>
			</div>
			<div class="ml-3">
				<h3 class="text-sm font-medium text-yellow-800">
					Editing Tips
				</h3>
				<div class="mt-2 text-sm text-yellow-700">
					<ul class="list-disc pl-5 space-y-1">
						<li>Changes are saved immediately when you click "Update Task"</li>
						<li>You can change the status to mark progress on your task</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
@endsection
