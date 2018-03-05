<?php
return array (
  'Development' => 
  array (
    'path' => 'dev',
    'setWritable' => 
    array (
      1 => 'apps/backend/web/assets',
      5 => 'apps/front/web/assets',
    ),
    'setExecutable' => 
    array (
      0 => 'scripts/yii',
    ),
    'setCookieValidationKey' => 
    array (
      1 => 'apps/backend/config/main-local.php',
      5 => 'apps/front/config/main-local.php',
    ),
  ),
  'Production' => 
  array (
    'path' => 'prod',
    'setWritable' => 
    array (
      1 => 'apps/backend/web/assets',
      5 => 'apps/front/web/assets',
    ),
    'setExecutable' => 
    array (
      0 => 'scripts/yii',
    ),
    'setCookieValidationKey' => 
    array (
      1 => 'apps/backend/config/main-local.php',
      5 => 'apps/front/config/main-local.php',
    ),
  ),
);