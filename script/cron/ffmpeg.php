<?php

set_time_limit(0);

$dblink = mysqli_connect('localhost', 'qick_user', 'qick_pass'); // сервер, пользователь, пароль к БД
if (!$dblink OR !mysqli_select_db($dblink, 'qick_db')) // имя БД
	exit('Нет соединения с БД.');

mysqli_query($dblink, 'SET NAMES utf8');
mysqli_query($dblink, 'SET SESSION character_set_results = utf8');

$rs = mysqli_query($dblink, 'SELECT * FROM videos WHERE processing = 0 LIMIT 1');
while ($a = mysqli_fetch_assoc($rs))
{
	if (!$a['id'])
		continue;
    mysqli_query($dblink, 'UPDATE videos SET processing = 1 WHERE id = '.$a['id'].';');
    $auser = mysqli_fetch_assoc(mysqli_query($dblink, 'SELECT * FROM users WHERE id = '.$a['user_id']));


    $filename = explode('/', $a['url'])[1];
	print 'FILE: '.$a['url']."\n";
    $resolution = $return = '';
	print "FFMPEG SIZE: ffmpeg -i /var/www/www-root/data/www/qick.fun/".$a['url']." 2>&1 | grep Video: | grep -Po '\d{3,5}x\d{3,5}'\n";
    $return = system("ffmpeg -i /var/www/www-root/data/www/qick.fun/".$a['url']." 2>&1 | grep Video: | grep -Po '\d{3,5}x\d{3,5}'", $resolution); // путь где лежит сайт вместо /home/piotr/www/leak
    if (!$resolution)
        $resolution = $return;
    $resolution = explode('x', $resolution);
    $maxwidth = intval($resolution[0] * 0.37);
    if ($maxwidth > 855)
        $maxwidth = 855;

    resizeImageText('/var/www/www-root/data/www/qick.fun/uploads/img/watermark.png', $maxwidth, $maxwidth, $a['id'], $auser['username']); // где лежит чистый watermark, который берётся за основу
	$newvideo = '/var/www/www-root/data/www/qick.fun/'.$filename;
	print 'newvideo: '.$newvideo."\n";
    //system('ffmpeg -i /var/www/www-root/data/www/qick.fun/'.$a['url'].' -vcodec mjpeg -vframes 1 -an -f rawvideo -ss `ffmpeg -i /var/www/www-root/data/www/qick.fun/'.$a['url'].' 2>&1 | grepDuration | awk \'{print $2}\' | tr -d , | awk -F \':\' \'{print ($3+$2*60+$1*3600)/2}\'` /var/www/www-root/data/www/leak.fun/thumbnails/'.$a['id'].'.jpg'); // genm r d
    system('ffmpeg -i /var/www/www-root/data/www/qick.fun/'.$a['url'].' -vframes 1 -vf "scale=360:-1" /var/www/www-root/data/www/qick.fun/thumbnails/'.$a['id'].'.jpg -vcodec mjpeg');
    resizeImage('/var/www/www-root/data/www/qick.fun/thumbnails/'.$a['id'].'.jpg', 500, 500, $a['id']);

	print 'FFMPEG: ffmpeg -i /var/www/www-root/data/www/qick.fun/'.$a['url'].' -i /var/www/www-root/data/www/qick.fun/uploads/img/watermark/'.$a['id'].'.png -filter_complex "overlay=10:main_h-overlay_h-10" -c:a copy '.$newvideo."\n";
    system('ffmpeg -i /var/www/www-root/data/www/qick.fun/'.$a['url'].' -i /var/www/www-root/data/www/qick.fun/uploads/img/watermark/'.$a['id'].'.png -filter_complex "overlay=10:main_h-overlay_h-10" -c:a copy '.$newvideo); // 1 это путь к папке сайта для видео, которое надо рендерить, 2 путь к временному знаку, 3 путь куда сохранять видео, можно попробовать указать то что и в 1
    mysqli_query($dblink, 'UPDATE videos SET processing = 2 WHERE id = '.$a['id']);
	unlink('/var/www/www-root/data/www/qick.fun/'.$a['url']); // удаление старого видео
    unlink('/var/www/www-root/data/www/qick.fun/uploads/img/watermark/'.$a['id'].'.png'); // удаление временного знака
	rename($newvideo, '/var/www/www-root/data/www/qick.fun/'.$a['url']);
}

function resizeImage($originalImage, $toWidth, $toHeight, $id)
{
	list($width, $height) = getimagesize($originalImage);
	$xscale = $width / $toWidth;
	$yscale = $height / $toHeight;
	
	if ($yscale>$xscale)
	{
		$new_width = round($width * (1/$yscale));
		$new_height = round($height * (1/$yscale));
	}
	else
	{
		$new_width = round($width * (1 / $xscale));
		$new_height = round($height * (1 / $xscale));
	}
    $imageTmp = imagecreatefromjpeg($originalImage);
	$imageResized = imagecreatetruecolor($new_width, $new_height);

    imagecopyresampled($imageResized, $imageTmp, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

	imagejpeg($imageResized, '/var/www/www-root/data/www/qick.fun/thumbnails/'.$id.'.jpg');
    imagedestroy($imageTmp);
}



function resizeImageText($originalImage, $toWidth, $toHeight, $id, $login)
{
	list($width, $height) = getimagesize($originalImage);
	$xscale = $width / $toWidth;
	$yscale = $height / $toHeight;
	
	if ($yscale>$xscale)
	{
		$new_width = round($width * (1/$yscale));
		$new_height = round($height * (1/$yscale));
	}
	else
	{
		$new_width = round($width * (1 / $xscale));
		$new_height = round($height * (1 / $xscale));
	}

	$imageResized = imagecreatetruecolor($new_width, $new_height);
	$imageTmp = imagecreatefrompng($originalImage);
	
    $white = imagecolorallocate($imageTmp, 255, 255, 255);
    imageAlphaBlending($imageTmp, false);
    imageSaveAlpha($imageTmp, true);
    
    imageAlphaBlending($imageResized, false);
    imageSaveAlpha($imageResized, true);

    $font_path = '/var/www/www-root/data/www/qick.fun/uploads/img/watermark/Arial.ttf'; // путь к шрифту

    $text = $login;

    imagettftext($imageTmp, 42, 0, 20, 210, $white, $font_path, $text);

    imagecopyresampled($imageResized, $imageTmp, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

	imagepng($imageResized, '/var/www/www-root/data/www/qick.fun/uploads/img/watermark/'.$id.'.png'); // куда сохранить временную watermark с логином на ней
    imagedestroy($imageTmp);
}
