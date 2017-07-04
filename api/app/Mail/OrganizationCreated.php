<?php

namespace App\Mail;

use App\Models\Organization;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrganizationCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $organization;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Organization $org)
    {
        $this->organization = $org;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('donotreply@myphilly.org')
            ->markdown('email.survey');
    }
}
