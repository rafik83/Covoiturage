<?php

namespace Covoiturage\FrontendBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CovoiturageFrontendBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
