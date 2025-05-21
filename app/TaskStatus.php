<?php

namespace App;

enum TaskStatus: string
{
	case PENDING = 'pending';
	case IN_PROGRESS = 'in_progress';
	case COMPLETED = 'completed';

	public function getLabel(): string
	{
		return match ($this) {
			self::PENDING => 'Pending',
			self::IN_PROGRESS => 'In Progress',
			self::COMPLETED => 'Completed',
			default => '-',
		};
	}
}
