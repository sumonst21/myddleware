<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MailControllerTest extends WebTestCase
{

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    
    // public function testEmailsAreSentCorrectly()
    // {
    //     // setup
    //     // perform action
    //     $this->client->request('GET', '/email');
    //     // make assertions
    //     $sentMail = $this->getMailerMessage(0);

    //     // 1 email sent
    //     $this->assertEmailCount(1);
    //     //  has correct body sent
    //     $this->assertEmailHeaderSame($sentMail, 'To', 'Estelle <email@example.com>');
    //     // Has correct body content
    //     $this->assertEmailTextBodyContains($sentMail, 'The expected delivery date is');
    //     // Has an attachment
    //     $this->assertEmailAttachmentCount($sentMail, 1);
    // }

    public function testMailIsSentAndContentIsOk()
    {

        // enables the profiler for the next request (it does nothing if the profiler is not available)
        $this->client->enableProfiler();
        // request(
        //     $method,
        //     $uri,
        //     array $parameters = [],
        //     array $files = [],
        //     array $server = [],
        //     $content = null,
        //     $changeHistory = true
        // )
        // $client->request('POST', '/follow', [
        //     'username' => $user->getUsername()
        // ]);
        // TODO: THIS NEEDS TO BE TESTED WITHOUT HAVING TO PASS AN ENTIRE FORM TO THE REQUEST PARAMETERS
        $crawler = $this->client->request('POST', '/rule/send_test_mail', ['form' => ['']]);
        // $crawler = $this->client->request('POST', '/sendmail');

        $mailCollector = $this->client->getProfile()->getCollector('swiftmailer');

        // checks that an email was sent
        $this->assertSame(1, $mailCollector->getMessageCount());

        $collectedMessages = $mailCollector->getMessages();
        $message = $collectedMessages[0];

        // Asserting email data
        $this->assertInstanceOf('Swift_Message', $message);
        $this->assertSame('Hello Email', $message->getSubject());
        $this->assertSame('send@example.com', key($message->getFrom()));
        $this->assertSame('estellegaits@myddleware.com', key($message->getTo()));
        $this->assertSame(
            'You should see me from the profiler!',
            $message->getBody()
        );
    }
}