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
 * Table tl_authclient_server
 */
$GLOBALS['TL_DCA']['tl_authclient_server'] = array
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
            array('tl_authclient_server', 'onSubmitDca')
        ),
		'onload_callback'		  => array
		(
			array('tl_authclient_server', 'onCertificateUpload')
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
				'label'               => &$GLOBALS['TL_LANG']['tl_authclient_server']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_authclient_server']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_authclient_server']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_authclient_server']['show'],
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
		'default'                     => '{server_auth_legend:hide},auth_provider;{certificate_legend},authinfo,server_key;'
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
			'label'                   => &$GLOBALS['TL_LANG']['tl_authclient_server']['name'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
        
        'server_key' => array(
			'label'                   => &$GLOBALS['TL_LANG']['tl_authclient_server']['server_key'],
			'exclude'                 => true,
			'inputType'               => 'fileUpload',
			'eval'                    => array
			(
				'mandatory' 		  => true,
				'extensions' 	 	  => $GLOBALS['TL_CONFIG']['authClientCertificateFiletype'],
				'storeFile' 		  => true,
				'uploadFolder' 	 	  => 'system/tmp',
			),
            'sql'                     => "blob NOT NULL",
        ),

        'public_id' => array
        (
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50 wizard'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),

        'server_address' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_authclient_server']['server_address'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255),
            'sql'                     => "text NOT NULL"
        ),

        'auth_provider' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_authclient_server']['auth_provider'],
            //'exclude'                 => true,
            'inputType'               => 'select',
            'options'                 => $GLOBALS['AUTH_CLIENT']['providers'],
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'rgxp' => 'classname', 'tl_class'=>'w50 wizard'),
            'sql'                     => "text NOT NULL"
        ),

		'validTo' => array
		(
			'eval'                    => array('maxlength'=>100),
			'sql'                     => "varchar(100) NOT NULL default ''"
		),

		// TODO: Rename to certinfo
		'authinfo' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_authclient_server']['authinfo'],
			'inputType'               => 'infobox',
			'load_callback'			  => array
			(
				array('tl_authclient_server', 'getAuthServerInfo'),
			),
			'save_callback' 		  => array
			(
				array('tl_authclient_server', 'doNotSave'),
			),
			'eval'                    => array('doNotSaveEmpty' => true, 'readonly' => true, 'blankOptionLabel' => '-'),
		),
	)
);