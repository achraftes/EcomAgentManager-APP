<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AgentAssigned extends Mailable
{
    use Queueable, SerializesModels;

    public $agent;
    public $leads;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($agent, $leads)
    {
        $this->agent = $agent;
        $this->leads = $leads;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.agent-assigned')
                    ->with([
                        'agentName' => $this->agent->name,
                        'leads' => $this->leads,
                    ]);
    }
}
