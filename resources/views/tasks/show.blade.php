@extends('layouts.app')

@section('title', 'Task Details')

@section('content')
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

					@if ($task->due_date)
						<div>
							<label class="font-medium">Due Date:</label>
							<p>{{ $task->due_date->format('M d, Y H:i') }}</p>
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection
