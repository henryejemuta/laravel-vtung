<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    /*
     * ---------------------------------------------------------------
     * Base Url
     * ---------------------------------------------------------------
     *
     * The VtuDotNG base url upon which others is based, if not set it's going to use the sandbox version
     */
    'base_url' => env('VTU_DOT_NG_BASE_URL', 'https://vtu.ng/wp-json/api/v1/'),


    /*
     * ---------------------------------------------------------------
     * Username
     * ---------------------------------------------------------------
     *
     * Your VtuDotNG username
     */
    'username' => env('VTU_DOT_NG_USERNAME'),


    /*
     * ---------------------------------------------------------------
     * Password
     * ---------------------------------------------------------------
     *
     * Your VtuDotNG password
     */
    'password' => env('VTU_DOT_NG_PASSWORD'),

];
