<?php

$schemas = (!isset($schemas)) ? [] : $schemas;
$schemas['faq'] = [
    'faq_id' => [
        'type' => 'int(11) unsigned',
        'auto_increment' => true,
        'primary' => true,
        'index' => true,
    ],
    'question' => [
        'type' => 'text',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci'
    ],
    'answer' => [
        'type' => 'longtext',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci'
    ],
    'state' => [
        'type' => 'varchar(255)',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'default' => 'pending'
    ],
    'order' => [
        'type' => 'int(11) unsigned',
    ],
    'stars' => [
        'type' => 'int(11) unsigned',
    ],
    'value_id' => [
        'type' => 'int(11) unsigned',
    ],
    'created_at' => [
        'type' => 'datetime',
    ],
    'updated_at' => [
        'type' => 'datetime',
    ],
];