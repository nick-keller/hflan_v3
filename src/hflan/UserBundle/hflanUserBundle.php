<?php

namespace hflan\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class hflanUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
