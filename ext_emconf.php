<?php
/**
 * $EM_CONF
 *
 * @package    Hdnet
 * @author     Tim Lochmüller <tim.lochmueller@hdnet.de>
 */

$EM_CONF[$_EXTKEY] = [
    'title' => 'Language Detection',
    'description' => 'Language Detection Middleware for TYPO3',
    'category' => 'fe',
    'version' => '0.1.0',
    'state' => 'beta',
    'author' => 'Tim Lochmüller',
    'author_email' => 'tim@fruit-lab.de',
    'author_company' => 'hdnet.de',
    'constraints' => [
        'depends' => [
            'php' => '7.3.0-7.4.99',
            'typo3' => '10.4.6-10.4.99'
        ],
    ],
    'autoload' => [
        'psr-4' => ['LD\\Hdnet\\' => 'Classes']
    ],
];
