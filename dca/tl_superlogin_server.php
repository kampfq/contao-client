<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package   AuthClient
 * @author    Hendrik Obermayer - Comolo GmbH
 * @license   -
 * @copyright 2014 Hendrik Obermayer
 */

/**
 * Table tl_superlogin_server
 */
$GLOBALS['TL_DCA']['tl_superlogin_server'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => false,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		),

        'onsubmit_callback' => array(
            array('\Comolo\SuperLoginClient\ContaoEdition\Module\tl_superlogin_server', 'onSubmitDca')
        ),
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 0,
			'fields'                  => array(''),
			'flag'                    => 1
		),
		'label' => array
		(
			'fields'                  => array('name'),
			'format'                  => '%s'
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_superlogin_server']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_superlogin_server']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_superlogin_server']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_superlogin_server']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Select
	'select' => array
	(
		'buttons_callback' => array()
	),

	// Edit
	'edit' => array
	(
		'buttons_callback' => array()
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array(''),
		'default'                     => '{server_auth_legend:hide},name,url_authorize,url_access_token,url_resource_owner_details,public_id,secret'
	),

	// Subpalettes
	'subpalettes' => array
	(
		''                            => ''
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'name' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_superlogin_server']['name'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
        
        // Todo: add docp (dynamic oath2 configuration protocol)
        // ToDo: enabled checkbox
        
        'url_authorize' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_superlogin_server']['url_authorize'],
            'inputType'               => 'text',
            'exclude'                 => true,
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50 wizard', 'mandatory'=>true),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        
        'url_access_token' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_superlogin_server']['url_authorize'],
            'inputType'               => 'text',
            'exclude'                 => true,
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50 wizard', 'mandatory'=>true),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        
        'url_resource_owner_details' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_superlogin_server']['url_authorize'],
            'inputType'               => 'text',
            'exclude'                 => true,
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50 wizard', 'mandatory'=>true),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),

        'public_id' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_superlogin_server']['publicId'],
            'inputType'               => 'text',
            'exclude'                 => true,
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50 wizard', 'mandatory'=>true),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),

        'secret' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_superlogin_server']['secret'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50 wizard'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
	)
);