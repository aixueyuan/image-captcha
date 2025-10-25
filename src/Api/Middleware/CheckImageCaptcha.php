<?php

namespace aixueyuan\ImageCaptcha\Api\Middleware;

use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\Foundation\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CheckImageCaptcha implements MiddlewareInterface
{
    /**
     * @var SettingsRepositoryInterface
     */
    protected $settings;

    public function __construct(SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }

    

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->getAttribute('routeName') === 'users.create') {
            // 检查是否启用验证码
            if ($this->settings->get('image-captcha.enabled', true)) {
                $session = $request->getAttribute('session');
                $input = $request->getParsedBody();
                
                $code = $session->get('captcha_code');
                $userInput = $input['data']['attributes']['captchaCode'] ?? '';
                
                if ($code !== $userInput) {
                    throw new ValidationException(['captchaCode' => 'Invalid captcha code']);
                }
            }
        }
        
        return $handler->handle($request);
    }
}
