<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CaptchaController extends Controller
{
    public function generate()
    {
        $code = $this->generateRandomString(6);
        Session::put('captcha_code', strtoupper($code));

        $width = 200;
        $height = 60;

        $svg = "<svg width='$width' height='$height' xmlns='http://www.w3.org/2000/svg'>";
        
        // Background - Matching the red in the user image
        $svg .= "<rect width='100%' height='100%' fill='#DA200B' />";

        // Add some noise lines
        for ($i = 0; $i < 10; $i++) {
            $x1 = rand(0, $width);
            $y1 = rand(0, $height);
            $x2 = rand(0, $width);
            $y2 = rand(0, $height);
            $svg .= "<line x1='$x1' y1='$y1' x2='$x2' y2='$y2' stroke='rgba(255,255,255,0.3)' stroke-width='1' />";
        }

        // Add text
        $chars = str_split($code);
        $x = 20;
        foreach ($chars as $char) {
            $y = 40 + rand(-5, 5);
            $rotate = rand(-20, 20);
            $svg .= "<text x='$x' y='$y' fill='#FFFFFF' font-size='28' font-family='Arial, sans-serif' font-weight='bold' transform='rotate($rotate, $x, $y)'>$char</text>";
            $x += 28;
        }

        $svg .= "</svg>";

        return response($svg)->header('Content-Type', 'image/svg+xml');
    }

    public function refresh()
    {
        return response()->json(['url' => route('captcha.generate', ['t' => time()])]);
    }

    private function generateRandomString($length = 6)
    {
        $characters = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
