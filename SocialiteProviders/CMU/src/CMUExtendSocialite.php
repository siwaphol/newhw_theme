<?php

namespace SocialiteProviders\CMU;

use SocialiteProviders\Manager\SocialiteWasCalled;

class CMUExtendSocialite
{
    /**
     * Execute the provider.
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('cmu', __NAMESPACE__.'\Provider');
    }
}
