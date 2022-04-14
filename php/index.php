<?php

$articleArray = [
   'id' => 'id',
   'titulo' => '$title',
   'body' => 'body',
   'category' => '$category',
   'image' => '$image',
   'imageTmp' => '$imageTmp',
   'imgPath' => '$imgPath',
   'video' => '$video',
   'status' =>' $status',
   'issetstatus' => 'post',
];

$articleArray['hola'] = 'hola';

echo json_encode($articleArray);

?> 