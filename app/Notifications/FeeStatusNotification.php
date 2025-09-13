<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class FeeStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;
    protected $message;
    protected $amount;
    protected $dueDate;
    protected $status;

    /**
     * Create a new notification instance.
     */
 public function __construct($message, $amount, $dueDate, $status)
    {
        $this->message = $message;
        $this->amount = $amount;
        $this->dueDate = $dueDate;
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
          return [];
    }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
   public function toDatabase($notifiable)
    {
        return [
            'title' => 'Monthly Fee Due',
            'message' => $this->message,
            'amount' => $this->amount,
            'due_date' => $this->dueDate,
            'status' => $this->status,
            'member_id' => $notifiable->id
        ];
    }
}
