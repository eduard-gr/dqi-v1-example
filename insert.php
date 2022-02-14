<?php

use Trackpoint\DataQueryInterface\DQL;

return [
	DQL::STATEMENT => DQL::INSERT,

	DQL::RETURNING => [
		'lslp_id',
		'lsusr_id',
		'lslp_type',
		'lsusr_first_name',
		'lsusr_last_name',
		'lsusr_gender',
		'lsusr_description'
	],

	DQL::DATA => [
		'lslp_type' => 1,
		'lslp_status' => 1,
		'lsusr_status' => 1,
		'lsusr_first_name' => 'First name',
		'lsusr_last_name' => 'Last name',
		'lsusr_gender' => 'M',
		'lsusr_description' => 'New user description'
	],


	DQL::INTERFACE => [
		DQL::NAME => 'LegalPerson',
		DQL::RELATION => [
			[

				DQL::JOIN => 'lslp_id',
				DQL::TYPE => DQL::OUTER_JOIN,

				DQL::INTERFACE => [
					DQL::NAME => 'User',

					DQL::RELATION => [
						[

							DQL::JOIN => 'lsusr_id',
							DQL::TYPE => DQL::OUTER_JOIN,

							DQL::INTERFACE => [
								DQL::NAME => 'UserProfile',
							]
						]
					]
				]
			]
		]
	]
];