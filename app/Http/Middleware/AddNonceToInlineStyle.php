<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddNonceToInlineStyle {
    public function handle($request, Closure $next) {
        $response = $next($request);

        if ($response->isClientError() || $response->isServerError()) {
            $content = $response->getContent();
            $nonce = csp_nonce();
            $contentWithNonce = $this->addNonceToInlineScripts($content, $nonce);

            $response->setContent($contentWithNonce);
        }

        return $response;
    }

    protected function addNonceToInlineScripts($content, $nonce) {
        return preg_replace_callback(
            '/<style(.*?)>(.*?)<\/style>/is', function ($match) use ($nonce) {
            $attributes = $match[1];
            $styleContent = $match[2];

            if (!str_contains($attributes, 'nonce')) {
                $attributes .= " nonce=\"$nonce\"";
            }

            return "<style$attributes>$styleContent</style>";
        }, $content);
    }
}
