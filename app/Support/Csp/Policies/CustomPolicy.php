<?php

namespace App\Support\Csp\Policies;
 
use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Basic;
 
class CustomPolicy extends Basic {
    public function configure() {
        parent::configure();
        
        $this->addDirective(Directive::STYLE, 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css')
            ->addDirective(Directive::STYLE, 'https://fonts.googleapis.com/')
            ->addDirective(Directive::DEFAULT, 'https://fonts.googleapis.com/')
            ->addDirective(Directive::DEFAULT, 'https://fonts.gstatic.com/')
            ->addDirective(Directive::STYLE, 'https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/css/boxicons.min.css')
            ->addDirective(Directive::DEFAULT, 'https://cdnjs.cloudflare.com/')
            // ->addDirective(Directive::CONNECT, Scheme::WSS)
            ->addNonceForDirective(Directive::SCRIPT)
            ->addNonceForDirective(Directive::STYLE)
            ->addDirective(Directive::IMG, 'data:')
            ->addDirective(Directive::FORM_ACTION, 'https://vpos.jsp.my.id/')
            ->addDirective(Directive::DEFAULT, 'https://vpos.jsp.my.id/');
    }
}