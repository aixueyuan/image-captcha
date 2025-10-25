<?php

namespace aixueyuan\ImageCaptcha\Api\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;

class GenerateImageCaptchaController implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Generate random 4-digit code
        $code = sprintf('%04d', random_int(0, 9999));
        
        // Create image
        $image = imagecreatetruecolor(120, 40);
        $bg = imagecolorallocate($image, 255, 255, 255);
        $textColor = imagecolorallocate($image, 0, 0, 0);
        
        // Fill background
        imagefilledrectangle($image, 0, 0, 120, 40, $bg);
        
        // Add noise
        for ($i = 0; $i < 100; $i++) {
            $x = random_int(0, 120);
            $y = random_int(0, 40);
            imagesetpixel($image, $x, $y, $textColor);
        }
        
        // Add text
        imagestring($image, 5, 30, 12, $code, $textColor);
        
        // Convert to base64
        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        imagedestroy($image);
        
        $base64 = 'data:image/png;base64,' . base64_encode($imageData);
        
        // Store code in session
        $request->getAttribute('session')->put('captcha_code', $code);
        
        return new JsonResponse(['image' => $base64]);
    }
}