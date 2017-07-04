@component('mail::message')
Hello,

Code for Philly is creating a website that helps neighbors find and connect with their Registered Community Organization (RCO).
We are collecting an abbreviated mission statement as well as website, social media, and committee information from RCOs to display on the new website.
You are receiving this email because you are listed as the primary contact for "{{$organization->name}}".  Completing the survey will provide more information to your friends and neighbors.

@component('mail::button',
['url' => "http://api.myphilly.org/survey/".$organization->getLatestSurvey()->token,
'color' => 'blue'])
Take Survey
@endcomponent

Here is the address of the survey if you are unable to click the link above: http://api.myphilly.org/survey/{{$organization->getLatestSurvey()->token}}

Thank you,

The My Philly Team
@endcomponent
