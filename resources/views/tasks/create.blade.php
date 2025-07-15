@extends('layouts.app')

@section('title', 'Create New Task')

@section('content')
	<div class="bg-white shadow just overflow-hidden sm:rounded-lg">
		<div class="px-4 py-5 sm:px-6">
			<h1 class="text-2xl font-bold text-gray-900">Create New Task</h1>
		</div>

		<div class="border-t border-gray-200">
			<form action="{{ route('tasks.store') }}" method="POST" class="px-4 py-5 sm:p-6">
				@csrf

				{{-- Title --}}
				<div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 mb-6">
					<div class="sm:col-span-6">
						<label for="title" class="block text-sm font-medium text-gray-700">
							Task Title *
						</label>
						<div class="mt-1">
							<input type="text" name="title" id="title" value="{{ old('title') }}" required
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
							 placeholder="Describe the task in detail">{{ old('description') }}</textarea>
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
								<option value="{{ \App\TaskStatus::PENDING }}" {{ old('status', 'pending') == \App\TaskStatus::PENDING->value ? 'selected' : '' }}>Pending</option>
								<option value="{{ \App\TaskStatus::IN_PROGRESS }}" {{ old('status', 'pending') == \App\TaskStatus::IN_PROGRESS->value ? 'selected' : '' }}>In Progress</option>
								<option value="{{ \App\TaskStatus::COMPLETED }}" {{ old('status', 'pending') == \App\TaskStatus::COMPLETED->value ? 'selected' : '' }}>Completed</option>
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
							<input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}"
								class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('due_date') border-red-300 @enderror">
						</div>
						@error('due_date')
							<p class="mt-2 text-sm text-red-600">{{ $message }}</p>
						@enderror
					</div>

					{{-- Importance --}}
					<div>
						<label for="is_important" class="block text-sm font-medium text-gray-700">
							Is Important?
						</label>
						<div class="mt-1">
							<input type="checkbox" id="is_important" name="is_important" @checked(old('is_important')) />
						</div>
						@error('is_important')
							<p class="mt-2 text-sm text-red-600">{{ $message }}</p>
						@enderror
					</div>

					{{-- Assigned To --}}
					<div>
						<label for="assigned_to" class="block text-sm font-medium text-gray-700">
							Assigned To
						</label>
						<div class="mt-1">
							<select id="assigned_to" name="assigned_to"
								class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('assigned_to') border-red-300 @enderror">
								<option value="">Select a user</option>
								@foreach ($users as $user)
									<option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
										{{ $user->name ?? $user->email }}
									</option>
								@endforeach
							</select>
						</div>
						@error('assigned_to')
							<p class="mt-2 text-sm text-red-600">{{ $message }}</p>
						@enderror
					</div>
				</div>

				{{-- Form Actions --}}
				<div class="pt-5 border-t border-gray-200">
					<div class="flex justify-end space-x-3">
						<a href="{{ route('tasks.index') }}"
							class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
							Cancel
						</a>
						<button type="submit"
							class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
							<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
								xmlns="http://www.w3.org/2000/svg">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
							</svg>
							Create Task
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	{{-- Help Section --}}
	<div class="mt-6 bg-blue-50 border border-blue-200 rounded-md p-4">
		<div class="flex">
			<div class="flex-shrink-0">
				<svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
					xmlns="http://www.w3.org/2000/svg">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
						d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
				</svg>
			</div>
			<div class="ml-3">
				<h3 class="text-sm font-medium text-blue-800">
					Quick Tips
				</h3>
				<div class="mt-2 text-sm text-blue-700">
					<ul class="list-disc pl-5 space-y-1">
						<li>Use descriptive titles to make tasks easy to identify</li>
						<li>Set realistic due dates to stay on track</li>
						<li>Important tasks will be highlighted in your task list</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
@endsection
