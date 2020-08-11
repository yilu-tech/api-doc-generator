<?php

return [
    /**
     * @Required
     * This string MUST be the semantic version number of the OpenAPI Specification version that the OpenAPI document uses.
     * The openapi field SHOULD be used by tooling specifications and clients to interpret the OpenAPI document.
     * This is not related to the API info.version string.
     */
    'openapi' => '3.0.0',

    /**
     * @Required
     * Provides metadata about the API. The metadata MAY be used by tooling as required.
     */
    'info' => [
        /**
         * @Required
         * The version of the OpenAPI document (which is distinct from the OpenAPI Specification version or the API implementation version).
         */
        'version' => '1.0.1',

        /**
         * @Required
         * The title of the API.
         */
        'title' => 'Sample Pet Store App',

        /**
         * A short description of the API. CommonMark syntax MAY be used for rich text representation.
         */
        'description' => <<<MARKDOWN
### user server

MARKDOWN,

        /**
         * A URL to the Terms of Service for the API. MUST be in the format of a URL.
         */
        'termsOfService' => 'http://example.com/terms/',

        'contact' => [
            'name' => 'API Support',
            'url' => 'http://www.example.com/support',
            'email' => 'support@example.com'
        ],

        'license' => [
            'name' => 'Apache 2.0',
            'url' => 'https://www.apache.org/licenses/LICENSE-2.0.html',
        ],
    ],

    /**
     * An array of Server Objects, which provide connectivity information to a target server.
     * If the servers property is not provided, or is an empty array, the default value would be a Server Object with a url value of /.
     */
    'servers' => [
        [
            /**
             * @Required
             * A URL to the target host.
             * This URL supports Server Variables and MAY be relative, to indicate that the host location is relative to the location where the OpenAPI document is being served.
             * Variable substitutions will be made when a variable is named in {brackets}.
             */
            'url' => '{username}.example.com/{basePath}/',

            /**
             * An optional string describing the host designated by the URL. CommonMark syntax MAY be used for rich text representation.
             */
            'description' => 'example',

            /**
             * A map between a variable name and its value. The value is used for substitution in the server's URL template.
             */
            'variables' => [
                'username' => [
                    /**
                     * @Required
                     * The default value to use for substitution, which SHALL be sent if an alternate value is not supplied.
                     * Note this behavior is different than the Schema Object's treatment of default values, because in those cases parameter values are optional. If the enum is defined, the value SHOULD exist in the enum's values.
                     */
                    'default' => 'user',

                    /**
                     * An optional description for the server variable. CommonMark syntax MAY be used for rich text representation.
                     */
                    'description' => '',

                    /**
                     * An enumeration of string values to be used if the substitution options are from a limited set. The array SHOULD NOT be empty.
                     */
                    'enum' => []
                ],
            ],
        ],
    ]
];
