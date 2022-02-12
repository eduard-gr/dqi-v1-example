<?php

use Trackpoint\DataQueryInterface\DQL;

return [
	DQL::STATEMENT => DQL::SELECT,

/*
	DQL::EXPRESSIONS => [
		[
			DQL::TYPE => DQL::EQUAL,
			DQL::NAME => 'lslp_id',
			DQL::CONSTANT => '209'
		]
	],
*/

	DQL::RETURNING => [
		'lsusr_id',
		'lsusr_first_name',
		'lsusr_last_name',
		'lsusr_gender',
		'lsusr_description'
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

								DQL::RELATION => [

								]
							]
						]
					]
				]
			]
		]
	]
];