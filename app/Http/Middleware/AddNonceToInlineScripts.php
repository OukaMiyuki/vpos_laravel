<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddNonceToInlineScripts {
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
            '/<script(.*?)>(.*?)<\/script>/is', function ($match) use ($nonce) {
            $attributes = $match[1];
            $scriptContent = $match[2];

            if (!str_contains($attributes, 'nonce')) {
                $attributes .= " nonce=\"$nonce\"";
            }

            return "<script$attributes>$scriptContent</script>";
        }, $content);
    }
}
