<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RemindDueDate extends Notification
{
    use Queueable;

    public $loan;
    public $overdueDays;
    public $settings;

    public function __construct($loan, $overdueDays, $settings)
    {
        $this->loan = $loan;
        $this->overdueDays = $overdueDays;
        $this->settings = $settings;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Overdue Book Reminder')
            ->line("Hello {$this->loan->user->name},")
            ->line("Your loan for '{$this->loan->book->title}' is overdue by {$this->overdueDays} days.")
            ->line("Daily fine rate: ₱{$this->settings->daily_fine_rate}")
            ->line("Current fine: ₱" . ($this->settings->daily_fine_rate * $this->overdueDays))
            ->action('Return Book', url('/dashboard'))
            ->line('Thank you for your prompt attention!');
    }
}