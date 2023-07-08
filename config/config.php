<?php

return [
    /**
     * The beginning of a placeholder.
     */
    "start" => "%%",

    /**
     * The end of a placeholder.
     */
    "end" => "%%",

    /**
     * Missing placeholders behavior.
     *
     * Possible values:
     *  - 'error': Throw an Exception if a placeholder is missing.
     *  - 'skip': Delete the placeholder from the output if it is missing.
     *  - 'preserve': Do nothing and output the placeholder as is if it is missing.
     */
    "behavior" => 'preserve',
];
