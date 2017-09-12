<?php

namespace Api\Types;

interface RuleType
{
    /**
    * @author  [Layo Demetrio] <layo.demetrio@locaweb.com.br>
    * @package [Api\Services]
    * @since   [2017-02-23]
    */
    const PATTERN   = 1;
    const HOURLY    = 2;
    const AUTOMATIC = 3;
}
