<?php

namespace App\Enums;

enum TaskStatus: string
{
    use EnumToArray;
    case NotStarted = "Not Started";
    case InProgress = "In Progress";
    case Complete = "Complete";
    case OnHold = "On Hold";

    public function isValidTransition(TaskStatus $newState): bool
    {
        $transitions = [
            TaskStatus::NotStarted->value => [
                TaskStatus::InProgress,
                TaskStatus::OnHold,
            ], TaskStatus::InProgress->value => [
                TaskStatus::Complete,
                TaskStatus::OnHold,
            ], TaskStatus::OnHold->value => [
                TaskStatus::InProgress,
                TaskStatus::Complete,
            ]
        ];

        return in_array($newState, $transitions[$this->value]);
    }
}


