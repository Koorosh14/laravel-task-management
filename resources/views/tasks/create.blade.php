@extends('layouts.app')

@section('title', 'Create New Task')

@section('content')
	<div class="bg-white shadow just overflow-hidden sm:rounded-lg">
		<div class="px-4 py-5 sm:px-6">
			<h1 class="text-2xl font-bold text-gray-900">Create New Task</h1>
		</div>

		<div class="border-t border-gray-200">
			<form action="{{-- {{ route('tasks.store') }} --}}" method="GET" class="px-4 py-5 sm:p-6">
				@csrf

				{{-- Title --}}
				<div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 mb-6">
					<div class="sm:col-span-6">
						<label for="title" class="block text-sm font-medium text-gray-700">
							Task Title *
						</label>
						<div class="mt-1">
							<input type="text" name="title" id="title" value="{{ old('title') }}" required
								class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
								placeholder="Enter task title">
						</div>
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
							 class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
							 placeholder="Describe the task in detail">{{ old('description') }}</textarea>
						</div>
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
								class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
								<option value="{{ \App\TaskStatus::PENDING }}" {{ old('status', 'pending') == \App\TaskStatus::PENDING->value ? 'selected' : '' }}>Pending</option>
								<option value="{{ \App\TaskStatus::IN_PROGRESS }}" {{ old('status', 'pending') == \App\TaskStatus::IN_PROGRESS->value ? 'selected' : '' }}>In Progress</option>
								<option value="{{ \App\TaskStatus::COMPLETED }}" {{ old('status', 'pending') == \App\TaskStatus::COMPLETED->value ? 'selected' : '' }}>Completed</option>
							</select>
						</div>
					</div>

					{{-- Due Date --}}
					<div>
						<label for="due_date" class="block text-sm font-medium text-gray-700">
							Due Date
						</label>
						<div class="mt-1">
							<input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}"
								class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
						</div>
					</div>

					{{-- Importance --}}
					<div>
						<label for="is_important" class="block text-sm font-medium text-gray-700">
							Is important?
						</label>
						<div class="mt-1">
							<input type="checkbox" id="is_important" name="is_important" />
						</div>
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
							Create Task
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection
