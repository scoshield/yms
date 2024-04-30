<?php

namespace App\Notifications;

use App\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentNotification extends Notification
{
    use Queueable;

    public $level;
    public $appointment;
    public $action_tag = "Approve";
    public $action_url;
    public $message;
    public $subject;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Appointment $appointment, $level)
    {
        //There are 3 Approval levels level one is the supervisor level 2 head of department level 3 security
        $tag = "693fbc24-23ad-40a2-8fc3-9f1f05e4dc32";
        $ref = sha1($appointment->id) . $tag . sha1($level);
        $this->action_url = route('admin.appointments.approve_action_url', $ref);
        $purpose = config('appointment.purpose')[$appointment->purpose];

        switch ($level) {
            case 1: //Hod
                $this->message = (new MailMessage)
                    ->subject('H.O.D Approval required for Appointment #' . $appointment->id)
                    ->greeting('Hello!')
                    ->line(
                        '
                        Your approval is required for an ' . $purpose . ' appointment  scheduled for ' . $appointment->appointment_date . '.
                        Hauler: ' . $appointment->hauler->name . ', 
                        Driver: ' . $appointment->driver_name . ', 
                        Truck Registration Number: ' . $appointment->truck_details
                    )->action($this->action_tag, $this->action_url);

                break;
            case 2: // Security
                $this->message = (new MailMessage)
                    ->subject('Security Approval required for Appointment #' . $appointment->id)
                    ->greeting('Hello!')
                    ->line(
                        '
                        Your approval is required for an ' . $purpose . ' appointment  scheduled for ' . $appointment->appointment_date . '.
                        Hauler: ' . $appointment->hauler->name . ',
                        Driver: ' . $appointment->driver_name . ',
                        Truck Registration Number: ' . $appointment->truck_details
                    )->action($this->action_tag, $this->action_url);

                break;
                // case 3:
                //     $this->subject = "Action on appointment required";
                //     $this->message = "Your action is required for the appointment below:<br/>";
                //     break;
            default:
                // do nothing
                break;
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return $this->message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
