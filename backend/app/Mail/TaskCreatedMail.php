<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TaskCreatedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $task;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nova Tarefa Criada - ' . $this->task->title)
                    ->view('emails.task-created')
                    ->with([
                        'task' => $this->task,
                        'userName' => $this->task->user->name ?? 'Usuário',
                        'createdAt' => now()->format('d/m/Y H:i')
                    ]);
    }
}
