<?php

declare(strict_types=1);

/*
 * This file is part of the Tabler UX Components Bundle package.
 *
 * (c) SILARHI <dev@silarhi.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Silarhi\TablerUxComponents\Tests\Component;

use Silarhi\TablerUxComponents\Tests\ComponentTestCase;

final class ChatTest extends ComponentTestCase
{
    public function testAllInOneMessages(): void
    {
        $html = $this->renderComponent(
            '<twig:Tabler:Chat messages="{{ messages }}" />',
            ['messages' => [
                ['author' => 'Alice', 'date' => '10:24', 'text' => 'Hey!', 'avatar' => '/a.jpg'],
                ['author' => 'You', 'date' => '10:26', 'text' => 'Sure.', 'avatar' => '/me.jpg', 'me' => true],
            ]],
        );

        self::assertHtmlSame(
            '<div class="chat"><div class="chat-bubbles">'
            . '<div><div class="row align-items-end">'
            . '<div class="col-auto"><span class="avatar" style="background-image: url(/a.jpg)"></span></div>'
            . '<div class="col col-lg-6"><div class="chat-bubble">'
            . '<div class="chat-bubble-title"><div class="row"><div class="col chat-bubble-author">Alice</div><div class="col-auto chat-bubble-date">10:24</div></div></div>'
            . '<div class="chat-bubble-body"><p>Hey!</p></div>'
            . '</div></div>'
            . '</div></div>'
            . '<div><div class="row align-items-end justify-content-end">'
            . '<div class="col col-lg-6"><div class="chat-bubble chat-bubble-me">'
            . '<div class="chat-bubble-title"><div class="row"><div class="col chat-bubble-author">You</div><div class="col-auto chat-bubble-date">10:26</div></div></div>'
            . '<div class="chat-bubble-body"><p>Sure.</p></div>'
            . '</div></div>'
            . '<div class="col-auto"><span class="avatar" style="background-image: url(/me.jpg)"></span></div>'
            . '</div></div>'
            . '</div></div>',
            $html,
        );
    }

    public function testMessageWithoutAvatarAndCustomAvatarBlock(): void
    {
        self::assertHtmlSame(
            '<div class="mb-2"><div class="row align-items-end"><div class="col col-lg-6"><div class="chat-bubble"><div class="chat-bubble-body"><p>Hi</p></div></div></div></div></div>',
            $this->renderComponent('<twig:Tabler:Chat:Message text="Hi" class="mb-2" />'),
        );

        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Chat:Message me>
                <twig:block name="avatar"><span class="avatar avatar-xs">GS</span></twig:block>
                <twig:Tabler:Chat:Bubble me text="Sure." />
            </twig:Tabler:Chat:Message>
            TWIG);

        self::assertHtmlSame(
            '<div><div class="row align-items-end justify-content-end">'
            . '<div class="col col-lg-6"><div class="chat-bubble chat-bubble-me"><div class="chat-bubble-body"><p>Sure.</p></div></div></div>'
            . '<div class="col-auto"><span class="avatar avatar-xs">GS</span></div>'
            . '</div></div>',
            $html,
        );
    }

    public function testComposedBubble(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Chat:Bubble me>
                <twig:Tabler:Chat:Bubble:Title>
                    <twig:Tabler:Chat:Bubble:Author>You</twig:Tabler:Chat:Bubble:Author>
                    <twig:Tabler:Chat:Bubble:Date>10:26</twig:Tabler:Chat:Bubble:Date>
                </twig:Tabler:Chat:Bubble:Title>
                <twig:Tabler:Chat:Bubble:Body><p>Sure, <strong>five minutes</strong>.</p></twig:Tabler:Chat:Bubble:Body>
            </twig:Tabler:Chat:Bubble>
            TWIG);

        self::assertHtmlSame(
            '<div class="chat-bubble chat-bubble-me">'
            . '<div class="chat-bubble-title"><div class="row"><div class="col chat-bubble-author">You</div><div class="col-auto chat-bubble-date">10:26</div></div></div>'
            . '<div class="chat-bubble-body"><p>Sure, <strong>five minutes</strong>.</p></div>'
            . '</div>',
            $html,
        );
    }

    public function testBubbleBodyBlockAndTitleWithAuthorOnly(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Chat:Bubble author="Alice">
                <twig:block name="body"><twig:Tabler:Chat:Bubble:Body><p>Look</p><img src="/c.jpg" alt=""></twig:Tabler:Chat:Bubble:Body></twig:block>
            </twig:Tabler:Chat:Bubble>
            TWIG);

        self::assertHtmlSame(
            '<div class="chat-bubble">'
            . '<div class="chat-bubble-title"><div class="row"><div class="col chat-bubble-author">Alice</div></div></div>'
            . '<div class="chat-bubble-body"><p>Look</p><img src="/c.jpg" alt=""></div>'
            . '</div>',
            $html,
        );
    }

    public function testComposedChatWithTyping(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Chat>
                <twig:Tabler:Chat:Bubbles>
                    <twig:Tabler:Chat:Typing>Alice is typing</twig:Tabler:Chat:Typing>
                    <twig:Tabler:Chat:Typing />
                </twig:Tabler:Chat:Bubbles>
            </twig:Tabler:Chat>
            TWIG);

        self::assertHtmlSame(
            '<div class="chat"><div class="chat-bubbles">'
            . '<div class="chat-bubble align-self-start"><div class="chat-bubble-body"><p class="text-secondary fst-italic mb-0">Alice is typing <span class="animated-dots"></span></p></div></div>'
            . '<div class="chat-bubble align-self-start"><div class="chat-bubble-body"><p class="text-secondary fst-italic mb-0">Typing <span class="animated-dots"></span></p></div></div>'
            . '</div></div>',
            $html,
        );
    }
}
