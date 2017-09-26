<?php

$config['progress'] = [
  'start' => 0,
  'prefill_check' => 25
];

$config['generic_questions'] = [
  '1' => [
    'name' => 'informed',
    'type' => 'checkbox',
    'question' => 'How do you keep yourself informed about available tools?',
    'answers' => [
      '1' => 'Through organisation',
      '2' => 'Through colleagues in my organisation',
      '3' => 'Peers (e.g. web forums/conferences/scientific papers)',
      '4' => 'School/training',
      '5' => 'Newsletter/advertisement',
      '6' => 'Periodic searches (e.g. web)'
    ],
    'other' => true
  ],
  '2' => [
    'name' => 'literate',
    'type' => 'scale',
    'question' => 'How literate do you consider yourself about technology-assisted systematic reviews?',
    'answers' => 10,
    'other' => false
  ],
  '3' => [
    'name' => 'difficult',
    'type' => 'scale',
    'question' => 'Do you find it difficult to determine which tasks a tool will be able to perform in your workflow?',
    'answers' => 10,
    'other' => false
  ],
  '4' => [
    'name' => 'difficult_aspects',
    'type' => 'checkbox',
    'question' => 'Which aspects mostly contribute to this?',
    'answers' => [
      '1' => 'Lacking user documentation',
      '2' => 'Lacking information (e.g. online)',
      '3' => 'No own experience with the tool',
      '4' => 'No colleagues/peers using it'
    ],
    'other' => true
  ],
  '5' => [
    'name' => 'necessity_start',
    'type' => 'checkbox',
    'question' => 'What is necessary for you to start using a new tool?',
    'answers' => [
      '' => 'Addresses a barrier in my workflow',
      '' => 'Decreases project time',
      '' => 'Reproducible results',
      '' => 'Collaboration with colleagues',
      '' => 'Remote collaboration with colleagues',
      '' => '(Extensive) user documentation',
      '' => 'Scientific underpinning of method/algorithm'
    ],
    'other' => true
  ],
  '6' => [
    'name' => 'consider_past',
    'type' => 'radio',
    'question' => 'Are there tools that you consider or have used in the past, but that you currently don\'t use?',
    'answers' => [
      'yes' => 'Yes',
      'no' => 'No'
    ],
    'other' => false,
    'follow_up' => 'why_not'
  ],
  '7' => [
    'is_follow_up' => true,
    'name' => 'why_not',
    'type' => 'checkbox',
    'question' => 'Why don\'t you use these tools?',
    'answers' => [
      '1' => 'Lacking (expected) functionality',
      '2' => 'Poor usability',
      '3' => 'Steep learning curve',
      '4' => 'Lacking support from colleagues or organisation',
      '5' => 'Lacking user documentation',
      '6' => 'Doesn\'t fit current workflow',
      '7' => 'Cannot trust results/output',
      '8' => 'Licensing'
    ],
    'other' => true
  ],
  // '' => [
  //   'name' => '',
  //   'type' => '',
  //   'question' => '',
  //   'answers' => [
  //     '' => ''
  //   ],
  //   'other' => true
  // ],
];